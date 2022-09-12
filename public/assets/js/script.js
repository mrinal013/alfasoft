(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 */
	$(document).on( 'click', 'button[id^="mcq-submit"]', function() {
		var score = 0;
		var totalQuestions = 0;
		$(this).parent('div').find('div[id^="single-mcq-"]').each(function(i, k) {
			totalQuestions++;
			var correct = $(k).data('correct');
			var selectedVal = $(k).find('input:checked').val();
			
			if ( correct == selectedVal ) {
				score++;
			}
		})
		$(this).parent('div').hide()
		$(this).parent('div').after('<p>Total: ' + totalQuestions + '</p>');
		$(this).parent('div').after('<p>Correct: ' + score + '</p>');
	})

})( jQuery );
