<?php
//Header section
include("include/header.php"); ?>

<section id="content">
	<div>
		<div class="container clearfix">
			<div class="postcontent nobottommargin">
				<?php /*?><div class="heading-block topmargin-sm bottommargin-sm center">
					<h3>Title Here</h3>
				</div><?php */?>
				<div class="alert alert-success alert-dismissable"><?=$contractor_thank_you_form_msg_text?></div>
				<a href="<?=SITE_URL?>" class="button button-3d nomargin"><?=$continue_btn_text?></a>
			</div>

			<!-- Sidebar
			============================================= -->
			<div class="sidebar col_last nobottommargin">

				<address>
				  <strong><?=$contractor_form_address_text?>:</strong><br>
				  <?php
				  if($company_name) {
					 echo '<strong>'.$company_name.'</strong>';
				  }
				  if($company_address) {
					 echo '<br />'.$company_address;
				  }
				  if($company_city) {
					 echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode;
				  }
				  if($company_country) {
					 echo '<br />'.$company_country;
				  } ?>
				</address>
				
				<?php
				if($site_phone) {
					echo '<abbr title="'.$phone_title.'"><strong>'.$phone_title.':</strong></abbr> '.$site_phone.'<br>';
				}
				if($site_email) {
					echo '<abbr title="'.$email_title.'"><strong>'.$email_title.':</strong></abbr> '.$site_email.'<br>';
				} ?>

				<div class="widget noborder notoppadding">
					<?php //START for socials link
					if($socials_link) { ?>
						<?=$socials_link?>
					<?php
					} //END for socials link ?>
				</div>
			</div><!-- .sidebar end -->
		</div>
	</div>
</section>