(function($){
    var st = {
        boxSuscribe: '.jetpack_subscription_widget',
        footer: '#footer-sidebar',
        stick: ''
    },
    dom = {},
    catchDom = function(){
        dom.boxSuscribe = $(st.boxSuscribe);
        dom.footer = $(st.footer);
    },
    suscribeEvents = function() {
      $(window).on('scroll', events.stickSuscribe);
      $(window).on('resize', events.stickSuscribe);
    };
    events = {
      stickSuscribe: function() {
        if ($.support.cors && !functions.isMobile()) {
          functions.scrollSuscribe();
        } else {
          functions.scrollSuscribeIE();
        }
      }
    };
    functions = {
      scrollSuscribe: function() {
        var box, footer, margin, pos, stick, windowpos;
        margin = 35;
        box = dom.boxSuscribe;
        stick = st.stick;
        footer = dom.footer.offset();
        windowpos = $(window).scrollTop();
        if ($(window).height() >= stick - windowpos && $(window).height() < footer.top - windowpos + margin) {
          pos = windowpos + $(window).height() - box.height() - margin * 2;
          functions.updatePosition(pos, "absolute");
        } else if ($(window).height() > footer.top - windowpos + margin) {
          pos = footer.top - box.height() - margin;
          functions.updatePosition(pos, "absolute");
        }
      },
      scrollSuscribeIE: function() {
        var box, footer, margin, pos, stick, windowpos;
        margin = 35;
        box = dom.boxSuscribe;
        stick = st.stick;
        footer = dom.footer.offset();
        windowpos = $(window).scrollTop();
        if ($(window).height() < stick - windowpos) {
          pos = stick;
          functions.updatePosition(pos, "absolute");
          dom.boxSuscribe.addClass('position_initial_suscribe');
        } else if ($(window).height() >= stick - windowpos - box.height() && $(window).height() < footer.top - windowpos + margin) {
          pos = box.height() - 80;
          dom.boxSuscribe.removeClass('position_initial_suscribe');
          dom.boxSuscribe.css({
            position: 'fixed',
            bottom: pos + "px",
            top: ''
          });
        } else if ($(window).height() > footer.top - windowpos + margin) {
          pos = footer.top - box.height() - margin;
          functions.updatePosition(pos, "absolute");
        }
      },
      updatePosition: function(actualTop, actualPos) {
        dom.boxSuscribe.css({
          position: actualPos,
          top: actualTop + "px",
          bottom: ''
        });
      },
      isMobile: function() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
      },
      getPositionSuscribe: function() {
        st.stick = parseInt(dom.boxSuscribe.css('top'));
      },
      removeTransition: function() {
        if (!($.support.cors && !functions.isMobile())) {
          dom.boxSuscribe.removeClass('suscribe_effect');
        }
      }
    };
    initialize = function(oP) {
      $.extend(st, oP);
      catchDom();
      suscribeEvents();
      functions.getPositionSuscribe();
      functions.removeTransition();
      events.stickSuscribe();
    };
    $(document).ready(function(){
        initialize();
    });
}(jQuery));
