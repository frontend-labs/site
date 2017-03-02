define(['../lib/debugger'], function(Debugger) {
  var Util;
  Util = {
    timestamp: function() {
      return new Date().getTime();
    },
    toInt: function(obj, def) {
      var x;
      if (obj != null) {
        x = parseInt(obj, 10);
        if (!isNaN(x)) {
          return x;
        }
      }
      return Util.toInt(def, 0);
    },
    toFloat: function(obj, def) {
      var x;
      if (obj != null) {
        x = parseFloat(obj);
        if (!isNaN(x)) {
          return x;
        }
      }
      return Util.toFloat(def, 0.0);
    },
    limit: function(value, min, max) {
      return Math.max(min, Math.min(value, max));
    },
    randomInt: function(min, max) {
      return Math.round(Util.interpolate(min, max, Math.random()));
    },
    randomChoice: function(opts) {
      return opts[Util.randomInt(0, opts.length - 1)];
    },
    percentRemaining: function(n, total) {
      return (n % total) / total;
    },
    accelerate: function(v, accel, dt) {
      return v + (accel * dt);
    },
    interpolate: function(a, b, percent) {
      return a + (b - a) * percent;
    },
    easeIn: function(a, b, percent) {
      return a + (b - a) * Math.pow(percent, 2);
    },
    easeOut: function(a, b, percent) {
      return a + (b - a) * (1 - Math.pow(1 - percent, 2));
    },
    easeInOut: function(a, b, percent) {
      return a + (b - a) * ((-Math.cos(percent * Math.PI) / 2) + 0.5);
    },
    exponentialFog: function(distance, density) {
      return 1 / (Math.pow(Math.E, distance * distance * density));
    },
    increase: function(start, increment, max) {
      var result;
      result = start + increment;
      while (result >= max) {
        result -= max;
      }
      while (result < 0) {
        result += max;
      }
      return result;
    },
    project: function(p, camX, camY, camZ, camDepth, width, height, roadWidth) {
      p.camera.x = (p.world.x || 0) - camX;
      p.camera.y = (p.world.y || 0) - camY;
      p.camera.z = (p.world.z || 0) - camZ;
      p.screen.scale = camDepth / p.camera.z;
      p.screen.x = Math.round((width / 2) + (p.screen.scale * p.camera.x * width / 2));
      p.screen.y = Math.round((height / 2) - (p.screen.scale * p.camera.y * height / 2));
      p.screen.w = Math.round(p.screen.scale * roadWidth * width / 2);
    },
    overlap: function(x1, w1, x2, w2, percent) {
      var half, max1, max2, min1, min2;
      half = percent || 1 / 2;
      min1 = x1 - (w1 * half);
      max1 = x1 + (w1 * half);
      min2 = x2 - (w2 * half);
      max2 = x2 + (w2 * half);
      return !((max1 < min2) || (min1 > max2));
    }
  };
  return Util;
});
