<link rel="stylesheet" href="<?=SITE_URL?>css/home-testimonials.css" type="text/css" />
<style>
h1,
h2,
h3,
h4,
h5,
h6 {
    color: #000000;
}

.banner {
    padding: 30px 0;
    padding-top: 150px;
}

.inersection {
    padding: 50px 0;
    padding-left: 50px;
    background: #ffe9f7;
    border-radius: 20px;
    box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
}

.main-img {
    width: 90%;
}

.inersection h1 {
    font-size: 3.6rem;
    color: black;
    font-weight: 700;
}

.search {
    position: relative;
    color: #aaa;
    font-size: 16px;
}

.search {
    display: inline-block;
    position: relative;
}
.search-btn{
    position: absolute;
    right: 10px;
    top: 30%;
    background: #ff148b;
    color: #ffffff;
    border: none;
    outline: none;
    padding: 13px 30px;
    border-radius:5px;
}
.search input {
    width: 500px;
    height: 8vh;
    background: #ffffff;
    border: 1px solid #aaa;
    border-radius: 10px;
    margin: 30px 0;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    border: none;
    outline: none;
}

.search input {
    text-indent: 32px;
}

.search .fa-search {
    position: absolute;
    top: 10px;
    left: 10px;
}

.search .fa-search {
    left: auto;
    right: 10px;
}

.inersection span {
    font-size: 1.6rem;
    font-weight: bold;
    margin: 0 20px;
}

.choosbrands {
    padding-top: 10px;
}

.inersection p {
    color: #333333;
    padding: 0 40px;
    font-weight: 600;
    position: relative;
    font-size: 18px;
}

.inersection p::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 10px;
    width: 20px;
    height: 1px;
    background: #333333;
}

.inersection p::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 193px;
    width: 25px;
    height: 1px;
    background: #333333;
}

.choosbrands a {
    padding: 30px 10px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden !important;
    position: relative;
    margin: 0 5px;
    font-size: 18px;
}

.choosbrands a img {
    width: 11%;
    object-fit: cover;
}

.imgbox {
    margin: 0 20px;
}

.boximg {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 30px;
}

.boximg img {
    margin-top: 50px;
    width: 36%;
}

.imgbox .count {
    font-size: 15px;
    color: #ffffff;
    background: #ff148b;
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50px;
}

.headcount {
    display: flex;
    align-items: center;
}

.imgbox p {
    font-size: 1.7rem;
    font-weight: bold;
    color: gray;
}

.imgbox h2 {
    color: #333333;
    font-size: 2.25rem;
    padding-left: 30px !important;
}

.allbox {
    padding: 0;
    color: #000000;
}

.allbox p {
    color: #777777 !important;
}

.whybox {
    display: flex;
    align-items: center;
}

.whybox img {
    width: 20% !important;
}

.whybox .info {
    margin-left: 20px;
    text-align: left !important;
}

.whybox .info h2 {
    font-size: 20px;
    font-weight: bold;
    color: #ffffff;
}

.whybox .info p {
    margin-top: -23px;
    font-weight: bolder !important;
    font-size: 17px !important;
    padding: 0;
}

.accordion {
    width: 90%;
    max-width: 100%;
    margin: 0rem auto;
}

.accordion-item {
    background-color: #fff;
    color: #111;
    margin: 2.8rem 0;
    border-radius: 0.5rem;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}

.accordion-item-header {
    padding: 0 20px;
    min-height: 7.5rem;
    line-height: 1.25rem;
    font-weight: bold;
    display: flex;
    align-items: center;
    position: relative;
    cursor: pointer;
    font-size: 18px;
    border-bottom: 1px solid #e6e6e6;
}

.accordion-item-header::after {
    content: "\002B";
    font-size: 2.5rem;
    position: absolute;
    right: 4rem;
}

.accordion-item-header.active::after {
    content: "\2212";
}

.accordion-item-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}

