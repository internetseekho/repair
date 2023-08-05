<script>
function removeImage(id, type) {
	swal({
		title: "Are you sure you want to delete this icon?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/general_settings.php?req_type=<?=$type?>&"+type+"="+id;
		}
	});
}

function removeXmlFile() {
	swal({
		title: "Are you sure to delete sitemap(XML) file?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/general_settings.php?req_type=<?=$type?>&r_sitemap=yes";
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
					<?php
					if($type == "appointment") { ?>
                    order_prefix: {
                        required: true,
                    },
                    order_completed_prefix: {
                        required: true
                    },
                    appt_start_time: {
                        required: true
                    },
                    appt_end_time: {
                        required: true
                    },
                    appt_time_interval: {
                        required: true
                    }
					<?php
					} ?>
                }
            });

            if (!form.valid()) {
                return;
            }

			<?php
			if($type == "general") { ?>
			if($('.description').summernote('codeview.isActivated')) {
				$('.description').summernote('codeview.deactivate');
			}
			<?php
			} ?>
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
        $('.multidate').datepicker({
            rtl: mUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
			multidate: true,
			format: 'dd-mm-yyyy'
        });
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
    SnippetFormValidation.init();
	DescriptionEditor.init();
	BootstrapSwitch.init();
	Select2.init();
	BootstrapDatepicker.init();
});

jQuery(document).ready(function(){
    var maxField = 100;
	
	$('#full_review_or_number_of_words_full').on("change",function(e){
		var checked = $("#full_review_or_number_of_words_full").is(":checked");
		if(checked){
			$('.review_limited_words_showhide').hide();
		}
	});
	$('#full_review_or_number_of_words_limited').on("change",function(e){
		var checked = $("#full_review_or_number_of_words_limited").is(":checked");
		if(checked){
			$('.review_limited_words_showhide').show();
		}
	});
	
	$('#allowed_num_of_booking_per_time_slot').on("change",function(e){
		var checked = $("#allowed_num_of_booking_per_time_slot").is(":checked");
		if(checked){
			$('.booking_allowed_per_time_slot').show();
		} else {
			$('.booking_allowed_per_time_slot').hide();	
		}
	});
	
	$('#is_ip_restriction').on("change",function(e){
		var checked = $("#is_ip_restriction").is(":checked");
		if(checked){
			$('.allowed_ip').show();
		} else {
			$('.allowed_ip').hide();	
		}
	});
	
    var addButton = $('.add_payment_method');
    var wrapper = $('.payment_method_wrapper');
    var fieldHTML = '<div class="form-group m-form__group row">';
						fieldHTML += '<div class="col-lg-8">';
							fieldHTML += '<div class="row">';
								fieldHTML += '<div class="col-md-6">';
									fieldHTML += '<div class="m-form__group--inline">';
										fieldHTML += '<div class="m-form__control">';
											fieldHTML += '<input class="form-control m-input" name="payment_method[]" value="" maxlength="50">';
										fieldHTML += '</div>';
									fieldHTML += '</div>';
									fieldHTML += '<div class="d-md-none m--margin-bottom-10"></div>';
								fieldHTML += '</div>';
								fieldHTML += '<div class="col-md-2">';
									fieldHTML += '<div class="remove_payment_method btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
										fieldHTML += '<span>';
											fieldHTML += '<i class="la la-trash-o"></i>';
											fieldHTML += '<span>Delete</span>';
										fieldHTML += '</span>';
									fieldHTML += '</div>';
								fieldHTML += '</div>';
							fieldHTML += '</div>';
						fieldHTML += '</div>';
					fieldHTML += '</div>'; 
    var x = 1;
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_payment_method', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent('div').remove();
        x--;
    });
	
	var addButton_2 = $('.add_payment_status');
    var wrapper_2 = $('.payment_status_wrapper');
    var fieldHTML_2 = '<div class="form-group m-form__group row">';
						fieldHTML_2 += '<div class="col-lg-8">';
							fieldHTML_2 += '<div class="row">';
								fieldHTML_2 += '<div class="col-md-6">';
									fieldHTML_2 += '<div class="m-form__group--inline">';
										fieldHTML_2 += '<div class="m-form__control">';
											fieldHTML_2 += '<input class="form-control m-input" name="payment_status[]" value="" maxlength="50">';
										fieldHTML_2 += '</div>';
									fieldHTML_2 += '</div>';
									fieldHTML_2 += '<div class="d-md-none m--margin-bottom-10"></div>';
								fieldHTML_2 += '</div>';
								fieldHTML_2 += '<div class="col-md-2">';
									fieldHTML_2 += '<div class="remove_payment_status btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
										fieldHTML_2 += '<span>';
											fieldHTML_2 += '<i class="la la-trash-o"></i>';
											fieldHTML_2 += '<span>Delete</span>';
										fieldHTML_2 += '</span>';
									fieldHTML_2 += '</div>';
								fieldHTML_2 += '</div>';
							fieldHTML_2 += '</div>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>'; 
    var x_2 = 1;
    
    //Once add button is clicked
    $(addButton_2).click(function(){
        //Check maximum number of input fields
        if(x_2 < maxField){ 
            x_2++; //Increment field counter
            $(wrapper_2).append(fieldHTML_2); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper_2).on('click', '.remove_payment_status', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent('div').remove();
        x--;
    });
	
});

function checkImage(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}
	
    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase(); 
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
	    var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function checkFaviconIcon(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}
	
    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase(); 
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if(FileExt != "ico"){
	    var error = "Please make sure your image is in ico format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function chg_mailer_type(type) {
	if(type=="smtp") {
		$(".showhide_smtp_fields").show();
		$(".showhide_emailapi_fields").hide();
	} else if(type=="sendgrid") {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").show();
	} else {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").hide();
	}
}
</script>