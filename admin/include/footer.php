			<!-- begin::Footer -->
			<footer class="m-grid__item	m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								<?=date('Y')?> &copy; <?=ADMIN_PANEL_NAME?>
							</span>
						</div>
					</div>
				</div>
			</footer>
			<!-- end::Footer -->
		</div>
		<!-- end:: Page -->

		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->

		<!-- begin::Quick Nav -->
		<ul class="m-nav-sticky" style="margin-top: 30px;">
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Dashboard" data-placement="left">
				<a href="dashboard.php"><i class="la la-home"></i></a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Models" data-placement="left">
				<a href="mobile.php"><i class="la la-list"></i></a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Orders" data-placement="left">
				<a href="appointment.php"><i class="la la-list"></i></a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Invoices" data-placement="left">
				<a href="invoice_list.php"><i class="la la-file"></i></a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Customers" data-placement="left">
				<a href="users.php"><i class="la la-users"></i></a>
			</li>
		</ul>
		<!-- begin::Quick Nav -->

		<script src="assets/js/common.js" type="text/javascript"></script>
		<?php
		if(isset($custom_js_path) && $custom_js_path!="") { ?>
		<!--begin::Page Scripts -->
		<script src="<?=$custom_js_path?>" type="text/javascript"></script>
		<!--end::Page Scripts -->
		<?php
		}
		if(isset($custom_phpjs_path) && $custom_phpjs_path!="") {
			if(!isset($json_data_list)) {
				$json_data_list = "";
			}
			include($custom_phpjs_path);
		} ?>
	</body>
	<!-- end::Body -->
</html>

<?php
//Close db connection of mysql
mysqli_close($db); ?>
