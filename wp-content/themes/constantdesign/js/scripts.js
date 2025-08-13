jQuery(document).ready(function($){


    // Handle the visibility of elements based on scroll position
    const $elements = $('.visible');
    $elements.each(function () {
        $(this).data('visible-state', 'hidden');
    });
    function isElementPartiallyInViewport(el) {
        const rect = el.getBoundingClientRect();
        const windowHeight = (window.innerHeight || document.documentElement.clientHeight);

        return (
            rect.top < windowHeight && rect.bottom > 0
        );
    }
    function isElementFullyOutOfView(el) {
        const rect = el.getBoundingClientRect();
        const windowHeight = (window.innerHeight || document.documentElement.clientHeight);

        return (
            rect.bottom <= 0 || rect.top >= windowHeight
        );
    }
    $(window).on('scroll resize', function () {
        $elements.each(function () {
            const $el = $(this)[0]; // raw DOM element
            const $jqEl = $(this);
            const state = $jqEl.data('visible-state');

            if (isElementPartiallyInViewport($el)) {
                if (state !== 'visible') {
                    setTimeout(function() {
                        $jqEl.addClass('is_visible');
                        $jqEl.data('visible-state', 'visible');
                    }, 300);
                }
            } else if (isElementFullyOutOfView($el)) {
                $jqEl.removeClass('is_visible');
                $jqEl.data('visible-state', 'hidden');
            }
        });
    });
    // Initial check
    $(window).trigger('scroll');


    // Handle the focus and blur events for the content editor
    function bindTinyMCEFocusHandlers() {
        $('iframe[id$="_ifr"]').each(function () {
        const $iframe = $(this);

        // Only bind once
        if ($iframe.data('focus-bound')) return;
        $iframe.data('focus-bound', true);

        const editorId = $iframe.attr('id').replace('_ifr', '');
        const $container = $('#wp-' + editorId + '-editor-container');

        // Access iframe DOM and bind focus/blur inside
        const iframe = $iframe[0];
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

        if (iframeDoc && iframeDoc.body) {
            $(iframeDoc.body).on('focus', function () {
            $container.addClass('editor-focused');
            }).on('blur', function () {
            $container.removeClass('editor-focused');
            });
        }
        });
    }
    // Run periodically until all iframes are bound
    const interval = setInterval(function () {
        if ($('iframe[id$="_ifr"]').length > 0) {
        bindTinyMCEFocusHandlers();
        }

        // Stop polling after a few seconds (or when all editors are ready)
        if (typeof tinymce !== 'undefined' && tinymce.editors.length) {
        const allReady = tinymce.editors.every(ed => ed.initialized);
        if (allReady) {
            clearInterval(interval);
        }
        }
    }, 500);


    // Toggle the visibility of the quote details fieldset
    $(document).on('click', '#i-need-a-quote', function () {
        const $button = $(this);
        const $section = $('#contact-section');
        if ($section.hasClass('quote-needed')) {
            $section.removeClass('quote-needed');
            $button.text('I Need a Quote');
        } else {
            $section.addClass('quote-needed');
            $button.text('Never Mind');
        }
    });
    
    
    // Handle the visibility of the referrer fields
    $(document).ready(function() {
	    const $button = $('input[name="referrals"][value="Referral"]');
        const $section = $('#contact-section');
		$('input[name="referrals"]').on('change', function() {
			if ($button.is(':checked')) {
				$section.addClass('referred');
			} else {
				$section.removeClass('referred');
			}
		});
	});


    // Handle the FAQ accordion functionality
    $(document).on('click', 'li.faq-item', function () {
        const $li = $(this);
        if( $li.hasClass('open')) {
            $li.removeClass('open');
        } else {
            $('#faqs li').removeClass('open');
            $li.addClass('open');
        }
    });


    // Handle the FAQ search functionality
    $(document).on('keyup', 'input#faq_filter', function () {
        const stopWords = ['the', 'and', 'can', 'how', 'is', 'a', 'an', 'in', 'of', 'to', 'for', 'on', 'with', 'that', 'this', 'it', 'as', 'at', 'by', 'from', 'or', 'but', 'if', 'not', 'be', 'are', 'was', 'were', 'which', 'who', 'what', 'when', 'where', 'why', 'do', 'does', 'did', 'has', 'have', 'had', 'will', 'shall', 'may', 'might', 'must', 'should', 'could','me', 'my', 'you', 'your', 'he', 'his', 'she', 'her', 'they', 'them', 'their', 'we', 'us', 'our', 'i', 'me', 'mine', 'myself', 'you', 'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she', 'her', 'hers', 'herself', 'it', 'its', 'itself', 'they', 'them', 'their', 'theirs', 'themselves'];
        const input = $(this).val().toLowerCase();
        // remove punctuation special characters and commas
        const sanitizedInput = input.replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]/g, '').trim();        
        // Break input into words and filter out stop words
        const searchWords = sanitizedInput.split(/\s+/).filter(word => !stopWords.includes(word));
        $('#faq-questions li').each(function () {
            const $li = $(this);
            const questionText = $li.find('h3').text().toLowerCase();

            // Show item if it matches ANY search word
            const matches = searchWords.some(word => questionText.includes(word));

            if (matches || searchWords.length === 0) {
                $li.show();
            } else {
                $li.hide();
            }
        });
    });


    // Typing animation for the header logo text
    $(document).ready(function() {
        if($('#typing-text').length === 0) {
            return; // Exit if the element doesn't exist
        }
        const typingText = $('#typing-text');
        // array of words to type
        const words = ['branding', 'graphics', 'webistes', 'design'];
        let wordIndex = 0;
        let charIndex = 0;
        const typingSpeed = 100; // speed in milliseconds
        const erasingSpeed = 50; // speed for erasing characters
        const newWordDelay = 2000; // delay before typing the next word
        // const eraseDelay = 500; // delay before erasing the current word (not needed with the modification)

        function typeWord() {
            if (charIndex < words[wordIndex].length) {
                typingText.text(typingText.text() + words[wordIndex][charIndex]);
                charIndex++;
                setTimeout(typeWord, typingSpeed);
            } else {
                // Check if it's the last word
                if (wordIndex === words.length - 1) {
                    // If it's the last word, do nothing more (leave it visible)
                    return;
                } else {
                    setTimeout(eraseWord, newWordDelay);
                }
            }
        }

        function eraseWord() {
            if (charIndex > 0) {
                typingText.text(typingText.text().slice(0, -1));
                charIndex--;
                setTimeout(eraseWord, erasingSpeed);
            } else {
                wordIndex++; // Move to the next word
                setTimeout(typeWord, typingSpeed); // Start typing the next word immediately after erasing
            }
        }

        // Start the typing animation
        typeWord();
    });


    // change button text on click for #send-message
    $(document).on('click', '#send-message', function () {
        const $button = $(this);
        const $requiredName = $('#fullname');
        const $requiredEmail = $('#email');
        // validate email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if ($requiredName.val().trim() === '') {
            alert('Please enter your name.');
            $requiredName.focus();
            return false;
        }
        if ($requiredEmail.val().trim() === '') {
            alert('Please enter your email address.');
            $requiredEmail.focus();
            return false;
        }
        if (!emailPattern.test($requiredEmail.val().trim())) {
            alert('Please enter a valid email address.');
            $requiredEmail.focus();
            return false;
        }
        $button.text('Sending ');
    });

    
	/*
	// JS hover effect
	$('#projects .project').mouseenter(function(){
		var $this = $(this);
		$('#projects .project').addClass('blur');
		$this.removeClass('blur');
	});
	$('#projects .project').mouseleave(function(){
		$('#projects .project').removeClass('blur');
	});
    */


});
