document.addEventListener('DOMContentLoaded', function () {
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-full-width",
	  "preventDuplicates": true,
	  "onclick": null,
	  "showDuration": "100",
	  "hideDuration": "10000",
	  "extendedTimeOut": "10000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	};
});

function show_toast(type,msg){
	toastr[type](msg);
}

function clear_data_and_redirect() {
	window.location.href = "/admin";
}

function checkFile(fieldObj) {
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