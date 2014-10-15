module.exports = function(grunt) {
  grunt.initConfig({

    //imagemin
    imagemin: {
        dynamic: {
            options: {
                optimizationLevel: 4
            },
            files: [{
                expand: true,                   // Enable dynamic expansion
                cwd: '../wp-content/uploads',   // Src matches are relative to this path
                src: ['**/*.{png,jpg,gif,svg}'],// Actual patterns to match
                dest: '../wp-content/cc'        // Destination path prefix
            }]
        }
    },

     //copy
      copy: {
          libs: {
              options: {
                  
              },
              expand: true,
              cwd: path.static+'js/source/libs/',
              src: ['**/*.js'],
              dest: path.static+'js/dist/libs/',
              ext: '.js'
          },
          favicon : {
              src: path.imgSrc+'favicon.ico',
              dest: path.static+'img/favicon.ico'
          }
      }
  });
 
  // Cargar tarea
  grunt.loadNpmTasks('grunt-newer');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
};
