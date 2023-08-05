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
			scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
			// height: 450, // datatable's body's fixed height
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
			field: "invoice_id",
			title: "Invoice ID",
			width: 80
		}, {
			field: "appt_id",
			title: "Order ID",
			width: 80,
			template: function (row) {
				return '<a href="javascript:void(0);" title="'+row.contr_type+'">'+row.appt_id+'</a>';
			}
		}, {
			field: "payment_method",
			title: "Payment Method",
			width: 100,
		}, {
			field: "payment_status",
			title: "Payment Status",
			width: 100,
		}, {
			field: "invoice_date",
			title: "Invoice Date/Time"
		}, {
			field: "actual_cost_total",
			title: "Actual Cost(<?=$currency_symbol?>)",
			template: function (row) {
				if(row.actual_cost_total_with_format>0) {
					return row.actual_cost_total_with_format+'<a href="javascript:void(0);" onClick="showInvoiceAjaxModal('+row.appt_auto_inc_id+');return false;"><span class="la la-info-circle"></span></a>';
				} else {
					return '';
				}
			}
		}, {
			field: "Actions",
			width: 110,
			title: "Actions",
			sortable: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
				
				var customer_email = "''";
				if(row.customer_email) {
					customer_email = "'"+row.customer_email+"'";
				}
				
				return '\
					<?php
					if($prms_invoice_edit == '1') { ?>
					<a href="order_invoice.php?id='+row.appt_auto_inc_id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Invoice">\
						<i class="la la-edit"></i>\
					</a>\
					<?php
					}
					if($prms_invoice_delete == '1') { ?>
					<a href="javascript:void(0);" onClick="removeRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete Invoice">\
						<i class="la la-trash"></i>\
					</a>\
					<?php
					} ?>
					<a href="javascript:void(0);" onClick="emailInvoice('+row.appt_auto_inc_id+','+customer_email+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Invoice email send to customer">\
						<i class="la la-envelope"></i>\
					</a>\
				';
			}
		}]
	});

	$('#m_form_p_status').on('change', function () {
		datatable.search($(this).val(), 'payment_status');
	});
	
	$('#m_form_p_method').on('change', function () {
		datatable.search($(this).val(), 'payment_method');
	});

	$('#m_form_customer').on('change', function () {
		datatable.search($(this).val(), 'customer_name');
	});

	$('#m_form_p_status, #m_form_p_method, #m_form_customer').selectpicker();
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
			window.location.href = "controllers/order_invoice.php?d_id="+id;
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
			window.location.href = "controllers/order_invoice.php?i_order_id="+id;
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
	var data = { post_data:post_data };
	mApp.block('#list_body');
	$.ajax({
		url: "ajax/actions/order_invoice.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				//show_toast('success',e.message);
				window.location.href = "invoice_list.php";
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
        $('.datepicker').datepicker({
            rtl: mUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
			autoclose: true,
        });
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

jQuery(document).ready(function() {    
    BootstrapDatepicker.init();
});
</script>