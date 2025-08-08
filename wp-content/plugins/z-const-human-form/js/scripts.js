jQuery(document).ready(function($){
    // Add a disabled class to all submit buttons inside a .const-human-form class
    $('.const-human-form form input[type="submit"]').addClass('disabled');
    $('.const-human-form form button[type="submit"]').addClass('disabled');
    // finda ll forms inside a .const-human-form class and add a .yesNoSliderContainer right before the submit button
    setTimeout(function() {
        $('.const-human-form form').each(function() {
            // find the submit button
            var $submitButton = $(this).find('input[type="submit"]');
            if ($submitButton.length === 0) {
                $submitButton = $(this).find('button[type="submit"]');
            }
            if ($submitButton.length) {
                // add disabled class to the submit button
                $submitButton.addClass('disabled');
                // create the yesNoSliderContainer
                var $yesNoSliderContainer = $('<sup>Are you a human?</sup><div class="yesNoSliderContainer"><label class="label-left"></label><input type="range" class="yesNoSlider" min="0" max="100" value="50"><label class="label-right"></label></div>');
                // insert it before the submit button
                $submitButton.before($yesNoSliderContainer);
            }
        });

        let leftLabel = 'No';
        let rightLabel = 'Yes';

        // Randomly assign sides
        if (Math.random() < 0.5) {
            [leftLabel, rightLabel] = ['Yes', 'No'];
        }

        $('.label-left').text(leftLabel);
        $('.label-right').text(rightLabel);

        // Track if callback was already triggered to avoid duplicates
        let lastState = null;

        $('.yesNoSlider').on('input', function() {
        const val = parseInt($(this).val(), 10);

        if (val <= 0 && lastState !== 'left') {
            if (leftLabel === 'Yes') {
                yesFunction();
            } else {
                noFunction();
            }
            lastState = 'left';
        } else if (val >= 100 && lastState !== 'right') {
            if (rightLabel === 'Yes') {
                yesFunction();
            } else {
                noFunction();
            }
            lastState = 'right';
            } else if (val > 0 && val < 100) {
                lastState = null;
            }
        });

    }, 1000); // Delay to ensure the form is fully loaded

    function yesFunction() {
        //console.log('YES triggered');
        $('.const-human-form form input[type="submit"]').removeClass('disabled');
        $('.const-human-form form button[type="submit"]').removeClass('disabled');
    }

    function noFunction() {
        //console.log('NO triggered');
        $('.const-human-form form input[type="submit"]').addClass('disabled');
        $('.const-human-form form button[type="submit"]').addClass('disabled');
    }
});