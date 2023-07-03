/**
 * Table of contents
 * -----------------------------------
 * 1. PRELOADER
 * 2. MASSONARY JS
 * 3. ADD CLASS HEADER
 * 4. NAV COLLAPSE
 * 5. NAV SMOOTH SCROLL
 * 6. FIXED HEADER
 * 7. STELLAR JS
 * 8. TYPED JS
 * 9. SCREENSHOTS CAROUSEL
 * 10. SCREENSHOTS MOBILE CAROUSEL
 * 11. TESTIMONIAL CAROUSEL
 * 12. LATEST BLOG CAROUSEL
 * 13. SCREENSHOTS POP-UP
 * 14. VIDEO POP-UP
 * 15. COUNTER UP
 * 16. CONTACT FORM
 * 17. AJAX MAILCHIMP SUBSCRIBE
 * 18. LOCAL SUBSCRIPTION
 * 19. SCROLL TO UP
 * 20. WOW JS
 * 21. COUNT DOWN TIMER
 * 22. COLLAPSE FAQ
 *
 */


(function ($) {
	"use strict"
	var PATH = {};
	/******************** 1. PRELOADER ********************/
	PATH.preLoader = function () {
        // will first fade out the loading animation
        $(".status").fadeOut();
        // will fade out the whole DIV that covers the website.
        $(".preloader").delay(1000).fadeOut("slow");	
	}
	
	/******************** 2. MASSONARY JS ********************/
	PATH.masonaryGrid = function (){
			$('.grid').masonry({
			itemSelector: '.grid-item',
			columnWidth: '.grid-item',
		});
	}
	
	/******************** 3. ADD CLASS HEADER ********************/
	PATH.HeaderSticky = function () {
		$(".navbar-toggler").on("click", function (a) {
			a.preventDefault(),
				$(".navbar").addClass("nav-sticky")
		});
	}

	/******************** 4. NAV COLLAPSE ********************/
	PATH.MenuClose = function () {
		$('.navbar-nav .nav-link').on('click', function () {
			var toggle = $('.navbar-toggler').is(':visible');
			if (toggle) {
				$('.navbar-collapse').collapse('hide');
			}
		});
	}

	/******************** 5. NAV SMOOTH SCROLL ********************/
	PATH.HeaderScroll = function () {
		$('.navbar a[href*="#"]:not([href="#"])').on('click', function () {
			var PathName = location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname;
			if (PathName) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					$('html,body').animate({
						scrollTop: target.offset().top - 65,
					}, 1000);
					return false;
				}
			}
		});
	}

	/******************** 6. FIXED HEADER ********************/
	PATH.HeaderFixed = function () {
		var varHeaderFix = $(window).scrollTop() >= 60,
		$navbar = $('.navbar');
		if (varHeaderFix) {
			$navbar.addClass('nav-sticky');
		} else {
			$navbar.removeClass('nav-sticky');
		}
	}
	
	/******************** 7. STELLAR JS ********************/
	PATH.stellerJs = function () {
        $(window).stellar({
            horizontalScrolling: false,
        });
	}
	
	/******************** 8. TYPED JS ********************/
	PATH.typedJS = function () {
	    $("#typed").typed({
            strings: ["Effortless", "Trading Platform", "With Zero Market Impact."], // Change typed text here...
            typeSpeed: 100,
            backDelay: 1000,
            loop: true,
        });
	}
	
	/******************** 9. SCREENSHOTS CAROUSEL ********************/
	PATH.screenShots = function () {
        $(".screenshots").owlCarousel({
            dots: true,
            autoplay: true,
            loop: true,
            autoplayTimeout: 5000,
            margin: 15,
            responsive: {
                0: {
                    items: 1,
                },
                480: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                1100: {
                    items: 4,
                },
            },
        });
	}
	
	/******************** 10. SCREENSHOTS MOBILE CAROUSEL ********************/
	PATH.screenShotsMob = function () {
	    $(".screenshots-mobile").owlCarousel({
			nav: false,
            autoplay: false,
            loop: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1,
                },
                480: {
                    items: 1,
                },
                768: {
                    items: 1,
                },
            },
        });
	}
	/******************** 11. TESTIMONIAL CAROUSEL ********************/
	PATH.testiMonials = function () {
	    $(".testimonials").owlCarousel({
            dots: true,
            items: 1,
            autoplay: true,
            loop: true,
            animateOut: 'fadeOut',
            autoplayTimeout: 5000,
        });
	}
	/******************** 12. LATEST BLOG CAROUSEL ********************/
	PATH.latestBlog = function () {
	    $(".latest-blog").owlCarousel({
            dots: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i'],
            autoplay: false,
            autoplayTimeout: 5000,
            margin: 30,
            responsive: {
                0: {
                    items: 1,
                },
                480: {
                    items: 1,
                },
                990: {
                    items: 2,
                },
                1100: {
                    items: 3,
                },
            },
        });
	}
	/******************** 13. SCREENSHOTS POP-UP ********************/
	PATH.ssPopUp = function () {
        $('.zoom-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            gallery: {
            enabled: true,
            },
            zoom: {
                enabled: true,
                duration: 300, // don't foget to change the duration also in CSS
                opener: function(element) {
                    return element.find('img');
                }
            }
        });
	}
	/******************** 14. VIDEO POP-UP ********************/
	PATH.videoModal = function () {
		$(".js-modal-btn").modalVideo();
	}
	/******************** 15. COUNTER UP ********************/
	PATH.counterUp = function () {
		$('.counter').counterUp({
			delay: 10,
			time: 2000
		});
	}
	/******************** 16. CONTACT FORM ********************/
	PATH.contactForm = function () {
		function isValidEmail(emailAddress) {
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
		$("#contact-form").on('submit', function(e) {
			e.preventDefault();
			var success = $(this).find('.email-success'),
				failed = $(this).find('.email-failed'),
				loader = $(this).find('.email-loading'),
				postUrl = $(this).attr('action');

			var data = {
				name: $(this).find('.contact-name').val(),
				email: $(this).find('.contact-email').val(),
				subject: $(this).find('.contact-subject').val(),
				message: $(this).find('.contact-message').val()
			};
			if (isValidEmail(data['email']) && (data['message'].length > 1) && (data['name'].length > 1)) {
				$.ajax({
					type: "POST",
					url: postUrl,
					data: data,
					beforeSend: function() {
						loader.fadeIn(1000);
					},
					success: function(data) {
						loader.fadeOut(1000);
						success.delay(500).fadeIn(1000);
						failed.fadeOut(500);
					},
					error: function(xhr) { // if error occured
						loader.fadeOut(1000);
						failed.delay(500).fadeIn(1000);
						success.fadeOut(500);
					},
					complete: function() {
						loader.fadeOut(1000);
					}
				});
			} else {
				loader.fadeOut(1000);
				failed.delay(500).fadeIn(1000);
				success.fadeOut(500);
			}
			return false;
		});
	}
	/******************** 17. AJAX MAILCHIMP SUBSCRIBE ********************/
	PATH.ajaxChimp = function () {
		$("#subscribe-mailchimp").ajaxChimp({
			callback: mailchimpCallback,
			url: "http:////unitetheme.us12.list-manage.com/subscribe/post?u=5e0141c017272ff01c6c3a091&amp;id=335f7c3601" // Replace your mailchimp post url inside double quote "".  
		});

		function mailchimpCallback(resp) {
		   var error_msg = $('#subscribe-mailchimp').find('.error-msg');
		   var success_msg = $('#subscribe-mailchimp').find('.success-msg');
		   
		   if(resp.result === 'success') {
			  error_msg.fadeOut(200);
			  success_msg.html(resp.msg).fadeIn(200);
		   } else if(resp.result === 'error') {
			  success_msg.fadeOut(200);
			  error_msg.html(resp.msg).fadeIn(200);
		   }  
		};
	}
	/******************** 18. LOCAL SUBSCRIPTION ********************/
	PATH.localSubs = function () {
		$("#subscribe").submit(function (e) {
			e.preventDefault();
			var email = $("#subscriber-email").val();
			var dataString = 'email=' + email;

			function isValidEmail(emailAddress) {
				var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
				return pattern.test(emailAddress);
			};

			if (isValidEmail(email)) {
				$.ajax({
					type: "POST",
					url: "subscribe/subscribe.php",
					data: dataString,
					success: function () {
						$('.success-msg').fadeIn(1000);
						$('.error-msg').fadeOut(500);
						$('.hide-after').fadeOut(500);
					}
				});
			} else {
				$('.error-msg').fadeIn(1000);
			}

			return false;
		});
	}
	/******************** 19. SCROLL TO UP ********************/
	PATH.scrollToUp = function () {
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 500) {
				$('.scrollup').fadeIn();
			} else {
				$('.scrollup').fadeOut();
			}
		});
		$('.scrollup').on("click", function() {
			$("html, body").animate({
				scrollTop: 0
			}, 800);
			return false;
		});	
	}
	/******************** 20. WOW JS ********************/
	PATH.wowJS = function () {
		var wow = new WOW({
			offset: 50,
			mobile: true
		});
		wow.init();
		}

	/******************** 21. COUNT DOWN TIMER ********************/
	PATH.countDown = function () {
		$('#launch-timer').countdown('2017/10/01', function(event) { // Changed date to your lunching date
		   $(this).html(event.strftime('<ul><li><span>%-D</span> day%!D</li><li><span>%H</span> hour%!H</li><li><span>%M</span> minute%!M</li><li><span>%S</span> second%!S</li></ul>'));
		});
	}
	/******************** 22. COLLAPSE FAQ ********************/
	PATH.colapsFaq = function () {
		$('.collapse.show').prev('.card-header').addClass('active');
		  $('#accordion, #bs-collapse')
			.on('show.bs.collapse', function(a) {
			  $(a.target).prev('.card-header').addClass('active');
			})
			.on('hide.bs.collapse', function(a) {
			  $(a.target).prev('.card-header').removeClass('active');
		});
	}
	
	/* Document ready function */
	$(function(){
		PATH.HeaderSticky();
		PATH.MenuClose();
		PATH.HeaderScroll();
		PATH.HeaderFixed();
		PATH.stellerJs();
		PATH.typedJS();
		PATH.screenShots();
		PATH.screenShotsMob();
		PATH.testiMonials();
		PATH.latestBlog();
		PATH.ssPopUp();
		PATH.videoModal();
		PATH.counterUp();
		PATH.contactForm();
		PATH.ajaxChimp();
		PATH.localSubs();
		PATH.scrollToUp();
		PATH.wowJS();
		PATH.countDown();
		PATH.colapsFaq();
	});
	
	/* Window on scroll function */
	$(window).on("scroll", function () {
		
	});

	/* Window on load function */
	$(window).on('load', function () {
		PATH.preLoader();
		PATH.masonaryGrid();
	});
	//
	
})(jQuery);



