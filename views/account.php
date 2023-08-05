<?php
//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} ?>

<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row clearfix">
				<div class="col-md-12">
					
					<?php
					//START for confirm message
					$confirm_message = getConfirmMessage()['msg'];
					echo $confirm_message;
					//END for confirm message
					
					if($user_data['image']) {
						$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/avatar/'.$user_data['image'].'&h=150'; ?>
						<img loading="lazy" src="<?=$md_img_path?>" class="alignleft img-circle img-thumbnail notopmargin nobottommargin" alt="Avatar" style="max-width:84px;">
					<?php
					} else { ?>
						<img loading="lazy" src="images/icons/avatar.jpg" class="alignleft img-circle img-thumbnail notopmargin nobottommargin" alt="Avatar" style="max-width: 84px;">
					<?php
					} ?>

					<div class="heading-block noborder">
						<h3>
							<?=$user_data['first_name'].' '.$user_data['last_name']?>
							<a class="btn btn-danger btn-sm" href="controllers/logout.php"><i class="icon-line2-logout"></i> <?=$logout_btn_text?></a>
						</h3>
						<?php
						if($user_data['image']) { ?>
							<span><a class="btn btn-danger btn-sm" href="controllers/user/profile.php?remove_av_id=<?=$user_data['id']?>&t=<?=md5(date("YmdHis"))?>" onclick="return confirm('<?=$remove_avtar_confirm_msg_text?>')"><?=$remove_avtar_btn_text?></a></span>
						<?php
						} ?>
					</div>

					<div class="clear"></div>
					<div class="row clearfix">
						<div class="col-lg-12">
							<div class="tabs tabs-alt clearfix" id="tabs-profile">
								<ul class="tab-nav clearfix">
									<li><a href="#tab-orders"><i class="icon-list"></i> <?=$account_order_menu_text?></a></li>
									<li><a href="#tab-profile"><i class="icon-user"></i> <?=$account_profile_menu_text?></a></li>
									<li><a href="#tab-changepsw"><i class="icon-lock"></i> <?=$account_change_psw_menu_text?></a></li>
									<!--<li><a href="controllers/logout.php"><i class="icon-line2-logout"></i> <?=$logout_btn_text?></a></li>-->
								</ul>

								<div class="tab-container">
									<div class="tab-content clearfix" id="tab-orders">
										<div class="row notopmargin clearfix">
											<h4 class="nobottommargin"><?=$account_order_list_text?></h4>
											<table class="table table-bordered table-striped">
											  <tr>
												<th width="5%">Order ID</th>
												<th width="30%">Device</th>
												<?php
												if($online_booking_hide_price != '1') { ?>
												<th width="10%">Amount</th>
												<?php
												} ?>
												<th>Appt. Date / Time</th>
												<th>Status</th>
												<th>Submitted Date</th>
												<th width="150px;">Label Print</th>
											  </tr>
											  <?php
												$pages = new Paginator($page_list_limit,'p');
								
												$appt_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_appointments FROM appointments WHERE email='".$user_data['email']."' AND email!=''");
												$appt_data = mysqli_fetch_assoc($appt_query);
												$pages->set_total($appt_data['num_of_appointments']);
								
												if($appt_data['num_of_appointments']>0) {
													$appt_items_query=mysqli_query($db,"SELECT a.*, aps.name AS appt_status_name FROM appointments AS a LEFT JOIN appointments_status AS aps ON aps.id=a.status WHERE a.email='".$user_data['email']."' AND a.email!='' ORDER BY CONCAT(a.appt_date,' ',a.appt_time) DESC ".$pages->get_limit());
													while($appointment_data=mysqli_fetch_assoc($appt_items_query)) {
													
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
														} ?>
														<tr>
															<td><a href="<?='view_appointment/'.$appointment_data['appt_id'].(isset($post['p']) && $post['p']>0?'?p='.$post['p']:'')?>"><?=$appointment_data['appt_id']?></a></td>
															<td><?=$items_name?></td>
															<?php
															if($online_booking_hide_price != '1') { ?>
															<td><?=amount_fomat($appointment_data['item_amount'])?></td>
															<?php
															} ?>
															<td><?=format_date($appointment_data['appt_date']).' '.format_time($appointment_data['appt_time'])?></td>
															<td><?=ucwords(str_replace('_',' ',$appointment_data['appt_status_name']))?></td>
															<td><?=format_date($appointment_data['added_date'])?></td>
															<td>
															<?php
															$shipment_label_url = $appointment_data['shipment_label_url'];
															if($appointment_data['shipping_method'] == "ship_device" && $shipment_label_url != "") { ?>
																<a href="<?=SITE_URL.'controllers/download.php?download_link='.$shipment_label_url?>" class="btn btn-success btn-sm"><i class="icon-download"></i>&nbsp;<?=$address_label_btn_text?></a>
															<?php
															} ?>
															</td>
														</tr>
													<?php
													}
													// echo '<tr><td class="divider" colspan="7">'.$pages->page_links().'</td></tr>';
												} else { ?>
													<tr class="item">
														<td colspan="6" align="center">No Data Found</td>
													</tr>
											  <?php
											  } ?>
											</table>
										
											<div class="clearfix">
												<?=$pages->page_links()?>
											</div>
										</div>
									</div>
									<div class="tab-content clearfix" id="tab-profile">
										<div class="row notopmargin clearfix">
											<div class="col-md-12">
												<form action="controllers/user/profile.php" method="post" id="profile_form" enctype="multipart/form-data">
													<h4 class="nobottommargin"><?=$account_profile_page_title?></h4>
													<p class="alert alert-warning" style="margin-bottom:15px;margin-top:15px;"><i class="icon-warning-sign"></i><?=$account_profile_page_desc?></p>
				
													<div class="row">
													  <div class="col-md-12">
														<div class="form-group">
														  <label><?=$choose_avatar_field_title?></label>
														  <input type="file" name="image" id="image" class="sm-form-control choose-review-image" />
														</div>
													  </div>
													</div>
													
													<div class="row">
													  <div class="col-md-6">
														<div class="form-group">
														  <label><?=$first_name_field_title?></label>
														  <input type="text" name="first_name" id="first_name" placeholder="<?=$first_name_field_placeholder_text?>" value="<?=$user_data['first_name']?>" required class="sm-form-control" autocomplete="off" />
														</div>
													  </div>
													  <div class="col-md-6">
														<div class="form-group">
														  <label><?=$last_name_field_title?></label>
														  <input type="text" name="last_name" id="last_name" placeholder="<?=$last_name_field_placeholder_text?>" value="<?=$user_data['last_name']?>" class="sm-form-control" autocomplete="off" />
														</div>
													  </div>
													</div>
													<div class="row">
													  <div class="col-md-6">
														<div class="form-group">
														  <label><?=$email_field_title?></label>
														  <input type="email" name="email" id="email" placeholder="<?=$email_field_placeholder_text?>" value="<?=$user_data['email']?>" required class="sm-form-control" autocomplete="off" />
														</div>
													  </div>
													  <div class="col-md-6 tel-phone">
														<div class="form-group">
														  <label><?=$phone_field_title?></label>
														  <input type="tel" id="cell_phone" name="cell_phone" placeholder="<?=$phone_field_placeholder_text?>" class="sm-form-control" value="<?=$user_data['phone']?>">
														  <input type="hidden" name="phone" id="phone" />
														</div>
													  </div>
													</div>
													<div class="row">
													  <div class="col-md-12">
														<div class="h3"><strong><?=$account_profile_adr_details_title?></strong></div>
													  </div>
													</div>
													<div class="row">
													  <div class="col-md-6">
														<div class="form-group">
														  <label><?=$address_field_title?></label>
														  <input type="text" name="address" id="address" placeholder="<?=$address1_field_placeholder_text?>" value="<?=$user_data['address']?>" required class="sm-form-control" autocomplete="off" />
														</div>
													  </div>
													  <div class="col-md-6">
														<div class="form-group">
														  <label><?=$address2_field_title?></label>
														  <input type="text" name="address2" id="address2" placeholder="<?=$address2_field_placeholder_text?>" value="<?=$user_data['address2']?>" class="sm-form-control" autocomplete="off" />
														</div>
													  </div>
													</div>
													<div class="row">
													  <div class="col-md-4">
														<div class="form-group">
														  <label><?=$city_field_title?></label>
														  <input type="text" name="city" id="city" placeholder="<?=$city_field_placeholder_text?>" value="<?=$user_data['city']?>" required class="sm-form-control" />
														</div>
													  </div>
													  <div class="col-md-4">
														<div class="form-group">
														  <label><?=$state_field_title?></label>
														  <input type="text" name="state" id="state" placeholder="<?=$state_field_placeholder_text?>" value="<?=$user_data['state']?>" class="sm-form-control" />
														</div>
													  </div>
													  <div class="col-md-4">
														<div class="form-group">
														  <label><?=$zipcode_field_title?></label>
														  <input type="text" name="postcode" id="postcode" placeholder="<?=$zipcode_field_placeholder_text?>" value="<?=$user_data['postcode']?>" class="sm-form-control" autocomplete="off" />
														</div>
													  </div>
													</div>
													<div class="row">
													  <div class="col-md-12">
														<div class="form-group">
														  <button type="submit" class="button button-3d nomargin sbmt_button"><?=$update_btn_text?></button>
														  <input type="hidden" name="submit_form" id="submit_form" />
														</div>
													  </div>
													</div>
													<?php
													$profile_csrf_token = generateFormToken('profile'); ?>
													<input type="hidden" name="csrf_token" value="<?=$profile_csrf_token?>">
											   </form>
											</div>
										</div>
									</div>
									<div class="tab-content clearfix" id="tab-changepsw">
										<div class="row notopmargin clearfix">
											<div class="col-md-12">
												<form action="controllers/user/change_password.php" method="post" id="chg_psw_form">
													<h4 class="nobottommargin"><?=$account_cng_psw_page_title?></h4>
													<p><?=$account_cng_psw_page_desc?></p>
	
													<div class="row">
													  <div class="col-md-6">
														<div class="form-group">
														  <label><?=$new_password_field_title?>:</label>
														  <input type="password" name="password" id="password" class="sm-form-control" />
														</div>
													  </div>
													  <div class="col-md-6">
														<div class="form-group">
														  <label><?=$confirm_password_field_title?>:</label>
														  <input type="password" name="password2" id="password2" class="sm-form-control "/>
														</div>
													  </div>
													</div>
													<div class="row">
													  <div class="col-md-12">
														<div class="form-group">
														  <button type="submit" class="button button-3d nomargin sbmt_button"><?=$save_psw_btn_text?></button>
														  <input type="hidden" name="submit_form" id="submit_form" />
														</div>
													  </div>
													</div>
													<?php
													$change_password_csrf_token = generateFormToken('change_password'); ?>
													<input type="hidden" name="csrf_token" value="<?=$change_password_csrf_token?>">
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="w-100 line d-block d-md-none"></div>
			</div>
			<div class="row clearfix">
				<div class="col-md-12">
					<div class="block block-appoinments clearfix">
						<div class="heading-block topmargin-sm bottommargin-sm center">
							<h3><strong><?=$account_statuses_title?></strong></h3>
						</div>
						<div class="row">
							<div class="col-md-6 text-center">
								<p><strong>Submitted</strong> - You Appt. has been submitted.<br />
								<strong>Completed</strong> - Your Appt. has been completed.</p>
							</div>
							<div class="col-md-6 text-center">
								<p><strong>Received</strong> - Your Appt. has been received.<br />
								<strong>Rejected</strong> - Your Appt. has been rejected.<p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
