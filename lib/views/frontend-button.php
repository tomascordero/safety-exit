
<button id="sftExt-frontend-button" class="<?= $classes; ?>" data-new-tab="<?= $sftExtSettings['sftExt_new_tab_url']; ?>" data-url="<?= $sftExtSettings['sftExt_current_tab_url']; ?>">
	<?php if($sftExtSettings['sftExt_type'] != 'round' && $sftExtSettings['sftExt_type'] != 'square') { ?>
		<div class="sftExt-inner"><?= $icon; ?><?= $sftExtSettings['sftExt_rectangle_text']; ?></div>
	<?php }else{ ?>
		<div class="sr-only">Safety Exit</div>
		<?= $icon; ?>
	<?php } ?>
</button>
