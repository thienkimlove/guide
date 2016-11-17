module.exports = function(grunt) {
  // Project configuration
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    autoprefixer: {
      options: {
        browsers: ['Android >= 2.1', 'Chrome >= 21', 'Explorer >= 8', 'Firefox >= 17', 'Opera >= 12.1', 'Safari >= 6.0']
      },
      core: {
        expand: true,
        src: ['style.css', 'rtl.css']
      }
    },

    concat: {
      core: {
        src: ['js/plugins/*.js'],
        dest: 'js/plugins.js'
      }
    },

    less: {
      core: {
        options: {
          paths: ["css/"]
          //plugins: [
          //	new (require('less-plugin-clean-css'))({cleancss: true})
          //]
        },
        files: {
          "css/style.css": "less/style.less"

        }
      }
    },

    jshint: {
      options: {
        "boss": true,
        "curly": true,
        "eqeqeq": false,
        "eqnull": true,
        "es3": true,
        "expr": true,
        "immed": true,
        "noarg": true,
        "onevar": true,
        "quotmark": "single",
        "trailing": true,
        "undef": true,
        "unused": true,
        "ignores": ['js/plugins/'],
        "browser": true,

        "globals": {
          "jQuery": false,
          "google": true,
          "YT": true,
          "WOW": true
        }
      },
      core: {
        expand: true,
        cwd: 'js/',
        src: [
          'scripts.js',
          '!plugins.js'
        ]
      }
    },

    uglify: {
      core: {
        expand: true,
        cwd: 'js/',
        dest: 'js/',
        ext: '.min.js',
        src: [
            'main.js'
        ]
      }
    },

    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'img/',
          src: ['**/*.{png,jpg,gif}'],
          dest: 'img/'
        }]
      }
    },

    watch: {
      options: {
        livereload: true
      },
      jsdev: {
        files: ['js/*.js'],
        tasks: ['uglify']
      },
      mergejs: {
        files: ['js/plugins/**'],
        tasks: ['concat']
      },
      less: {
        files: ['less/*.less'],
        tasks: ['less', 'autoprefixer'],
        options: {
          livereload: false
        }
      },
      core: {
        files: ['*.php', 'parts/*.php', 'inc/*.php', 'inc/**/*.php', '!inc/backend/*.php'],
        tasks: []
      }
    }
  });

  // Load tasks.
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  //grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Register makepot task
  grunt.registerTask('buildstart', ['replace:core']);

  // Register dev task
  grunt.registerTask('dev', ['concat', 'less', 'watch']);

  // Register default tasks
  grunt.registerTask('default', ['concat', 'less', 'autoprefixer', 'uglify', 'imagemin', 'watch']);
};
