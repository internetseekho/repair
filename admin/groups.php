<?php 
$file_name="groups";

//Header section
require_once("include/header.php");
?>

<link rel="stylesheet" href="plugins/bootstrap-sweetalert/sweet-alert.css" />
<link href="plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

<div id="wrapper">
    <header id="header" class="container">
        <?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header>
					<h2>Manage Groups</h2>
					<?php
					if($prms_model_add == '1') { ?>
					<ul class="data-header-actions">
						<li><a href="add_group.php">Add New</a></li>
					</ul>
					<?php
					} ?>
				</header>
                <section>
					<?php 
					include('confirm_message.php');
					if(isset($_SESSION['success']) && $_SESSION['success']!="") { ?>
						<div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
						<?php
						unset($_SESSION['success']);
					} ?>

					<form>
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-alt btn-danger" onclick="multi_delete('groups')">Bulk Remove</button>
						</div>
					</div>
					</form>

					<table id="datatable-responsive"
						   class="table table-striped  table-colored table-info dt-responsive nowrap" cellspacing="0"
						   width="100%" style="font-size:12px;">
						<thead>
							<tr>
								<th width="15">Sr#</th>
								<th width="10"><input type="checkbox" onclick="selectAll()"/> </th>
								<th>Name</th>
								<th>Status</th>
								<th>Created Date</th>
								<th width="150">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "select * from groups where user_id = '".$_SESSION['id']."' order by id desc";
							$exe = mysqli_query($db,$sql);
							$i=1;
							while($row = mysqli_fetch_assoc($exe)) { ?>
								<tr id="row-<?=$row['id']?>">
									<td><?=$i++?></td>
									<td><input type="checkbox" class="deletecheckbox" name="delete[]" value="<?=$row['id']?>" /></td>
									<td><?=$row['name']?></td>
									<td>
									<?php
									if($row['status']==1){
										echo '<label class="label label-success sm">Published</label>';
									}else{
										echo '<label class="label label-danger">Not Published</label>';
									}
									?>
									</td>
									<td><?=$row['created_date']?></td>
									<td>
										<?php
										if($prms_model_edit == '1') { ?>
										<a href="add_group.php?id=<?=$row['id']?>" class="btn btn-alt btn-default"> <i class="icon-pencil"></i> </a>
										<?php
										}
										if($prms_model_delete == '1') { ?>
										<button onclick="deleteRow(this)" id="<?=$row['id']?>" data-type="groups" title="Delete Groups" class="btn btn-danger btn-alt"> <i class="icon-trash"></i> </button>
										<?php
										} ?>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>

<?php 
include("footer.php");

//Footer section
require_once("include/footer.php"); ?>