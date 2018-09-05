jQuery(function($){
	$('#sftExt_type').on('change', function(e){
		if($(this).val() == 'rectangle') {
			$('.rectangle-only').removeClass('hidden')
		}else{
			$('.rectangle-only').addClass('hidden')
		}
	})
})

// sftExt_rectangle_text