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

.breadcrums {
    color: gray;
    padding-top: 50px;
}

.breadcrums span {
    font-size: 15px;
    cursor: pointer;
}

.banner {
    padding: 30px 0;
}

.inersection {
    padding: 50px 0;
    padding-left: 50px;
    background: #f7f7f7;
    border-radius: 20px;
    box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
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
    width: 26%;
}

.imgbox .count {
    font-size: 15px;
    color: #ffffff;
    background: #42c8b7;
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
    width: 14%;
}

.whybox .info {
    margin-left: 20px;
}

.whybox .info h2 {
    font-size: 20px;
    font-weight: bold;
}

.whybox .info p {
    margin-top: -23px;
    font-weight: bolder;
    font-size: 16px;
}

.model {
    width: 165px;
    height: 170px;
    background: #ffffff;
    box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    border-radius: 10px;
    margin: 20px 0px;
    padding: 10px;
    padding-top: 35px !important;
    text-align: center;
    cursor: pointer;
}

.model img {
    width: 75%;
    object-fit: cover;
    margin-bottom: 10px;
}

.model-logo {
    position: relative;
    width: 180px;
    height: 120px;
    background: #ffffff;
    box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
    border-radius: 10px;
    margin: 20px 0px;
    cursor: pointer;
}

.model-logo img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    object-fit: cover;
    width: 50%;
}

.model-service {
    width: 170px;
    height: 190px;
    background: #ffffff;
    box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    border-radius: 10px;
    margin: 20px 0px;
    padding: 10px;
    padding-top: 20px !important;
    text-align: center;
    cursor: pointer;
}

.model-service img {
    width: 65%;
    padding-bottom: 10px;
}

.model-service h5 {
    font-weight: normal;
}

#slider-text {
    padding-top: 40px;
    display: block;
}

#slider-text .col-md-6 {
    overflow: hidden;
}

#slider-text h2 {
    font-family: 'Josefin Sans', sans-serif;
    font-weight: 400;
    font-size: 30px;
    letter-spacing: 3px;
    margin: 30px auto;
    padding-left: 40px;
}

#slider-text h2::after {
    border-top: 2px solid #c7c7c7;
    content: "";
    position: absolute;
    bottom: 35px;
    width: 100%;
}

#itemslider h4 {
    font-family: 'Josefin Sans', sans-serif;
    font-weight: 400;
    font-size: 12px;
    margin: 10px auto 3px;
}

#itemslider h5 {
    font-family: 'Josefin Sans', sans-serif;
    font-weight: bold;
    font-size: 12px;
    margin: 3px auto 2px;
}

#itemslider h6 {
    font-family: 'Josefin Sans', sans-serif;
    font-weight: 300;
    ;
    font-size: 10px;
    margin: 2px auto 5px;
}

@media screen and (max-width: 992px) {
    .slider-control img {
        padding-top: 70px;
        margin: 0 auto;
    }
}

.carousel-showmanymoveone .carousel-control.left {
    margin-left: 5px;
    background: #ffffff;
    border-radius: 50px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    height: 50px;
    width: 50px;
    margin-top: 55px;
    margin-left: -40px !important;
}

.carousel-showmanymoveone .carousel-control.right {
    margin-left: 5px;
    background: #ffffff;
    border-radius: 50px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    height: 50px;
    width: 50px;
    margin-top: 55px;
    margin-right: -30px !important;
}

.services-model {
    padding-top: 30px;
}

.services-model .carousel-showmanymoveone .carousel-control.left {
    margin-left: 5px;
    background: #ffffff;
    border-radius: 50px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    height: 50px;
    width: 50px;
    margin-top: 85px;
    margin-right: -60px !important;
}

.services-model .carousel-showmanymoveone .carousel-control.right {
    margin-left: 5px;
    background: #ffffff;
    border-radius: 50px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    height: 50px;
    width: 50px;
    margin-top: 85px;
    margin-right: -50px !important;
}

.carousel-showmanymoveone .carousel-control {
    width: 4%;
    background-image: none;
}

.carousel-showmanymoveone .carousel-control.left {
    margin-left: 5px;
}

.carousel-showmanymoveone .carousel-control.right {
    margin-right: 5px;
}

.carousel-showmanymoveone .cloneditem-1,
.carousel-showmanymoveone .cloneditem-2,
.carousel-showmanymoveone .cloneditem-3,
.carousel-showmanymoveone .cloneditem-4,
.carousel-showmanymoveone .cloneditem-5 {
    display: none;
}

