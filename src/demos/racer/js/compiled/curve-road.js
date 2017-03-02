define(['lib/dom', 'lib/utils', 'lib/debugger', 'lib/render', 'lib/game', 'lib/stats', 'settings/key', 'settings/background', 'settings/colors'], function(DOM, Util, Debugger, Render, Game, Stats, KEY, BACKGROUND, COLORS) {
  var ROAD, accel, addCurve, addRoad, addSCurves, addSegment, addStraight, background, breaking, camDepth, camHeight, canvas, centrifugal, ctx, decel, drawDistance, fieldOfView, findSegment, fogDensity, fps, height, hillOffset, hillSpeed, keyFaster, keyLeft, keyRight, keySlower, lanes, maxSpeed, offRoadDecel, offRoadLimit, playerX, playerZ, position, render, reset, resetRoad, resolution, roadWidth, rumbleLength, segmentLength, segments, skyOffset, skySpeed, speed, sprites, stats, step, trackLength, treeOffset, treeSpeed, update, width;
  fps = 60;
  step = 1 / fps;
  width = 1024;
  height = 768;
  centrifugal = 0.3;
  offRoadDecel = 0.99;
  skySpeed = 0.001;
  hillSpeed = 0.002;
  treeSpeed = 0.003;
  skyOffset = 0;
  hillOffset = 0;
  treeOffset = 0;
  segments = [];
  stats = Game.stats('fps');
  canvas = DOM.get('canvas');
  ctx = canvas.getContext('2d');
  background = null;
  sprites = null;
  resolution = null;
  roadWidth = 2000;
  segmentLength = 200;
  rumbleLength = 3;
  trackLength = null;
  lanes = 3;
  fieldOfView = 100;
  camHeight = 1000;
  camDepth = null;
  drawDistance = 300;
  playerX = 0;
  playerZ = null;
  fogDensity = 5;
  position = 0;
  speed = 0;
  maxSpeed = segmentLength / step;
  accel = maxSpeed / 5;
  breaking = -maxSpeed;
  decel = -maxSpeed / 5;
  offRoadDecel = -maxSpeed / 2;
  offRoadLimit = maxSpeed / 4;
  keyLeft = false;
  keyRight = false;
  keyFaster = false;
  keySlower = false;
  ROAD = {
    LENGTH: {
      NONE: 0,
      SHORT: 25,
      MEDIUM: 50,
      LONG: 100
    },
    CURVE: {
      NONE: 0,
      EASY: 2,
      MEDIUM: 4,
      HARD: 6
    }
  };
  update = function(dt) {
    var dx, playerSegment, speedPercent;
    playerSegment = findSegment(position + playerZ);
    speedPercent = speed / maxSpeed;
    dx = dt * 2 * speedPercent;
    position = Util.increase(position, dt * speed, trackLength);
    skyOffset = Util.increase(skyOffset, skySpeed * playerSegment.curve * speedPercent, 1);
    hillOffset = Util.increase(hillOffset, hillSpeed * playerSegment.curve * speedPercent, 1);
    treeOffset = Util.increase(treeOffset, treeSpeed * playerSegment.curve * speedPercent, 1);
    if (keyLeft) {
      playerX = playerX - dx;
    } else if (keyRight) {
      playerX = playerX + dx;
    }
    playerX = playerX - (dx * speedPercent * playerSegment.curve * centrifugal);
    if (keyFaster) {
      speed = Util.accelerate(speed, accel, dt);
    } else if (keySlower) {
      speed = Util.accelerate(speed, breaking, dt);
    } else {
      speed = Util.accelerate(speed, decel, dt);
    }
    if (((playerX < -1) || (playerX > 1)) && (speed > offRoadLimit)) {
      speed = Util.accelerate(speed, offRoadDecel, dt);
    }
    playerX = Util.limit(playerX, -2, 2);
    speed = Util.limit(speed, 0, maxSpeed);
  };
  render = function() {
    var basePercent, baseSegment, dx, maxy, n, segment, x;
    baseSegment = findSegment(position);
    basePercent = Util.percentRemaining(position, segmentLength);
    maxy = height;
    x = 0;
    dx = -(baseSegment.curve * basePercent);
    ctx.clearRect(0, 0, width, height);
    Render.background(ctx, background, width, height, BACKGROUND.SKY, skyOffset);
    Render.background(ctx, background, width, height, BACKGROUND.HILLS, hillOffset);
    Render.background(ctx, background, width, height, BACKGROUND.TREES, treeOffset);
    n = 0;
    while (n < drawDistance) {
      segment = segments[(baseSegment.index + n) % segments.length];
      segment.looped = segment.index < baseSegment.index;
      segment.fog = Util.exponentialFog(n / drawDistance, fogDensity);
      Util.project(segment.p1, (playerX * roadWidth) - x, camHeight, position - (segment.looped ? trackLength : 0), camDepth, width, height, roadWidth);
      Util.project(segment.p2, (playerX * roadWidth) - x - dx, camHeight, position - (segment.looped ? trackLength : 0), camDepth, width, height, roadWidth);
      x = x + dx;
      dx = dx + segment.curve;
      n++;
      if ((segment.p1.camera.z <= camDepth) || (segment.p2.screen.y >= maxy)) {
        continue;
      }
      Render.segment(ctx, width, lanes, segment.p1.screen.x, segment.p1.screen.y, segment.p1.screen.w, segment.p2.screen.x, segment.p2.screen.y, segment.p2.screen.w, segment.fog, segment.color);
      maxy = segment.p2.screen.y;
    }
    Render.player(ctx, width, height, resolution, roadWidth, sprites, speed / maxSpeed, camDepth / playerZ, width / 2, height, speed * (keyLeft ? -1 : keyRight ? 1 : 0), 0);
  };
  addSegment = function(curve) {
    var n;
    n = segments.length;
    segments.push({
      index: n,
      p1: {
        world: {
          z: n * segmentLength
        },
        camera: {},
        screen: {}
      },
      p2: {
        world: {
          z: (n + 1) * segmentLength
        },
        camera: {},
        screen: {}
      },
      curve: curve,
      color: Math.floor(n / rumbleLength) % 2 ? COLORS.DARK : COLORS.LIGHT
    });
  };
  addRoad = function(enter, hold, leave, curve) {
    var nEnter, nHold, nLeave, _results;
    nEnter = 0;
    nHold = 0;
    nLeave = 0;
    while (nEnter < enter) {
      addSegment(Util.easeIn(0, curve, nEnter / enter));
      nEnter++;
    }
    while (nHold < hold) {
      addSegment(curve);
      nHold++;
    }
    _results = [];
    while (nLeave < leave) {
      addSegment(Util.easeInOut(curve, 0, nLeave / leave));
      _results.push(nLeave++);
    }
    return _results;
  };
  addStraight = function(n) {
    var num;
    num = n || ROAD.LENGTH.MEDIUM;
    addRoad(num, num, num, 0);
  };
  addCurve = function(n, c) {
    var curve, num;
    num = n || ROAD.LENGTH.MEDIUM;
    curve = c || ROAD.CURVE.MEDIUM;
    addRoad(num, num, num, curve);
  };
  addSCurves = function() {
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, -ROAD.CURVE.EASY);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.CURVE.EASY);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, -ROAD.CURVE.EASY);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, -ROAD.CURVE.MEDIUM);
  };
  resetRoad = function() {
    var nRumble;
    segments = [];
    addStraight(ROAD.LENGTH.SHORT / 4);
    addSCurves();
    addStraight(ROAD.LENGTH.LONG);
    addCurve(ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM);
    addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM);
    addStraight();
    addSCurves();
    addCurve(ROAD.LENGTH.LONG, -ROAD.CURVE.MEDIUM);
    addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM);
    addStraight();
    addSCurves();
    addCurve(ROAD.LENGTH.LONG, -ROAD.CURVE.EASY);
    segments[findSegment(playerZ).index + 2].color = COLORS.START;
    segments[findSegment(playerZ).index + 3].color = COLORS.START;
    nRumble = 0;
    while (nRumble < rumbleLength) {
      segments[segments.length - 1 - nRumble].color = COLORS.FINISH;
      nRumble++;
    }
    trackLength = segments.length * segmentLength;
  };
  findSegment = function(z) {
    return segments[Math.floor(z / segmentLength) % segments.length];
  };
  Game.run({
    canvas: canvas,
    render: render,
    update: update,
    stats: stats,
    step: step,
    imgs: ["background", "sprites"],
    keys: [
      {
        keys: [KEY.LEFT, KEY.A],
        mode: 'down',
        action: function() {
          keyLeft = true;
        }
      }, {
        keys: [KEY.RIGHT, KEY.D],
        mode: 'down',
        action: function() {
          keyRight = true;
        }
      }, {
        keys: [KEY.UP, KEY.W],
        mode: 'down',
        action: function() {
          keyFaster = true;
        }
      }, {
        keys: [KEY.DOWN, KEY.S],
        mode: 'down',
        action: function() {
          keySlower = true;
        }
      }, {
        keys: [KEY.LEFT, KEY.A],
        mode: 'up',
        action: function() {
          keyLeft = false;
        }
      }, {
        keys: [KEY.RIGHT, KEY.D],
        mode: 'up',
        action: function() {
          keyRight = false;
        }
      }, {
        keys: [KEY.UP, KEY.W],
        mode: 'up',
        action: function() {
          keyFaster = false;
        }
      }, {
        keys: [KEY.DOWN, KEY.S],
        mode: 'up',
        action: function() {
          keySlower = false;
        }
      }
    ],
    ready: function(images) {
      background = images[0];
      sprites = images[1];
      reset();
    }
  });
  reset = function(opts) {
    var options;
    options = opts || {};
    canvas.width = width = Util.toInt(options.width, width);
    canvas.height = height = Util.toInt(options.height, height);
    lanes = Util.toInt(options.lanes, lanes);
    roadWidth = Util.toInt(options.roadWidth, roadWidth);
    camHeight = Util.toInt(options.camHeight, camHeight);
    drawDistance = Util.toInt(options.drawDistance, drawDistance);
    fogDensity = Util.toInt(options.fogDensity, fogDensity);
    fieldOfView = Util.toInt(options.fieldOfView, fieldOfView);
    segmentLength = Util.toInt(options.segmentLength, segmentLength);
    rumbleLength = Util.toInt(options.rumbleLength, rumbleLength);
    camDepth = 1 / Math.tan((fieldOfView / 2) * Math.PI / 180);
    playerZ = camHeight * camDepth;
    resolution = height / 480;
    if ((segments.length === 0) || options.segmentLength || options.rumbleLength) {
      resetRoad();
    }
  };
});
