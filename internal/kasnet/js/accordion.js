
/*
Permite crear un accordion
@class accordion
@main pagoefectivomovil/all
@author Luis Natividad
 */

$(function(){
  var catchDom, dom, st;
  dom = {};
  st = {
    accordion: ".accordion",
    container: ".container",
    accordion_icon: ".accordion span"
  };
  catchDom = function() {
    dom.accordion = $(st.accordion);
    dom.container = $(st.container);
    dom.accordion_icon = $(st.accordion_icon);
  };
  catchDom();
  dom.accordion.on('click', function () {
    console.log("open");
    var _this;
    _this = $(this);
    if (_this.next(st.container).is(":visible")) {
      _this.next(st.container).hide(500);
      _this.children("span").html("+");
    } else {
      dom.container.hide();
      dom.accordion_icon.html("+");
      _this.next(st.container).show("slow");
      _this.children("span").html("-");
    }
  });
  
});