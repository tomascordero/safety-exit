<?php
	$sftExtSettings = get_option('sftExt_settings', array(
		'sftExt_position' => 'bottom right',
		'sftExt_type' => 'rectangle',
		'sftExt_rectangle_text' => 'Safety Exit',
		'sftExt_current_tab_url' => 'https://google.com',
		'sftExt_new_tab_url' => 'https://google.com',
		'sftExt_fontawesome_icon_classes' => 'fas fa-times'

	));
	// var_dump($sftExtSettings);
	$classes = $sftExtSettings['sftExt_position'] . ' ' . $sftExtSettings['sftExt_type'];
?>
<?php if($sftExtSettings['sftExt_customMarkup'] == '') { ?>
	<aside id="sftExt-frontend-button" class="<?= $classes; ?>" data-new-tab="<?= $sftExtSettings['sftExt_new_tab_url']; ?>" data-url="<?= $sftExtSettings['sftExt_current_tab_url']; ?>">
		<?php if($sftExtSettings['sftExt_type'] != 'round') { ?>
			<div class="sftExt-inner"><i class="<?= $sftExtSettings['sftExt_fontawesome_icon_classes']; ?>"></i><?= $sftExtSettings['sftExt_rectangle_text']; ?></div>
		<?php }else{ ?>
			<i class="<?= $sftExtSettings['sftExt_fontawesome_icon_classes']; ?>"></i>
		<?php } ?>
	</aside>
<?php }else{
	echo $sftExtSettings['sftExt_customMarkup'];
 } ?>