<script src="../js/intlTelInput.js"></script>
<script>
var telInput = document.querySelector("#cell_phone"), errorMsg = document.querySelector("#error-msg"), validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
			
var itiTel = window.intlTelInput(telInput, {
  allowDropdown: false,
  initialCountry: "<?=$country_small_nm?>",
  geoIpLookup: function(callback) {
	$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
	  var countryCode = (resp && resp.country) ? resp.country : "";
	  callback(countryCode);
	});
  },
  utilsScript: "../js/intlTelInput-utils.js"
});

var reset = function() {
  telInput.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
telInput.addEventListener('blur', function() {
  reset();
  if (telInput.value.trim()) {
	if (itiTel.isValidNumber()) {
	  validMsg.classList.remove("hide");
	  //$("#mobile_number_status").val("valid");
	} else {
	  telInput.classList.add("error");
	  var errorCode = itiTel.getValidationError();
	  errorMsg.innerHTML = errorMap[errorCode];
	  errorMsg.classList.remove("hide");
	 // $("#mobile_number_status").val("invalid");
	}
  }
});

// on keyup / change flag: reset
telInput.addEventListener('change', reset);
telInput.addEventListener('keyup', reset);
</script>

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
			field: "name",
			title: "Name",
			width: 80,
		}, {
			field: "email",
			title: "Email",
			width: 150,
		}/*, {
			field: "phone",
			title: "Phone",
			width: 80,
		}*/, {
			field: "company_name",
			title: "Company"
		}, {
			field: "date",
			title: "Date"
		}, {
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

				return '\
					<?php
					if($prms_customer_edit == '1') { ?>
					<a href="edit_contractor.php?id='+row.id+'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Contractor Details">\
						<i class="la la-edit"></i>\
					</a>\
					<?php
					}
					if($prms_customer_delete == '1') { ?>
					<a href="javascript:void(0);" onClick="removeRecord('+row.id+')" class="m_sweetalert_demo_9 m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Delete Contractor">\
						<i class="la la-trash"></i>\
					</a>\
					<?php
					} ?>
				';
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
			window.location.href = "controllers/contractor.php?d_id="+id;
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
		url: "ajax/actions/contractor.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				//show_toast('success',e.message);
				window.location.href = "contractors.php";
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
			window.location.href = "controllers/contractor.php?id="+id+"&r_img_id="+r_img_id;
		}
	});
}

//== Class Definition
var SnippetAddFormValidation = function() {
    var handleProfileFormSubmit = function() {
        $('#m_add_form_submit').click(function(e) {
            //e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
						email: true
                    },
                    password: {
                        required: true,
						minlength: 6
                    }
                },
				submitHandler: function (form) {
					if(itiTel.isValidNumber()) {
						var phone_number = itiTel.getNumber();
						$("#phone").val(phone_number);
						
						var phone = $("#phone").val();
						if(phone=="") {
							swal({
								"title": "", 
								"text": "Please enter phone number", 
								"type": "error",
								"confirmButtonClass": "btn btn-danger m-btn m-btn--wide"
							});
							return false;
						} else {
							return true;
						}
					} else {
						swal({
							"title": "", 
							"text": "Please enter valid phone number", 
							"type": "error",
							"confirmButtonClass": "btn btn-danger m-btn m-btn--wide"
						});
						return false;
					}
				}
            });

            if (!form.valid()) {
                return;
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

var SnippetEditFormValidation = function() {
    var handleProfileFormSubmit = function() {
        $('#m_edit_form_submit').click(function(e) {
            //e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
						email: true
                    },
                    password: {
                        //required: true,
						minlength: 6
                    }
                },
				submitHandler: function (form) {
					if(itiTel.isValidNumber()) {
						var phone_number = itiTel.getNumber();
						$("#phone").val(phone_number);
						
						var phone = $("#phone").val();
						if(phone=="") {
							swal({
								"title": "", 
								"text": "Please enter phone number", 
								"type": "error",
								"confirmButtonClass": "btn btn-danger m-btn m-btn--wide"
							});
							return false;
						} else {
							return true;
						}
					} else {
						swal({
							"title": "", 
							"text": "Please enter valid phone number", 
							"type": "error",
							"confirmButtonClass": "btn btn-danger m-btn m-btn--wide"
						});
						return false;
					}
				}
            });

            if (!form.valid()) {
                return;
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

//== Class Initialization
jQuery(document).ready(function() {
    SnippetAddFormValidation.init();
	SnippetEditFormValidation.init();
	DescriptionEditor.init();
	BootstrapSwitch.init();
});
</script>