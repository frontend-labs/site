define(['lib/dom', 'lib/utils', 'lib/debugger', 'lib/render', 'lib/game', 'lib/stats', 'settings/key', 'settings/background', 'settings/colors'], function(DOM, Util, Debugger, Render, Game, Stats, KEY, BACKGROUND, COLORS) {
  var ROAD, accel, addCurve, addDownhillToEnd, addHill, addLowRollingHills, addRoad, addSCurves, addSegment, addStraight, background, breaking, camDepth, camHeight, canvas, centrifugal, ctx, decel, drawDistance, fieldOfView, findSegment, fogDensity, fps, height, hillOffset, hillSpeed, keyFaster, keyLeft, keyRight, keySlower, lanes, lastY, maxSpeed, offRoadDecel, offRoadLimit, playerX, playerZ, position, render, reset, resetRoad, resolution, roadWidth, rumbleLength, segmentLength, segments, skyOffset, skySpeed, speed, sprites, stats, step, trackLength, treeOffset, treeSpeed, update, width;
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
    HILL: {
      NONE: 0,
      LOW: 20,
      MEDIUM: 40,
      HIGH: 60
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
    var basePercent, baseSegment, dx, maxy, n, playerPercent, playerSegment, playerY, segment, x;
    baseSegment = findSegment(position);
    basePercent = Util.percentRemaining(position, segmentLength);
    playerSegment = findSegment(position + playerZ);
    playerPercent = Util.percentRemaining(position + playerZ, segmentLength);
    playerY = Util.interpolate(playerSegment.p1.world.y, playerSegment.p2.world.y, playerPercent);
    maxy = height;
    x = 0;
    dx = -(baseSegment.curve * basePercent);
    ctx.clearRect(0, 0, width, height);
    Render.background(ctx, background, width, height, BACKGROUND.SKY, skyOffset, resolution * skySpeed * playerY);
    Render.background(ctx, background, width, height, BACKGROUND.HILLS, hillOffset, resolution * hillSpeed * playerY);
    Render.background(ctx, background, width, height, BACKGROUND.TREES, treeOffset, resolution * treeSpeed * playerY);
    n = 0;
    while (n < drawDistance) {
      segment = segments[(baseSegment.index + n) % segments.length];
      segment.looped = segment.index < baseSegment.index;
      segment.fog = Util.exponentialFog(n / drawDistance, fogDensity);
      Util.project(segment.p1, (playerX * roadWidth) - x, playerY + camHeight, position - (segment.looped ? trackLength : 0), camDepth, width, height, roadWidth);
      Util.project(segment.p2, (playerX * roadWidth) - x - dx, playerY + camHeight, position - (segment.looped ? trackLength : 0), camDepth, width, height, roadWidth);
      x = x + dx;
      dx = dx + segment.curve;
      n++;
      if ((segment.p1.camera.z <= camDepth) || (segment.p2.screen.y >= segment.p1.screen.y) || (segment.p2.screen.y >= maxy)) {
        continue;
      }
      Render.segment(ctx, width, lanes, segment.p1.screen.x, segment.p1.screen.y, segment.p1.screen.w, segment.p2.screen.x, segment.p2.screen.y, segment.p2.screen.w, segment.fog, segment.color);
      maxy = segment.p2.screen.y;
    }
    Render.player(ctx, width, height, resolution, roadWidth, sprites, speed / maxSpeed, camDepth / playerZ, width / 2, (height / 2) - (camDepth / playerZ * Util.interpolate(playerSegment.p1.camera.y, playerSegment.p2.camera.y, playerPercent) * height / 2), speed * (keyLeft ? -1 : keyRight ? 1 : 0), playerSegment.p2.world.y - playerSegment.p1.world.y);
  };
  lastY = function() {
    if (segments.length === 0) {
      return 0;
    } else {
      return segments[segments.length - 1].p2.world.y;
    }
  };
  addSegment = function(curve, y) {
    var n;
    n = segments.length;
    segments.push({
      index: n,
      p1: {
        world: {
          y: lastY(),
          z: n * segmentLength
        },
        camera: {},
        screen: {}
      },
      p2: {
        world: {
          y: y,
          z: (n + 1) * segmentLength
        },
        camera: {},
        screen: {}
      },
      curve: curve,
      color: Math.floor(n / rumbleLength) % 2 ? COLORS.DARK : COLORS.LIGHT
    });
  };
  addRoad = function(enter, hold, leave, curve, y) {
    var endY, nEnter, nHold, nLeave, startY, total;
    startY = lastY();
    endY = startY + (Util.toInt(y, 0) * segmentLength);
    total = enter + hold + leave;
    nEnter = 0;
    nHold = 0;
    nLeave = 0;
    while (nEnter < enter) {
      addSegment(Util.easeIn(0, curve, nEnter / enter), Util.easeInOut(startY, endY, nEnter / total));
      nEnter++;
    }
    while (nHold < hold) {
      addSegment(curve, Util.easeInOut(startY, endY, (enter + nHold) / total));
      nHold++;
    }
    while (nLeave < leave) {
      addSegment(Util.easeInOut(curve, 0, nLeave / leave), Util.easeInOut(startY, endY, (enter + hold + nLeave) / total));
      nLeave++;
    }
  };
  addStraight = function(n) {
    var num;
    num = n || ROAD.LENGTH.MEDIUM;
    addRoad(num, num, num, 0, 0);
  };
  addHill = function(n, h) {
    var num, _height;
    num = n || ROAD.LENGTH.MEDIUM;
    _height = h || ROAD.HILL.MEDIUM;
    addRoad(num, num, num, 0, _height);
  };
  addCurve = function(n, c, h) {
    var curve, num, _height;
    num = n || ROAD.LENGTH.MEDIUM;
    curve = c || ROAD.CURVE.MEDIUM;
    _height = h || ROAD.HILL.NONE;
    addRoad(num, num, num, curve, _height);
  };
  addLowRollingHills = function(n, h) {
    var num, _height;
    num = n || ROAD.LENGTH.SHORT;
    _height = h || ROAD.HILL.LOW;
    addRoad(num, num, num, 0, _height / 2);
    addRoad(num, num, num, 0, -_height);
    addRoad(num, num, num, 0, _height);
    addRoad(num, num, num, 0, 0);
    addRoad(num, num, num, 0, _height / 2);
    addRoad(num, num, num, 0, 0);
  };
  addSCurves = function() {
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, -ROAD.CURVE.EASY, ROAD.HILL.NONE);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM, ROAD.HILL.MEDIUM);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.CURVE.EASY, -ROAD.HILL.LOW);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, -ROAD.CURVE.EASY, ROAD.HILL.MEDIUM);
    addRoad(ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, ROAD.LENGTH.MEDIUM, -ROAD.CURVE.MEDIUM, -ROAD.HILL.MEDIUM);
  };
  addDownhillToEnd = function(n) {
    var num;
    num = n || 200;
    addRoad(num, num, num, -ROAD.CURVE.EASY, -lastY() / segmentLength);
  };
  resetRoad = function() {
    var nRumble;
    segments = [];
    addStraight(ROAD.LENGTH.SHORT / 2);
    addHill(ROAD.LENGTH.SHORT, ROAD.HILL.LOW);
    addLowRollingHills();
    addCurve(ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM, ROAD.HILL.LOW);
    addLowRollingHills();
    addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM, ROAD.HILL.MEDIUM);
    addStraight();
    addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM, -ROAD.HILL.LOW);
    addHill(ROAD.LENGTH.LONG, -ROAD.HILL.MEDIUM);
    addStraight();
    addDownhillToEnd();
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
