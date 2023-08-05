<style type="text/css">
.logo-text{
  font-family: 'Lobster', cursive;
  font-size: 30px;
  text-decoration: none;
  font-weight:bold;
  display: block;
  padding-bottom: 30px;
  color:#ff1e8b;
}
</style>

<h1>
	<!-- Main page logo -->
	<a class="logo-text" href="<?=ADMIN_URL?>" title="<?=ADMIN_PANEL_NAME?>"><?=ADMIN_PANEL_NAME?></a>
</h1>

<div class="user-profile">
	<figure>
		<!-- User profile info -->
		<figcaption>
			<strong><a href="profile.php" class="">Hello <?=($loggedin_user_name?$loggedin_user_name:'Contractor')?></a></strong>
			<?php /*?><ul>
				<li <?php if($file_name=="profile"){echo 'class="active"';}?>><a href="profile.php">My Account</a> | </li><?php */?>
				<?php
				/*if($admin_type == "super_admin") { ?>
					<li <?php if($file_name=="general_settings"){echo 'class="active"';}?>>
						<a href="general_settings.php" title="Settings">Settings</a> | 
					</li>
					<li <?php if($file_name=="staff"){echo 'class="active"';}?>><a href="staff.php">Staff User(s)</a> | </li>
				<?php
				}*/ ?>
				<?php /*?><li><a href="logout.php" title="Logout">Logout</a></li>
			</ul><?php */?>
		</figcaption>
		<!-- /User profile info -->
	</figure>
</div>

<nav class="main-navigation">
	<!-- Responsive navbar button -->
	<div class="navbar">
		<a class="btn btn-alt btn-large btn-primary btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-home"></span> Dashboard</a>
	</div>
	<!-- /Responsive navbar button -->
    <div class="nav-collapse collapse" role="navigation">
        <ul>
			<li <?php if($file_name=="appointments"){echo 'class="active"';}?>><a href="appointment.php" title="Orders">Orders</a></li>
			<li <?php if($file_name=="profile"){echo 'class="active"';}?>><a href="profile.php" title="My Account">My Account</a></li>
			<li><a href="logout.php" title="Logout">Logout</a></li>
		</ul>
    </div>
</nav>