@media all and (min-width: 768px) {

    .carousel-showmanymoveone .carousel-inner>.active.left,
    .carousel-showmanymoveone .carousel-inner>.prev {
        left: -50%;
    }

    .carousel-showmanymoveone .carousel-inner>.active.right,
    .carousel-showmanymoveone .carousel-inner>.next {
        left: 50%;
    }

    .carousel-showmanymoveone .carousel-inner>.left,
    .carousel-showmanymoveone .carousel-inner>.prev.right,
    .carousel-showmanymoveone .carousel-inner>.active {
        left: 0;
    }

    .carousel-showmanymoveone .carousel-inner .cloneditem-1 {
        display: block;
    }
}

@media all and (min-width: 768px) and (transform-3d),
all and (min-width: 768px) and (-webkit-transform-3d) {

    .carousel-showmanymoveone .carousel-inner>.item.active.right,
    .carousel-showmanymoveone .carousel-inner>.item.next {
        -webkit-transform: translate3d(50%, 0, 0);
        transform: translate3d(50%, 0, 0);
        left: 0;
    }

    .carousel-showmanymoveone .carousel-inner>.item.active.left,
    .carousel-showmanymoveone .carousel-inner>.item.prev {
        -webkit-transform: translate3d(-50%, 0, 0);
        transform: translate3d(-50%, 0, 0);
        left: 0;
    }

    .carousel-showmanymoveone .carousel-inner>.item.left,
    .carousel-showmanymoveone .carousel-inner>.item.prev.right,
    .carousel-showmanymoveone .carousel-inner>.item.active {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        left: 0;
    }
}

@media all and (min-width: 992px) {

    .carousel-showmanymoveone .carousel-inner>.active.left,
    .carousel-showmanymoveone .carousel-inner>.prev {
        left: -16.666%;
    }

    .carousel-showmanymoveone .carousel-inner>.active.right,
    .carousel-showmanymoveone .carousel-inner>.next {
        left: 16.666%;
    }

    .carousel-showmanymoveone .carousel-inner>.left,
    .carousel-showmanymoveone .carousel-inner>.prev.right,
    .carousel-showmanymoveone .carousel-inner>.active {
        left: 0;
    }

    .carousel-showmanymoveone .carousel-inner .cloneditem-2,
    .carousel-showmanymoveone .carousel-inner .cloneditem-3,
    .carousel-showmanymoveone .carousel-inner .cloneditem-4,
    .carousel-showmanymoveone .carousel-inner .cloneditem-5,
    .carousel-showmanymoveone .carousel-inner .cloneditem-6 {
        display: block;
    }
}

@media all and (min-width: 992px) and (transform-3d),
all and (min-width: 992px) and (-webkit-transform-3d) {

    .carousel-showmanymoveone .carousel-inner>.item.active.right,
    .carousel-showmanymoveone .carousel-inner>.item.next {
        -webkit-transform: translate3d(16.666%, 0, 0);
        transform: translate3d(16.666%, 0, 0);
        left: 0;
    }

    .carousel-showmanymoveone .carousel-inner>.item.active.left,
    .carousel-showmanymoveone .carousel-inner>.item.prev {
        -webkit-transform: translate3d(-16.666%, 0, 0);
        transform: translate3d(-16.666%, 0, 0);
        left: 0;
    }

    .carousel-showmanymoveone .carousel-inner>.item.left,
    .carousel-showmanymoveone .carousel-inner>.item.prev.right,
    .carousel-showmanymoveone .carousel-inner>.item.active {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        left: 0;
    }
}

.accordion {
    width: 90%;
    max-width: 100%;
    margin: 0rem auto;
}

.accordion-item {
    background-color: #fff;
    color: #111;
    margin: 1.8rem 0;
    border-radius: 0.5rem;
    /* box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; */
}

