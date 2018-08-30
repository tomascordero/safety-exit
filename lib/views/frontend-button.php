<?php
	$sftExtSettings = get_option('sftExt_settings');
	var_dump($sftExtSettings['sftExt_position']);

	$classes = $sftExtSettings['sftExt_position'] . ' ' . $sftExtSettings['sftExt_type'];

	// if($sftExtSettings['sftExt_btn-type'])
?>

<aside id="sftExt-frontend-button" class="<?= $classes; ?>">
	<div class="sftExt-inner">Safety Exit</div>
</aside>