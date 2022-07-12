; (function () {

	'use strict';

	var isMobile = {
		Android: function () {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function () {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function () {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function () {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function () {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function () {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};


	var mobileMenuOutsideClick = function () {

		$(document).click(function (e) {
			var container = $("#gtco-offcanvas, .js-gtco-nav-toggle");
			if (!container.is(e.target) && container.has(e.target).length === 0) {

				if ($('body').hasClass('offcanvas')) {

					$('body').removeClass('offcanvas');
					$('.js-gtco-nav-toggle').removeClass('active');

				}


			}
		});

	};


	var scrollNavBar = function () {

		if ($(window).scrollTop() > 50) {
			if ($(window).width() > 1900) {
				$('body').addClass('c-page-on-scroll');
			}

			// $('.js-gtco-nav-toggle').removeClass('gtco-nav-white');			
		} else if ($(window).scrollTop() < 50) {
			$('body').removeClass('c-page-on-scroll');
			// $('.js-gtco-nav-toggle').addClass('gtco-nav-white');
		}



		$(window).scroll(function () {
			if ($(window).scrollTop() > 50) {
				$('body').addClass('c-page-on-scroll');
				// $('.js-gtco-nav-toggle').removeClass('gtco-nav-white');
				// $('ul.Language').addClass('language-scroll');
			} else if ($(window).scrollTop() < 50) {
				$('body').removeClass('c-page-on-scroll');
				// $('.js-gtco-nav-toggle').addClass('gtco-nav-white');
				// $('ul.Language').removeClass('language-scroll');
			}
		});
	};

	function obeleziJezik(obj) {
		console.log(obj.value);

	}

	var offcanvasMenu = function () {

		$('#page').prepend('<div id="gtco-offcanvas" />');
		$('#page').prepend('<a href="#" class="js-gtco-nav-toggle gtco-nav-toggle gtco-nav-white"><i></i></a>');
		var clone1 = $('.menu-1 > ul').clone();
		$('#gtco-offcanvas').append(clone1);
		var clone2 = $('.menu-2 > ul').clone();
		$('#gtco-offcanvas').append(clone2);

		$('#gtco-offcanvas .has-dropdown').addClass('offcanvas-has-dropdown');
		$('#gtco-offcanvas')
			.find('li')
			.removeClass('has-dropdown');

		// Hover dropdown menu on mobile
		$('.offcanvas-has-dropdown').mouseenter(function () {
			var $this = $(this);

			$this
				.addClass('active')
				.find('ul')
				.slideDown(500, 'easeOutExpo');
		}).mouseleave(function () {

			var $this = $(this);
			$this
				.removeClass('active')
				.find('ul')
				.slideUp(500, 'easeOutExpo');
		});


		$(window).resize(function () {

			if ($('body').hasClass('offcanvas')) {

				$('body').removeClass('offcanvas');
				$('.js-gtco-nav-toggle').removeClass('active');

			}
		});
	};


	var burgerMenu = function () {

		$('body').on('click', '.js-gtco-nav-toggle', function (event) {
			var $this = $(this);


			if ($('body').hasClass('overflow offcanvas')) {
				$('body').removeClass('overflow offcanvas');
			} else {
				$('body').addClass('overflow offcanvas');
			}
			$this.toggleClass('active');
			event.preventDefault();

		});
	};



	var contentWayPoint = function () {
		var i = 0;
		$('.animate-box').waypoint(function (direction) {

			if (direction === 'down' && !$(this.element).hasClass('animated-fast')) {

				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function () {

					$('body .animate-box.item-animate').each(function (k) {
						var el = $(this);
						setTimeout(function () {
							var effect = el.data('animate-effect');
							if (effect === 'fadeIn') {
								el.addClass('fadeIn animated-fast');
							} else if (effect === 'fadeInLeft') {
								el.addClass('fadeInLeft animated-fast');
							} else if (effect === 'fadeInRight') {
								el.addClass('fadeInRight animated-fast');
							} else {
								el.addClass('fadeInUp animated-fast');
							}

							el.removeClass('item-animate');
						}, k * 50, 'easeInOutExpo');
					});

				}, 100);

			}

		}, { offset: '85%' });
	};


	var dropdown = function () {

		$('.has-dropdown').mouseenter(function () {

			var $this = $(this);
			$this
				.find('.dropdown')
				.css('display', 'block')
				.addClass('animated-fast fadeInUpMenu');

		}).mouseleave(function () {
			var $this = $(this);

			$this
				.find('.dropdown')
				.css('display', 'none')
				.removeClass('animated-fast fadeInUpMenu');
		});

	};

	var dropdownsubmenu = function () {

		$('.has-dropdown-sub').mouseenter(function () {

			var $this = $(this);
			$this
				.find('.dropdown_sub')
				.css('display', 'block')
				.addClass('animated-fast fadeInUpMenu');

		}).mouseleave(function () {
			var $this = $(this);

			$this
				.find('.dropdown_sub')
				.css('display', 'none')
				.removeClass('animated-fast fadeInUpMenu');
		});

	};


	var goToTop = function () {

		$('.js-gotop').on('click', function (event) {

			event.preventDefault();

			$('html, body').animate({
				scrollTop: $('html').offset().top
			}, 500, 'easeInOutExpo');

			return false;
		});

		$(window).scroll(function () {

			var $win = $(window);
			if ($win.scrollTop() > 200) {
				$('.js-top').addClass('active');
			} else {
				$('.js-top').removeClass('active');
			}

		});

	};


	// Loading page
	var loaderPage = function () {
		$(".gtco-loader").fadeOut("slow");
	};

	var counter = function () {
		$('.js-counter').countTo({
			formatter: function (value, options) {
				return value.toFixed(options.decimals);
			},
		});
	};

	var counterWayPoint = function () {
		if ($('#gtco-counter').length > 0) {
			$('#gtco-counter').waypoint(function (direction) {

				if (direction === 'down' && !$(this.element).hasClass('animated')) {
					setTimeout(counter, 400);
					$(this.element).addClass('animated');
				}
			}, { offset: '90%' });
		}
	};

	var parallax = function () {
		if (!isMobile.any()) {
			$(window).stellar();
		}
	};



	$(function () {
		mobileMenuOutsideClick();
		scrollNavBar();
		offcanvasMenu();
		burgerMenu();
		contentWayPoint();
		dropdown();
		dropdownsubmenu();
		goToTop();
		loaderPage();
		counterWayPoint();
		parallax();
		//LayoutBrand.init();
	});


	/* TABLE */
	(function (defaults, $, window, document, undefined) {

		'use strict';

		$.extend({
			// Function to change the default properties of the plugin
			// Usage:
			// jQuery.tabifySetup({property:'Custom value'});
			tabifySetup: function (options) {

				return $.extend(defaults, options);
			}
		}).fn.extend({
			// Usage:
			// jQuery(selector).tabify({property:'value'});
			tabify: function (options) {

				options = $.extend({}, defaults, options);

				return $(this).each(function () {
					var $element, tabHTML, $tabs, $sections;

					$element = $(this);
					$sections = $element.children();

					// Build tabHTML
					tabHTML = '<ul class="tab-nav">';
					$sections.each(function () {
						if ($(this).attr("title") && $(this).attr("id")) {
							tabHTML += '<li><a href="#' + $(this).attr("id") + '">' + $(this).attr("title") + '</a></li>';
						}
					});
					tabHTML += '</ul>';

					// Prepend navigation
					$element.prepend(tabHTML);

					// Load tabs
					$tabs = $element.find('.tab-nav li');

					// Functions
					var activateTab = function (id) {
						$tabs.filter('.active').removeClass('active');
						$sections.filter('.active').removeClass('active');
						$tabs.has('a[href="' + id + '"]').addClass('active');
						$sections.filter(id).addClass('active');
					}

					// Setup events
					$tabs.on('click', function (e) {
						activateTab($(this).find('a').attr('href'));
						e.preventDefault();
					});

					// Activate first tab
					activateTab($tabs.first().find('a').attr('href'));

				});
			}
		});
	})({
		property: "value",
		otherProperty: "value"
	}, jQuery, window, document);

	// Calling the plugin
	$('.tab-group').tabify();


	var podacijson;

	//$.getJSON("http://localhost/stefan_www/transparentnost/Cross-Border.json", function (result) {
	//	podacijson = result;
	//	createTable(podacijson);
	//});


	function createTable(data) {

		var table = document.createElement("table");

		// KREIRANJE HEADER ROW

		var tr = table.insertRow(-1);                   // TABLE ROW.

		for (var i = 1; i < data[0].length; i++) {
			var th = document.createElement("th");      // TABLE HEADER.
			tr.appendChild(th);
			var tabThCell = th;
			th.innerHTML = data[0][i];
		}


		// ADD JSON DATA TO THE TABLE AS ROWS.

		for (var i = 1; i < data.length; i++) {

			tr = table.insertRow(-1);

			for (var j = 1; j < data[i].length; j++) {
				var tabCell = tr.insertCell(-1);
				tabCell.innerHTML = data[i][j];
			}
		}

		$(table).addClass('DesnaTabela');

		$('#dvTable').append(table);

		dodajAtributePoljima();

	}


	function dodajAtributePoljima() {
		$('.DesnaTabela tr').each(function () {
			var row = $(this);
			var polje1 = row.find('td:first-child').html();
			var polje2 = row.find('td:nth-child(2)').html();


			if (polje1 == 'HU' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'HU >> RS');
				});
			} else if (polje1 == 'RO' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'RO >> RS');
				});
			} else if (polje1 == 'BG' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'BG >> RS');
				});
			} else if (polje1 == 'MK' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'MK >> RS');
				});
			} else if (polje1 == 'AL' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'AL >> RS');
				});
			} else if (polje1 == 'ME' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'ME >> RS');
				});
			} else if (polje1 == 'BA' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'BA >> RS');
				});
			} else if (polje1 == 'HR' && polje2 == 'RS') {
				row.find('td').each(function () {
					$(this).attr('title', 'HR >> RS');
				});
			}

			else if (polje1 == 'RS' && polje2 == 'HU') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> HU');
				});
			} else if (polje1 == 'RS' && polje2 == 'RO') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> RO');
				});
			} else if (polje1 == 'RS' && polje2 == 'BG') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> BG');
				});
			} else if (polje1 == 'RS' && polje2 == 'MK') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> MK');
				});
			} else if (polje1 == 'RS' && polje2 == 'AL') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> AL');
				});
			} else if (polje1 == 'RS' && polje2 == 'ME') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> ME');
				});
			} else if (polje1 == 'RS' && polje2 == 'BA') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> BA');
				});
			} else if (polje1 == 'RS' && polje2 == 'HR') {
				row.find('td').each(function () {
					$(this).attr('title', 'RS >> HR');
				});
			}



		});
	}


	$('.accordion-item .heading').on('click', function (e) {
		e.preventDefault();

		// Add the correct active class
		if ($(this).closest('.accordion-item').hasClass('active')) {
			// Remove active classes
			$('.accordion-item').removeClass('active');
		} else {
			// Remove active classes
			$('.accordion-item').removeClass('active');

			// Add the active class
			$(this).closest('.accordion-item').addClass('active');
		}

		// Show the content
		var $content = $(this).next();
		$content.slideToggle(300);
		$('.accordion-item .content').not($content).slideUp(300);
	});

	// if ($(window).width() < 1200) {
	// 	$('.menu-1').appendTo('.MenuContainer');
	// }

	// $(window).on('resize', function(){
	// 	var win = $(this); //this = window
	// 	if (win.width() <= 1200) { 
	// 		$('.menu-1').appendTo('.MenuContainer');
	// 	}
	// 	if (win.width() > 1200) { 
	// 		$('.menu-1').appendTo('.my_container');
	// 	}
	// });






	// BEGIN: Layout Brand
	var ActiveLink = function () {
		var url = window.location.href;
		return {

			init: function () {
				$('.c-hor-nav-toggler').on('click', function () {
					event.stopPropagation();
					var target = $(this).data('target');
					console.log(target);
					$(target).addClass('c-shown');
				});

			}

		};
	}();
	// END

	// 		var CloseMenu = function () {
	// 			return {
	// 				init: function () {
	// 					$(document).on("click", function (e) {
	// 						if (!$(e.target).is(".c-mega-menu").length) {
	// 							$(".c-mega-menu").removeClass("c-shown");
	// 						}
	// 					});
	// 				}
	// 			};
	// 		}();


	$('.c-mega-menu').on('click', '.manu-link', function (e) {
		e.stopPropagation();
		console.log(this);
		if ($(this).closest("li").hasClass('c-open')) {
			$(this).closest("li").removeClass('c-open');
		} else {
			$(this).closest("li").addClass('c-open');
		}

	});


	/* -------- SENDVIC BUTTON -------- */

	$('.c-hor-nav-toggler').on('click', function () {
		event.stopPropagation();
		var target = $(this).data('target');
		console.log(target);
		if ($(target).hasClass('c-shown')) {
			$(target).removeClass('c-shown');
		} else {
			$(target).addClass('c-shown');
		}
	});

	$(document).on("click", function (e) {
		if ($(e.target).is(".c-mega-menu") === false && $(e.target).is(".c-hor-nav-toggler") === false) {
			$(".c-mega-menu").removeClass("c-shown");
		}
	});

	/* -------- END OF SENDVIC BUTTON -------- */


	// BEGIN: ACTIVE MENU LINK
	var ActiveLink = function () {
		var url = window.location.pathname;
		return {

			init: function () {

				var link = url.split('/').slice(2).join('/');
				// console.log(url);
				if (link != 'index.php') {
					$('a[href="../../' + link + '"]').css('color', '#F25F5C');
					$('a[href="../../' + link + '"]').parents('#navigation').addClass('activeLink');
					// 						} else if($('a[href="'+link+'"] ').parent().parent()[0].tagName == 'UL') {
				} else if (link == 'index.php') {
					$('a[href="' + link + '"]').parent().addClass('activeLink');
				}

			}

		};
	}();
	// END

	// 	CloseMenu.init();
	ActiveLink.init();
	//LayoutBrand.init();


	$('.Jezici li').click(function () {
		var _this = $(this).attr("id");
		localStorage.setItem('ja', _this);
	});

	window.onload = function () {
		var clickedLang = localStorage.getItem('ja');
		$('#' + clickedLang).addClass('activeLang');
	}

}());


