define(['lib/stats', 'lib/dom', 'lib/utils'], function(Stats, DOM, Util) {
  var Game;
  Game = {
    run: function(opts) {
      Game.loadImgs(opts.imgs, function(image) {
        var canvas, dt, frame, gdt, last, now, render, stats, step, update;
        opts.ready(image);
        Game.setKeyListener(opts.keys);
        canvas = opts.canvas;
        update = opts.update;
        render = opts.render;
        step = opts.step;
        stats = opts.stats;
        now = null;
        last = Util.timestamp();
        dt = 0;
        gdt = 0;
        frame = function() {
          now = Util.timestamp();
          dt = Math.min(1, (now - last) / 1000);
          gdt = gdt + dt;
          while (gdt > step) {
            gdt = gdt - step;
            update(step);
          }
          render();
          stats.update();
          last = now;
          requestAnimationFrame(frame, canvas);
        };
        frame();
      });
    },
    loadImgs: function(names, callback) {
      var count, i, name, onload, result, _i, _len;
      result = [];
      count = names.length;
      onload = function() {
        if (--count === 0) {
          callback(result);
        }
      };
      for (i = _i = 0, _len = names.length; _i < _len; i = _i += 1) {
        name = names[i];
        result[i] = document.createElement('img');
        DOM.on(result[_i], 'load', onload);
        result[i].src = "images/" + name + ".png";
      }
    },
    setKeyListener: function(keys) {
      var onKey;
      onKey = function(keyCode, mode) {
        var i, item, _results;
        i = 0;
        _results = [];
        while (i < keys.length) {
          item = keys[i];
          item.mode = item.mode || 'up';
          if ((item.key === keyCode) || (item.keys && item.keys.indexOf(keyCode) >= 0)) {
            if (item.mode === mode) {
              item.action.call();
            }
          }
          _results.push(i++);
        }
        return _results;
      };
      DOM.on(document, 'keydown', function(ev) {
        return onKey(ev.keyCode, 'down');
      });
      DOM.on(document, 'keyup', function(ev) {
        return onKey(ev.keyCode, 'up');
      });
    },
    stats: function(parentId, id) {
      var msg, result, value;
      result = new Stats();
      result.domElement.id = id || 'stats';
      DOM.get(parentId).appendChild(result.domElement);
      msg = document.createElement('div');
      msg.style.cssText = "border: 2px solid gray; padding: 5px; margin-top: 5px; text-align: left; font-size: 1.15em; text-align:right;";
      msg.innerHTML = "Your canvas performance is";
      DOM.get(parentId).appendChild(msg);
      value = document.createElement('span');
      value.innerHTML = "...";
      msg.appendChild(value);
      setInterval(function() {
        var color, fps, ok;
        fps = result.current();
        ok = fps > 50 ? 'good' : fps < 30 ? 'bad' : 'ok';
        color = fps > 50 ? 'green' : fps < 30 ? 'red' : 'gray';
        value.innerHTML = ok;
        value.style.color = color;
        return msg.style.borderColor = color;
      }, 5000);
      return result;
    },
    playMusic: function() {
      var music;
      music = DOM.get('music');
      music.loop = true;
      music.volume = 0.05;
      music.muted = DOM.storage.muted === true;
      music.play();
      DOM.toggleClassName('mute', 'on', music.muted);
      DOM.on('mute', 'click', function() {
        DOM.storage.muted = music.muted = !music.muted;
        return DOM.toggleClassName('mute', 'on', music.muted);
      });
    }
  };
  return Game;
});
