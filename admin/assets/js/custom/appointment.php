<script>
<?php
if(!empty($json_data_list)) { ?>
var datatable;
function DatatableDataListInit() {
	<?php /*?>var dataJSONArray = JSON.parse('<?=$json_data_list?>');<?php */?>
	var dataJSONArray = <?=$json_data_list?>;

	if(datatable){
		datatable.destroy();	
	}

	datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'local',
			source: dataJSONArray,
			pageSize: <?=$page_list_limit?>
		},

		// layout definition
		layout: {
			theme: 'default', // datatable theme
			class: '', // custom wrapper class
			scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
			height: 600, // datatable's body's fixed height
			footer: false // display/hide footer
		},

		// column sorting
		sortable: true,

		pagination: true,

		search: {
			input: $('#generalSearch')
		},

		// inline and bactch editing(cooming soon)
		// editable: false,

		// columns definition
		columns: [{
			field: "id",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "appt_id",
			title: "Order ID",
			width: 80,
			template: function (row) {
				return '<a href="view_appointment.php?id='+row.id+'" title="'+row.contr_type+'">'+row.appt_id+'</a><br><small>'+row.contr_type+'</small>';
			}
		}, {
			field: "item_name",
			title: "Repair Item(s)",
			template: function (row) {
				//return atob(row.item_name);
				var product_info = '';
				product_info += atob(row.product_name);
				if(row.remarks!="") {
					product_info += '&nbsp;<a href="javascript:void(0);" data-toggle="m-tooltip-remarks" data-skin="light" title="'+atob(row.item_name)+'" data-html="true" data-content="'+atob(row.item_name)+'"><span class="la la-info-circle"></span></a>';
				}
				return product_info;
			}
		}, {
			field: "customer_name_w_link",
			title: "Name",
			width: 80,
			template: function (row) {
				return atob(row.customer_name_w_link);
			}
		}, {
			field: "phone",
			title: "Phone",
			width: 80
		}, {
			field: "appt_datetime",
			title: "Appt. Date/Time"
		}, {
			field: "added_date",
			title: "Order Date"
		}, {
			field: "estimate_cost",
			title: "Estimate Cost(<?=$currency_symbol?>)",
			width: 80,
			template: function (row) {
				return row.estimate_cost+atob(row.f_promocode_info);
			}
		}
		<?php
		if($contractor_concept == '1') { ?>
		, {
			field: "contractor_cost",
			width: 80,
			title: "Contractor Cost(<?=$currency_symbol?>)"
		}, {
			field: "actual_cost_total",
			title: "Actual Cost(<?=$currency_symbol?>)",
			width: 80,
			template: function (row) {
				if(row.actual_cost_total>0) {
					return row.actual_cost_total+'<a href="javascript:void(0);" onClick="showInvoiceAjaxModal('+row.id+');return false;"><span class="la la-info-circle"></span></a>';
				} else {
					return row.actual_cost_total;
				}
			}
		}, {
			field: "commision",
			width: 80,
			title: "Commision(<?=$currency_symbol?>)"
		}
		<?php
		} ?>
		, {
			field: "Actions",
			width: 80,
			title: "Actions",
			sortable: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

				return '\
					<?php
					if($prms_order_edit == '1') { ?>
					<a href="addedit_appointment.php?id='+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Order">\
						<i class="la la-edit"></i>\
					</a>\
					<?php
					} ?>
					<a href="view_appointment.php?id='+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View Order, Order Assign to Contractor, Change Status & Send Alert to Customer">\
						<i class="la la-eye"></i>\
					</a>\
					<?php
					if($prms_order_delete == '1') { ?>
					<a href="javascript:void(0);" onClick="removeRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete Order">\
						<i class="la la-trash"></i>\
					</a>\
					<?php
					}
					if($prms_order_invoice == '1') { ?>
					<a href="order_invoice.php?id='+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Generate/Update invoice of this order">\
						<i class="la la-file"></i>\
					</a>\
					<?php
					} ?>
					<a href="javascript:open_window(\'print_order_receipt.php?id='+row.id+'\')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Print receipt of this order">\
						<i class="la la-print"></i>\
					</a>\
				';
			}
		}]
	});

	$('#m_location').on('change', function () {
		datatable.search($(this).val(), 'location_name');
	});
	
	$('#m_status').on('change', function () {
		datatable.search($(this).val(), 'status_name');
	});

	$('#m_contractor_type').on('change', function () {
		datatable.search($(this).val(), 'contractor_type');
	});

	$('#m_location, #m_status, #m_contractor_type').selectpicker();
	
	$('[data-toggle="m-tooltip-remarks"]').tooltip();
}

