/*
## @author mrdoob / http://mrdoob.com/
*/

define(function() {
  var Stats;
  return Stats = function() {
    var bar, container, fps, fpsDiv, fpsGraph, fpsMax, fpsMin, fpsText, frames, mode, ms, msDiv, msGraph, msMax, msMin, msText, prevTime, setMode, startTime, updateGraph;
    startTime = Date.now();
    prevTime = startTime;
    ms = 0;
    msMin = 1000;
    msMax = 0;
    fps = 0;
    fpsMin = 1000;
    fpsMax = 0;
    frames = 0;
    mode = 0;
    mode;
    container = document.createElement('div');
    container.id = 'stats';
    container.addEventListener('mousedown', function(event) {
      event.preventDefault();
      return setMode(++mode % 2);
    }, false);
    container.style.cssText = 'width:80px;opacity:0.9;cursor:pointer';
    fpsDiv = document.createElement('div');
    fpsDiv.id = 'fps';
    fpsDiv.style.cssText = 'padding:0 0 3px 3px;text-align:left;background-color:#002';
    container.appendChild(fpsDiv);
    fpsText = document.createElement('div');
    fpsText.id = 'fpsText';
    fpsText.style.cssText = 'color:#0ff;font-family:Helvetica,Arial,sans-serif;font-size:9px;font-weight:bold;line-height:15px';
    fpsText.innerHTML = 'FPS';
    fpsDiv.appendChild(fpsText);
    fpsGraph = document.createElement('div');
    fpsGraph.id = 'fpsGraph';
    fpsGraph.style.cssText = 'position:relative;width:74px;height:30px;background-color:#0ff';
    fpsDiv.appendChild(fpsGraph);
    while (fpsGraph.children.length < 74) {
      bar = document.createElement('span');
      bar.style.cssText = 'width:1px;height:30px;float:left;background-color:#113';
      fpsGraph.appendChild(bar);
    }
    msDiv = document.createElement('div');
    msDiv.id = 'ms';
    msDiv.style.cssText = 'padding:0 0 3px 3px;text-align:left;background-color:#020;display:none';
    container.appendChild(msDiv);
    msText = document.createElement('div');
    msText.id = 'msText';
    msText.style.cssText = 'color:#0f0;font-family:Helvetica,Arial,sans-serif;font-size:9px;font-weight:bold;line-height:15px';
    msText.innerHTML = 'MS';
    msDiv.appendChild(msText);
    msGraph = document.createElement('div');
    msGraph.id = 'msGraph';
    msGraph.style.csstext = 'position:relative;width:74px;height:30px;background-color:#0f0';
    msDiv.appendChild(msGraph);
    while (msGraph.children.length < 74) {
      bar = document.createElement('span');
      bar.style.cssText = 'width:1px;height:30px;float:left;background-color:#131';
      msGraph.appendChild(bar);
    }
    setMode = function(value) {
      mode = value;
      switch (mode) {
        case 0:
          fpsDiv.style.display = 'block';
          msDiv.style.display = 'none';
          break;
        case 1:
          fpsDiv.style.display = 'none';
          msDiv.style.display = 'block';
      }
    };
    updateGraph = function(dom, value) {
      var child;
      child = dom.appendChild(dom.firstChild);
      child.style.height = value + 'px';
    };
    return {
      domElement: container,
      setMode: setMode,
      current: function() {
        return fps;
      },
      begin: function() {
        startTime = Date.now();
      },
      end: function() {
        var time;
        time = Date.now();
        ms = time - startTime;
        msMin = Math.min(msMin, ms);
        msMax = Math.max(msMax, ms);
        msText.textContent = ms + ' MS (' + msMin + '-' + msMax + ')';
        updateGraph(msGraph, Math.min(30, 30 - (ms / 200) * 30));
        frames++;
        if (time > prevTime + 1000) {
          fps = Math.round((frames * 1000) / (time - prevTime));
          fpsMin = Math.min(fpsMin, fps);
          fpsMax = Math.max(fpsMax, fps);
          fpsText.textContent = fps + ' FPS (' + fpsMin + '-' + fpsMax + ')';
          updateGraph(fpsGraph, Math.min(30, 30 - (fps / 100) * 30));
          prevTime = time;
          frames = 0;
        }
        return time;
      },
      update: function() {
        startTime = this.end();
      }
    };
  };
});
