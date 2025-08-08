jQuery.easing.easeOutQuad = function (x, t, b, c, d) {
  return -c * (t /= d) * (t - 2) + b;
};

jQuery(document).ready(function($){

	// ANIMATE CHAOTIC FLY
	function chaoticFlyAnimation(selector) {
	const $el = $(selector);
	const $parent = $el.closest("#menu-button");

	const parentHeight = $parent.height();
	const originalTop = $el.position().top;
	const originalLeft = $el.position().left;

	const chaosSteps = 4;
	const chaosDuration = 400;
	const returnDuration = 100;

	let sequence = $el;

	for (let i = 0; i < chaosSteps; i++) {
		const randTop = originalTop + (Math.random() - 0.5) * 80;
		const randLeft = originalLeft + (Math.random() - 0.5) * 80;
		sequence = sequence.animate({
		top: randTop + "px",
		left: randLeft + "px"
		}, chaosDuration / chaosSteps, "linear");
	}

	sequence.animate(
		{ progress: 1 },
		{
		duration: returnDuration,
		step: function (now, fx) {
			if (fx.prop === "progress") {
			const newTop = originalTop + (0 - originalTop) * now;
			const newLeft = originalLeft + (0 - originalLeft) * now;
			$el.css({
				top: newTop + "px",
				left: newLeft + "px"
			});
			}
		},
		easing: "easeOutQuad",
		complete: function () {
			$el.removeAttr("style");
		}
		}
	);
	}

	// DISABLE SCROLL
	function disableScroll() {
		var scrollDiv = document.createElement("div");
		scrollDiv.className = "b-scrollbar";
		document.body.appendChild(scrollDiv);
		var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
		document.body.removeChild(scrollDiv);

		$('body').css({'overflow': 'hidden'});
		$('.b-page').css({'border-right-width': scrollbarWidth + 'px'});
		$('.b-page-head, .b-nav, .b-modal').css({'right': scrollbarWidth + 'px'});
	}


	// ENABLE SCROLL
	function enableScroll() {
		$('body').removeAttr('style');
		$('.b-page').removeAttr('style');
		$('.b-page-head, .b-nav, .b-modal').removeAttr('style');
	}


    // UPDATE CURRENT LEVEL
    // This function will update the current level of the menu
    function updateCurrentLevel(){
        var $deepestOnItem = $('li.menu-item-has-children.on').filter(function () {
            return $(this).find('li.menu-item-has-children.on').length === 0;
        });
        var currentLevel = $deepestOnItem.find('a').first().html();
        if(currentLevel == undefined){
            $('#nav-current-level').html('Menu');
        }
        else{
            $('#nav-current-level').html(currentLevel);
        }
    }


	// OPEN MOBLE NAV
	// This function will open the mobile navigation
	function openMobileNav(){
		$('body').addClass('menu-open');
		disableScroll();
	}


	// CLOSE MOBILE NAV
	// This function will close the mobile navigation
	function closeMobileNav(){
		$('body').removeClass('menu-open');
		enableScroll();
	}


	// GLOBAL VARIABLES
	var $window = $(window);
	var vw = $(window).width();
	$(window).resize(function(){
		vw = $(window).width();
	});


	// SCROLLING
	$window.scroll(function() {
		var distance = $('#page').offset().top;
		if ( $window.scrollTop() > distance ) {
			$('body').addClass('scrolling');
		}else{
			$('body').removeClass('scrolling');
		}
	});
	var lastScrollTop = 0, delta = 5;

	$(window).scroll(function(event){
		var st = $(this).scrollTop();
		
		if(Math.abs(lastScrollTop - st) <= delta)
		return;
		
		if (st > lastScrollTop){
			// downscroll code
			$('body').removeClass('scrolling_up');
		} else {
			// upscroll code
			$('body').addClass('scrolling_up');
		}
		lastScrollTop = st;
	});


	// SMOOTH SCROLL ON ACHORS
	$('a[href*="#"]').on('click', function(event) {     
		if (
			location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
			location.hostname == this.hostname &&
			$(this.hash).length
		) {
			event.preventDefault();
			$('html, body').animate({ scrollTop: $(this.hash).offset().top }, 500, function() {
				// end scroll to function
			});
		}
	});


	// MENU TOGGLE
	$(document).on('click', '#menu-button', function(e) {
		e.preventDefault();
		chaoticFlyAnimation("#menu-button .bar1");
		chaoticFlyAnimation("#menu-button .bar2");
		if ($('body').hasClass('menu-open')) {
			closeMobileNav();
		} else {
			openMobileNav();
		}
	});


    // click outside .menu-header-container to close mobile nav
	$(document).on('click', function(e) {
		if (!$(e.target).closest('.menu-header-container').length && !$(e.target).is('#menu-button')) {
			$('#menu-button .bar').css('transition', 'transform 0s linear');
			if ($('body').hasClass('menu-open')) {
				closeMobileNav();
				setTimeout(function() {
					$('#menu-button .bar').removeAttr('style');
				}, 600);
			}
		}
	});
      

    // toggle faq
    $(document).on('click', '.faq h3', function () {
        const $question = $(this).closest('.faq');
		if ($question.hasClass('open')) {
			$('.faq').removeClass('open');
		} else {
			$('.faq').removeClass('open');
			$question.addClass('open');
		}
    });
    
      
    // toggle information
    $(document).on('click', '.question', function () {
        $question = $(this).data('question-id');
        const $info = $('#information-wrapper');
        const $infoElement = $info.find('.info[data-info-id="' + $question + '"]');
        if ($infoElement.hasClass('active')) {
            $infoElement.removeClass('active');
            $info.removeClass('active');
			enableScroll();
        } else {
            $infoElement.addClass('active');
            $info.addClass('active');
			disableScroll();
        }
    });


    // close information
    $(document).on('click', '#information-wrapper .close', function () {
        const $info = $('#information-wrapper');
        $info.removeClass('active');
        $info.find('.info').removeClass('active');
		enableScroll();
    });
    // close on click of $information-wrapper but not on .info
    $(document).on('click', '#information-wrapper', function (e) {
        if (!$(e.target).closest('.info').length) {
            const $info = $('#information-wrapper');
            $info.removeClass('active');
            $info.find('.info').removeClass('active');
			enableScroll();
        }
    });


});