jQuery(document).ready(function () {
	DatatableDataListInit();
});

function removeRecord(id) {
	swal({
		title: "Are you sure you want to delete this record?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/appointment.php?d_id="+id;
		}
	});
}

function emailInvoice(id, email) {
	swal({
		title: "Are you sure you want to send invoice email to customer's email "+email+"?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/appointment.php?i_order_id="+id;
		}
	});
}

function showInvoiceAjaxModal(id) {
	if(id>0) {
		post_data = "id="+id;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"get_invoice_data.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('.comment_form_data').html(data);
					}
				}
			});
			$('#invoice_details_model').modal({backdrop: 'static',keyboard: false});
		});
	}
}

function items_order_action() {
	var ordering_id=[{}];
	$('.m-ordering').each(function(e) {
			var spl_id = this.id.split('-');
			var id = spl_id[1]+':'+this.value;
			ordering_id.push(id);
	});
	ajax_records_action(ordering_id, 'order');
}

function selected_items_action(type){
	var action_msg;
	if(type == "remove") {
		action_msg = "Are you sure to delete this record(s)?";
	} else if(type == "published") {
		action_msg = "Are you sure to published this record(s)?";
	} else if(type == "unpublished") {
		action_msg = "Are you sure to unpublished this record(s)?";
	} else if(type == "export") {
		
		var selected_chkbox_id=[];
		$('.m-checkbox').find('input[type="checkbox"]').each(function(e) {
			var status = $(this).is(":checked");
			if(status && this.value!='' && this.value!='on'){
				selected_chkbox_id.push(this.value);
			}
		});
	
		ajax_records_action(selected_chkbox_id, type);
		return true;
	}
	
	var selected_chkbox_id=[];
	$('.m-checkbox').find('input[type="checkbox"]').each(function(e) {
		var status = $(this).is(":checked");
		if(status && this.value!='' && this.value!='on'){
			selected_chkbox_id.push(this.value);
		}
	});

	if(selected_chkbox_id.length==0){
		swal({
			title: "Please first make a selection from the list.",
			showCancelButton: false,
			type: "error",
			confirmButtonText: "Ok"
		})
	} else {
		swal({
			title: action_msg,
			showCancelButton: true,
			type: "error",
			confirmButtonText: "Yes"
		}).then(function (e) {
			if(e.value) {
				ajax_records_action(selected_chkbox_id, type);
			}
		});
	}
}

function ajax_records_action(ids, type) {
	var post_data={};
	post_data.type = type;
	post_data.ids = ids;
	
	var from_date = $("#from_date").val();
	if(from_date!="") {
		post_data.from_date = from_date;
	}
	
	var to_date = $("#to_date").val();
	if(to_date!="") {
		post_data.to_date = to_date;
	}
	
	var location = $("#m_location").val();
	if(location!="") {
		post_data.location = location;
	}
	
	var status = $("#m_status").val();
	if(status!="") {
		post_data.status = status;
	}
	
	var contractor_type = $("#m_contractor_type").val();
	if(contractor_type!="") {
		post_data.contractor_type = contractor_type;
	}
	
	var data = { post_data:post_data };
	mApp.block('#list_body');
	$.ajax({
		url: "ajax/actions/appointment.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				//show_toast('success',e.message);
				window.location.href = "appointment.php";
			} else if(e.status == 'pdf_success') {
				swal({
					title: "Download PDF file",
					showCancelButton: true,
					type: "success",
					confirmButtonText: "Download"
				}).then(function (s) {
					if(s.value) {
						window.open(e.pdf_path,'_blank');
					}
				});
			} else if(e.status == 'fail'){
				swal({
					title: e.message,
					type: "error",
					showCancelButton: false,
					confirmButtonText: "Ok"
				}).then(function (e) {
					clear_data_and_redirect();
				});
			} else {
				show_toast('error',e.message);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			mApp.unblock('#list_body');
		}
	});	
}
<?php
} ?>

