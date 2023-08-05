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
			pageSize: 10
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
			field: "title",
			title: "Title"
		}, {
			field: "url",
			title: "SEF Url",
			template: function (row) {
				return '<a href="'+row.url_link+'" target="_blank">' + row.url + '</span>';
			}
		}/*, {
			field: "meta_title",
			title: "Meta Title"
		}, {
			field: "meta_desc",
			title: "Meta Desc"
		}, {
			field: "meta_keywords",
			title: "Meta Keywords"
		}*/, {
			field: "status",
			title: "Status",
			width: 100,
			template: function (row) {
				var status = {
					1: {'title': 'Published', 'class': ' m-badge--success'},
					0: {'title': 'Unpublished', 'class': ' m-badge--metal'}
				};
				return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
			}
		}, {
			field: "Actions",
			width: 110,
			title: "Actions",
			sortable: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
				
				if(row.is_inbuild_page == '1') {
					return '\
						<?php
						if($prms_page_edit == '1') { ?>
						<a href="edit_page.php?p_type=<?=$p_type?>&id='+row.id+row.brw_slug_param+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Page Details">\
							<i class="la la-edit"></i>\
						</a>\
						<?php
						} ?>
					';
				} else {
					return '\
						<?php
						if($prms_page_edit == '1') { ?>
						<a href="edit_page.php?p_type=<?=$p_type?>&id='+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Page Details">\
							<i class="la la-edit"></i>\
						</a>\
						<?php
						}
						if($prms_page_delete == '1') { ?>
						<a href="javascript:void(0);" onClick="removeRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete Page">\
							<i class="la la-trash"></i>\
						</a>\
						<?php
						} ?>
						<a href="javascript:void(0);" onClick="copyRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Copy page, It will copy with inactive status">\
							<i class="la la-copy"></i>\
						</a>\
					';
				}
			}
		}]
	});

	$('#m_form_status').on('change', function () {
		datatable.search($(this).val(), 'status');
	});

	$('#m_form_type').on('change', function () {
		datatable.search($(this).val(), 'Type');
	});

	$('#m_form_status, #m_form_type').selectpicker();
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
			window.location.href = "controllers/page.php?p_type=<?=$p_type?>&d_id="+id;
		}
	});
}

function copyRecord(id) {
	swal({
		title: "Are you sure you want to copy this page?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/page.php?p_type=<?=$p_type?>&c_id="+id;
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
		url: "ajax/actions/page.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				//show_toast('success',e.message);
				window.location.href = "page.php?p_type=<?=$p_type?>";
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

function removeImage(id, r_img_id) {
	swal({
		title: "Are you sure you want to delete this icon?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/page.php?p_type=<?=$p_type?>&id="+id+"&r_img_id="+r_img_id;
		}
	});
}

//== Class Definition
var SnippetFormValidation = function() {
    var handleProfileFormSubmit = function() {
        $('#m_form_submit').click(function(e) {
            //e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    title: {
                        required: true
                    }
					<?php
					if(!in_array($post['slug'],array("home"))) { ?>
					,
                    url: {
                        required: true
                    }
					<?php
					} ?>
                }
            });

            if (!form.valid()) {
                return;
            }
			
			if($('.description').summernote('codeview.isActivated')) {
				$('.description').summernote('codeview.deactivate');
			}
			return;
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function() {
            handleProfileFormSubmit();
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

//== Class Initialization
jQuery(document).ready(function() {
    SnippetFormValidation.init();
	DescriptionEditor.init();
	BootstrapSwitch.init();
	Select2.init();
});

jQuery(document).ready(function($){
	$(".catsbrands_in_menu").on('change',function() {
		var cats_in_menu = $('input:radio[id=cats_in_menu]:checked').val();
		var brands_in_menu = $('input:radio[id=brands_in_menu]:checked').val();
		var devices_in_menu = $('input:radio[id=devices_in_menu]:checked').val();
		if(cats_in_menu != 'cat' && brands_in_menu != 'brand' && devices_in_menu != 'device') {
			$(".category_section").show();
			$(".brand_section").show();
			$(".device_section").show();
			Select2.init();
		} else {
			$(".category_section").hide();
			$(".brand_section").hide();
			$(".device_section").hide();
		}
		
		if(devices_in_menu == 'device') {
			$(".device_section_for_device_menu").show();
			Select2.init();
		} else {
			$(".device_section_for_device_menu").hide();
		}
	});
});
</script>