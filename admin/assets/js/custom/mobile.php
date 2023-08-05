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
			field: "image",
			title: "Icon",
			sortable: false,
			width: 80,
			template: function (row) {
				if(row.image!="") {
					return '<img src="../images/mobile/'+row.image+'" width="50" title="'+row.title+'">';
				} else {
					return '';
				}
			}
		}/*, {
			field: "prev_url",
			title: 'Preview',
			sortable: false,
			width: 50,
			template: function (row) {
				return '<a target="_blank" href="'+row.prev_url+'"><i class="la la-eye"></i></a>';
			}	
		}*/, {
			field: "title",
			title: "Title"
		}, {
			field: "device_title",
			title: "Device"
		}/*, {
			field: "price",
			title: "Price"
		}*/, {
			field: "ordering",
			title: 'Order <button class="m-btn btn btn-sm btn-primary" type="button" onclick="items_order_action();"><i class="la la-save"></i></button>',
			sortable: false,
			width: 70,
			template: function (row) {
				return '<input type="text" class="m-ordering form-control m-input" id="ordering-'+row.id+'" value="'+row.ordering+'" name="ordering['+row.id+']">';
			}	
		}, {
			field: "status",
			title: "Status",
			template: function (row) {
				var status = {
					1: {'title': 'Published', 'class': ' m-badge--success'},
					0: {'title': 'Unpublished', 'class': ' m-badge--metal'}
				};
				return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
			}
		}, {
			field: "Actions",
			width: 80,
			title: "Actions",
			sortable: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

				return '\
					<?php
					if($prms_model_edit == '1') { ?>
					<a href="add_product.php?id='+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Model Details">\
						<i class="la la-edit"></i>\
					</a>\
					<?php
					}
					if($prms_model_delete == '1') { ?>
					<a href="javascript:void(0);" onClick="removeRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete Model">\
						<i class="la la-trash"></i>\
					</a>\
					<?php
					} ?>
					<a href="javascript:void(0);" onClick="copyRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Copy model, It will copy with unpublished status">\
						<i class="la la-copy"></i>\
					</a>\
					<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" target="_blank" href="'+row.prev_url+'" title="View This Model in Front-end"><i class="la la-eye"></i></a>\
				';
			}
		}]
	});

	$('#m_form_status').on('change', function () {
		datatable.search($(this).val(), 'status');
	});
	
	$('#m_form_cat').on('change', function () {
		datatable.search($(this).val(), 'cat_title');
	});
	
	$('#m_form_brand').on('change', function () {
		datatable.search($(this).val(), 'brand_title');
	});
	
	$('#m_form_device').on('change', function () {
		datatable.search($(this).val(), 'device_title');
	});

	$('#m_form_type').on('change', function () {
		datatable.search($(this).val(), 'Type');
	});

	$('#m_form_status, #m_form_cat, #m_form_brand, #m_form_device, #m_form_type').selectpicker();
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
			window.location.href = "controllers/mobile.php?d_id="+id;
		}
	});
}

function copyRecord(id) {
	swal({
		title: "Are you sure to copy this model?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/mobile.php?c_id="+id;
		}
	});
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
	} else if(type == "export_meta") {
	
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
	
	var status = $("#m_form_status").val();
	if(status!="") {
		post_data.status = status;
	}
	
	var cat = $("#m_form_cat").val();
	if(cat!="") {
		post_data.cat = cat;
	}
	
	var brand = $("#m_form_brand").val();
	if(brand!="") {
		post_data.brand = brand;
	}
	
	var device = $("#m_form_device").val();
	if(device!="") {
		post_data.device = device;
	}
	
	var data = { post_data:post_data };
	mApp.block('#list_body');
	$.ajax({
		url: "ajax/actions/mobile.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				//show_toast('success',e.message);
				window.location.href = "mobile.php";
			} else if(e.status == 'csv_success') {
				swal({
					title: "Download CSV file",
					showCancelButton: true,
					type: "success",
					confirmButtonText: "Download"
				}).then(function (s) {
					if(s.value) {
						window.open(e.csv_path,'_blank');
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

function ImportDataModal() {
	jQuery(document).ready(function($) {
		$('#export_modal').modal({backdrop: 'static',keyboard: false});
	});
}

function ImportDataModal2() {
	jQuery(document).ready(function($) {
		$('#export_modal2').modal({backdrop: 'static',keyboard: false});
	});
}
</script>