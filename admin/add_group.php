<?php 
$file_name="groups";

//Header section
require_once("include/header.php");
$con = $db;
?>

<div id="wrapper">
    <header id="header" class="container">
        <?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2>Add / Edit Group</h2></header>
                <section>
					<?php include('confirm_message.php');?>
                    <div class="row-fluid">
						<div class="span8">
							<?php
							$sql = "select * from groups where id = '".@$_REQUEST['id']."'";
							$exe = mysqli_query($con,$sql);
							$row = mysqli_fetch_assoc($exe); ?>
							
							<div class="alert alert-warning hidden fade in">
								<h4>Oh snap!</h4>
								<p>This form seems to be invalid :(</p>
							</div>
						
							<div class="alert alert-info hidden fade in">
								<h4>Yay!</h4>
								<p>Everything seems to be ok :)</p>
							</div>
						
							<form id="demo-form" class="form-horizontal form-groups-bordered" data-parsley-validate="" action="action.php" method="post">
								<div class="control-group">
									<label class="control-label" for="input">Group Name * </label>
									<div class="controls">
									<input type="text" class="form-control" name="name" id="name" value="<?php echo @$row['name']; ?>" required="">
									</div>
								</div>
						
								<div class="control-group radio-inline">
									<label class="control-label" for="input">Status * </label>
									<div class="controls">
										<label class="radio-custom-inline custom-radio">
											<input type="radio" name="status" id="statusP" value="1" <?php if(@$row['status']==1){ echo "checked"; } ?> required="">
												Active
										</label>
										<label class="radio-custom-inline ml-10 custom-radio">
											<input type="radio" name="status" id="statusNP" value="0" <?php if(@$row['status']==0){ echo "checked"; } ?>>
												Inactive
										</label>
									</div>
								</div>
								
								<div class="form-actions">
									<input type="hidden" name="action" value="save_group">
									<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
									<input type="hidden" name="id" value="<?php echo @$row['id']; ?>">
									<input type="submit" class="btn btn-alt btn-large btn-primary" value="Save">
									<a href="groups.php" class="btn btn-alt btn-large btn-black">Back</a>
								</div>
							</form>
						</div> <!-- container -->
                    </div> <!-- content -->
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>

<?php
include_once("footer.php");

//Footer section
require_once("include/footer.php"); ?>