.accordion-item-body-content {
    padding: 1rem;
    line-height: 2.5rem;
    border-top: 1px solid;
    border-image: linear-gradient(to right, transparent, #34495e, transparent) 1;
    font-size: 16px;
}

.faq-sec {
    padding: 100px 0;
}

.app {
    background:#ff148b;
    border-radius: 15px;
    padding: 50px 40px 0 40px;
    margin: 0 40px;
}

.app h2 {
    font-size: 40px;
}

.app p {
    font-size: 18px;
    margin-top: -20px;
}

.applog img {
    width: 17%;
    margin: 0 10px;
    cursor: pointer;
}


@media screen and (max-width: 600px) {
    body{
        overflow-x: hidden;
    }
    .topbar img {
        width:30%;
    }
    .menu-opne{
        width: 10% !important;
        margin-right: 45px;
        cursor: pointer;
        display: block;
    }
    .topbar {
        padding: 0!important;
    }

    .topbar button {
        font-size: 15px;
    }
    .search-btn {
        display: none !important;
    }
    .breadcrums {
        padding: 0 30px !important;
        padding-top: 25px !important;
    }

    .banner {
        padding: 30px 10px;
        text-align: center;
    }

    .inersection {
        padding-left: 0px;
        border-radius: 2px !important;
        box-shadow: none !important;
    }

    .inersection span {
        display: none;
    }

    .inersection p::before {
        left: 60px;
        width: 40px;
    }

    .inersection p::after {
        left: 260px;
        width: 42px;
    }

    .search input {
        width: 320px;
        height: 9vh;
    }

    .inersection h1 {
        font-size: 2rem;
    }

    .choosbrands a {
        padding: 30px 20px;
        margin: 0 3px;
        font-size: 15px;
    }

    .more-btn {
        line-height: 9 !important;
        border-radius: 50px !important;
        border: 1px solid #ff148b;
        padding: 10px 20px !important;
    }

    .main-img {
        margin-top: 60px;
        width: 85%;
    }

    .why-us .row {
        margin-left: -50px !important;
    }

    .whybox {
        flex-direction: column !important;
    }
    .imgbox .count {
        width: 30px;
        height: 40px;
    }

    .mobiwhy {
        margin-top: 0 !important;
    }

    .whybox .info h2 {
        font-size: 17px;
    }

    .whybox .info p {
        margin-top: -23px;
        font-weight: bolder;
        font-size: 13px;
    }

    .whybox img {
        width: 35% !important;
        margin-left: -70px;
    }

    .allbox {
        padding: 0px;
    }

    .whybox {
        margin: 20px 0;
    }

    .why-us .col-md-4 {
        width: 50%;
    }

    .faq-sec {
        padding: 50px 0 !important;
    }

    .faq-sec h2 {
        text-align: center;
    }

    .accordion-item-header {
        line-height: 3.4rem;
    }

    .applog img {
        width: 30%;
        cursor: pointer;
    }

    .appimg {
        margin-top: 50px;
    }
    .footer-logo{
        width: 50% !important;
        padding-top: 50px;
    }
}
</style>
<div class="banner">
    <div class="container inersection">
        <div class="row">
            <div class="col-md-6">
                <h1>Repair your phone at doorstep</h1>
                <span><i class="fa-solid fa-check"></i> Trained Professionals</span>
                <span><i class="fa-solid fa-check"></i> Doorstep Service</span>
                <span><i class="fa-solid fa-check"></i> 6 months warranty</span>
                <br>
                <div class="search">
                    <input placeholder="Search Your Mobile Phone to Repair">
                    <button type="button" class="search-btn">SEARCH</button>
                </div>
                <p>Or choose a brand</p>
                <div class="choosbrands">
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/2e7cdc22-5a5f.jpg" alt=""></a>
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/cb96df6e-080f.jpg" alt=""></a>
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/406a512d-e8dd.jpg" alt=""></a>
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/20922c34-8afc.jpg" alt=""></a>
                    <a href="#" class="more-btn" style="background:#ffe9f7;box-shadow: none;color:black;">More
                        Brands</a>
                </div>
            </div>
            <div class="col-md-6" style="display:flex;justify-content:center;align-items:center;">
                <img src="https://s3n.beta.cashify.in/estore/ea5b0a8d4c664a39be0ffb040c7b7e35.png" class="main-img"
                    alt="">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="imgbox">
                    <div class="boximg">
                        <img src="images/icon.png" class="mb-4" alt="">
                    </div>
                    <div class="headcount">
                        <p class="count">1</p>
                        <h2> Check Price</h2>
                    </div>
                    <p>Select your device that needs to be repaired. Get best Pricing.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="imgbox">
                    <div class="boximg">
                        <img src="images/icon-2.png" class="mb-4"
                            alt="">
                    </div>
                    <div class="headcount">
                        <p class="count">2</p>
                        <h2> Schedule Service</h2>
                    </div>
                    <p>Book a free technician visit at your home or work at a time slot that best suits your
                        convenience.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="imgbox">
                    <div class="boximg">
                        <img src="images/icon-1.png" class="mb-4"
                            alt="">
                    </div>
                    <div class="headcount">
                        <p class="count">3</p>
                        <h2> Get Device Repaired</h2>
                    </div>
                    <p>Our super-skilled technician will be there and make it as good as new.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="why-us p-5" style="background: #290a38;">
    <div class="container allbox">
        <h2 class="text-white">Why us</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="whybox">
                    <img src="images/why.png" alt="">
                    <div class="info">
                        <h2>Premium Repair</h2>
                        <p>Top quality certified parts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="images/why1.png" class="mobiwhy" alt=""
                        style="margin-top: -40px;">
                    <div class="info">
                        <h2>Instant Mobile Repair</h2>
                        <p>Mobile Repair on the Spot in Cashify Store or at Home</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="images/why2.png" class="mobiwhy" alt=""
                        style="margin-top: -50px;">
                    <div class="info">
                        <h2>Physical Protection Warranty</h2>
                        <p>Free 1 Month Screen Replacement even if it breaks for all Screen Repair</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="images/why5.png" alt="">
                    <div class="info">
                        <h2>6 Months Warranty</h2>
                        <p>Hassle free 6 month warranty on parts replaced</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="images/why3.png" alt="">
                    <div class="info">
                        <h2>Skilled Technicians</h2>
                        <p>Trained & Qualified Professionals</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="images/why4.png" alt="">
                    <div class="info">
                        <h2>Guaranteed Safety</h2>
                        <p>Total Device & Data Security</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container faq-sec">
    <h2>FAQs</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-item-header">
                        What happens when I place an order?
                    </div>
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content">
                            Once the order is placed, our support team contacts you to confirm your availability for
                            the service & an executive is assigned for your order. The executive will reach your
                            location at a preferred time & repair your device.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-item-header">
                        How do I pay for my order?
                    </div>
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content">
                            Once the repair is completed by our technician, you can pay using the following methods:
                            Cash, Paytm, UPI or Credit/Debit Card.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-item-header">
                        How Will I Get An Invoice For The Service?
                    </div>
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content">
                            Once the repair order is completed, you will get an email with an invoice in the
                            attachment. The invoice will have the amount charged for the order and can be used later
                            to claim the warranty.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="app mb-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="text-white">Download the App</h2>
            <p class="text-white">Sell your old phone | Buy top-quality refurbished phones | Get your phone repaired
            </p>
            <div class="applog">
                <img src="https://s3n.beta.cashify.in/estore/94828f16c39b44cdbb06e4a7dc2e1463.png" alt="">
                <img src="https://s3n.beta.cashify.in/estore/71d86f3e31d3464eb6d1467ec3af9f94.png" alt="">
            </div>

        </div>
        <div class="col-md-4">
            <img src="https://s3n.cashify.in/cashify/web/images/landing/pngs/download-app.png" class="appimg" alt="">
        </div>
    </div>
</div>
<script>
(function($) {
    $(function() {
        var telInput = document.querySelector("#cell_phone");
        var itiTel = window.intlTelInput(telInput, {
            allowDropdown: false,
            initialCountry: "<?=$country_small_nm?>",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js"
        });

        $('#contact_form').bootstrapValidator({
            fields: {
                name: {
                    validators: {
                        stringLength: {
                            min: 1,
                        },
                        notEmpty: {
                            message: '<?=$validation_name_msg_text?>'
                        }
                    }
                },
                cell_phone: {
                    validators: {
                        callback: {
                            message: '<?=$validation_valid_phone_msg_text?>',
                            callback: function(value, validator, $field) {
                                if (itiTel.isValidNumber()) {
                                    var phone_number = itiTel.getNumber();
                                    $("#phone").val(phone_number);
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: '<?=$validation_email_msg_text?>'
                        },
                        emailAddress: {
                            message: '<?=$validation_valid_email_msg_text?>'
                        }
                    }
                },
                message: {
                    validators: {
                        notEmpty: {
                            message: '<?=$validation_message_msg_text?>'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });

        $('#instant_repair_cost_form').bootstrapValidator({
            fields: {
                quote_make: {
                    validators: {
                        stringLength: {
                            min: 1,
                        },
                        notEmpty: {
                            message: '<?=$validation_sel_make_msg_text?>'
                        }
                    }
                },
                quote_device: {
                    validators: {
                        stringLength: {
                            min: 1,
                        },
                        notEmpty: {
                            message: '<?=$validation_sel_device_msg_text?>'
                        }
                    }
                },
                quote_model: {
                    validators: {
                        stringLength: {
                            min: 1,
                        },
                        notEmpty: {
                            message: '<?=$validation_sel_model_msg_text?>'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            $('#instant_repair_cost_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });

    });
})(jQuery);

function getQuoteDevice(val) {
    var brand_id = val.trim();
    if (brand_id) {
        post_data = "brand_id=" + brand_id + "&token=<?=get_unique_id_on_load()?>";
        jQuery(document).ready(function($) {
            $.ajax({
                type: "POST",
                url: "ajax/get_quote_device.php",
                data: post_data,
                success: function(data) {
                    if (data != "") {
                        console.log(data);
                        $('#quote_device').html(data);
                        //$('.add-quote-device').selectpicker('refresh');

                        $('#quote_model').html('<option value="">Please Choose</option>');
                        //$('.add-quote-model').selectpicker('refresh');
                    } else {
                        alert('<?=$validation_something_went_wrong_msg_text?>');
                        return false;
                    }
                }
            });
        });
    }
}

function getQuoteModel(val) {
    var device_id = val.trim();
    if (device_id) {
        <?php

		if($home_instant_repair_quote == "b_d_m") {
			echo 'var brand_id = jQuery("#quote_make").val().trim();';
		} else {
			echo 'var brand_id = 0;';
		} ?>
        post_data = "device_id=" + device_id + "&brand_id=" + brand_id + "&token=<?=get_unique_id_on_load()?>";
        jQuery(document).ready(function($) {
            $.ajax({
                type: "POST",
                url: "ajax/get_quote_model.php",
                data: post_data,
                success: function(data) {
                    if (data != "") {
                        console.log(data);
                        $('#quote_model').html(data);
                        //$('.add-quote-model').selectpicker('refresh');
                    } else {
                        alert('<?=$validation_something_went_wrong_msg_text?>');
                        return false;
                    }
                }
            });
        });
    }
}

function getWhatWrongDevice(val) {
    var brand_id = val.trim();
    if (brand_id) {
        post_data = "brand_id=" + brand_id + "&token=<?=get_unique_id_on_load()?>";
        jQuery(document).ready(function($) {
            $.ajax({
                type: "POST",
                url: "ajax/get_quote_device.php",
                data: post_data,
                success: function(data) {
                    if (data != "") {
                        $('#quote_device2').html(data);
                        //$('.add-quote-device2').selectpicker('refresh');

                        $('#quote_model2').html('<option value="">Please Choose</option>');
                        //$('.add-quote-model2').selectpicker('refresh');
                    } else {
                        alert('<?=$validation_something_went_wrong_msg_text?>');
                        return false;
                    }
                }
            });
        });
    }
}

function getWhatWrongModel(val) {
    var device_id = val.trim();
    if (device_id) {
        var brand_id = jQuery("#quote_make2").val().trim();
        post_data = "device_id=" + device_id + "&brand_id=" + brand_id + "&token=<?=get_unique_id_on_load()?>";
        jQuery(document).ready(function($) {
            $.ajax({
                type: "POST",
                url: "ajax/get_quote_model2.php",
                data: post_data,
                success: function(data) {
                    if (data != "") {
                        $('#quote_model2').html(data);
                        //$('.add-quote-model2').selectpicker('refresh');
                    } else {
                        alert('<?=$validation_something_went_wrong_msg_text?>');
                        return false;
                    }
                }
            });
        });
    }
}

function getModelDetails(val) {
    var model_id = val.trim();
    if (model_id) {
        post_data = "model_id=" + model_id + "&token=<?=get_unique_id_on_load()?>";
        jQuery(document).ready(function($) {
            $.ajax({
                type: "POST",
                url: "ajax/get_quote_model_details.php",
                data: post_data,
                success: function(data) {
                    if (data != "") {
                        $('#quote_model_details').html(data);
                        //$('.add-quote-model').selectpicker('refresh');
                    } else {
                        alert('<?=$validation_something_went_wrong_msg_text?>');
                        return false;
                    }
                }
            });
        });
    }
}
</script>

<script>
const accordionItemHeaders = document.querySelectorAll(
    ".accordion-item-header"
);

accordionItemHeaders.forEach((accordionItemHeader) => {
    accordionItemHeader.addEventListener("click", (event) => {
        // Uncomment in case you only want to allow for the display of only one collapsed item at a time!

        const currentlyActiveAccordionItemHeader = document.querySelector(
            ".accordion-item-header.active"
        );
        if (
            currentlyActiveAccordionItemHeader &&
            currentlyActiveAccordionItemHeader !== accordionItemHeader
        ) {
            currentlyActiveAccordionItemHeader.classList.toggle("active");
            currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
        }
        accordionItemHeader.classList.toggle("active");
        const accordionItemBody = accordionItemHeader.nextElementSibling;
        if (accordionItemHeader.classList.contains("active")) {
            accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
        } else {
            accordionItemBody.style.maxHeight = 0;
        }
    });
});
</script>