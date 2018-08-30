jQuery(function($){
	$('#sftExt_type').on('change', function(e){
		if($(this).val() == 'rectangle') {
			$('.sftExt_rectangle_text').removeClass('hidden')
		}else{
			$('.sftExt_rectangle_text').addClass('hidden')
		}
	})
})

// sftExt_rectangle_text