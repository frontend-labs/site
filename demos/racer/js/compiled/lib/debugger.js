define(function() {
  var Debugger;
  Debugger = {
    storageElements: [],
    createSector: function(sector) {
      var body;
      body = document.getElementsByTagName('body')[0];
      body.appendChild(sector);
    },
    updateSector: function(id, value) {
      var sector;
      sector = document.getElementById(id);
      sector.innerHTML = value;
    },
    isLiteralObject: function(element) {
      var _test;
      _test = element;
      if (typeof element !== 'object' || element === null) {
        return false;
      } else {
        return (function() {
          while (!false) {
            if ((Object.getPrototypeOf(_test = Object.getPrototypeOf(_test))) === null) {
              break;
            }
          }
          return Object.getPrototypeOf(element) === _test;
        })();
      }
    },
    element: function(label, value) {
      var sector;
      if (this.isLiteralObject(value)) {
        value = JSON.stringify(value);
      }
      if (this.storageElements.indexOf(label) === -1) {
        this.storageElements.push(label);
        sector = document.createElement('div');
        sector.id = label;
        return this.createSector(sector);
      } else {
        return this.updateSector(label, value);
      }
    }
  };
  return Debugger;
});
