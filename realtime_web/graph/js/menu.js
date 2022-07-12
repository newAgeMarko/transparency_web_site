(function ($) {
  'use strict';

  var defaults = {};

  function Menu (element, options) {
    this.$el = $(element);
    this.opt = $.extend(true, {}, defaults, options);

    this.init(this);
  }

  Menu.prototype = {
    init: function (self) {
      $(document).on('click', function (e) {
        var $target = $(e.target);

        if ($target.closest(self.$el.data('menu-toggle'))[0]) {
          $target = $target.closest(self.$el.data('menu-toggle'));

          self.$el
            .css(self.calcPosition($target))
            .toggleClass('show');

          e.preventDefault();
        } else if (!$target.closest(self.$el)[0]){
          self.$el.removeClass('show');
        }
      });
    },

    calcPosition: function ($target) {
      var windowWidth, targetOffset, position;
      var popupOffset, popupWidth;
	  
	  popupOffset = $("#popup").offset();
	  popupWidth = $("#popup").outerWidth();
	  
      windowWidth = $(window).width();
      targetOffset = $target.offset();

      position = {
        top: targetOffset.top + ($target.outerHeight() / 2) - popupOffset.top

      };

//      if (targetOffset.left > windowWidth / 2) {
        this.$el
          .addClass('menu--right')
          .removeClass('menu--left');

        position.right = (windowWidth - targetOffset.left) - ($target.outerWidth() / 2) - (windowWidth - popupOffset.left - popupWidth);
        position.left = 'auto';
//      } else {
//        this.$el
//          .addClass('menu--left')
//          .removeClass('menu--right');

//        position.left = targetOffset.left + ($target.outerWidth() / 2);
//        position.right = 'auto';
//      }

      return position;
    }
  };

  $.fn.menu = function (options) {
    return this.each(function() {
      if (!$.data(this, 'menu')) {
        $.data(this, 'menu', new Menu(this, options));
      }
    });
  };
})(window.jQuery);
