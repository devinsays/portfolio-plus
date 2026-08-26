import { readFile, writeFile } from 'node:fs/promises';
import { dirname, relative, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

import autoprefixer from 'autoprefixer';
import cssjanus from 'cssjanus';
import { transform } from 'esbuild';
import postcss from 'postcss';
import * as sass from 'sass-embedded';
import { defineConfig } from 'vite';

const themeDir = dirname( fileURLToPath( import.meta.url ) );

/**
 * Vite always needs an entry to build. This is a classic WordPress theme with
 * no JS module graph, so it gets an empty virtual one and the plugin below
 * produces the real artifacts.
 */
const virtualEntry = '\0portfolio-plus';

/** Stylesheet entry, and the artifacts built from it (all theme-root relative). */
const stylesheet = {
	entry: 'scss/style.scss',
	css: 'style.css',
	map: 'style.css.map',
	rtl: 'style-rtl.css',
};

/**
 * Files concatenated into js/combined-min.js, in order.
 *
 * These are classic jQuery scripts, not ES modules. They are minified with
 * esbuild's transform API rather than bundled, so nothing wraps them in module
 * machinery and the global jQuery they depend on is left alone.
 */
const combinedScripts = {
	sources: [ 'js/navigation.js', 'js/jquery.fitvids.js' ],
	output: 'js/combined-min.js',
};

/** Scripts minified on their own: source -> output. */
const standaloneScripts = {
	'js/jquery.infinitescroll.js': 'js/jquery.infinitescroll.min.js',
};

/** esbuild options standing in for the old grunt-contrib-uglify config. */
const minifyOptions = {
	loader: 'js',
	target: 'es2015',
	minify: true,
	// Equivalent of uglify's drop_console.
	drop: [ 'console' ],
	legalComments: 'none',
};

const read = ( file ) => readFile( resolve( themeDir, file ), 'utf8' );
const write = ( file, contents ) =>
	writeFile( resolve( themeDir, file ), contents );

/**
 * Compiles scss/style.scss to style.css, style.css.map and style-rtl.css.
 *
 * Sass runs here rather than through Vite's CSS pipeline because that pipeline
 * drops CSS sourcemaps on build, and the theme ships style.css.map. Compiling
 * directly also keeps dart-sass's expanded output verbatim, which is what
 * preserves the WordPress theme header comment at the top of style.scss.
 */
async function buildStylesheet( ctx ) {
	const compiled = await sass.compileAsync( resolve( themeDir, stylesheet.entry ), {
		style: 'expanded',
		sourceMap: true,
		sourceMapIncludeSources: false,
		// Sass would otherwise emit an @charset rule ahead of the WordPress
		// theme header comment, which has to stay at the top of the file. The
		// fallback encoding for a stylesheet is UTF-8 and WordPress serves its
		// pages as UTF-8, so the rule buys nothing here.
		charset: false,
	} );

	// Re-run the build when any @imported partial changes (`vite build --watch`).
	for ( const url of compiled.loadedUrls ) {
		if ( url.protocol === 'file:' ) {
			ctx.addWatchFile( fileURLToPath( url ) );
		}
	}

	// Browser targets come from the "browserslist" field in package.json.
	const processed = await postcss( [ autoprefixer() ] ).process( compiled.css, {
		from: resolve( themeDir, stylesheet.entry ),
		to: resolve( themeDir, stylesheet.css ),
		map: {
			prev: compiled.sourceMap,
			inline: false,
			sourcesContent: false,
			annotation: stylesheet.map,
		},
	} );

	// Sass reports its sources as absolute file: URLs. Rewrite them relative to
	// the theme root so the shipped map stays portable.
	const map = processed.map.toJSON();
	map.file = stylesheet.css;
	map.sources = map.sources.map( ( source ) =>
		source.startsWith( 'file:' )
			? relative( themeDir, fileURLToPath( source ) )
			: source
	);
	delete map.sourceRoot;

	await write( stylesheet.css, processed.css );
	await write( stylesheet.map, JSON.stringify( map, null, '\t' ) );

	// transformDirInUrl/transformEdgeInUrl mirror the old grunt-cssjanus
	// `swapLtrRtlInUrl: false`. The `/* @noflip */` annotations in the Sass are
	// honored by cssjanus as before.
	await write(
		stylesheet.rtl,
		cssjanus.transform( processed.css, {
			transformDirInUrl: false,
			transformEdgeInUrl: false,
		} )
	);
}

/** Minifies the theme's classic jQuery scripts. */
async function buildScripts( ctx ) {
	for ( const file of [
		...combinedScripts.sources,
		...Object.keys( standaloneScripts ),
	] ) {
		ctx.addWatchFile( resolve( themeDir, file ) );
	}

	const sources = await Promise.all( combinedScripts.sources.map( read ) );
	const combined = await transform( sources.join( '\n' ), minifyOptions );
	await write( combinedScripts.output, combined.code );

	for ( const [ source, output ] of Object.entries( standaloneScripts ) ) {
		const minified = await transform( await read( source ), minifyOptions );
		await write( output, minified.code );
	}
}

function themeArtifacts() {
	return {
		name: 'portfolio-plus-theme-artifacts',
		resolveId( id ) {
			return id === virtualEntry ? id : null;
		},
		load( id ) {
			return id === virtualEntry ? 'export default null;' : null;
		},
		async buildStart() {
			await Promise.all( [ buildStylesheet( this ), buildScripts( this ) ] );
		},
	};
}

export default defineConfig( {
	build: {
		// The plugin writes every artifact straight to the theme root, where the
		// PHP enqueues expect them, so Vite itself has nothing to emit.
		write: false,
		// `--watch` writes the (empty) entry chunk regardless of `write`, so keep
		// it out of the theme root in a gitignored scratch directory.
		outDir: '.vite',
		emptyOutDir: true,
		rollupOptions: {
			input: virtualEntry,
		},
	},
	plugins: [ themeArtifacts() ],
} );
