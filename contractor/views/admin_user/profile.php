<script type="text/javascript">
function check_form(a){
	if(a.company_name.value.trim()==""){
		alert('Please enter company name');
		a.company_name.focus();
		a.company_name.value='';
		return false;
	}
	if(a.name.value.trim()==""){
		alert('Please enter name');
		a.name.focus();
		a.name.value='';
		return false;
	}
	if(a.email.value.trim()==""){
		alert('Please enter email');
		a.email.focus();
		a.email.value='';
		return false;
	}
	
	var telInput = $("#cell_phone");
	$("#phone").val(telInput.intlTelInput("getNumber"));
	if(a.phone.value.trim()=="") {
		alert('Please enter phone number');
		return false;
	}
	if(!telInput.intlTelInput("isValidNumber")) {
		alert('Please enter valid phone number');
		return false;
	}
	
	if(a.password.value.trim()!=""){
		var regex = /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?!.*\s).{8,}$/;
        var password = a.password.value.trim();
        if(!regex.test(password)) {
            alert("Password must have at least one number and one albhabet and one special char, and at least 8 or more characters.");
			return false;
        }
		if(a.rpassword.value.trim()==""){
			alert('Please retype password.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}
		if(a.password.value.trim()!=a.rpassword.value.trim()){
			alert('Password and Retype password not matched.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}
	}
}
</script>

<div id="wrapper">
    <header id="header" class="container">
        <?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><span class="icon-user"></span> My Account</h2></header>
                <section>
					<?php include('confirm_message.php'); ?>
                    <div class="row-fluid">
                        <div class="span6">
                            <h4>Edit Profile</h4>
                            <form action="controllers/admin_user/profile.php" role="form" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);">
                                <fieldset>
									<div class="control-group">
                                        <label class="control-label" for="company_name">Company Name *</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="company_name" value="<?=$get_userdata_row['company_name']?>" name="company_name">
                                        </div>
                                    </div>
									
                                    <div class="control-group">
                                        <label class="control-label" for="name">Name *</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="name" value="<?=$get_userdata_row['name']?>" name="name">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="email">Email *</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="email" value="<?=$get_userdata_row['email']?>" name="email">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="cell_phone">Phone *</label>
                                        <div class="controls">
											<input type="tel" id="cell_phone" name="cell_phone" class="input-xlarge" placeholder="">
											<input type="hidden" name="phone" id="phone" />
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="country">Country</label>
                                        <div class="controls">
											<select name="country" id="country">
												<option value=""> - Country - </option>
												<?php
												foreach($countries_list as $c_k => $c_v) { ?>
													<option value="<?=$c_v?>" <?php if($get_userdata_row['country'] == $c_v){echo 'selected="selected"';}?>><?=$c_v?></option>
												<?php
												} ?>
											</select>
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="state">State</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="state" value="<?=$get_userdata_row['state']?>" name="state">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="city">City</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="city" value="<?=$get_userdata_row['city']?>" name="city">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="zip_code">Zip Code</label>
                                        <div class="controls">
											<input type="text" class="input-xlarge" id="zip_code" value="<?=$get_userdata_row['zip_code']?>" name="zip_code">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="password">Change Password</label>
                                        <div class="controls">
											<input type="password" class="input-xlarge" id="password" name="password">
                                        </div>
                                    </div>
									
									<div class="control-group">
                                        <label class="control-label" for="rpassword">Retype Password</label>
                                        <div class="controls">
											<input type="password" class="input-xlarge" id="rpassword" name="rpassword">
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?=$get_userdata_row['id']?>" />
         							<input type="hidden" name="old_password" value="<?=$get_userdata_row['password']?>" />
									 
                                    <div class="form-actions">
                                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="update">Update</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>

<script src="../js/intlTelInput.js"></script>
<script>
var telInput = $("#cell_phone"),errorMsg = $("#error-msg"),validMsg = $("#valid-msg");
telInput.intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
	$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
	  var countryCode = (resp && resp.country) ? resp.country : "";
	  callback(countryCode);
	});
  },
  utilsScript: "../js/intlTelInput-utils.js" //just for formatting/placeholders etc
});

var reset = function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
};

// on blur: validate
telInput.blur(function() {
  reset();
  if ($.trim(telInput.val())) {
	if(telInput.intlTelInput("isValidNumber")) {
	  validMsg.removeClass("hide");
	} else {
	  telInput.addClass("error");
	  errorMsg.removeClass("hide");
	}
  }
});

// on keyup / change flag: reset
telInput.on("keyup change", reset);

$("#cell_phone").intlTelInput("setNumber", "<?=($get_userdata_row['phone']?'+'.$get_userdata_row['phone']:'')?>");

</script>