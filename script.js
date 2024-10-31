jQuery(document).ready(function($){

	$(window).on('resize',function() {
		$('#current-size').text('('+ $(window).width() +' x '+ $(window).height() +')');
	}).resize();

	$('#device-custom').on('change', function() {

		if (this.checked) {
			$('#device-custom-width, #device-custom-height').prop( "disabled", false );
		} else {
			$('#device-custom-width, #device-custom-height').prop( "disabled", true );
		}

	});

	$('#device-custom-width, #device-custom-height').on('input', function() {
		$('#device-custom').prop( "checked", true );
	});

	$('#devices-list input[type="checkbox"]').on('change', function() {
		if ( $('#devices-list input[type="checkbox"]:checked').length ) {
			$('#resp-submit').prop( "disabled", false );
		} else {
			$('#resp-submit').prop( "disabled", true );
		}
	});

	$('#optioner-form').on('submit', function(){
		if ( $('#device-custom-width, #device-custom-height').val() == "" ) {

			$('#device-custom').prop( "checked", false );
			$('#device-custom-width, #device-custom-height').prop( "disabled", true );

		}
	});


	// ACCESS SETTING SAVE
	$('#responsivity_public').on('change', function() {
		$('#responsivity-ajax-option-save').submit();
	});
	$('#responsivity-ajax-option-save').submit(function() {
		var form = $(this);
		var check = $('#responsivity_public');
		var data =  form.serialize();

		check.prop("disabled", true);

        $.post( 'options.php', data ).error(function() {
            alert('An error occured. Please try again.');
        }).success( function() {
            check.prop("disabled", false);
        });

        return false;

	});


	$('#resp_full_height_mode').on('change', function() {

		if ( $(this).prop("checked") ) $('#resp_show_devices').prop('checked', false).prop('disabled', true);
		else $('#resp_show_devices').prop('disabled', false);

	});


}); // document ready