(function ($) {
	$(function () {
		var telInput = document.querySelector("#cell_phone");
		var itiTel = window.intlTelInput(telInput, {
		  allowDropdown: false,
		  initialCountry: "<?=$country_small_nm?>",
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js"
		});
	  
		$(".choose-review-image").change(function(e) {
			var fileName = e.target.files[0].name;
			var file_ext = fileName.replace(/^.*\./,'');
			if(file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'png' || file_ext == 'gif') {
				$(".review-image-name").html('<br>'+fileName+'&nbsp;<a href="javascript:void(0);" id="cancel-browse-file"><i class="fa fa-close"></i></a>');
	
				$("#cancel-browse-file").on("click",function() {
					$(".review-image-name").html('');
					$(".choose-review-image").val(null);
				});
			} else {
				alert("Only jpg/jpeg/png/gif are allowed!");
				return false;
			}
		});
		
		$('#profile_form').bootstrapValidator({
			fields: {
			  first_name: {
				validators: {
				  stringLength: {
					min: 1,
				  },
				  notEmpty: {
					message: '<?=$validation_first_name_msg_text?>'
				  }
				}
			  }<?php /*?>,
			  last_name: {
				validators: {
				  stringLength: {
					min: 1,
				  },
				  notEmpty: {
					message: '<?=$validation_last_name_msg_text?>'
				  }
				}
			  }<?php */?>,
			  cell_phone: {
				validators: {
				  callback: {
					message: '<?=$validation_valid_phone_msg_text?>',
					callback: function (value, validator, $field) {
						if(itiTel.isValidNumber()) {
							var phone_number = itiTel.getNumber();
							$("#phone").val(phone_number);
							return true;
						} else {
							return false;
						}
					}
				  }
				}
			  },
			  email: {
				validators: {
				  notEmpty: {
					message: '<?=$validation_email_msg_text?>'
				  },
				  emailAddress: {
					message: '<?=$validation_valid_email_msg_text?>'
				  }
				}
			  },
			  password: {
				validators: {
				  notEmpty: {
					message: '<?=$validation_password_msg_text?>'
				  }
				}
			  },
			  address: {
				validators: {
				  notEmpty: {
					message: '<?=$validation_address_msg_text?>'
				  }
				}
			  }<?php /*?>,
			  address2: {
				validators: {
				  notEmpty: {
					message: '<?=$validation_address2_msg_text?>'
				  }
				}
			  }<?php */?>,
			  city: {
				validators: {
				  notEmpty: {
					message: '<?=$validation_city_msg_text?>'
				  }
				}
			  }<?php /*?>,
			  state: {
				validators: {
				  notEmpty: {
					message: '<?=$validation_state_msg_text?>'
				  }
				}
			  },
			  postcode: {
				validators: {
				  notEmpty: {
					message: '<?=$validation_zipcode_msg_text?>'
				  }
				}
			  }<?php */?>,
			  terms_conditions: {
				validators: {
				  callback: {
					message: '<?=$validation_terms_msg_text?>',
					callback: function (value, validator, $field) {
					  var terms = document.getElementById("terms_conditions").checked;
					  if (terms == false) {
						return false;
					  } else {
						return true;
					  }
					}
				  }
				}
			  }
			}
		}).on('success.form.bv', function (e) {
			$('#profile_form').data('bootstrapValidator').resetForm();
	
			// Prevent form submission
			e.preventDefault();
	
			// Get the form instance
			var $form = $(e.target);
	
			// Get the BootstrapValidator instance
			var bv = $form.data('bootstrapValidator');
	
			// Use Ajax to submit form data
			$.post($form.attr('action'), $form.serialize(), function (result) {
			  console.log(result);
			}, 'json');
		});
		
		$('#chg_psw_form').bootstrapValidator({
			fields: {
				password: {
					validators: {
						notEmpty: {
							message: '<?=$validation_new_password_msg_text?>'
						},
						identical: {
							field: 'password2',
							message: '<?=$validation_new_confirm_password_not_match_msg_text?>'
						}
					}
				},
				password2: {
					validators: {
						notEmpty: {
							message: '<?=$validation_confirm_password_msg_text?>'
						},
						identical: {
							field: 'password',
							message: '<?=$validation_new_confirm_password_not_match_msg_text?>'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#chg_psw_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
	});
})(jQuery);
</script>
