<?php
	$sftExtSettings = wp_parse_args(get_option('sftExt_settings'), array(
        'sftExt_position' => 'bottom right',
        'sftExt_fontawesome_icon_classes' => 'fas fa-times',
        'sftExt_type' => 'rectangle',
        'sftExt_current_tab_url' => 'https://google.com',
        'sftExt_new_tab_url' => 'https://google.com',
        'sftExt_rectangle_text' => 'Safety Exit',
        'sftExt_rectangle_icon_onOff' => 'yes',
        'sftExt_rectangle_font_size_units' => 'rem',
        'sftExt_rectangle_font_size' => '1',
        'sftExt_bg_color' => 'rgba(58, 194, 208, 1)',
        'sftExt_font_color' => 'rgba(255, 255, 255, 1)',
        'sftExt_letter_spacing' => 'inherit'
	));
	$classes = $sftExtSettings['sftExt_position'] . ' ' . $sftExtSettings['sftExt_type'];
	$icon = '';
	if($sftExtSettings['sftExt_rectangle_icon_onOff'] == 'yes' && $sftExtSettings['sftExt_type'] == 'rectangle') {
		$icon = '<i class="' . $sftExtSettings['sftExt_fontawesome_icon_classes'] . '"></i>';
	}else if($sftExtSettings['sftExt_type'] == 'round'){
		$icon = '<i class="' . $sftExtSettings['sftExt_fontawesome_icon_classes'] . '"></i>';
	}
?>
<style>
	#sftExt-frontend-button {
		background-color: <?php echo $sftExtSettings['sftExt_bg_color'] ?>;
		color: <?php echo $sftExtSettings['sftExt_font_color'] ?>;
	}
	#sftExt-frontend-button.rectangle {
		font-size: <?php echo $sftExtSettings['sftExt_rectangle_font_size'] . $sftExtSettings['sftExt_rectangle_font_size_units']  ; ?>;
		letter-spacing: <?php echo $sftExtSettings['sftExt_letter_spacing']; ?>;
	}
</style>
<aside id="sftExt-frontend-button" class="<?= $classes; ?>" data-new-tab="<?= $sftExtSettings['sftExt_new_tab_url']; ?>" data-url="<?= $sftExtSettings['sftExt_current_tab_url']; ?>">
	<?php if($sftExtSettings['sftExt_type'] != 'round') { ?>
		<div class="sftExt-inner"><?= $icon; ?><?= $sftExtSettings['sftExt_rectangle_text']; ?></div>
	<?php }else{ ?>
		<?= $icon; ?>
	<?php } ?>
</aside>