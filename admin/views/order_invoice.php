<?php
$custom_phpjs_path = "assets/js/custom/appointment.php"; ?>

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

	<!-- BEGIN: Left Aside -->
	<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
	<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

		<!-- BEGIN: Aside Menu -->
		<?php
		include("include/admin_menu.php"); ?>
		<!-- END: Aside Menu -->
	</div>

	<!-- END: Left Aside -->
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title m-subheader__title--separator">Invoice #<?=($invoice_id!=''?$invoice_id:'xxxxxxxx')?></h3>
					<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
						<li class="m-nav__item m-nav__item--home">
							<a href="dashboard.php" class="m-nav__link m-nav__link--icon">
								<i class="m-nav__link-icon la la-home"></i>
							</a>
						</li>
						<li class="m-nav__separator">-</li>
						<li class="m-nav__item">
							<a href="" class="m-nav__link">
								<span class="m-nav__link-text">Order Invoice</span>
							</a>
						</li>
					</ul>
				</div>
				
				<?php
				if(!empty($invoice_details) && $invoice_details!="") { ?>
				<div>
					<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
						<a href="javascript:open_window('print_order.php?id=<?=$post['id']?>')" class="btn btn-alt btn-small btn-success">
							<span><i class="m-nav__link-icon la la-print"></i> <span>Print</span></span>
						</a>
						
						<a href="download_order_pdf.php?id=<?=$post['id']?>" target="_blank" class="btn btn-alt btn-small btn-metal">
							<span><i class="m-nav__link-icon la la-download"></i> <span>Download PDF</span></span>
						</a>
									
						<?php /*?><a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
							<i class="la la-plus m--hide"></i>
							<i class="la la-ellipsis-h"></i>
						</a>
						<div class="m-dropdown__wrapper">
							<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
							<div class="m-dropdown__inner">
								<div class="m-dropdown__body">
									<div class="m-dropdown__content">
										<ul class="m-nav">
											<li class="m-nav__section m-nav__section--first m--hide">
												<span class="m-nav__section-text">Quick Actions</span>
											</li>
											<li class="m-nav__item">
												<a href="javascript:open_window('print_order.php?id=<?=$post['id']?>')" class="m-nav__link">
													<i class="m-nav__link-icon la la-print"></i>
													<span class="m-nav__link-text">Print</span>
												</a>
											</li>
											<li class="m-nav__item">
												<a href="download_order_pdf.php?id=<?=$post['id']?>" target="_blank" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-download"></i>
													<span class="m-nav__link-text">Download PDF</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div><?php */?>
					</div>
				</div>
				<?php
				} ?>		
			</div>
		</div>
		<!-- END: Subheader -->
		
		<div class="m-content">
		
			<div class="row">
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										From
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<div class="m-section">
								<span class="m-section__sub">
									<dt>Address:</dt>
									<dd><?=$company_address?></dd>
									<dd><?=$company_city.', '.$company_state.' '.$company_zipcode?></dd>
									<dd><?=$company_country?></dd>
									<dt>Contact:</dt>
									<dd><a href="mailto:<?=$site_email?>"><?=$site_email?></a></dd>
									<dd><a href="site_phone:<?=$site_email?>"><?=$site_phone?></a></dd>
								</span>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										To
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<!--begin::Section-->
							<div class="m-section">
								<span class="m-section__sub">
									<dt>Name:</dt>
									<dd><?=$appointment_data['name']?></dd>
									<dt>Email:</dt>
									<dd><?=$appointment_data['email']?></dd>
									<dt>Phone:</dt>
									<dd><?=$appointment_data['phone']?></dd>
									<dt>Invoice Number:</dt>
									<dd>#<?=($invoice_id!=''?$invoice_id:'xxxxxxxx')?></dd>
									<dt>Invoice Date:</dt>
									<dd><?=($invoice_date!=""?format_date($invoice_date).' '.format_time($invoice_date):"xx-xx-xxxx xx:xx")?></dd>
								</span>
							</div>
							<!--end::Section-->
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Order Info
									</h3>
								</div>
							</div>
						</div>
						<div class="m-portlet__body">
							<!--begin::Section-->
							<div class="m-section">
								<span class="m-section__sub">
									<dt>Order ID:</dt>
									<dd><?=$appointment_data['appt_id']?></dd>
									<dt>Product Name:</dt>
									<dd><?=$product_name?></dd>
									<dt>Estimate Amount:</dt>
									<dd><?=amount_fomat($appointment_data['item_amount'])?></dd>
								</span>
							</div>
							<!--end::Section-->
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="m-portlet m-portlet--tab">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										Invoice #<?=($invoice_id!=''?$invoice_id:'xxxxxxxx')?>
									</h3>
								</div>
							</div>
						</div>
						
						<form action="controllers/appointment.php" method="post" class="m-form m-form--fit m-form--label-align-right">
						<div class="m-portlet__body m--padding-top-10 m--padding-bottom-10">
							<div class="m-form__content">
								<?php include('confirm_message.php'); ?>
							</div>
						    <div class="form-group m-form__group row">
								<div class="col-lg-3">
									<select required="required" id="discount_type" name="discount_type" class="form-control m-input">
										<option value="%" <?php if($discount_type == '%'){echo 'selected="selected"';}?>>% Discount</option>
										<option value="$" <?php if($discount_type == '$'){echo 'selected="selected"';}?>>Flat Discount</option>
									</select>
								</div>
								<div class="col-lg-3">
									<select required="required" id="tax_type" name="tax_type" class="form-control m-input">
										<option value="%" <?php if($tax_type == '%'){echo 'selected="selected"';}?>>% Tax</option>
										<option value="$" <?php if($tax_type == '$'){echo 'selected="selected"';}?>>Flat Tax</option>
									</select>
								</div>
								<div class="col-lg-3">
									<select required="required" id="payment_method" name="payment_method" class="form-control m-input">
										<option value=""> - Payment Method - </option>
										<?php
										if(!empty($payment_method_list_array)) {
											foreach($payment_method_list_array as $payment_method_k => $payment_method_v) { ?>
												<option value="<?=$payment_method_v?>" <?php if($payment_method_v == $payment_method){echo 'selected="selected"';}?>><?=$payment_method_v?></option>
											<?php
											}
										} ?>
									</select>
								</div>
								<div class="col-lg-3">
									<select required="required" id="payment_status" name="payment_status" class="form-control m-input">
										<?php /*?><option value=""> - Payment Status - </option><?php */?>
										<?php
										if(!empty($payment_status_list_array)) {
											foreach($payment_status_list_array as $payment_status_k => $payment_status_v) { ?>
												<option value="<?=$payment_status_v?>" <?php if($payment_status_v == $payment_status){echo 'selected="selected"';}?>><?=$payment_status_v?></option>
											<?php
											}
										} ?>
									</select>
								</div>
						    </div>
							
							<div class="form-group m-form__group row">
								<table class="table m-table m-table--head-bg-brand" id="tab_logic">
									<thead>
									  <tr>
										<th>Item Name</th>
										<th>Qty</th>
										<th>Price (<?=$currency_symbol?>)</th>
										<th>Discount (<?=$currency_symbol?>)</th>
										<th>Tax (<?=$currency_symbol?>)</th>
										<th width="125">Price Total (<?=$currency_symbol?>)</th>
										<th>Action</th>
									  </tr>
									</thead>
									<tbody>
									  <?php
									  $product_item_k = 0;
									  if(empty($invoice_details) || $invoice_details=="") { ?>
									  <tr id='addr0'>
										<td>
											<div class="col-lg-12 m-form__group-sub">
												<input type="text" name='product[]' placeholder='Item Name' class="form-control m-input" required/>
											</div>
										</td>
										<td>
											<div class="col-lg-10 m-form__group-sub">
												<input type="number" name='qty[]' placeholder='Qty' class="form-control m-input qty" step="0" min="0" required/>
											</div>
										</td>
										<td>
											<div class="col-lg-10 m-form__group-sub">
												<input type="number" name='price[]' placeholder='Price' class="form-control m-input price" step="0.00" min="0" required/>
											</div>
										</td>
										<td>
											<div class="col-lg-10 m-form__group-sub">
												<input type="number" name='discount[]' placeholder='Discount' class="form-control m-input discount" step="0.00" min="0"/><span class="discount_row_total"></span><input type="hidden" name='discount_val[]' class="discount_val" readonly/>
											</div>
										</td>
										<td>
											<div class="col-lg-10 m-form__group-sub">
												<input type="number" name='tax[]' placeholder='Tax' class="form-control m-input tax" step="0.00" min="0"/><span class="tax_row_total"></span><input type="hidden" name='tax_val[]' class="tax_val" readonly/>
											</div>
										</td>
										<td>
											<div class="col-lg-10 m-form__group-sub"><span class="row_ftotal">0.00</span></div>
											<input type="hidden" name='total[]' placeholder='0.00' class="total" readonly/>
										</td>
										<td>
											<a href="javascript:void(0);" id="deleter0" data-id="0" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill delete_per_row"><span><i class="la la-trash-o"></i><span>Delete</span></span></a>
										</td>
									  </tr>
									  <?php
									  } else {
										  foreach($invoice_details as $product_item_k => $product_item_data) { ?>
										  <tr id='addr<?=$product_item_k?>'>
											<td>
												<div class="col-lg-12 m-form__group-sub">
													<input type="text" name='product[]' placeholder='Item Name' value="<?=$product_item_data['item_name']?>" class="form-control m-input" required/>
												</div>
											</td>
											<td>
												<div class="col-lg-10 m-form__group-sub">
													<input type="number" name='qty[]' placeholder='Qty' class="form-control m-input qty" step="0" min="0" value="<?=$product_item_data['qty']?>" required/>
												</div>
											</td>
											<td>
												<div class="col-lg-10 m-form__group-sub">
													<input type="number" name='price[]' placeholder='Price' class="form-control m-input price" step="0.00" min="0" value="<?=$product_item_data['price']?>" required/>
												</div>
											</td>
											<td>
												<div class="col-lg-10 m-form__group-sub">
													<input type="number" name='discount[]' placeholder='Discount' class="form-control m-input discount" step="0.00" min="0" value="<?=$product_item_data['discount']?>"/><span class="discount_row_total"></span><input type="hidden" name='discount_val[]' class="discount_val" readonly/>
												</div>
											</td>
											<td>
												<div class="col-lg-10 m-form__group-sub">
													<input type="number" name='tax[]' placeholder='Tax' class="form-control m-input tax" step="0.00" min="0" value="<?=$product_item_data['tax']?>"/><span class="tax_row_total"></span><input type="hidden" name='tax_val[]' class="tax_val" readonly/>
												</div>
											</td>
											<td>
												<div class="col-lg-10 m-form__group-sub"><span class="row_ftotal"><?=$product_item_data['total']?></span></div>
												<input type="hidden" name='total[]' placeholder='0.00' class="total" value="<?=$product_item_data['total']?>" readonly/>
											</td>
											<td>
												<a href="javascript:void(0);" id="deleter<?=$product_item_k?>" data-id="<?=$product_item_k?>" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill delete_per_row"><span><i class="la la-trash-o"></i><span>Delete</span></span></a>
											</td>
										  </tr>
										  <?php
										  }
									  } ?>
									  
									  <tr id='addr<?=($product_item_k+1)?>'></tr>
									</tbody>
								</table>
							</div>
							
							<div class="m-form__group form-group m--align-right m--padding-top-0 m--padding-bottom-0 m--padding-right-20">
								<div id="add_row" class="add_payment_method btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
									<span>
										<i class="la la-plus"></i>
										<span>Add Row</span>
									</span>
								</div>
							</div>
						
							<table class="table m-table m-table--head-bg-brand m--align-right" id="tab_logic_total">
								<tbody>
									<tr>
										<td><strong>Price Sub Total (<?=$currency_symbol?>):</strong> <span id="sub_total">0.00</span></td>
									</tr>
									<tr>
										<td><strong>Discount Total (<?=$currency_symbol?>):</strong> <span id="discount_total">0.00</span></td>
									</tr>
									<?php
									if($promocode_amt>0) { ?>
										<tr><td><?=$f_promocode_info?></td></tr>
									<?php
									} ?>
									<tr>
										<td><strong>Tax Total (<?=$currency_symbol?>):</strong> <span id="tax_amount">0.00</span></td>
									</tr>
									<tr>
										<td><strong>Grand Total (<?=$currency_symbol?>):</strong> <span id="total_amount">0.00</span></td>
									</tr>
								</tbody>
							</table>
						</div>
								
						<div class="m-portlet__foot m-portlet__foot--fit">
							<div class="m-form__actions">
								<button id="m_form_submit" type="submit" class="btn btn-primary" name="invoice"><?=($invoice_id!=""?"Update":"Generate")?></button>
								<a href="appointment.php" class="btn btn-secondary">Back</a>
							</div>
						</div>
							
						<input type="hidden" name="appt_id" id="appt_id" value="<?=$appointment_data['appt_id']?>" />
						<input type="hidden" name="appt_auto_inc_id" id="appt_auto_inc_id" value="<?=$post['id']?>" />
						<input type="hidden" name="promocode_amt" id="promocode_amt" value="<?=$promocode_amt?>" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Body -->

<?php
if(!empty($invoice_details)) {
	echo '<script>calc()</script>';
} ?>
