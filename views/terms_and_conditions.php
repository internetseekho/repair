<div class="container clearfix center">
	<div class="clear"></div>
	<?php
	if($active_page_data['show_title'] == '1' || $active_page_data['content']) { ?>
		<div class="heading-block topmargin-sm bottommargin-sm center">
			<?php
			if($active_page_data['show_title'] == '1') {
				echo '<h3>'.$active_page_data['title'].'</h3>';
			}
			if($active_page_data['content']) {
				echo '<span class="divcenter">'.$active_page_data['content'].'</span>';
			} ?>
		</div>
	<?php
	} ?>
	<div class="row">
		<div class="col-md-12">
			<?=$general_setting_data['order_receipt_terms']?>
		</div>
	</div>
</div>