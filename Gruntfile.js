module.exports = function(grunt) {
	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),
		sass : {
			addressMaps : {
				options : {
					style : 'compressed'
				},
				files : {
					'ui/css/pods-address-maps.css' : 'ui/css/sass/**/*.scss'
				}
			}
		},
		concat : {
			addressMaps : {
				src : 'ui/js/src/**/*.js',
				dest : 'ui/js/pods-address-maps.js'
			}
		},
		watch : {
			sass : {
				files : ['ui/css/sass/**/*.scss','ui/js/src/**/*.js'],
				tasks : ["sass","concat"]
			}
		}

	});
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default',['sass','concat']);
}