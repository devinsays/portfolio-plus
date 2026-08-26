/**
 * Syncs the package.json version into the theme's two other version locations.
 *
 * Replaces the old grunt-text-replace tasks. Run it after bumping the version
 * in package.json, then rebuild so style.css picks up the new header:
 *
 *   pnpm version-bump && pnpm build
 */

import { readFile, writeFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const themeDir = resolve( dirname( fileURLToPath( import.meta.url ) ), '..' );

const { version } = JSON.parse(
	await readFile( resolve( themeDir, 'package.json' ), 'utf8' )
);

const replacements = [
	{
		file: 'scss/style.scss',
		pattern: /^Version:.*$/m,
		replacement: `Version: ${ version }`,
	},
	{
		file: 'functions.php',
		pattern: /^define\( 'PORTFOLIO_VERSION'.*$/m,
		replacement: `define( 'PORTFOLIO_VERSION', '${ version }' );`,
	},
];

for ( const { file, pattern, replacement } of replacements ) {
	const path = resolve( themeDir, file );
	const contents = await readFile( path, 'utf8' );
	const match = contents.match( pattern );

	if ( ! match ) {
		console.error( `${ file }: no version line matched, skipped.` );
		process.exitCode = 1;
		continue;
	}

	if ( match[ 0 ] === replacement ) {
		console.log( `${ file }: already at ${ version }.` );
		continue;
	}

	await writeFile( path, contents.replace( pattern, replacement ) );
	console.log( `${ file }: ${ match[ 0 ] } -> ${ replacement }` );
}
