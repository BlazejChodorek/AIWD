module.exports = function (grunt) {
    grunt.initConfig({

        browserSync: {
            dev: {
                bsFiles: {
                    src: [
                        'css/*.css',
                        '*.html',
                        'js/*.js'
                    ]
                },
                options: {
                    watchTask: true,
                    server: './',
                    ui: {
                        port: 8889,
                        weinre: {
                            port: 9999
                        }
                    },
                    port: 8888
                }
            }
        },
        postcss: {
            options: {
                map: true,
                processors: [
                    require('autoprefixer')({
                        browsers: ['last 20 versions', 'ie 7-11']
                    })
                ]
            },
            dist: {
                src: 'css/*.css'
            }
        },
        sass: {
            options: {
                sourceMap: true,
                outputStyle: 'compressed'
            },
            dist: {
                files: {
                    'web/css/main.min.css': 'dev/scss/main.scss'
                }
            }
        },
        
        watch: {
            files: 'dev/**/*.scss',
            tasks: ['sass', 'postcss:dist']
        }
    });


    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');

    grunt.registerTask('default', ['browserSync', 'watch']);
    grunt.registerTask('build-css', ['sass', 'postcss:dist']);
};