var BootstrapSwitch = function () {
    //== Private functions
    var demos = function () {
        // minimum setup
        $('[data-switch=true]').bootstrapSwitch();
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

var BootstrapDatepicker = function () {
    var arrows;
    if (mUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
    
    //== Private functions
    var demos = function () {
        // minimum setup
        $('.date_picker').datepicker({
            rtl: mUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
			autoclose: true,
        });
		
		$('.date_picker').datepicker().on('changeDate', function(e) {
			getTimeSlotList('', '');
		});
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

var DescriptionEditor = function () {    
    //== Private functions
    var demos = function () {
        $('.description').summernote({
            height: 150
        });
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

var Select2 = function() {
    //== Private functions
    var demos = function() {
        // basic
        $('.m_select2').select2({
            placeholder: " - Select - ",
            allowClear: true
        });
    }
	
    //== Public functions
    return {
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() { 
	BootstrapSwitch.init();   
    BootstrapDatepicker.init();
	DescriptionEditor.init();
	Select2.init();
});

jQuery(document).ready(function($) {
	$('.print').on('click', function(e) {
		var post_data = $('.filter_form').serialize();
		//console.log('post_data: ',post_data);
		open_window('<?=ADMIN_URL?>print_order_list.php?print=yes'+post_data);
		return false;
	});
	
	$('.print').on('click', function(e) {
		var post_data = $('.filter_form').serialize();
		//console.log(post_data);
		open_window('<?=ADMIN_URL?>print_order_list.php?export=yes'+post_data);
		return false;
	});
});

function showInvoiceAjaxModal(id) {
	if(id>0) {
		post_data = "id="+id;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"get_invoice_data.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('.comment_form_data').html(data);
					}
				}
			});
			$('#invoice_details_model').modal({backdrop: 'static',keyboard: false});
		});
	}
}

function open_window(url) {
	window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=960,height=960');
}

jQuery(document).ready(function($) {
	
	$('#user_id').on('change', function(e) {
		var user_id = $(this).val();
		if(user_id>0) {
			$(".add_user_fields").hide();
			$("#user_other_fields_status").val(0);
			
			post_data = {user_id:user_id};
			jQuery.ajax({
				type: "POST",
				url:"get_user_info.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var form_data = JSON.parse(data);
						if(form_data.status == true) {
							$('#name').val(form_data.name);
							$('#email').val(form_data.email);
							$('#phone').val(form_data.phone);
							$('#address1').val(form_data.address1);
							$('#address2').val(form_data.address2);
							$('#city').val(form_data.city);
							$('#state').val(form_data.state);
							$('#postcode').val(form_data.postcode);
						} else {
							alert(form_data.message);
							return false;
						}
					}
				}
			});
		} else {
			$('#name').val('');
			$('#email').val('');
			$('#phone').val('');
			$('#address1').val('');
			$('#address2').val('');
			$('#city').val('');
			$('#state').val('');
			$('#postcode').val('');
		}
	});
	
	$("#payment_method_cheque").click(function() {
		$(".payment_method_cheque").slideDown(),
		$(".payment_method_bank").slideUp(),
		$(".payment_method_ship_device").slideUp();
		//$('.payment_method_cheque_li').addClass('active'),
		//$(".payment_method_bank_li").removeClass('active');
	});

	$("#payment_method_bank").click(function() {
		$(".payment_method_bank").slideDown(),
		$(".payment_method_cheque").slideUp(),
		$(".payment_method_ship_device").slideUp();
		//$('.payment_method_bank_li').addClass('active'),
		//$(".payment_method_cheque_li").removeClass('active');
	});
	
	$("#payment_method_ship_device").click(function() {
		$(".payment_method_ship_device").slideDown(),
		$(".payment_method_cheque").slideUp(),
		$(".payment_method_bank").slideUp();
		//$('.payment_method_bank_li').addClass('active'),
		//$(".payment_method_cheque_li").removeClass('active');
	});
	
	$("#add_user").click(function() {
		var user_other_fields_status = $("#user_other_fields_status").val();
		if(user_other_fields_status == 0) {
			$(".add_user_fields").show();
			$("#user_other_fields_status").val(1);
			$('#user_id option[value=]').attr('selected', 'selected');
			$('#name').val('');
			$('#email').val('');
			$('#phone').val('');
			$('#address1').val('');
			$('#address2').val('');
			$('#city').val('');
			$('#state').val('');
			$('#postcode').val('');
		} else if(user_other_fields_status == 1) {
			$(".add_user_fields").hide();
			$("#user_other_fields_status").val(0);
		}
	});
});

