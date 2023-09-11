import '../css/admin.css';

function calculateContrastRatio(color1, color2) {
  function parseColor(colorString) {
    const colorArray = colorString.match(/\d+/g);
    return colorArray.map(Number);
  }

  function getLuminance(color) {
    const normalizedColor = color.map(value => {
      value /= 255;
      if (value <= 0.03928) {
        return value / 12.92;
      } else {
        return Math.pow((value + 0.055) / 1.055, 2.4);
      }
    });

    return 0.2126 * normalizedColor[0] + 0.7152 * normalizedColor[1] + 0.0722 * normalizedColor[2];
  }

  const colorArray1 = parseColor(color1);
  const colorArray2 = parseColor(color2);

  const luminance1 = getLuminance(colorArray1);
  const luminance2 = getLuminance(colorArray2);

  const ratio = (Math.max(luminance1, luminance2) + 0.05) / (Math.min(luminance1, luminance2) + 0.05);

  const aaThreshold = 4.5;
  const aaaThreshold = 7;

  const passesAA = ratio >= aaThreshold;
  const passesAAA = ratio >= aaaThreshold;

  return { passesAA, passesAAA };
}


function calcContrastError(color1, color2) {
	const targetElement = document.querySelector('.sftExt_type');

	// Insert the new row before the target element
	let accessibilityResults = calculateContrastRatio(color1, color2);
	if (accessibilityResults.passesAA && accessibilityResults.passesAAA) {
		if (document.querySelector('.sftExt_alert')) document.querySelector('.sftExt_alert').remove();
		return;
	}

	// Create a new table row element
	const newRow = document.createElement('tr');
	newRow.classList.add('sftExt_alert');
	newRow.innerHTML = `<th>Warning:</th><td>The contrast ratio between the background color and text color does not meet the accessibility standards.<br/>AA: ${accessibilityResults.passesAA ? 'Passing' : 'Failing'}<br/>AAA: ${accessibilityResults.passesAAA ? 'Passing' : 'Failing'}`;


	if (targetElement && targetElement.parentNode) {
		if (document.querySelector('.sftExt_alert')) document.querySelector('.sftExt_alert').remove();
		targetElement.parentNode.insertBefore(newRow, targetElement);
	}
}


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


	var font_color_picker = new Picker({
		parent: $fontParent,
		color:$('#sftExt_font_color').val()
	});
	bg_color_picker.onChange = function(color) {
		$('#sftExt_bg_color').val(color.rgbaString);
		calcContrastError(color.rgbaString, font_color_picker.color.rgbaString);
		$('#sftExt_color_picker_btn_bg_color').css({
			'background-color': color.rgbaString
		});
    };
	font_color_picker.onChange = function(color) {
		$('#sftExt_font_color').val(color.rgbaString);
		calcContrastError(bg_color_picker.color.rgbaString, color.rgbaString);
		$('#sftExt_color_picker_btn_font_color').css({
			'background-color': color.rgbaString
		});
    };
	calcContrastError(bg_color_picker.color.rgbaString, font_color_picker.color.rgbaString);
})
// sftExt_icon_display

// sftExt_rectangle_text
