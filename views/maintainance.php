<?php
$meta_keywords = 'Site Maintenance';
$meta_desc = 'Site Maintenance';
$meta_title = 'Site Maintenance';
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="IE=edge" >
	
	<meta name="keywords" content="<?=$meta_keywords?>" />
	<meta name="description" content="<?=$meta_desc?>" />
	<title><?=$meta_title?></title>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?=SITE_URL?>css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=SITE_URL?>style.css" type="text/css" />
	<link rel="stylesheet" href="<?=SITE_URL?>css/main.css">
	<link rel="stylesheet" href="<?=SITE_URL?>css/main_media.css">

	<link rel="stylesheet" href="<?=SITE_URL?>css/custom.css">
</head>
<body>
	<section id="offline" class="d-flex align-items-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-5">
					<div class="block text-center">
						<div class="card">
							<div class="card-body">
								<h1><?=$maintenance_page_title?></h1>
								<p><?=str_replace(array('[site_email]','[site_phone]'), array($site_email,$site_phone), $maintenance_page_desc)?></p>
								<h4>&mdash; <?=SITE_NAME?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>