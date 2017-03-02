/* Custom Front-End jQuery scripts */
jQuery(document).ready(function($) {

	"use strict";
	
	/* WooCommerce Cart Sidebar */
	$(function() {
		
		var side_shopping_cart = $('.side-shopping-cart');
		
		$(side_shopping_cart).find('.widget_shopping_cart_content').before('<div class="cart-button-close" />');
		
		$(side_shopping_cart).find('.ssc-button').click(function(event) {
			event.preventDefault();
			$(side_shopping_cart).addClass('is-open');
		});
        
		$('.cart-button-close').on('click',function(event) {
			event.preventDefault();
			$(side_shopping_cart).removeClass('is-open');
		});

        // Show cart if we have items in it 
        /*$('.add_to_cart_button').on('click', function(e) {
            if ( $(side_shopping_cart).hasClass('hidden') ) {
                $(side_shopping_cart).toggleClass('hidden visible');
            }
        });*/
	
	});
    

        
    /* Product slider */
    $(function() {
        
        var slider = $('.product-page-slider'),
            thumbs = $('.product-slider-thumbs');
        
        slider.slick({
            fade:true,
            dots:true,
            autoplay:false,
            adaptiveHeight:true,
            prevArrow:'<a heref="#" class="slider-nav-arrow prev-arrow"></a>',
            nextArrow:'<a heref="#" class="slider-nav-arrow next-arrow"></a>',
            asNavFor:thumbs
        });
        
        thumbs.slick({
            slidesToShow:3,
            slidesToScroll:1,
            centerMode:true,
            centerPadding:0,
            focusOnSelect:true,
            arrows:false,
            asNavFor:slider
        });
            
        slider.find('.slick-dots').each(function() {
            var slider_image_count = $(this).children().length;
            $(this).append( '<li class="slider-image-count">' + slider_image_count + '</li>');
        });

        $('.variations').on('change', 'select', function() {
            slider.slick( "slickGoTo", 0 );
            
        });
    
    });
			
	/* customize select tags */
    $('.woocommerce-page form:not(.comment-form, .woocommerce-shipping-calculator, .woocommerce-checkout, .woocommerce-account) select').wrap('<div class="styled-select" />');
	
	/* LightBox */
	$('a.zoom').swipebox({
		hideBarsDelay:0
	});
	
	
	/* (+/-) Button Number Incrementers */
    $(".cart .quantity .qty").prop('type', 'text');
	$(".cart .quantity").append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

	$("input.qty:not(.product-quantity input.qty)").each(function () {
		var min = parseFloat($(this).attr('min'));
		if (min && min > 0 && parseFloat($(this).val()) < min) {
			$(this).val(min);
		}
	});
	
	$(document).on('click', '.plus, .minus', function () {
	  
		var $qty = $(this).closest('.quantity').find(".qty");
		var currentVal = parseFloat($qty.val());
		var max = parseFloat($qty.attr('max'));
		var min = parseFloat($qty.attr('min'));
		var step = $qty.attr('step');
	   
	   if ( $qty.val() == 0 && $(this).is('.minus') ) {
		   return;   
	   }
		
		if (!currentVal || currentVal == "" || currentVal == "NaN") currentVal = 0;
		if (max == "" || max == "NaN") max = '';
		if (min == "" || min == "NaN") min = 0;
		if (step == 'any' || step == "" || step == undefined || parseFloat(step) == "NaN") step = 1;
	
		if ($(this).is('.plus')) {
			if ( max && currentVal  >= max ) {
				$qty.val(max);
			} else {
				currentVal++;
				$qty.val(currentVal);
			}
		} else {
			if (min && (min == currentVal || currentVal < min)) {
				$qty.val(min);
			} else if (currentVal > 0) {
				currentVal--;
				$qty.val(currentVal);
			}
		}
	
		$qty.trigger('change');
	});

	
	$.fn.disableNumberButtons = function () {
		var value = parseFloat($(this).val());
		
		var minus = this.prev();
		var minAttr = this.attr('min'); 
		var min = (minAttr) ? minAttr : 0;
	  
		(value > min ) ? minus.removeClass('is-disabled') : minus.addClass('is-disabled');
	
		var plus = this.next();
		var maxAttr = this.attr('max');
		var max = (maxAttr) ? maxAttr : 999;
		( value < max ) ? plus.removeClass('is-disabled') : plus.addClass('is-disabled');
		
		if ( value <  min ) {
		   $(this).val(min); 
		}
	}
	
	$('input.qty').each(function () {
		$(this).disableNumberButtons();
	});
	
	$('input.qty').change(function () {
		$(this).disableNumberButtons();
	});
	
	$("form.cart").on("change", "input.qty", function() {
        $(this.form).find("button[data-quantity]").data("quantity", this.value);
    });
    
    /* Sticky Sidebar in Single Product Page */
    $('.sticky-product-details').hcSticky({
		offResolutions: [-960],
        top:60,
        bottomEnd:30,
		wrapperClassName:'sticky-product-details-container'
	});
    
    $('.sticky-product-details .variations').on('change', 'select', function() {
		$('html, body').animate({scrollTop: $('.single-product-columns').offset().top}, 700);
    });    
						

});// - document ready