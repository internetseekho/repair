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
		columns: [/*{
			field: "id",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, */{
			field: "order_id",
			title: "Order ID"
		}, {
			field: "clock_in_datetime",
			title: "Clock In"
		}, {
			field: "clock_out_datetime",
			title: "Clock Out"
		}, {
			field: "total_hm",
			title: "Total (H:M)"
		}/*, {
			field: "message",
			title: "Message",
			template: function (row) {
				return atob(row.message);
			}
		}, {
			field: "Actions",
			width: 110,
			title: "Actions",
			sortable: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

				return '\
					<a href="javascript:void(0);" onClick="removeRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete This Record">\
						<i class="la la-trash"></i>\
					</a>\
				';
			}
		}*/]
	});

	/*$('#m_form_type').on('change', function () {
		datatable.search($(this).val(), 'Type');
	});*/

	$('#staff_id, #order_id').selectpicker();
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
			window.location.href = "controllers/contact.php?d_id="+id;
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
		url: "ajax/actions/contact.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				show_toast('success',e.message);
				window.location.href = "contact.php";
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
<?php
} ?>
</script>