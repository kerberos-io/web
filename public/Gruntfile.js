
module.exports = function(grunt) {

    /***************************
    *   Register taks
    ***************************/

    grunt.registerTask('build_the_css', ['less','cssmin']);
    grunt.registerTask('default', ['build_the_css', 'watch']);
    grunt.registerTask('cleanUpJS', ['clean']);

    /*****************************************
    *   Grunt configuration
    *****************************************/
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        clean: {
          videojs: [
            'js/vendor/video.js/dist/video-js-*',
            'js/vendor/video.js/dist/alt/',
            'js/vendor/video.js/src/',
          ],
          bootstrap: [
            'js/vendor/bootstrap/dist/css/',
            'js/vendor/bootstrap/grunt/',
            'js/vendor/bootstrap/fonts/',
            'js/vendor/bootstrap/Gruntfile.js',
            'js/vendor/bootstrap/bower.js',
            'js/vendor/bootstrap/CHANGELOG.md',
          ],
          moment: [
            'js/vendor/moment/min/',
          ],
          fontawesome: [
            'js/vendor/fontawesome/scss/',
          ],
          'eonasdan-bootstrap-datetimepicker': [
            'js/vendor/eonasdan-bootstrap-datetimepicker/src/',
          ],
          'owl.carousel': [
            'js/vendor/owl.carousel/docs/',
            'js/vendor/owl.carousel/docs_src/',
          ],
        },

        /*****************************************
        *   CSS Operations
        *********
                *   LESS COMPILING
                **********************************/

        less: {
            dist: {
                src: ['css/less/main.less'],
                dest: 'css/kerberos.css'  // styles.less is main file, which includes
                                                // all other .less files
            }
        },
                /*****************************************
                *           MINIFY
                *****************************************/

        cssmin: {
            minify: {
                expand: true,
                cwd: 'css/',
                src: 'kerberos.css',
                dest: 'css/',
                ext: '.min.css'
            }
        },

    /*****************************************
    *   WATCHING FILES (DO BROWSER RELOAD)
    *****************************************/

        watch: {
            html: {
                files: ['../app/views/**/**/*'],
                options: { livereload: true },
            },
            css: {
                files: ['css/**/**/**/**/*.less'],
                tasks: ['build_the_css'],
                options: { livereload: true },
            },
        },
    });

    /***************************
    *   LOAD GRUNT DEPENDENCIES
    ***************************/

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-clean');

};
