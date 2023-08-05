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
		}, 
		/*{
			field: "image",
			title: "Icon",
			sortable: false,
			template: function (row) {
				if(row.image!="") {
					return '<img src="../images/mobile/'+row.image+'" width="100">';
				} else {
					return '';
				}
			}
		}, 
		{
			field: "prev_url",
			title: 'Preview',
			sortable: false,
			width: 100,
			template: function (row) {
				return '<a target="_blank" href="'+row.prev_url+'">Preview</a>';
			}	
		}, */
		{
			field: "fault_name",
			title: "Device Fault",
			//responsive: {visible: 'lg'}
			template: function (row) {
				
				/*var _html='<span class="instant_edit_name" id="fault_name_'+row['id']+'" data-row_id="'+row['id']+'" data-field_name="fault_name" data-field_value="'+row['fault_name']+'" data-field_type="text">' + row['fault_name'] + '</span>';
				return _html;*/
				
				
				var _html='<span id="fault_name_'+row['id']+'" data-row_id="'+row['id']+'" data-field_name="fault_name" data-field_value="'+row['fault_name']+'" data-field_type="text" onClick="open_edit_text_field(this);"> <i class="la la-edit"></i> ' + row['fault_name'] + '</span>';
				return _html;
			}
		}, 
		{
			field: "title",
			title: "Model"
		}, 
		/*{
			field: "brand_title",
			title: "Device make"
		},*/
		{
			field: "regular_price",
			title: "Regular Price",
			template: function (row) {
				var _html='<span onClick="open_edit_text_field(this);" id="fault_name_'+row['id']+'" data-row_id="'+row['id']+'" data-field_name="regular_price" data-field_value="'+row['regular_price']+'" data-field_type="number"> <i class="la la-edit"></i> ' + row['regular_price_display'] + '</span>';
				return _html;
				//return row['regular_price_display'];
			}
		}, 
		{
			field: "is_on_offer",
			title: "On Offer",
			template: function (row) {
				var _html='<span id="fault_name_'+row['id']+'" data-row_id="'+row['id']+'" data-field_name="is_on_offer" data-field_value="'+row['is_on_offer']+'" data-field_type="dropdown" onClick="open_edit_dropdown_field(this);"> <i class="la la-edit"></i> ' + (row['is_on_offer']=='1'?'Yes':'No') + '</span>';
				return _html;
				//return row['is_on_offer']=='1'?'Yes':'No';
			}
		},
		{
			field: "sale_price",
			title: "Sale Price",
			template: function (row) {
				var _html='<span onClick="open_edit_text_field(this);" id="fault_name_'+row['id']+'" data-row_id="'+row['id']+'" data-field_name="sale_price" data-field_value="'+row['sale_price']+'" data-field_type="number"> <i class="la la-edit"></i> ' + (row['sale_price_display']?row['sale_price_display']:'-') + '</span>';
				return _html;
			}
		}, 
		{
			field: "status",
			title: "Status",
			template: function (row) {
				var status = {
					1: {'title': 'Published', 'class': ' m-badge--success'},
					0: {'title': 'Unpublished', 'class': ' m-badge--metal'}
				};
				
				var _html='<i class="la la-edit"></i> <span class="m-badge ' + status[row.status].class + ' m-badge--wide" id="fault_name_'+row['id']+'" data-row_id="'+row['id']+'" data-field_name="status" data-field_value="'+row['status']+'" data-field_type="dropdown" onClick="open_edit_dropdown_field(this);"> ' + status[row.status].title + '</span>';
				return _html;
			}
		}, 
		{
			field: "Actions",
			width: 110,
			title: "Actions",
			sortable: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

				return '\
					<?php
					if($prms_model_edit == '1') { ?>
					<a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Model Details" onClick="open_edit_popup('+row.id+');">\
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

function open_edit_text_field(element){
	var $this=$(element);
	
	var id = $this.attr("data-row_id");
	var field_name=$this.attr("data-field_name");
	var old_text = $this.attr("data-field_value");//$this.text();
	var field_type=$this.attr("data-field_type");
	
	var input = $('<input type="'+field_type+'" value="' + old_text + '" />')
	$this.after(input);
	input.select();
	$this.hide();
	
	input.focusout(function() {
		var new_text = this.value;
		if(old_text!=new_text && new_text.trim()!=''){
			edit_fault_field_data(field_name,new_text,id);
		}
		//$('#attribute').parent().text(text);
		input.remove();
		$this.show();
	});
}

function open_edit_dropdown_field(element){
	var $this=$(element);
	var id = $this.attr("data-row_id");
	var field_name=$this.attr("data-field_name");
	var old_text = $this.attr("data-field_value");//$this.text();
	var field_type=$this.attr("data-field_type");
	
	if(field_name=="is_on_offer"){
		var data = {'1': 'Yes','0': 'No'};
	}
	else if(field_name=="status"){
		var data = {'1': 'Published','0': 'Unpublished'};
	}
	
	var input = $('<select />'); 
	
	for(var val in data) {    
		$('<option />', {value: val, text: data[val]}).appendTo(input); 
	}
	
	input.val(old_text);
	
	//var input = $('<input type="'+field_type+'" value="' + old_text + '" />')
	$this.after(input);
	input.select();
	$this.hide();

	input.blur(function() {
		input.remove();
		$this.show();
	});
	
	input.change(function() {
		var new_text = this.value;
		console.log('new_text',new_text);
		if(old_text!=new_text && new_text.trim()!=''){
			edit_fault_field_data(field_name,new_text,id);
		}
		//$('#attribute').parent().text(text);
		input.remove();
		$this.show();
	});
}

jQuery(document).ready(function () {
	DatatableDataListInit();
	
	
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
	
	$('.datepicker').datepicker({
		rtl: mUtil.isRTL(),
		todayHighlight: true,
		orientation: "bottom left",
		templates: arrows,
		autoclose:true,
	});
	
	$('#edit_model').on('hidden.bs.modal', function () {
		reset_add_edit_form();
	});
	
});


function edit_fault_field_data(field_name,field_value,fault_id) {
	
	//$('#'+field_name+'_'+fault_id).text(field_value);
	
	if(field_name==null || field_name.trim()=='' || field_name==''){
		swal({
            title: "Please Enter Value",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else if(field_value==null || field_value.trim()=="" || field_value == ''){
		swal({
            title: "Please Enter value",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else{
		var post_data={};
		post_data.field_name = field_name;
		post_data.field_value = field_value;
		post_data.fault_id = fault_id;
		post_data.type = '_update_instant_field';
		
		var data = { post_data:post_data };
		mApp.block('#list_body');
		$.ajax({
			url: "ajax/actions/fault_list.php",
			method: "POST",
			//processData: false,
			//contentType: false,
			data: data,
			success: function (data) {
				mApp.unblock('#list_body');
				var e = JSON.parse(data);
				if(e.status == 'success') {
					//DatatableDataListInit();
					//show_toast('success',e.message);
					window.location.href = "fault_list.php";
				} 
				else if(e.status == 'fail'){
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
}

function export_data(export_file_type){
	var export_data_option=$('input[name=export_data_option]:checked').val();
	
	var selected_chkbox_id=[];
	if(export_data_option=="selected"){
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
			return false;
		}
	}
	
	
	var post_data={};
	
	
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
	
	var filter_by = $("#generalSearch").val();
	if(filter_by!="") {
		post_data.filter_by = filter_by;
	}
	
	post_data.type = 'export';
	post_data.export_file_type = export_file_type;
	post_data.export_data_option = export_data_option;
	post_data.ids = selected_chkbox_id;
	
	var data = { post_data:post_data };
	mApp.block('#list_body');
	$.ajax({
		url: "ajax/actions/fault_list.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				//show_toast('success',e.message);
				window.location.href = "fault_list.php";
			} else if(e.status == 'export_success') {
				swal({
					title: "Download "+export_file_type+" file",
					showCancelButton: true,
					type: "success",
					confirmButtonText: "Download"
				}).then(function (s) {
					if(s.value) {
						window.open(e.file_path,'_blank');
					}
				});
			} else if(e.status == 'fail'){
				swal({
					title: e.message,
					type: "error",
					showCancelButton: false,
					confirmButtonText: "Ok"
				}).then(function (e) {
					//clear_data_and_redirect();
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

function removeRecord(id) {
	swal({
		title: "Are you sure you want to delete this record?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/fault_list.php?d_id="+id;
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
			window.location.href = "controllers/fault_list.php?c_id="+id;
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
		url: "ajax/actions/fault_list.php",
		method: "POST",
		data: data,
		success: function (data) {
			mApp.unblock('#list_body');
			var e = JSON.parse(data);
			if(e.status == 'success') {
				//DatatableDataListInit();
				//show_toast('success',e.message);
				window.location.href = "fault_list.php";
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

var fault_data_list=<?=$json_data_list?>;

function open_edit_popup(id){
	if(fault_data_list.length>0){
		var selected_item_data=fault_data_list.find(function(data){return data.id==id;});
		if(selected_item_data){
			$("#fault_name").val(selected_item_data.fault_name);
			$("#regular_price").val(selected_item_data.regular_price);
			$("#sale_price").val(selected_item_data.sale_price);
			var is_on_offer=false;
			if(selected_item_data.is_on_offer=="1"){
				is_on_offer=true;	
			}
			$("#is_on_offer").prop('checked', is_on_offer);
			if(selected_item_data.offer_start_date!='' && selected_item_data.offer_start_date!='0000-00-00'){
				$('#offer_start_date').datepicker('setDate', selected_item_data._offer_start_date);
			}
			if(selected_item_data.offer_end_date!='' && selected_item_data.offer_end_date!='0000-00-00'){
				$('#offer_end_date').datepicker('setDate', selected_item_data._offer_end_date);
			}
			$("input[name=status][value="+selected_item_data.status+"]").attr('checked', true);
			$("#fault_id").val(id);
			$('#edit_model').modal('show');
		}
	}
}

function reset_add_edit_form(){
	var edit_form=$("#edit_item_form");
	edit_form.clearForm();
	edit_form.validate().resetForm();
}


function edit_fault_data() {
	
	var fault_name=$("#fault_name").val();
	var regular_price=$("#regular_price").val();
	var is_on_offer = ($("#is_on_offer").is(":checked"))?'1':'0';
	var sale_price=$("#sale_price").val();
	var offer_start_date=$("#offer_start_date").val();
	var offer_end_date=$("#offer_end_date").val();
	var status=$("input[name='status']:checked").val();
	var fault_id=$("#fault_id").val();
	
	if(fault_name==null || fault_name.trim()=='' || fault_name==''){
		swal({
            title: "Please Enter name",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else if(regular_price==null || regular_price.trim()=="" || regular_price == ''){
		swal({
            title: "Please Enter regular price",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else if(is_on_offer=='1' && (sale_price=='' || sale_price.trim()=="") ){
		swal({
            title: "Please Enter sale price",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else if(is_on_offer=='1' && ( offer_start_date.trim()=="" || offer_start_date == '')){
		swal({
            title: "Please Select offer start Date",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else if(is_on_offer=='1' && (offer_end_date==null || offer_end_date.trim()=="" || offer_end_date == '') ){
		swal({
            title: "Please Select offer END Date",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else if(is_on_offer=='1' && (Date.parse(offer_start_date) > Date.parse(offer_end_date)) ){
		swal({
            title: "Please Expire date should be equal to or greater than Start Date",
            showCancelButton: false,
			type: "error",
            confirmButtonText: "Ok"
        })
		return false;
	}
	else{
		var post_data={};
		post_data.fault_name = fault_name;
		post_data.regular_price = regular_price;
		post_data.is_on_offer = is_on_offer;
		post_data.sale_price = sale_price;
		post_data.offer_start_date = offer_start_date;
		post_data.offer_end_date=offer_end_date;
		post_data.status = status;
		post_data.fault_id = fault_id;
		post_data.type = '_update';
		
		//var formData = new FormData();
		//formData.append('post_data', JSON.stringify(post_data));
		
		var data = { post_data:post_data };
		mApp.block('#list_body');
		$.ajax({
			url: "ajax/actions/fault_list.php",
			method: "POST",
			//processData: false,
			//contentType: false,
			data: data,
			success: function (data) {
				mApp.unblock('#list_body');
				var e = JSON.parse(data);
				if(e.status == 'success') {
					//DatatableDataListInit();
					//show_toast('success',e.message);
					window.location.href = "fault_list.php";
				} 
				else if(e.status == 'fail'){
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
}

<?php
} ?>

function ImportDataModal() {
	jQuery(document).ready(function($) {
		$('#export_modal').modal({backdrop: 'static',keyboard: false});
	});
}


</script>