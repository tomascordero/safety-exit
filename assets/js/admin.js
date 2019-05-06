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
	// $('.sftExt_show_all').on('change', function(e){
	// 	console.log($(this).val());
	// 	if($(this).val() == 'no') {
	// 		$('.sftExt_front_page').show()
	// 		$('.sftExt_pages').show()
	// 	}else{
	// 		$('.sftExt_front_page').hide()
	// 		$('.sftExt_pages').hide()
	// 	}
	// });
	$('#sftExt_rectangle_font_size_units').on('change', function(e){
		$('.sftExt_units').text($(this).val());
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
	var $bgParent = document.querySelector('#sftExt_color_picker_btn_bg_color');
	var $fontParent = document.querySelector('#sftExt_color_picker_btn_font_color');
	var bg_color_picker = new Picker({
		parent: $bgParent,
		color:$('#sftExt_bg_color').val()
	});
	bg_color_picker.onChange = function(color) {
		$('#sftExt_bg_color').val(color.rgbaString);
		$('#sftExt_color_picker_btn_bg_color').css({
			'background-color': color.rgbaString
		});
    };
	var font_color_picker = new Picker({
		parent: $fontParent,
		color:$('#sftExt_font_color').val()
	});
	font_color_picker.onChange = function(color) {
		$('#sftExt_font_color').val(color.rgbaString);
		$('#sftExt_color_picker_btn_font_color').css({
			'background-color': color.rgbaString
		});
    };
})
// sftExt_icon_display

// sftExt_rectangle_text