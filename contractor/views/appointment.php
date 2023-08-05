<div id="wrapper">
  <header id="header" class="container">
    <?php include("include/admin_menu.php"); ?>
  </header>
  <section class="container" role="main">
    <div class="row">
      <article class="span12 data-block">
        <header>
          <h2>Orders</h2>
		  <?php /*?><ul class="data-header-actions">
			 <li><a href="addedit_appointment.php">Add New</a></li>
		  </ul><?php */?>
        </header>
        <section>
          <?php include('confirm_message.php');?>
		  <form method="post">
			<div class="control-group">
				<div class="controls">
					<input type="text" class="span3" placeholder="Search by Order ID, Name, Email, Phone" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>">
					<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Go</button>
					<?php
					if($post['filter_by']!="")
						echo '<a href="appointment.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>'; ?>
				</div>
			</div>
		  </form>
		  
		  <?php /*?><form method="post">
			<div class="control-group">
				<div class="controls">
					<select class="span3" name="filter_by_location" id="filter_by_location">
						<option value=""> -Select- </option>
						<?php
						while($location_data = mysqli_fetch_assoc($lcn_query)) { ?>
							<option value="<?=$location_data['id']?>"> <?=$location_data['name']?> </option>
						<?php
						} ?>
					</select>
					<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Go</button>
					<?php
					if($post['filter_by_location'])
						echo '<a href="appointment.php"><button class="btn btn-alt btn-primary" type="button">Clear</button></a>'; ?>
				</div>
			</div>
		  </form><?php */?>
			
		  <div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
			  	<th>Order ID</th>
                <!--<th>Product Name</th>-->
                <th>Product Item Name</th>
                <th>Amount</th>
				<!--<th>Customer</th>-->
                <th>Name</th>
                <!--<th>Email</th>-->
                <?php /*?><th>Phone</th><?php */?>
				<!--<th>Shop Location</th>-->
                <th>Appt. Date/Time</th>
                <!--<th>Appt. Time</th>-->
                <!--<th>Submitted Date</th>-->
                <th width="50">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
			$num_rows = mysqli_num_rows($query);
			if($num_rows>0) {
				while($appointment_data=mysqli_fetch_assoc($query)) {
				
				$items_name = "";
				$item_name_array = json_decode($appointment_data['item_name'],true);
				if(!empty($item_name_array)) {
					foreach($item_name_array as $item_name_data) {
						$items_name .= '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).':</strong> ';
						$items_opt_name = "";
						foreach($item_name_data['opt_data'] as $opt_data) {
							$items_opt_name .= $opt_data['opt_name'].', ';
						}
						$items_name .= rtrim($items_opt_name,', ');
						$items_name .= '<br>';		
					}
				}
				
				$sql_pro = "SELECT * FROM mobile WHERE id='".$appointment_data['product_id']."'";
				$exe_pro = mysqli_query($db,$sql_pro);
				$row_pro = mysqli_fetch_assoc($exe_pro);
				$product_name = $row_pro['title']; ?>
				<tr>
					<td><?=$appointment_data['appt_id']?></td>
					<?php /*?><td><?=$product_name?></td><?php */?>
					<td><?=$items_name?></td>
					<td><?=amount_fomat($appointment_data['c_amount'])?></td>
					<?php /*?><td>
					<?php
					if($appointment_data['user_id']>0 && $appointment_data['customer_name']) {
						echo '<a href="edit_user.php?id='.$appointment_data['user_id'].'">'.$appointment_data['customer_name'].'</a>';
					} else {
						echo 'Guest';
					} ?></td><?php */?>
					<td>
					<?=$appointment_data['name']?>
					<?php
					/*if($appointment_data['user_id']>0 && $appointment_data['customer_name']) {
						echo '<br><a href="edit_user.php?id='.$appointment_data['user_id'].'">'.$appointment_data['customer_name'].'</a>';
					} else {
						echo '<br>Guest';
					}*/ ?>
					</td>
					<?php /*?><td><?=$appointment_data['email']?></td><?php */?>
					<?php /*?><td><?=$appointment_data['phone']?></td><?php */?>
					<?php /*?><td><a href="edit_location.php?id=<?=$appointment_data['location_id']?>"><?=$appointment_data['location_name']?></a></td><?php */?>
					<td><?=date('m/d/Y',strtotime($appointment_data['appt_date']))?></td>
					<?php /*?><td><?=str_replace("_"," to ",$appointment_data['appt_time'])?></td><?php */?>
					<?php /*?><td><?=date('m/d/Y h:i A',strtotime($appointment_data['added_date']))?></td><?php */?>
					<td>
						<?php /*?><a title="Edit Order" href="addedit_appointment.php?id=<?=$appointment_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a><?php */?>
						<a title="View Order, Order Details, Leave Comments" href="view_appointment.php?id=<?=$appointment_data['id']?>" class="btn btn-success btn-alt"><i class="icon-search"></i></a>
						<?php /*?><a title="Delete Order" href="controllers/appointment.php?d_id=<?=$appointment_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
						<a title="Generate/Update invoice of this order" href="order_invoice.php?id=<?=$appointment_data['id']?>" class="btn btn-success btn-alt"><i class="icon-file"></i></a><?php */?> </td>
				</tr>
              <?php
			  }
			} ?>
            </tbody>
          </table>
		  <?php
		  echo $pages->page_links(); ?>
		  </div>
        </section>
      </article>
    </div>
  </section>
  <div id="push"></div>
</div>
