<?php
	$sftExtSettings = wp_parse_args(get_option('sftExt_settings'), array(
        'sftExt_position' => 'bottom right',
        'sftExt_fontawesome_icon_classes' => 'fas fa-times',
        'sftExt_type' => 'rectangle',
        'sftExt_current_tab_url' => 'https://google.com',
        'sftExt_new_tab_url' => 'https://google.com',
        'sftExt_rectangle_text' => 'Safety Exit',
        'sftExt_rectangle_icon_onOff' => 'yes',
        'sftExt_rectangle_font_size_units' => 'em',
        'sftExt_rectangle_font_size' => '20'
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
	#sftExt-frontend-button.rectangle {
		font-size: <?php echo $sftExtSettings['sftExt_rectangle_font_size'] . $sftExtSettings['sftExt_rectangle_font_size_units']  ; ?>
	}
</style>
<aside id="sftExt-frontend-button" class="<?= $classes; ?>" data-new-tab="<?= $sftExtSettings['sftExt_new_tab_url']; ?>" data-url="<?= $sftExtSettings['sftExt_current_tab_url']; ?>">
	<?php if($sftExtSettings['sftExt_type'] != 'round') { ?>
		<div class="sftExt-inner"><?= $icon; ?><?= $sftExtSettings['sftExt_rectangle_text']; ?></div>
	<?php }else{ ?>
		<?= $icon; ?>
	<?php } ?>
</aside>