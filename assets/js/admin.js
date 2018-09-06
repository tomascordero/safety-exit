jQuery(function($){
	$('#sftExt_type').on('change', function(e){
		if($(this).val() == 'rectangle') {
			$('.rectangle-only').removeClass('hidden')
		}else{
			$('.rectangle-only').addClass('hidden')
		}
		if($(this).val() == 'round') {
			$('.round-only').removeClass('hidden')
		}else{
			$('.round-only').addClass('hidden')
		}
	});

	$('#sftExt_fontawesome_icon_classes_btn').on('click' , function(e){
		e.preventDefault();
	});
	// TODO add button that says "Change Icon"
	$('#sftExt_fontawesome_icon_classes').iconpicker({
		hideOnSelect: false,
		placement: 'inline',
	});
	$('#sftExt_fontawesome_icon_classes').on('iconpickerSelected', function(e){
		$('#sftExt_icon_display i').attr('class', 'fa-3x ' +
        e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
		// $('#sftExt_fontawesome_icon_classes').val() = e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
	})

})
// sftExt_icon_display

// sftExt_rectangle_text