<?php
//START for show confirmation message for success
if(isset($_SESSION['success_msg']) && $_SESSION['success_msg']!=""){ ?>
	<div class="alert alert-success alert-dismissible <?php /*?>m-alert m-alert--outline alert alert-success alert-dismissible<?php */?>" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
		<span><?=$_SESSION['success_msg']?></span>
	</div>		
<?php
} unset($_SESSION['success_msg']);
//END for show confirmation message for success

//START for show confirmation message for error
if(isset($_SESSION['error_msg']) && $_SESSION['error_msg']){ ?>
	<div class="alert alert-danger alert-dismissible <?php /*?>m-alert m-alert--outline alert alert-danger alert-dismissible<?php */?>" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
		<span><?=$_SESSION['error_msg']?></span>
	</div>
<?php
} unset($_SESSION['error_msg']);
//END for show confirmation message for error ?>


