<div id="wrapper">
  <header id="header" class="container">
    <?php include("include/admin_menu.php"); ?>
  </header>
  <section class="container" role="main">
    <div class="row">
      <article class="span12 data-block">
        <header>
           <h2>Order View</h2>
        </header>
        <section>
          <?php include('confirm_message.php');?>		
          <div class="row-fluid">
            <div class="span6">
			    <h3>Order Details</h3>
				<div class="well">
					<h4 class="no-margin">Order Info:</h4>
					<dl class="no-bottom-margin">
						<dd><strong>Appt. ID:</strong> <?=$appointment_data['appt_id']?></dd>
						<dd><strong>Product Name:</strong> <?=$product_name?></dd>
						<dd><strong>Product Items:</strong></dd>
						<dd><?=$items_name?></dd>
						<dd><strong>Amount:</strong> <?=amount_fomat($appointment_data['c_amount'])?></dd>
						<dd><strong>Appt. Date:</strong> <?=date("m/d/Y",strtotime($appointment_data['appt_date']))?></dd>
						<dd><strong>Appt. Time:</strong> <?=str_replace("_"," to ",$appointment_data['appt_time'])?></dd>
						<dd><strong>Status:</strong> <?=ucwords(str_replace('_',' ',$appointment_data['status_name']))?></dd>
						<dd><strong>Submitted Date:</strong> <?=date('m/d/Y h:i A',strtotime($appointment_data['added_date']))?></dd>
					</dl>
				</div>
			
				<div class="well">
					<h4 class="no-margin">Extra Info: </h4>
					<dl class="no-bottom-margin">
						<dd><strong>Instructions:</strong> <?=($appointment_data['instructions']?$appointment_data['instructions']:'No Data')?></dd>
						<dd><strong>Extra Remarks:</strong> <?=$appointment_data['extra_remarks']?></dd>
					</dl>
				</div>	
            </div>
			
			<div class="span1">
				&nbsp;
			</div>
			
			<?php
			//if($assigned_contractor_data['contractor_id']>0) { ?>
			<div class="span5">
              <form action="controllers/appointment.php" method="post" role="form" class="form-vertical form-groups-bordered comment_form">
                <fieldset>
					<h3>Leave Comments</h3>
					<?php
					if($num_of_appt_cb_status > 0) { ?>								
					<div class="control-group">
						<label class="control-label" for="input">Order Status</label>
						<div class="controls">
							<select name="c_status" id="c_status" class="form-control">
								<option value=""> -Select- </option>
								<?php
								while($appt_cb_status_list = mysqli_fetch_assoc($appt_cb_status_query)) {?>
									<option value="<?=$appt_cb_status_list['id']?>" <?php //if($appointment_data['status'] == $appt_cb_status_list['id']){echo 'selected="selected"';}?>> <?=$appt_cb_status_list['name']?> </option>
								<?php
								} ?>
							</select>
						</div>
					</div>
					<?php
					} else {
						echo '<input type="hidden" name="c_status" id="c_status" value="" />';
					} ?>
					
					<div class="control-group">
						<label class="control-label" for="input">Comment * </label>
						<div class="controls">
							<textarea class="input-xxlarge" name="comment" id="comment" placeholder="Comment" rows="3" required></textarea>
						</div>
					</div>
					
					<input type="hidden" name="contractor_id" id="contractor_id" value="<?=$admin_l_id?>" />
					<input type="hidden" name="appt_id" id="appt_id" value="<?=$appointment_data['appt_id']?>" />
					<?php /*?><div class="form-actions">
						<button class="btn btn-alt btn-large btn-primary send_comment" type="button" name="c_send">Save</button>
					</div><?php */?>
					
					<h3>Comments History</h3>
					<div class="chat-messages" style="overflow-y:auto; max-height:350px;">
						<table class="table" width="100%">
							<tbody class="apd-chat-message">
								<?php
								if($num_of_comment>0) {
									while($comment_list = mysqli_fetch_assoc($comment_query)) {
										if($comment_list['thread_type'] == "contractor") { ?>
											<tr>
												<td>
													<img src="img/user-avatar.png" width="20">
													<span><?=date("m/d/Y h:i a",strtotime($comment_list['date']))?> <span class="label label-success"><?=$comment_list['status_name']?></span></span>
													<p><?=$comment_list['comment']?></p>
												</td>
											</tr>
										<?php
										} else { ?>
											<tr>
												<td style="text-align:right;">
													<span><?=date("m/d/Y h:i a",strtotime($comment_list['date']))?> <span class="label label-success"><?=$comment_list['status_name']?></span></span><img src="img/admin_avatar.png" width="15">
													<p style="text-align:left;"><?=$comment_list['comment']?></p>
												</td>
											</tr>
										<?php
										}
									}
								} else {
									echo '<small>History Not Available</small>';
								} ?>
							</tbody>
						</table>
					</div>
                </fieldset>
              </form>
            </div>
			<?php
			//} ?>
          </div>
        </section>
      </article>
    </div>
  </section>
  <div id="push"></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	//$('.send_comment').on('click', function(e) {
	$('#comment').on('blur keypress', function(e) {
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if(keycode == '13' || e.type === 'blur'){
			var post_data = $('.comment_form').serialize();
			jQuery.ajax({
				type: "POST",
				url:"ajax_send_comment.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var form_data = JSON.parse(data);
						if(form_data.status == true) {
							if(form_data.is_comment == "yes") {
								var message = '';
								message += '<tr>';
									message += '<td>';
										message += '<img src="img/user-avatar.png" width="20">';
										message += '<span>'+form_data.date;
										if(form_data.status_name!="") {
											message += ' <span class="label label-success">'+form_data.status_name+'</span>';
										}
										message += '</span>';
										message += '<p>'+form_data.comments+'</p>';
									message += '</td>';
								message += '</tr>';
								$('.apd-chat-message').prepend(message);
								$('#comment').val('');
								$('#c_status option[value='+form_data.status_id+']').attr('selected', 'selected');
								$('#status option[value='+form_data.status_id+']').attr('selected', 'selected');
							}
						} else {
							//alert(form_data.message);
							return false;
						}
					}
				}
			});
		}
	});
});
</script>
