
module.exports = function(grunt) {

    /***************************
    *   Register taks
    ***************************/

    grunt.registerTask('build_the_css', ['less','cssmin']);
    grunt.registerTask('default', ['build_the_css', 'watch']);

    /*****************************************
    *   Grunt configuration
    *****************************************/
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

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

};