.accordion-item-header {
    padding: 0.5rem 3rem 0.5rem 1rem;
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
    font-size: 2rem;
    position: absolute;
    right: 1rem;
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
    line-height: 2rem;
    border-top: 1px solid;
    border-image: linear-gradient(to right, transparent, #34495e, transparent) 1;
    font-size: 14px;
}

.faq-sec {
    padding-top: 30px;
}

.vidbox {
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    padding-bottom: 15px;
    border-radius: 10px;
}

.vidbox h2 {
    padding-top: 15px;
    font-size: 16px;
    font-weight: bold;
}

.vidbox p {
    margin-top: -15px;
    font-size: 13px;
}

.app {
    background: #42c8b7;
    border-radius: 15px;
    padding: 50px 40px 0 40px;
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
    .topbar img {
        width: 100% !important;
    }

    .topbar {
        padding: 0 25px !important;
    }

    .topbar button {
        font-size: 18px;
    }

    .breadcrums {
        padding: 0 30px !important;
    }

    .banner {
        padding: 30px 30px;
        text-align: center;
    }

    .inersection {
        padding-left: 0px;
    }

    .inersection span {
        font-size: 1.3rem;
    }

    .inersection p::before {
        left: 40px;
        width: 40px;
    }

    .inersection p::after {
        left: 245px;
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
        padding: 20px 10px;
        margin: 0 3px;
        font-size: 13px;
    }

    .main-img {
        margin-top: 60px;
        width: 85%;
    }

    .carousel-inner {
        padding-left: 50px;
    }

    .carousel-second2 .carousel-inner {
        padding-left: 100px;
    }

    .carousel-third3 .carousel-inner {
        padding-left: 100px;
    }

    .mobilesmodelbox .carousel-showmanymoveone .carousel-control.left {
        margin-left: 40px !important;
        margin-top: 80px;
    }

    .mobilesmodelbox .carousel-showmanymoveone .carousel-control.right {
        margin-right: 0px !important;
        margin-top: 80px;
    }

    .brandsmodel .carousel-showmanymoveone .carousel-control.left {
        margin-top: 55px !important;
        margin-left: 20px !important;
    }

    .brandsmodel .carousel-showmanymoveone .carousel-control.right {
        margin-top: 55px !important;
        margin-right: 0px !important;
    }

    .services-model .carousel-showmanymoveone .carousel-control.left {
        margin-top: 70px !important;
        margin-left: 20px !important;
    }

    .services-model .carousel-showmanymoveone .carousel-control.right {
        margin-right: 0px !important;
        margin-top: 80px;
    }

    .imgbox .count {
        width: 30px;
        height: 40px;
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
        width: 20%;
    }

    .allbox {
        padding: 0px;
    }

    .mobilesmodelbox .carousel-inner {
        padding-left: 110px !important;
    }

    .models {
        text-align: center !important;
    }

    .models h2 {
        font-size: 20px;
    }

    .modelbox {
        padding: 0 30px;
    }

    .whybox {
        margin: 20px 0;
    }

    .why-us .col-md-4 {
        width: 50%;
    }

    .faq-sec {
        padding: 0px !important;
    }

    .faq-sec h2 {
        text-align: center;
    }

    .accordion-item-header {
        line-height: 3.4rem;
    }

    .videomodels {
        padding: 20px !important;
    }

    .videomodels .row {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .vidbox {
        margin: 20px 0;
    }

    .vidbox h2,
    p {
        padding: 0 20px;
    }

    .applog img {
        width: 30%;
        cursor: pointer;
    }

    .appimg {
        margin-top: 50px;
    }
}
</style>
<div class="container breadcrums">
    <span>Home > </span>
    <span>Repair > </span>
    <span style="color:#333333;">Mobile</span>
</div>
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
                    <span class="fa fa-search"></span>
                    <input placeholder="Search Your Mobile Phone to Repair">
                </div>
                <p>Or choose a brand</p>
                <div class="choosbrands">
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/2e7cdc22-5a5f.jpg" alt=""></a>
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/cb96df6e-080f.jpg" alt=""></a>
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/406a512d-e8dd.jpg" alt=""></a>
                    <a href="#"><img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/20922c34-8afc.jpg" alt=""></a>
                    <a href="#" style="background:#f7f7f7;box-shadow: none;color:black;">More Brands</a>
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
                        <img src="https://s3n.beta.cashify.in/estore/acfe0a0b2bf84d62855a7ede5492b05c.png" class="mb-4"
                            alt="">
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
                        <img src="https://s3n.beta.cashify.in/estore/6c3a45cf00a8427e8bb48598d7e40493.png" class="mb-4"
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
                        <img src="https://s3n.beta.cashify.in/estore/6f46f6c953a74203bb330f736af57934.png" class="mb-4"
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
<div class="why-us p-5" style="background: #d9f4f1;">
    <div class="container allbox">
        <h2>Why us</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="whybox">
                    <img src="https://s3n.cashify.in/estore/99953fd419e2416ba7dc25e0164372c3.png" alt="">
                    <div class="info">
                        <h2>Premium Repair</h2>
                        <p>Top quality certified parts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="https://s3n.cashify.in/estore/acef68f939a84a8884640ae56f70867f.png" alt=""
                        style="margin-top: -40px;">
                    <div class="info">
                        <h2>Instant Mobile Repair</h2>
                        <p>Mobile Repair on the Spot in Cashify Store or at Home</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="https://s3n.cashify.in/estore/7989ad6b9431414481a1e9dcda098d45.png" alt=""
                        style="margin-top: -50px;">
                    <div class="info">
                        <h2>Physical Protection Warranty</h2>
                        <p>Free 1 Month Screen Replacement even if it breaks for all Screen Repair</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="https://s3n.cashify.in/estore/3c0a0e2e0f4945c09e941a10bcf66e83.png" alt="">
                    <div class="info">
                        <h2>6 Months Warranty</h2>
                        <p>Hassle free 6 month warranty on parts replaced</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="https://s3n.cashify.in/estore/09bf461127cd48acb409f207e1664438.png" alt="">
                    <div class="info">
                        <h2>Skilled Technicians</h2>
                        <p>Trained & Qualified Professionals</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="whybox">
                    <img src="https://s3n.beta.cashify.in/estore/a6185f79e61d4780bdd296d8ae3058a8.png" alt="">
                    <div class="info">
                        <h2>Guaranteed Safety</h2>
                        <p>Total Device & Data Security</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="models">
    <div class="container mobilesmodelbox" style="padding-top: 50px;">
        <h2>Top Repaired Models</h2>
        <!-- Item slider-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="carousel carousel-showmanymoveone slide carousel-first1" id="itemslider1">
                    <div class="carousel-inner">

                        <div class="item active">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-5x9nivcp-gnnb.png"
                                        alt="">
                                    <h5>Xiaomi Redmi Note 4</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-vlw1k1nh-cprj.png"
                                        alt="">
                                    <h5>Xiaomi Redmi Note 3</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-qp4ba4sq-aeny.png"
                                        alt="">
                                    <h5>Apple iPhone 6</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-t1iiuj3j-byma.png"
                                        alt="">
                                    <h5>Xiaomi Redmi 4</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-4wk6vj50-xzmd.png"
                                        alt="">
                                    <h5>Xiaomi Redmi Note 5 Pro</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-jwihkccb-gqpj.png"
                                        alt="">
                                    <h5>Apple iPhone 7</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-oh9xlwt8-yunr.png"
                                        alt="">
                                    <h5>Apple iPhone 6S</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-4wk6vj50-xzmd.png"
                                        alt="">
                                    <h5>Xiaomi Redmi 5A</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-mbiibold-kwza.png"
                                        alt="">
                                    <h5>Xiaomi Redmi 4A</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-6vukhanm-ci0i.png"
                                        alt="">
                                    <h5>Apple iPhone 5s</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model">
                                    <img src="https://s3n.cashify.in/cashify/product/img/xhdpi/csh-oh9xlwt8-yunr.png"
                                        alt="">
                                    <h5>Apple iPhone 6S</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="slider-control">
                        <a class="left carousel-control" href="#itemslider1" data-slide="prev"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" class="w-10 h-10 text-primary">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                        <a class="right carousel-control" href="#itemslider1" data-slide="next"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" class="w-10 h-10 text-primary">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="models">
    <div class="container modelbox brandsmodel">
        <h2 style="padding-top: 50px;">Top Repaired Brands</h2>
        <!-- Item slider-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="carousel carousel-showmanymoveone carousel-second2 slide" id="itemslider2">
                    <div class="carousel-inner">

                        <div class="item active">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/2e7cdc22-5a5f.jpg" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/cb96df6e-080f.jpg" alt="">

                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/406a512d-e8dd.jpg" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/20922c34-8afc.jpg" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/dfb6c340-010f.jpg" alt="">
                                    <h5>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/ac5c9a7b-76b5.jpg" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/0124cc45-3a6c.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/1dcd7fda-0141.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/fef4e5ae-6507.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/cfeaabff-69bf.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/bf25222a-a2a7.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/dacc50a2-77a9.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/3e072dc2-6d7b.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/5558a532-fcaa.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/e1b13cbc-ef06.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-logo">
                                    <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/06bc74db-4d38.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="slider-control">
                        <a class="left carousel-control" href="#itemslider2" data-slide="prev"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" class="w-10 h-10 text-primary">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                        <a class="right carousel-control" href="#itemslider2" data-slide="next"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" class="w-10 h-10 text-primary">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>






    </div>
</div>
<div class="models services-model">
    <div class="container modelbox">
        <h2>Services Available</h2>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="carousel carousel-showmanymoveone slide carousel-third3" id="itemslider3">
                    <div class="carousel-inner">

                        <div class="item active itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/2f89d20589af40b7b3ae79aa63930023.png"
                                        alt="">
                                    <h5>SCREEN</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/84a08366329341c88937615d5e01dee1.png"
                                        alt="">
                                    <h5>BATTERY</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/cf48e143753742ae9660efbfc8f81536.png"
                                        alt="">
                                    <h5>MIC</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/63cd8d65ae1d49c4a88164d3093be808.png"
                                        alt="">
                                    <h5>RECEIVER</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/40bf0f5f97b4442f992395d7a8609c57.png"
                                        alt="">
                                    <h5>CHARGING JACK</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/4df66e98a0aa466f8ea851b84cfd0c80.png"
                                        alt="">
                                    <h5>SPEAKER</h5>
                                </div>
                            </div>
                        </div>

                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/c1c8fb2be4f84fba8461e015e8f8c783.png"
                                        alt="">
                                    <h5>BACK PANEL</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">


                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/7559fa7b283246a1868322f229328929.png"
                                        alt="">
                                    <h5>PROXIMITY SENSOR</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">

                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/855a0fdc1e884399aa4fe2b7b7bec2ef.png"
                                        alt="">
                                    <h5>AUX JACK</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/f9f0faead4c9486189e7fc5211cefc65.png"
                                        alt="">
                                    <h5>FRONT CAMERA</h5>
                                </div>
                            </div>
                        </div>
                        <div class="item  itm3">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <div class="model-service">
                                    <img src="https://s3n.cashify.in/estore/f9f0faead4c9486189e7fc5211cefc65.png"
                                        alt="">
                                    <h5>BACK CAMERA</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="slider-control">
                        <a class="left carousel-control" href="#itemslider3" data-slide="prev"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" class="w-10 h-10 text-primary">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                        <a class="right carousel-control" href="#itemslider3" data-slide="next"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true" class="w-10 h-10 text-primary">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
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
<div class="container models videomodels p-5">
    <h2>Videos</h2>
    <div class="modelbox videomodels">
        <div class="row pl-4 pr-5">
            <div class="col-md-4">
                <div class="vidbox text-center">
                    <div class="video">
                        <iframe width="100%" src="https://www.youtube.com/watch?v=7_IjOZsinWA"></iframe>
                    </div>
                    <h2>How to Change iPhone 7 Battery at Home</h2>
                    <p>Choose Cashify repair services and get your phones battery delivered at your doorstep</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="vidbox text-center">
                    <div class="video">
                        <iframe width="100%" src="https://www.youtube.com/watch?v=7_IjOZsinWA"></iframe>
                    </div>
                    <h2>How to change redmi battery at home</h2>
                    <p>Choose Cashify repair services and get your phones battery delivered at your doorstep</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="vidbox text-center">
                    <div class="video">
                        <iframe width="100%" src="https://www.youtube.com/watch?v=7_IjOZsinWA"></iframe>
                    </div>
                    <h2>How to change one plus 5 battery at home?</h2>
                    <p>Choose Cashify repair services and get your phones battery delivered at your doorstep</p>
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
$(document).ready(function() {

    $('#itemslider1').carousel({
        interval: 3000
    });
    $('.carousel-first1 .item').each(function() {
        var itemToClone = $(this);

        for (var i = 1; i < 6; i++) {
            itemToClone = itemToClone.next();

            if (!itemToClone.length) {
                itemToClone = $(this).siblings(':first');
            }

            itemToClone.children(':first-child').clone()
                .addClass("cloneditem-" + (i))
                .appendTo($(this));
        }
    });
    $('#itemslider2').carousel({
        interval: 3000
    });
    $('.carousel-second2 .item').each(function() {
        var itemToClone = $(this);

        for (var i = 1; i < 6; i++) {
            itemToClone = itemToClone.next();

            if (!itemToClone.length) {
                itemToClone = $(this).siblings(':first');
            }

            itemToClone.children(':first-child').clone()
                .addClass("cloneditem-" + (i))
                .appendTo($(this));
        }
    });
    // });
    // $(document).ready(function(){

    $('#itemslider3').carousel({
        interval: 3000
    });

    $('.carousel-third3 .itm3').each(function() {
        var itemToClone = $(this);

        for (var i = 1; i < 6; i++) {
            itemToClone = itemToClone.next();

            if (!itemToClone.length) {
                itemToClone = $(this).siblings(':first');
            }

            itemToClone.children(':first-child').clone()
                .addClass("cloneditem-" + (i))
                .appendTo($(this));
        }
    });
});
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