'use strict';
module.exports = function(grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

    grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			files: ['scss/*.scss'],
			tasks: 'sass',
			options: {
				livereload: true,
			},
		},
		sass: {
			default: {
		  		options : {
			  		style : 'expanded'
			  	},
			  	files: {
					'style.css':'scss/style.scss',
				}
			}
		},
		autoprefixer: {
            options: {
				browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1', 'ie 9']
			},
			single_file: {
				src: 'style.css',
				dest: 'style.css'
			}
		},
		csscomb: {
	        release: {
	            options: {
	                config: '.csscomb.json'
	            },
	            files: {
	                'style.css': ['style.css'],
	            }
	        }
	    },
		concat: {
			release: {
		        src: [
		            'js/navigation.js',
		            'js/jquery.fitvids.js',
		        ],
		        dest: 'js/combined-min.js'
	        }
		},
		uglify: {
		    release: {
		    	files: [
					{
						src: 'js/combined-min.js',
						dest: 'js/combined-min.js'
					},
					{
						src: 'js/jquery.infinitescroll.js',
						dest: 'js/jquery.infinitescroll.min.js'
					}
				]
		    }
		},
    	// https://www.npmjs.org/package/grunt-wp-i18n
	    makepot: {
	        target: {
	            options: {
	                domainPath: '/languages/',    // Where to save the POT file.
	                potFilename: 'portfolio-plus.pot',   // Name of the POT file.
	                type: 'wp-theme'  // Type of project (wp-plugin or wp-theme).
	            }
	        }
	    },
		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
				},
				files: [
					{
						src: 'style.css',
						dest: 'style-rtl.css'
					}
				]
			}
		},
		replace: {
			styleVersion: {
				src: [
					'scss/style.scss',
				],
				overwrite: true,
				replacements: [{
					from: /Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				}]
			},
			functionsVersion: {
				src: [
					'functions.php'
				],
				overwrite: true,
				replacements: [ {
					from: /^define\( 'PORTFOLIO_VERSION'.*$/m,
					to: 'define( \'PORTFOLIO_VERSION\', \'<%= pkg.version %>\' );'
				} ]
			},
		}

	});

	grunt.registerTask( 'default', [
		'sass',
		'autoprefixer',
    ]);

    grunt.registerTask( 'release', [
	    'replace',
	    'sass',
		'autoprefixer',
		'csscomb',
		'concat',
		'uglify',
		'makepot',
		'cssjanus'
	]);

};