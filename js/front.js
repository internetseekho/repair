var tpj=jQuery;

function check_form_data(){
	tpj("#payment_amt").val(tpj(".show_final_amt_val").html());
	return true;
}

tpj(document).ready(function($){

	//START for check validations
	$(".sell-this-device").click(function() {
		var is_true = "yes";
		$('.model-details-panel .radios, .model-details-panel .checkboxes').each(function(i, element) {
			var html = $(this).html();
			var data_input_type = $(this).attr("data-input-type");
			if(data_input_type=="radio" || data_input_type == "select") {
				var crt_row_type = $(this).parent().parent().parent().attr("data-row_type");
				var is_required = $(this).parent().parent().parent().attr("data-required");
				if(is_required=="1"){
					if(crt_row_type=="radio" || crt_row_type=="select"){
						var cc = $(this).parent().find("input:checked").length;
						if(cc==0){
							$(this).parent().parent().prev().find(".validation-msg").html('Please choose an option');
							is_true = "no";
						}
					}
				} 
			} else if(data_input_type=="checkbox"){
				var crt_row_type = $(this).parent().parent().attr("data-row_type");
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var cc = $(this).parent().find("input:checked").length;
					if(cc==0){
						$(this).parent().prev().find(".validation-msg").html('Please choose an option');
						is_true = "no";
					}
				}
			}
		});

		$('.model-details-panel .dropdowns').each(function(i, element) {
			var data_input_type = $(this).attr("data-input-type");
			if(data_input_type=="radio") {
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var html = $(this).children().children().val();
					if(html=="") {
						$(this).parent().prev().find(".validation-msg").html('Please select value');
						is_true = "no";
					}
				}
			}
		});

		$(".model-details-panel .input").each(function(i, element) {												 
			var data_input_type = $(this).attr("data-input-type");
			if(data_input_type=="text" || data_input_type=="textarea" || data_input_type=="datepicker") {
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var html = $(this).val();
					if(html=="") {
						$(this).parent().prev().find(".validation-msg").html('Please enter value');
						is_true = "no";
					}
				}
			} else if(data_input_type=="file") {
				var is_required = $(this).parent().parent().attr("data-required");
				if(is_required=="1"){
					var html  = $(this).val();
					if(html=="") {
						$(this).parent().prev().find(".validation-msg").html('Please choose file');
						is_true = "no";
					}
				}
			}
		});

		if(is_true == "no") {
			return false;	
		}
	});
	//END for check validations

	$(".model-details-panel .radios, .model-details-panel .checkboxes").click(function() {													
		var data_input_type = $(this).attr("data-input-type");
		if(data_input_type=="radio" || data_input_type == "select") {
			var crt_row_type = $(this).parent().parent().parent().attr("data-row_type");
			var is_required = $(this).parent().parent().parent().attr("data-required");
			if(is_required=="1") {
				if(crt_row_type=="radio" || crt_row_type=="select") {
					//var cc = $(this).parent().find("input:checked").length;
					//if(cc>0) {
						$(this).parent().parent().prev().find(".validation-msg").html('');
					//}
				}
			}
			
			/*var html;
			if(crt_row_type=="radio" || crt_row_type=="select") {
				split_html = $(this).find("input").attr("value").split('::');
				html = split_html[0];
			}
			
			if(html != "") {
				$(this).parent().parent().prev().find(".selected-option-value").html('<span class="btn btn-info btn-sm">'+html+'</span>');
			} else {
				$(this).parent().parent().prev().find(".selected-option-value").html('');	
			}*/
		} else if(data_input_type=="checkbox") {
			var crt_row_type = $(this).parent().parent().attr("data-row_type");
			var is_required = $(this).parent().parent().attr("data-required");
			if(is_required=="1"){
				if(crt_row_type=="checkbox"){
					var cc = $(this).parent().find("input:checked").length;
					if(cc>0){
						$(this).parent().prev().find(".validation-msg").html('');
					}
				}
			}

			/*var html = $(this).find('input:checked').map(function() {
							var spl_html = this.value.split('::');
							return spl_html[0];
						}).get().join(', ');
			if(html!="") {
				html = html.substr(0, 28)+"...";
				$(this).parent().prev().find(".selected-option-value").html('<span class="btn btn-info btn-sm">'+html+'</span>');
			} else {
				html = '';
				$(this).parent().prev().find(".selected-option-value").html('');
			}*/	
		}
	});

	$(".model-details-panel .dropdowns").on("keyup change",function(e) {
		var data_input_type = $(this).attr("data-input-type");
		if(data_input_type=="radio") {
			var is_required = $(this).parent().parent().attr("data-required");
			if(is_required=="1"){
				var html = $(this).children().children().val();
				if(html!="") {
					$(this).parent().prev().find(".validation-msg").html('');
				}
			}
		}
	});

	$(".model-details-panel .input").on("keyup change",function(e) {													 
		var data_input_type = $(this).attr("data-input-type");
		if(data_input_type=="text" || data_input_type=="textarea" || data_input_type=="datepicker") {
			var html = $(this).val();
			var is_required = $(this).parent().parent().attr("data-required");
			if(is_required=="1"){
				if(html!="") {
					$(this).parent().prev().find(".validation-msg").html('');
				}
			}
				
			/*var html = $(this).val();
			if(html!="") {
				html = html.substr(0, 14)+"...";
				html = html;
			} else {
				html = '';
			}

			$(this).parent().prev().find(".selected-option-value").html('<span class="btn btn-info btn-sm">'+html+'</span>');*/
		} else if(data_input_type=="file") {
			var html  = $(this).val();
			var is_required = $(this).parent().parent().attr("data-required");
			if(is_required=="1"){
				if(html!="") {
					$(this).parent().prev().find(".validation-msg").html('');
				}
			}
			
			var file_id = $(this).attr('id');
			var fileName = e.target.files[0].name;
			var file_ext = fileName.replace(/^.*\./,'');
			if(file_ext != 'jpg' && file_ext != 'jpeg' && file_ext != 'png' && file_ext != 'gif' && file_ext != 'txt' && file_ext != 'pdf') {
				alert("Only jpg/jpeg/png/gif/txt/pdf are allowed!");
				document.getElementById(file_id).value = '';
				//$(this).parent().prev().find(".selected-option-value").html('');
				return false;
			} else {
				//$(this).parent().prev().find(".selected-option-value").html('<span class="btn btn-info btn-sm">'+html+'</span>');
			}
		}
	});	
});
