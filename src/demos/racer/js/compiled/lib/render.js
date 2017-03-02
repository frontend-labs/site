define(['../lib/utils', '../lib/debugger', '../settings/colors', '../settings/sprites'], function(Utils, Debugger, COLORS, SPRITES) {
  var Render;
  Render = {
    polygon: function(ctx, x1, y1, x2, y2, x3, y3, x4, y4, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.lineTo(x3, y3);
      ctx.lineTo(x4, y4);
      ctx.closePath();
      ctx.fill();
    },
    segment: function(ctx, width, lanes, x1, y1, w1, x2, y2, w2, fog, color) {
      var l1, l2, lane, lanew1, lanew2, lanex1, lanex2, r1, r2;
      r1 = Render.rumbleWidth(w1, lanes);
      r2 = Render.rumbleWidth(w2, lanes);
      l1 = Render.laneMarkerWidth(w1, lanes);
      l2 = Render.laneMarkerWidth(w2, lanes);
      ctx.fillStyle = color.grass;
      ctx.fillRect(0, y2, width, y1 - y2);
      Render.polygon(ctx, x1 - w1 - r1, y1, x1 - w1, y1, x2 - w2, y2, x2 - w2 - r2, y2, color.rumble);
      Render.polygon(ctx, x1 + w1 + r1, y1, x1 + w1, y1, x2 + w2, y2, x2 + w2 + r2, y2, color.rumble);
      Render.polygon(ctx, x1 - w1, y1, x1 + w1, y1, x2 + w2, y2, x2 - w2, y2, color.road);
      if (color.lane) {
        lanew1 = w1 * 2 / lanes;
        lanew2 = w2 * 2 / lanes;
        lanex1 = x1 - w1 + lanew1;
        lanex2 = x2 - w2 + lanew2;
        lane = 1;
        while (lane < lanes) {
          Render.polygon(ctx, lanex1 - l1 / 2, y1, lanex1 + l1 / 2, y1, lanex2 + l2 / 2, y2, lanex2 - l2 / 2, y2, color.lane);
          lanex1 += lanew1;
          lanex2 += lanew2;
          lane++;
        }
      }
      Render.fog(ctx, 0, y1, width, y2 - y1, fog);
    },
    background: function(ctx, background, width, height, layer, rotation, offset) {
      var destH, destW, destX, destY, imageH, imageW, sourceH, sourceW, sourceX, sourceY;
      rotation = rotation || 0;
      offset = offset || 0;
      imageW = layer.w / 2;
      imageH = layer.h;
      sourceX = layer.x + Math.floor(layer.w * rotation);
      sourceY = layer.y;
      sourceW = Math.min(imageW, layer.x + layer.w - sourceX);
      sourceH = imageH;
      destX = 0;
      destY = offset;
      destW = Math.floor(width * (sourceW / imageW));
      destH = height;
      ctx.drawImage(background, sourceX, sourceY, sourceW, sourceH, destX, destY, destW, destH);
      if (sourceW < imageW) {
        ctx.drawImage(background, layer.x, sourceY, imageW - sourceW, sourceH, destW - 1, destY, width - destW, destH);
      }
    },
    sprite: function(ctx, width, height, resolution, roadWidth, sprites, sprite, scale, destX, destY, offsetX, offsetY, clipY) {
      var clipH, destH, destW;
      destW = (sprite.w * scale * width / 2) * (SPRITES.SCALE * roadWidth);
      destH = (sprite.h * scale * width / 2) * (SPRITES.SCALE * roadWidth);
      destX = destX + (destW * (offsetX || 0));
      destY = destY + (destH * (offsetY || 0));
      clipH = clipY ? Math.max(0, destY + destH - clipY) : 0;
      if (clipH < destH) {
        ctx.drawImage(sprites, sprite.x, sprite.y, sprite.w, sprite.h - (sprite.h * clipH / destH), destX, destY, destW, destH - clipH);
      }
    },
    player: function(ctx, width, height, resolution, roadWidth, sprites, speedPercent, scale, destX, destY, steer, updown) {
      var bounce, sprite;
      bounce = (1.5 * Math.random() * speedPercent * resolution) * Utils.randomChoice([-1, 1]);
      if (steer > 0) {
        sprite = updown > 0 ? SPRITES.PLAYER_UPHILL_LEFT : SPRITES.PLAYER_LEFT;
      } else if (steer > 0) {
        sprite = updown > 0 ? SPRITES.PLAYER_UPHILL_RIGHT : SPRITES.PLAYER_RIGHT;
      } else {
        sprite = updown > 0 ? SPRITES.PLAYER_UPHILL_STRAIGHT : SPRITES.PLAYER_STRAIGHT;
      }
      Render.sprite(ctx, width, height, resolution, roadWidth, sprites, sprite, scale, destX, destY + bounce, -0.5, -1);
    },
    fog: function(ctx, x, y, width, height, fog) {
      if (fog < 1) {
        ctx.globalAlpha = 1 - fog;
        ctx.fillStyle = COLORS.FOG;
        ctx.fillRect(x, y, width, height);
        ctx.globalAlpha = 1;
      }
    },
    rumbleWidth: function(projectedRoadWidth, lanes) {
      return projectedRoadWidth / Math.max(6, 2 * lanes);
    },
    laneMarkerWidth: function(projectedRoadWidth, lanes) {
      return projectedRoadWidth / Math.max(32, 8 * lanes);
    }
  };
  return Render;
});
