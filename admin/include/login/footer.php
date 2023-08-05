
		<!--begin::Global Theme Bundle -->
		<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->
		
		<?php
		if(isset($custom_js_path) && $custom_js_path!="") { ?>
		<!--begin::Page Scripts -->
		<script src="<?=$custom_js_path?>" type="text/javascript"></script>
		<!--end::Page Scripts -->
		<?php
		} ?>
	</body>
	<!-- end::Body -->
</html>