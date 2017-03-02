define(function() {
  var DOM;
  DOM = {
    get: function(id) {
      if (id instanceof HTMLElement || id === document) {
        return id;
      } else {
        return document.getElementById(id);
      }
    },
    set: function(id, html) {
      return DOM.get(id).innerHTML = html;
    },
    on: function(ele, type, fn, capture) {
      DOM.get(ele).addEventListener(type, fn, capture);
    },
    un: function(ele, type, fn, capture) {
      return DOM.get(ele).removeEventListener(type, fn, capture);
    },
    show: function(ele, type) {
      return DOM.get(ele).style.display = type || 'block';
    },
    blur: function(ev) {
      return ev.target.blur();
    },
    addClassName: function(ele, name) {
      return DOM.toggleClassName(ele, name, true);
    },
    removeClassName: function(ele, name) {
      return DOM.toggleClassName(ele, name, false);
    },
    toggleClassName: function(ele, name, flag) {
      var classes, n;
      ele = DOM.get(ele);
      classes = ele.className.split(' ');
      n = classes.indexOf(name);
      flag = (typeof flag === "function" ? flag(n < 0) : void 0) ? void 0 : flag;
      if (flag && n < 0) {
        classes.push(name);
      } else if ((typeof true !== "undefined" && true !== null) && n >= 0) {
        classes.splice(n, 1);
      }
      return ele.className = classes.join(' ');
    },
    storage: window.localStorage || {}
  };
  return DOM;
});
