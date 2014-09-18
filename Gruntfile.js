module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		jshint: {
			all: ['Gruntfile.js', 'js/app.js']
		},

		uglify: {
			dist: {
				files: {
					'js/app.min.js': 'js/app.js'
				}
			}
		},

		watch: {
			scripts: {
				files: ['js/app.js', 'Gruntfile.js'],
				tasks: ['jshint']
			}
		}
	});

	// Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task(s).
	grunt.registerTask('default', ['watch']);

};