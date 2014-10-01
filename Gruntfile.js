'use strict';
module.exports = function(grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

    grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
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
		        src: 'js/combined-min.js',
		        dest: 'js/combined-min.js'
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
		}

	});

    grunt.registerTask( 'release', [
		'autoprefixer',
		'csscomb',
		'concat',
		'uglify',
		'makepot',
		'cssjanus'
	]);

};