function getTimeSlotList(id, type)
{
	if(type == "location") {
		var location_id = id.trim();
	} else {
		var location_id = $("#location_id").val();
	}
	if(location_id) {
		var calendar_date = $("#date").val();
		post_data = "location_id="+location_id+"&calendar_date="+calendar_date+"&option=1&panel=admin&token=<?=uniqid();?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/get_timeslot_list.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.html!="") {
							$('#time_slot').html(resp_data.html);
						}
					} else {
						return false;
					}
				}
			});
		});
	}
}

jQuery(document).ready(function($) {

	$('#contractor_id').on('change', function(e) {
		var contractor_id = $(this).val();
		post_data = {contractor_id:contractor_id};
		jQuery.ajax({
			type: "POST",
			url:"get_contractor_info.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var form_data = JSON.parse(data);
					if(form_data.status == true) {
						$('.contractor_info').html(form_data.contractor_info);
					} else {
						alert(form_data.message);
						return false;
					}
				}
			}
		});
	});

	//$('.send_comment').on('click', function(e) {
	$('#comment').on('blur keypress', function(e) {
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if(keycode == '13' || e.type === 'blur'){
			var post_data = $('.comment_form').serialize();
			jQuery.ajax({
				type: "POST",
				url:"ajax/ajax_send_comment.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var form_data = JSON.parse(data);
						if(form_data.status == "success") {
							if(form_data.is_comment == "yes") {
								var message = '';
								message += '<tr>';
									message += '<td>';
										message += '<img src="img/admin_avatar.png" width="15">';
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
							return false;
						}
					}
				}
			});
		}
	});
});

jQuery(document).ready(function ($) {
    var i=<?=(!empty($product_item_k)?$product_item_k:0+1)?>;
    $("#add_row").click(function(){
		b=i-1;
      	//$('#addr'+i).html($('#addr'+b).html()).find('td:last-child').html('<input type="number" name="total[]" placeholder="0.00" class="input-small total" readonly/>&nbsp;&nbsp;<a href="javascript:void(0);" id="deleter'+(i)+'" data-id="'+(i)+'" class="delete_per_row"><i class="icon-remove"></i></a>')
		$('#addr'+i).html($('#addr0').html()).find('td:last-child').html('<a href="javascript:void(0);" id="deleter'+(i)+'" data-id="'+(i)+'" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill delete_per_row"><span><i class="la la-trash-o"></i><span>Delete</span></span></a>');
		//$('#addr'+i).html($('#addr0').html()).find('td:nth-last-child').html('<div class="col-lg-10 m-form__group-sub"><span class="row_ftotal">0.00</span></div><input type="hidden" name="total[]" placeholder="0.00" class="total" readonly/><a href="javascript:void(0);" id="deleter'+(i)+'" data-id="'+(i)+'" class="delete_per_row"><i class="icon-remove"></i></a>');
		
		$('#addr'+i+' input[type=text]').val('');
		$('#addr'+i+' input[type=number]').val('');
		
      	$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
      	i++; 
  	});
	
	$(document).on('click', '.delete_per_row', function() {
		var id = $(this).attr("data-id");
		if(id>=1){
			$("#addr"+id).html('');
		} else {
			$('#addr'+id+' input[type=text]').val('');
			$('#addr'+id+' input[type=number]').val('');
		}
		calc();
	});
	
	$('#tab_logic tbody, #tax_type, #discount_type').on('keyup change',function(){
		calc();
	});
});

