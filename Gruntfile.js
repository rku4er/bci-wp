'use strict';
module.exports = function(grunt) {
  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  var rootPath = '/home/nblxtap/HTTPdocs/bci-wp/www/wp-content/themes/roots/';

  var jsFileList = [
    'assets/vendor/bootstrap/js/transition.js',
    'assets/vendor/bootstrap/js/alert.js',
    'assets/vendor/bootstrap/js/button.js',
    'assets/vendor/bootstrap/js/carousel.js',
    'assets/vendor/bootstrap/js/collapse.js',
    'assets/vendor/bootstrap/js/dropdown.js',
    'assets/vendor/bootstrap/js/modal.js',
    'assets/vendor/bootstrap/js/tooltip.js',
    'assets/vendor/bootstrap/js/popover.js',
    'assets/vendor/bootstrap/js/scrollspy.js',
    'assets/vendor/bootstrap/js/tab.js',
    'assets/vendor/bootstrap/js/affix.js',
    'assets/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js',
    'assets/vendor/jquery.easing/jquery.easing.1.3.js',
    //'assets/vendor/jquery-mousewheel/jquery.mousewheel.js',
    //'assets/vendor/Columnizer-jQuery-Plugin/src/jquery.columnizer.js',
    //'assets/vendor/jquery-waypoints/waypoints.js',
    'assets/js/plugins/*.js',
    'assets/js/_*.js'
  ];

  grunt.initConfig({
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'assets/js/*.js',
        '!assets/js/scripts.js',
        '!assets/**/*.min.*'
      ],
      gruntfile: [
        'Gruntfile.js'
      ]
    },
    less: {
      dev: {
        files: {
          'assets/css/main.css': [
            'assets/less/main.less'
          ]
        },
        options: {
          compress: false,
          // LESS source map
          // To enable, set sourceMap to true and update sourceMapRootpath based on your install
          sourceMap: true,
          sourceMapFilename: 'assets/css/main.css.map',
          sourceMapRootpath: rootPath
        }
      },
      build: {
        files: {
          'assets/css/main.min.css': [
            'assets/less/main.less'
          ]
        },
        options: {
          compress: true
        }
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [jsFileList],
        dest: 'assets/js/scripts.js',
      },
    },
    uglify: {
      dist: {
        options: {
          sourceMap: true,
          sourceMapName: 'assets/js/scripts.js.map'
        },
        files: {
          'assets/js/scripts.min.js': [jsFileList]
        }
      }
    },
    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
      },
      dev: {
        options: {
          map: {
            prev: 'assets/css/'
          }
        },
        src: 'assets/css/main.css'
      },
      build: {
        src: 'assets/css/main.min.css'
      }
    },
    delete_sync: {
      dist: {
        cwd: 'assets/img/bg/',
        src: ['**/*.{png,jpg,gif,svg}'],
        syncWith: 'assets/src/bg/'
      }
    },
    clean: {
      ftp: {
        options: {
          force: true
        },
        src: ['../roots_ftp/*', '!../roots_ftp/style.css']
      },
      icons: {
        src: ['assets/css/icons.*.css', 'assets/css/*.{txt,html}', 'assets/img/icons/*']
      }
    },
    copy: {
      toftp: {
        files: [
          {
            expand: true,
            src: [
              '*.{php,css,png}',
              '!style.css',
              'lang/*',
              'lib/*',
              'templates/*',
              'assets/{fonts,img}/**/*',
              'assets/{css,js}/{main,scripts}.min.{css,js}',
              'assets/js/vendor/modernizr.min.js',
              'assets/css/editor-style.css',
              'assets/css/icons.*.css'
            ],
            dest: '../roots_ftp/'
          }
        ]
      }
    },
    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'assets/src/bg/',
          src: ['**/*.{png,jpg,gif,svg}'],
          dest: 'assets/img/bg/'
        }]
      }
    },
    grunticon: {
      icons: {
        files: [{
          expand: true,
          cwd: 'assets/src/svg/',
          src: ['**/*.{svg,png}'],
          dest: 'assets/css/'
        }],
        options: {
          datasvgcss: 'icons.data.svg.css',
          datapngcss: 'icons.data.png.css',
          urlpngcss: 'icons.fallback.css',
          previewhtml: 'preview.html',
          loadersnippet: 'grunticon.loader.txt',
          pngfolder: '../img/icons/',
          cssprefix: '.icon-',
          customselectors: {
            //'*': ['.icon-$1:before']
          },
          defaultWidth: '20px',
          defaultHeight: '20px',
          colors: {
            'dark' : '#444'
          }
        }
      }
    },
    modernizr: {
      build: {
        devFile: 'assets/vendor/modernizr/modernizr.js',
        outputFile: 'assets/js/vendor/modernizr.min.js',
        files: {
          src: ['assets/js/scripts.min.js', 'assets/css/main.min.css']
        },
        uglify: true,
        parseFiles: true
      }
    },
    version: {
      default: {
        options: {
          format: true,
          length: 32,
          manifest: 'assets/manifest.json',
          querystring: {
            style: 'roots_css',
            script: 'roots_js'
          }
        },
        files: {
          'lib/scripts.php': 'assets/{css,js}/{main,scripts}.min.{css,js}'
        }
      }
    },
    watch: {
      gruntfile: {
        files: 'Gruntfile.js',
        tasks: ['jshint:gruntfile']
      },
      less: {
        files: [
          'assets/less/**/*.less'
        ],
        tasks: ['less:dev', 'autoprefixer:dev']
      },
      js: {
        files: [
          jsFileList,
          '<%= jshint.all %>'
        ],
        tasks: ['jshint', 'concat']
      },
      images: {
        files: [
          'assets/src/bg/**/*.{png,jpg,gif,svg}'
        ],
        tasks: ['delete_sync', 'newer:imagemin:dynamic']
      },
      icons: {
        files: [
          'assets/src/svg/**/*.svg'
        ],
        tasks: ['clean:icons', 'grunticon:icons']
      },
      livereload: {
        // Browser live reloading
        // https://github.com/gruntjs/grunt-contrib-watch#live-reloading
        options: {
          livereload: true
        },
        files: [
          'assets/css/main.css',
          'assets/js/scripts.js',
          '**/*.php'
        ]
      }
    }
  });

  // Register tasks
  grunt.registerTask('default', [
    'dev'
  ]);
  grunt.registerTask('dev', [
    'jshint',
    'less:dev',
    'autoprefixer:dev',
    'concat',
    'clean:icons',
    'grunticon',
    'delete_sync',
    'newer:imagemin'
  ]);
  grunt.registerTask('build', [
    'jshint',
    'less:build',
    'autoprefixer:build',
    'uglify',
    'modernizr',
    'clean:icons',
    'grunticon',
    'delete_sync',
    'newer:imagemin',
    'version',
    'clean:ftp',
    'copy:toftp'
  ]);
};