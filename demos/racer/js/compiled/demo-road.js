define(['lib/dom', 'lib/utils', 'lib/debugger', 'lib/render', 'lib/game', 'lib/stats', 'settings/key', 'settings/background', 'settings/sprites', 'settings/colors'], function(DOM, Util, Debugger, Render, Game, Stats, KEY, BACKGROUND, SPRITES, COLORS) {
  var ROAD, accel, addBumps, addCurve, addDownhillToEnd, addHill, addLowRollingHills, addRoad, addSCurves, addSegment, addSprite, addStraight, background, breaking, camDepth, camHeight, canvas, cars, centrifugal, ctx, currentLapTime, decel, drawDistance, fieldOfView, findSegment, fogDensity, formatTime, fps, height, hillOffset, hillSpeed, hud, keyFaster, keyLeft, keyRight, keySlower, lanes, lastLapTime, lastY, maxSpeed, offRoadDecel, offRoadLimit, playerX, playerZ, position, render, reset, resetCars, resetRoad, resetSprites, resolution, roadWidth, rumbleLength, segmentLength, segments, skyOffset, skySpeed, speed, sprites, stats, step, totalCars, trackLength, treeOffset, treeSpeed, update, updateCarOffset, updateCars, updateHud, width;
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
  cars = [];
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
  totalCars = 20;
  currentLapTime = 0;
  lastLapTime = null;
  keyLeft = false;
  keyRight = false;
  keyFaster = false;
  keySlower = false;
  hud = {
    speed: {
      value: null,
      dom: DOM.get('speed_value')
    },
    current_lap_time: {
      value: null,
      dom: DOM.get('current_lap_time_value')
    },
    last_lap_time: {
      value: null,
      dom: DOM.get('last_lap_time_value')
    },
    fast_lap_time: {
      value: null,
      dom: DOM.get('fast_lap_time_value')
    }
  };
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
    var dx, nPSegment, nPSegmentCar, playerSegment, playerW, speedPercent, startPosition, _car, _carW, _sprite, _spriteW;
    playerSegment = findSegment(position + playerZ);
    playerW = SPRITES.PLAYER_STRAIGHT.w * SPRITES.SCALE;
    speedPercent = speed / maxSpeed;
    dx = dt * 2 * speedPercent;
    startPosition = position;
    updateCars(dt, playerSegment, playerW);
    position = Util.increase(position, dt * speed, trackLength);
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
    if ((playerX < -1) || (playerX > 1)) {
      if (speed > offRoadLimit) {
        speed = Util.accelerate(speed, offRoadDecel, dt);
      }
      nPSegment = 0;
      while (nPSegment < playerSegment.sprites.length) {
        _sprite = playerSegment.sprites[nPSegment];
        _spriteW = _sprite.source.w * SPRITES.SCALE;
        if (Util.overlap(playerX, playerW, _sprite.offset + _spriteW / 2 * (_sprite.offset > 0 ? 1 : -1), _spriteW)) {
          speed = maxSpeed / 5;
          position = Util.increase(playerSegment.p1.world.z, -playerZ, trackLength);
          break;
        }
        nPSegment++;
      }
    }
    nPSegmentCar = 0;
    while (nPSegmentCar < playerSegment.cars.length) {
      _car = playerSegment.cars[nPSegmentCar];
      _carW = _car.sprite.w * SPRITES.SCALE;
      if (speed > _car.speed) {
        if (Util.overlap(playerX, playerW, _car.offset, _carW, 0.8)) {
          speed = _car.speed * (_car.speed / speed);
          position = Util.increase(_car.z, -playerZ, trackLength);
          break;
        }
      }
      nPSegmentCar++;
    }
    playerX = Util.limit(playerX, -3, 3);
    speed = Util.limit(speed, 0, maxSpeed);
    skyOffset = Util.increase(skyOffset, skySpeed * playerSegment.curve * (position - startPosition) / segmentLength, 1);
    hillOffset = Util.increase(hillOffset, hillSpeed * playerSegment.curve * (position - startPosition) / segmentLength, 1);
    treeOffset = Util.increase(treeOffset, treeSpeed * playerSegment.curve * (position - startPosition) / segmentLength, 1);
    if (position > playerZ) {
      if (currentLapTime && (startPosition < playerZ)) {
        lastLapTime = currentLapTime;
        currentLapTime = 0;
        if (lastLapTime <= Util.toFloat(DOM.storage.fast_lap_time)) {
          DOM.storage.fast_lap_time = lastLapTime;
          updateHud('fast_lap_time', formatTime(lastLapTime));
          DOM.addClassName('fast_lap_time', 'fastest');
          DOM.addClassName('last_lap_time', 'fastest');
        } else {
          DOM.removeClassName('fast_lap_time', 'fastest');
          DOM.removeClassName('last_lap_time', 'fastest');
        }
        updateHud('last_lap_time', formatTime(lastLapTime));
        DOM.show('last_lap_time');
      } else {
        currentLapTime += dt;
      }
    }
    updateHud('speed', 5 * Math.round(speed / 5000));
    updateHud('current_lap_time', formatTime(currentLapTime));
  };
  updateCars = function(dt, playerSegment, playerW) {
    var nCars, __car, _index, _newSegment, _oldSegment;
    nCars = 0;
    while (nCars < cars.length) {
      __car = cars[nCars];
      _oldSegment = findSegment(__car.z);
      __car.offset = __car.offset + updateCarOffset(__car, _oldSegment, playerSegment, playerW);
      __car.z = Util.increase(__car.z, dt * __car.speed, trackLength);
      __car.percent = Util.percentRemaining(__car.z, segmentLength);
      _newSegment = findSegment(__car.z);
      if (_oldSegment !== _newSegment) {
        _index = _oldSegment.cars.indexOf(__car);
        _oldSegment.cars.splice(_index, 1);
        _newSegment.cars.push(__car);
      }
      nCars++;
    }
  };
  updateCarOffset = function(car, carSegment, playerSegment, playerW) {
    var carW, dir, iLook, jSegCar, lookahead, otherCar, otherCarW, segment;
    lookahead = 20;
    carW = car.sprite.w * SPRITES.SCALE;
    if ((carSegment.index - playerSegment.index) > drawDistance) {
      return 0;
    }
    iLook = 0;
    while (iLook < lookahead) {
      segment = segments[(carSegment.index + iLook) % segments.length];
      if (segment === playerSegment && car.speed > speed && Util.overlap(playerX, playerW, car.offset, carW, 1.2)) {
        if (playerX > 0.5) {
          dir = -1;
        } else if (playerX < -0.5) {
          dir = 1;
        } else {
          dir = (car.offset > playerX ? 1 : -1);
        }
        return dir * 1 / iLook * (car.speed - speed) / maxSpeed;
      }
      jSegCar = 0;
      while (jSegCar < segment.cars.length) {
        otherCar = segment.cars[jSegCar];
        otherCarW = otherCar.sprite.w * SPRITES.SCALE;
        if (car.speed > otherCar.speed && Util.overlap(car.offset, carW, otherCar.offset, otherCarW, 1.2)) {
          if (otherCar.offset > 0.5) {
            dir = -1;
          } else if (otherCar.offset < -0.5) {
            dir = 1;
          } else {
            dir = (car.offset > otherCar.offset ? 1 : -1);
          }
          return dir * 1 / iLook * (car.speed - otherCar.speed) / maxSpeed;
        }
        jSegCar++;
      }
      iLook++;
    }
    if (car.offset < -0.9) {
      return 0.1;
    } else if (car.offset > 0.9) {
      return -0.1;
    } else {
      return 0;
    }
  };
  updateHud = function(key, value) {
    if (hud[key].value !== value) {
      hud[key].value = value;
      DOM.set(hud[key].dom, value);
    }
  };
  formatTime = function(dt) {
    var minutes, seconds, tenths;
    minutes = Math.floor(dt / 60);
    seconds = Math.floor(dt - (minutes * 60));
    tenths = Math.floor(10 * (dt - Math.floor(dt)));
    if (minutes > 0) {
      return "" + minutes + "." + ((seconds < 10 ? 0 : "") + seconds) + "." + tenths;
    } else {
      return "" + seconds + "." + tenths;
    }
  };
  render = function() {
    var basePercent, baseSegment, car, dx, maxy, n, nDrawDis, nSegmentCar, nSegmentSprite, playerPercent, playerSegment, playerY, segment, sprite, spriteScale, spriteX, spriteY, x;
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
      segment.clip = maxy;
      Util.project(segment.p1, (playerX * roadWidth) - x, playerY + camHeight, position - (segment.looped ? trackLength : 0), camDepth, width, height, roadWidth);
      Util.project(segment.p2, (playerX * roadWidth) - x - dx, playerY + camHeight, position - (segment.looped ? trackLength : 0), camDepth, width, height, roadWidth);
      x = x + dx;
      dx = dx + segment.curve;
      n++;
      if ((segment.p1.camera.z <= camDepth) || (segment.p2.screen.y >= segment.p1.screen.y) || (segment.p2.screen.y >= maxy)) {
        continue;
      }
      Render.segment(ctx, width, lanes, segment.p1.screen.x, segment.p1.screen.y, segment.p1.screen.w, segment.p2.screen.x, segment.p2.screen.y, segment.p2.screen.w, segment.fog, segment.color);
      maxy = segment.p1.screen.y;
    }
    nDrawDis = drawDistance - 1;
    while (nDrawDis > 0) {
      segment = segments[(baseSegment.index + nDrawDis) % segments.length];
      nSegmentCar = 0;
      while (nSegmentCar < segment.cars.length) {
        car = segment.cars[nSegmentCar];
        sprite = car.sprite;
        spriteScale = Util.interpolate(segment.p1.screen.scale, segment.p2.screen.scale, car.percent);
        spriteX = Util.interpolate(segment.p1.screen.x, segment.p2.screen.x, car.percent) + (spriteScale * car.offset * roadWidth * width / 2);
        spriteY = Util.interpolate(segment.p1.screen.y, segment.p2.screen.y, car.percent);
        Render.sprite(ctx, width, height, resolution, roadWidth, sprites, car.sprite, spriteScale, spriteX, spriteY, -0.5, -1, segment.clip);
        nSegmentCar++;
      }
      nSegmentSprite = 0;
      while (nSegmentSprite < segment.sprites.length) {
        sprite = segment.sprites[nSegmentSprite];
        spriteScale = segment.p1.screen.scale;
        spriteX = segment.p1.screen.x + (spriteScale * sprite.offset * roadWidth * width / 2);
        spriteY = segment.p1.screen.y;
        Render.sprite(ctx, width, height, resolution, roadWidth, sprites, sprite.source, spriteScale, spriteX, spriteY, (sprite.offset < 0 ? -1 : 0), -1, segment.clip);
        nSegmentSprite++;
      }
      if (segment === playerSegment) {
        Render.player(ctx, width, height, resolution, roadWidth, sprites, speed / maxSpeed, camDepth / playerZ, width / 2, (height / 2) - (camDepth / playerZ * Util.interpolate(playerSegment.p1.camera.y, playerSegment.p2.camera.y, playerPercent) * height / 2), speed * (keyLeft ? -1 : keyRight ? 1 : 0), playerSegment.p2.world.y - playerSegment.p1.world.y);
      }
      nDrawDis--;
    }
  };
  lastY = function() {
    if (segments.length === 0) {
      return 0;
    } else {
      return segments[segments.length - 1].p2.world.y;
    }
  };
  addSprite = function(n, sprite, offset) {
    segments[n].sprites.push({
      source: sprite,
      offset: offset
    });
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
      sprites: [],
      cars: [],
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
    addRoad(num, num, num, ROAD.CURVE.EASY, _height);
    addRoad(num, num, num, 0, 0);
    addRoad(num, num, num, -ROAD.CURVE.EASY, _height / 2);
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
  addBumps = function() {
    addRoad(10, 10, 10, 0, 5);
    addRoad(10, 10, 10, 0, -2);
    addRoad(10, 10, 10, 0, -5);
    addRoad(10, 10, 10, 0, 8);
    addRoad(10, 10, 10, 0, 5);
    addRoad(10, 10, 10, 0, -7);
    addRoad(10, 10, 10, 0, 5);
    addRoad(10, 10, 10, 0, -2);
  };
  resetRoad = function() {
    var nRumble;
    segments = [];
    addStraight(ROAD.LENGTH.SHORT);
    addLowRollingHills();
    addSCurves();
    addCurve(ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM, ROAD.HILL.LOW);
    addBumps();
    addLowRollingHills();
    addCurve(ROAD.LENGTH.LONG * 2, ROAD.CURVE.MEDIUM, ROAD.HILL.MEDIUM);
    addStraight();
    addHill(ROAD.LENGTH.MEDIUM, ROAD.HILL.HIGH);
    addSCurves();
    addCurve(ROAD.LENGTH.LONG, -ROAD.CURVE.MEDIUM, ROAD.HILL.NONE);
    addHill(ROAD.LENGTH.LONG, -ROAD.HILL.HIGH);
    addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM, -ROAD.HILL.LOW);
    addBumps();
    addHill(ROAD.LENGTH.LONG, -ROAD.HILL.MEDIUM);
    addStraight();
    addSCurves();
    addDownhillToEnd();
    resetSprites();
    resetCars();
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
  resetSprites = function() {
    var interI, nFour, nOne, nThree, nTwo, offset, side, sprite;
    addSprite(20, SPRITES.BILLBOARD07, -1);
    addSprite(40, SPRITES.BILLBOARD06, -1);
    addSprite(60, SPRITES.BILLBOARD08, -1);
    addSprite(80, SPRITES.BILLBOARD09, -1);
    addSprite(100, SPRITES.BILLBOARD01, -1);
    addSprite(120, SPRITES.BILLBOARD02, -1);
    addSprite(140, SPRITES.BILLBOARD03, -1);
    addSprite(160, SPRITES.BILLBOARD04, -1);
    addSprite(180, SPRITES.BILLBOARD05, -1);
    addSprite(240, SPRITES.BILLBOARD07, -1.2);
    addSprite(240, SPRITES.BILLBOARD06, 1.2);
    addSprite(segments.length - 25, SPRITES.BILLBOARD07, -1.2);
    addSprite(segments.length - 25, SPRITES.BILLBOARD06, 1.2);
    nOne = 10;
    while (nOne < 200) {
      addSprite(nOne, SPRITES.PALM_TREE, 0.5 + Math.random() * 0.5);
      addSprite(nOne, SPRITES.PALM_TREE, 1 + Math.random() * 2);
      nOne += 4 + Math.floor(nOne / 100);
    }
    nTwo = 250;
    while (nTwo < 1000) {
      addSprite(nTwo, SPRITES.COLUMN, 1.1);
      addSprite(nTwo + Util.randomInt(0, 5), SPRITES.TREE1, -1 - (Math.random() * 2));
      addSprite(nTwo + Util.randomInt(0, 5), SPRITES.TREE2, -1 - (Math.random() * 2));
      nTwo += 5;
    }
    nThree = 200;
    while (nThree < segments.length) {
      addSprite(nThree, Util.randomChoice(SPRITES.PLANTS, Util.randomChoice([1, -1]) * (2 + Math.random() * 5)));
      nThree += 3;
    }
    nFour = 1000;
    while (nFour < (segments.length - 50)) {
      side = Util.randomChoice([1, -1]);
      addSprite(nFour + Util.randomInt(0, 50), Util.randomChoice(SPRITES.BILLBOARDS), -side);
      interI = 0;
      while (interI < 20) {
        sprite = Util.randomChoice(SPRITES.PLANTS);
        offset = side * (1.5 + Math.random());
        addSprite(nFour + Util.randomInt(0, 50), sprite, offset);
        interI++;
      }
      nFour += 100;
    }
  };
  resetCars = function() {
    var car, nCars, segment, _offset, _speed, _sprite, _z;
    cars = [];
    nCars = 0;
    while (nCars < totalCars) {
      _offset = Math.random() * Util.randomChoice([-0.8, 0.8]);
      _z = Math.floor(Math.random() * segments.length) * segmentLength;
      _sprite = Util.randomChoice(SPRITES.CARS);
      _speed = maxSpeed / 4 + Math.random() * maxSpeed / (speed === SPRITES.SEMI ? 4 : 2);
      car = {
        offset: _offset,
        z: _z,
        sprite: _sprite,
        speed: _speed
      };
      segment = findSegment(car.z);
      segment.cars.push(car);
      cars.push(car);
      nCars++;
    }
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
      DOM.storage.fast_lap_time = DOM.storage.fast_lap_time || 180;
      updateHud('fast_lap_time', formatTime(Util.toFloat(DOM.storage.fast_lap_time)));
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