function calc()
{
	$('#tab_logic tbody tr').each(function(i, element) {
		var html = $(this).html();
		if(html!='')
		{
			var qty = $(this).find('.qty').val();
			var price = $(this).find('.price').val();
			
			var row_ftotal = (qty*price);
			$(this).find('.total').val(row_ftotal);
			
			var f_row_ftotal=formatMoney(row_ftotal);
			$(this).find('.row_ftotal').html(f_row_ftotal);
			
			var row_total = (qty*price);
			
			var tax_type = $("#tax_type").val();
			var discount_type = $("#discount_type").val();
			
			var discount = $(this).find('.discount').val();
			var tax = $(this).find('.tax').val();
			
			//var f_discount = (qty*discount);
			//var f_tax = (qty*tax);
			var f_discount = (1*discount);
			var f_tax = (1*tax);
			
			if(discount_type == '%') {
				discount_sum=row_total/100*f_discount;
				var discount_row_total = discount_sum.toFixed(2);
				//$(this).find('.discount_val').val(discount_sum.toFixed(2));
			} else {
				var discount_row_total = f_discount.toFixed(2);
				//$(this).find('.discount_val').val(f_discount.toFixed(2));
			}
			
			$(this).find('.discount_val').val(discount_row_total);
			
			var f_discount_row_total=formatMoney(discount_row_total);
			$(this).find('.discount_row_total').html(f_discount_row_total);
			
			if(tax_type == '%') {
				tax_sum=row_total/100*f_tax;
				var tax_row_total = tax_sum.toFixed(2);
				//$(this).find('.tax_val').val(tax_sum.toFixed(2));
			} else {
				var tax_row_total = f_tax.toFixed(2);
				//$(this).find('.tax_val').val(f_tax.toFixed(2));
			}
			
			$(this).find('.tax_val').val(tax_row_total);
			
			var f_tax_row_total=formatMoney(tax_row_total);
			$(this).find('.tax_row_total').html(f_tax_row_total);
			
			calc_total();
		}
    });
}

function calc_total()
{
	total=0;
	$('.total').each(function() {
        total += parseFloat($(this).val());
    });
	
	var f_sub_total=formatMoney(total);
	$('#sub_total').html(f_sub_total);
	
	discount=0;
	$('.discount_val').each(function() {
        discount += parseFloat($(this).val());
    });

	var f_discount=formatMoney(discount);
	$('#discount_total').html(f_discount);

	tax=0;
	$('.tax_val').each(function() {
        tax += parseFloat($(this).val());
    });
	tax_sum=tax;

	var f_tax_sum=formatMoney(tax_sum);
	$('#tax_amount').html(f_tax_sum);
	
	var promocode_amt = parseFloat($("#promocode_amt").val());
	if(promocode_amt>0) {
		total = (total - promocode_amt);
	}
	var total_amount = (tax_sum+(total-discount));
	var f_total_amount=formatMoney(total_amount);
	$('#total_amount').html(f_total_amount);
}

function open_window(url) {
	window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=960,height=960');
}

function showTimeSheetListAjaxModal() {
	jQuery('#timesheet_details_model').modal({backdrop: 'static',keyboard: false});
}
</script>

<?php
if(!empty($invoice_details)) {
	echo '<script>calc()</script>';
} ?>