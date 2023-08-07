<link rel="stylesheet" href="<?=SITE_URL?>css/home-testimonials.css" type="text/css" />
<style>
.breadcrums {
    color: gray;
    font-weight: 600;
    padding: 0 30px;
    padding-top: 50px;
}

.breadcrums span {
    font-size: 17px;
}

.banner {
    padding: 30px 130px;
}

.inersection {
    padding: 90px 0;
    padding-left: 50px;
    background: #f7f7f7;
    border-radius: 20px;
    box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
}

.inersection h1 {
    font-size: 3.25rem;
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
    height: 10vh;
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
    font-size: 1.4rem;
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
    padding: 30px 20px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden !important;
    position: relative;
    margin: 0 5px;
    font-size: 18px;
}

.choosbrands a img {
    width: 8%;
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
    padding-top: 100px;
}

.imgbox .count {
    font-size: 18px;
    color: #ffffff;
    background: #42c8b7;
    width: 40px;
    height: 40px;
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
    font-size: 1.4rem;
    font-weight: bold;
    color: gray;
}

.imgbox h2 {
    color: #333333;
    font-size: 2.25rem;
    padding-left: 30px !important;
}

.allbox {
    padding: 0 140px;
}

.whybox {
    display: flex;
    align-items: center;
}

.whybox img {
    width: 12%;
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

.modelbox {
    padding: 0 100px;
}

.model {
    width: 150px;
    height: 150px;
    background: #ffffff;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    border-radius: 10px;
    margin: 20px 0px;
    padding: 10px;
    padding-top: 20px !important;
    text-align: center;
}

.model img {
    width: 50%;
    object-fit: cover;
    margin-bottom: 10px;
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
    margin-top: 55px;
    margin-left: -40px !important;
}

.carousel-showmanymoveone .carousel-control.right {
    margin-left: 5px;
    background: #ffffff;
    border-radius: 50px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    height: 50px;
    margin-top: 55px;
    margin-right: -30px !important;
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
    margin: 2rem auto;
}

.accordion-item {
    background-color: #fff;
    color: #111;
    margin: 1.8rem 0;
    border-radius: 0.5rem;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
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
    font-size: 15px;
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

@media (max-width: 767px) {
    html {
        font-size: 14px;
    }
}
.vidbox{
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    padding-bottom: 15px;
    border-radius: 10px;
}
.vidbox h2{
    padding-top: 15px;
    font-size:16px;
    font-weight: bold;
}
.vidbox p{
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
    left: 52px;
    width: 40px;
}
.inersection p::after {
    left: 260px;
    width: 42px;
}
.search input {
    width: 320px;
    height:9vh;
}
.inersection h1 {
    font-size: 2rem;
}
.choosbrands a {
    padding: 20px 10px;
    margin: 0 3px;
    font-size: 13px;
}
.main-img{
    margin-top: 60px;
    width: 85%;
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
.mobilesmodelbox {
    padding-left: 80px !important;
}
.models h2{
    font-size: 20px;
}
.modelbox {
    padding: 0 30px;
}
.whybox {
    margin: 20px 0;
}
.why-us .col-md-4{
    width: 50%;
}
.faq-sec{
    padding: 0px !important;
}
.videomodels{
    padding: 0 !important;
}
.videomodels .row{
    padding-left: 0 !important;
    padding-right: 0 !important;
}
.vidbox{
    margin: 20px 0;
}
.applog img{
    width: 30%;
    cursor: pointer;
}
.appimg{
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
    <div class="inersection">
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
                <img src="https://s3n.beta.cashify.in/estore/ea5b0a8d4c664a39be0ffb040c7b7e35.png" class="main-img" alt="">
            </div>
        </div>
    </div>
    <div class="row p-5">
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
                <p>Book a free technician visit at your home or work at a time slot that best suits your convenience.
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
<div class="why-us p-5" style="background: #d9f4f1;">
    <h2 class="pl-5 text-black">Why us</h2>
    <div class="allbox">
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
<div class="models p-5">
    <h2 class="pl-5 text-black">Top Repaired Models</h2>
    <div class="modelbox mobilesmodelbox">
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
    <div class="models p-5">
        <h2 class="pl-5 text-black">Top Repaired Brands</h2>
        <div class="modelbox">
            <!-- Item slider-->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="carousel carousel-showmanymoveone carousel-second2 slide" id="itemslider2">
                        <div class="carousel-inner">

                            <div class="item active">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/2e7cdc22-5a5f.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/cb96df6e-080f.jpg"
                                            alt="">

                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/406a512d-e8dd.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/20922c34-8afc.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/dfb6c340-010f.jpg"
                                            alt="">
                                        <h5>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/ac5c9a7b-76b5.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/0124cc45-3a6c.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/1dcd7fda-0141.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/fef4e5ae-6507.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/cfeaabff-69bf.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/bf25222a-a2a7.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/dacc50a2-77a9.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/3e072dc2-6d7b.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/5558a532-fcaa.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/e1b13cbc-ef06.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/cashify/brand/img/xhdpi/06bc74db-4d38.jpg"
                                            alt="">
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
    <div class="models p-5">
        <h2 class="pl-5 text-black">Services Available</h2>
        <div class="modelbox">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="carousel carousel-showmanymoveone slide carousel-third3" id="itemslider3">
                        <div class="carousel-inner">

                            <div class="item active itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/2f89d20589af40b7b3ae79aa63930023.png"
                                            alt="">
                                        <h5>SCREEN</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/84a08366329341c88937615d5e01dee1.png"
                                            alt="">
                                        <h5>BATTERY</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/cf48e143753742ae9660efbfc8f81536.png"
                                            alt="">
                                        <h5>MIC</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/63cd8d65ae1d49c4a88164d3093be808.png"
                                            alt="">
                                        <h5>RECEIVER</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/40bf0f5f97b4442f992395d7a8609c57.png"
                                            alt="">
                                        <h5>CHARGING JACK</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/4df66e98a0aa466f8ea851b84cfd0c80.png"
                                            alt="">
                                        <h5>SPEAKER</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/c1c8fb2be4f84fba8461e015e8f8c783.png"
                                            alt="">
                                        <h5>BACK PANEL</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">


                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/7559fa7b283246a1868322f229328929.png"
                                            alt="">
                                        <h5>PROXIMITY SENSOR</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">

                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/855a0fdc1e884399aa4fe2b7b7bec2ef.png"
                                            alt="">
                                        <h5>AUX JACK</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
                                        <img src="https://s3n.cashify.in/estore/f9f0faead4c9486189e7fc5211cefc65.png"
                                            alt="">
                                        <h5>FRONT CAMERA</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="item  itm3">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    <div class="model">
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
    <div class="faq-sec p-5">
        <h2 class="pl-5 text-black">FAQs</h2>
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
    <div class="models videomodels p-5">
        <h2 class="pl-5 text-black">Videos</h2>
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
    <div class="app">
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
    <?php
//Static slider
// include 'static_slider.php';
//For home slider
$home_slider_data = get_home_page_data('','slider');
if( $home_slider_data == null ){
	$home_slider_data = [];
}
// echo "<pre>";print_r($home_slider_data);die();
if(count($home_slider_data)>0) {
	$section_color=($home_slider_data['section_color']!=""?$home_slider_data['section_color'].'-bg':'');

	$items_data_array = json_decode($home_slider_data['items'],true);
	if(!empty($items_data_array)) {
		array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array); ?>
    <div class="home-slide">
        <?php
			foreach($items_data_array as $items_data) { ?>
        <div id="slideshow" class="<?=$section_color?>"
            style="background-image: url('images/section/<?php echo $items_data['item_image'] ?>')">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block showcase-text">
                            <div class="slider-item">
                                <div class="row">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <div class="clearfix text-center w-100">
                                            <?php
												if($items_data['use_title_as_button'] == '1' && $items_data['item_title'] != '') {
													echo '<h1 class="mb-0 pb-2"><a href="'.$items_data['button_url'].'"><span>'.$items_data['item_title'].'</span> <i class="icon-angle-right"></i></a></h1>';
												} elseif($items_data['item_title'] != '') {
													echo '<h1 class="mb-0 pb-2">'.$items_data['item_title'].'</h1>';
												}
												if($items_data['item_sub_title']) {
													echo '<h3 class="pb-2">'.$items_data['item_sub_title'].'</h3>';
												} ?>
                                            <a href="<?=$items_data['button_url']?>"
                                                class="btn btn-lg px-5 rounded-pill btn-outline-light text-uppercase"><strong><?=$book_repair_btn_text?></strong></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
		} ?>
    </div>
    <?php
	}
}

$home_page_settings_list = get_home_page_data();
foreach($home_page_settings_list as $home_page_settings_data) {
	$home_page_settings_data['sub_title'] = str_replace("<p><br></p>","",$home_page_settings_data['sub_title']);
	$home_page_settings_data['intro_text'] = str_replace("<p><br></p>","",$home_page_settings_data['intro_text']);
	$home_page_settings_data['description'] = str_replace("<p><br></p>","",$home_page_settings_data['description']);

	$section_color=($home_page_settings_data['section_color']!=""?$home_page_settings_data['section_color'].'-bg':'');
	$section_bg_image = '';
	$section_bg_style_image = '';
	if($home_page_settings_data['section_image']) {
		$section_bg_image = "images/section/".$home_page_settings_data['section_image'];
		$section_bg_style_image = "style=\"background:url('$section_bg_image') no-repeat 0 0;\"";
	}
	
	$number_of_item_show = 0;
	$number_of_item_show = $home_page_settings_data['number_of_item_show'];
	
	$display_popular_devices_only = 0;
	$display_popular_devices_only = $home_page_settings_data['display_popular_devices_only'];
	
	if($home_page_settings_data['section_name'] == "how_it_works") {
		$items_data_array = json_decode($home_page_settings_data['items'],true);
		if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
    <section class="<?=$section_color?> pb-5 mb-5" <?=$section_bg_style_image?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block how-to-work text-center">
                        <div class="heading-block topmargin-lg bottommargin-sm center">
                            <?php
								if ($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') {
									echo '<h3>' . lastwordstrongorspan($home_page_settings_data['title'], 'strong') . '</h3>';
								}
								if ($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') {
									echo '<span class="divcenter">' . $home_page_settings_data['sub_title'] . '</span>';
								}
								if ($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') {
									echo '<span class="divcenter">' . $home_page_settings_data['intro_text'] . '</span>';
								}
								if ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') {
									echo $home_page_settings_data['description'];
								} ?>
                        </div>
                        <?php
								if(!empty($items_data_array)) { ?>
                        <div class="row">
                            <?php
									array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
									foreach($items_data_array as $items_data) {
										$item_fa_item = "";
										$item_icon_type = $items_data['item_icon_type'];
										if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
											$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
										} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
											$item_fa_item = '<img loading="lazy" src="images/section/'.$items_data['item_image'].'" class="img-fluid" alt="">';
										} ?>
                            <div class="col-md-4">
                                <div class="feature-box fbox-center fbox-light fbox-effect">
                                    <?php
											if($item_fa_item) {
												echo '<div class="fbox-icon"><a href="#">'.$item_fa_item.'</a></div>';
											}
											if($items_data['item_title']) {
												echo '<h3>'.$items_data['item_title'].'</h3>';
											}
											if($items_data['item_description']) {
												echo '<p>'.$items_data['item_description'].'</p>';
											} ?>
                                </div>
                            </div>
                            <?php
									} ?>
                        </div>
                        <?php
								} ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "top_devices") {
		//Get data from admin/include/functions.php, get_device_data_list function
		$device_data_list = get_popular_device_data();
		$num_of_device = count($device_data_list);
		if($num_of_device>0) { ?>
    <section id="device-category-sec" class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <div class="wrap">
            <?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h2>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h2>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<div class="intro-text">'.$home_page_settings_data['sub_title'].'</div>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>

            <div class="block block-category">
                <ul>
                    <?php
							foreach($device_data_list as $device_data) { ?>
                    <li>
                        <a href="<?=$device_data['sef_url']?>">
                            <div class="image">
                                <?php
											if($device_data['device_icon']) {
												$device_icon_path = SITE_URL.'images/device/'.$device_data['device_icon']; ?>
                                <img class="lazy" src="<?=$device_icon_path?>" alt="<?=$device_data['title']?>">
                                <?php
											} ?>
                            </div>
                            <span><?=$device_data['title']?></span>
                        </a>
                    </li>
                    <?php
							} ?>
                </ul>
            </div>
        </div>
    </section>
    <?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "categories") {
	  //Get data from admin/include/functions.php, get_category_data_list function
	  $category_data_list = get_category_data_list();
	  $num_of_category = count($category_data_list);
	  if($num_of_category>0) { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <!-- border-bottom -->
        <div class="section brand nobg m-0 py-5">
            <div class="container clearfix center">
                <div class="clear"></div>
                <div class="heading-block topmargin-sm bottommargin-sm center">
                    <?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
                </div>
                <ul class="clients-grid grid-5 nobottommargin clearfix">
                    <?php
					foreach($category_data_list as $category_data) { ?>
                    <li>
                        <a href="<?=SITE_URL.$category_details_page_slug.$category_data['sef_url']?>"
                            class="d-flex align-items-center">
                            <div class="inner mx-auto">
                                <?php
									if($category_data['image']) {
										echo '<img class="lazy" src="'.SITE_URL.'images/categories/'.$category_data['image'].'" alt="'.$category_data['title'].'">';
									} ?>
                                <h4><?=$category_data['title']?></h4>
                            </div>
                        </a>
                    </li>
                    <?php
					} ?>
                </ul>
            </div>
        </div>
    </section>
    <?php
	  }
	}
	elseif($home_page_settings_data['section_name'] == "devices") {
	    //Fetching devices
	    //Get data from admin/include/functions.php, get_device_data_list function
	    $device_data_list = get_device_data_list('',$display_popular_devices_only);
	    $num_of_device = count($device_data_list);
		if($num_of_device>0) { ?>
    <section id="services" class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <a name="device-section"></a>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-block topmargin-lg bottommargin-sm center">
                        <?php
								if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
									echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
								}
								if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
									echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
								}
								if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
									echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
								}
								if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
									echo $home_page_settings_data['description'];
								} ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="clients-grid grid-4 bottommargin-sm clearfix">
                        <?php
							foreach($device_data_list as $device_data) { ?>
                        <li class="center">
                            <a href="<?=$device_data['sef_url']?>">
                                <?php
										if($device_data['device_img']) {
											//$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=144';
											$device_img_path = SITE_URL.'images/device/'.$device_data['device_img']; ?>
                                <img class="lazy" src="<?=$device_img_path?>" alt="<?=$device_data['title']?>">
                                <?php
										} ?>
                                <h4><?=$device_data['title']?></h4>
                            </a>
                        </li>
                        <?php
							} ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php
	  }
	}
	elseif($home_page_settings_data['section_name'] == "models") {
		//Get data from admin/include/functions.php, get_top_seller_data_list function
		$top_seller_data_list = get_top_seller_data_list($top_seller_limit);
		$num_of_top_seller = count($top_seller_data_list);
		if($top_seller_limit>0 && $num_of_top_seller>0) { ?>
    <section id="model" class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-block topmargin-lg bottommargin-sm center">
                        <?php
								if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
									echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
								}
								if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
									echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
								}
								if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
									echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
								}
								if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
									echo $home_page_settings_data['description'];
								} ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="clients-grid grid-4 bottommargin-sm clearfix">
                        <?php
								$ts_i=1;
								foreach($top_seller_data_list as $top_seller_data) {
									$num_of_top_seller = $ts_i;
									if($num_of_top_seller<=$top_seller_limit) {
										$top_seller_md_url = SITE_URL.$top_seller_data['model_sef_url']; ?>
                        <li class="center">
                            <a href="<?=$top_seller_md_url?>">
                                <?php
												if($top_seller_data['model_img']) {
													//$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$top_seller_data['model_img'].'&h=178';
													$md_img_path = SITE_URL.'images/mobile/'.$top_seller_data['model_img']; ?>
                                <img class="lazy" src="<?=$md_img_path?>" alt="<?=$top_seller_data['model_title']?>">
                                <?php
												} ?>
                                <h4><?=$top_seller_data['model_title']?></h4>
                            </a>
                        </li>
                        <?php
								  }
								  $ts_i = $ts_i+1;
								} ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "brands") {
		//Get data from admin/include/functions.php, get_brand_data function
		$brand_data_list = get_brand_data();
		$num_of_brand = count($brand_data_list);
		if($num_of_brand>0) { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <div class="section brand nobg m-0 py-5">
            <div class="container clearfix center">
                <div class="clear"></div>
                <div class="heading-block topmargin-sm bottommargin-sm center">
                    <?php
							if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
								echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
							}
							if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
								echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
							}
							if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
								echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
							}
							if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
								echo $home_page_settings_data['description'];
							} ?>
                </div>
                <ul class="clients-grid grid-5 nobottommargin clearfix">
                    <?php
						foreach($brand_data_list as $brand_data) {
							//$brand_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/brand/'.$brand_data['image'].'&h=54'; ?>
                    <li>
                        <a href="<?=SITE_URL.$brand_data['sef_url']?>" class="d-flex align-items-center">
                            <div class="inner mx-auto">
                                <?php
										if($brand_data['image']) {
											echo '<img class="lazy" src="'.SITE_URL.'images/brand/'.$brand_data['image'].'" alt="'.$brand_data['title'].'">';
										} ?>
                                <h4><?=$brand_data['title']?></h4>
                            </div>
                        </a>
                    </li>
                    <?php
						} ?>
                </ul>
            </div>
        </div>
    </section>
    <?php
		} //END for brand section
	}
	elseif($home_page_settings_data['section_name'] == "why_choose_us") {
		$items_data_array = json_decode($home_page_settings_data['items'],true);
		if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <a name="why-choose-us"></a>
        <div class="container clearfix">
            <div class="clear"></div>
            <div class="heading-block topmargin-lg bottommargin-sm center">
                <?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
            </div>

            <?php
					array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
					foreach($items_data_array as $ik=>$items_data) {
						$item_fa_item = "";
						$item_icon_type = $items_data['item_icon_type'];
						if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
							$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
						} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
							$item_fa_item = '<img class="lazy" src="images/section/'.$items_data['item_image'].'">';
						}
						
						$row_last_col_cls = "";
						if($ik%3==0) {
							$row_last_col_cls = " col_last";
						} ?>

            <div class="col_one_third <?=$row_last_col_cls?>">
                <div class="feature-box fbox-center fbox-light fbox-effect">
                    <div class="fbox-icon">
                        <?php
								  if($item_fa_item) {
									echo '<a href="#">'.$item_fa_item.'</a>';
								  } ?>
                    </div>
                    <?php
								if($items_data['item_title']) {
									echo '<h3>'.$items_data['item_title'].'</h3>';
								}
								if($items_data['item_description']) {
									echo '<p>'.$items_data['item_description'].'</p>';
								} ?>
                </div>
            </div>
            <?php
					} ?>
        </div>
    </section>
    <?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "get_instant_repair_cost") { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <div class="container clearfix">
            <a name="request_quote"></a>
            <div class="clear"></div>
            <div class="heading-block topmargin-sm bottommargin-sm center">
                <?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>
            </div>

            <form action="controllers/home.php" method="post" id="instant_repair_cost_form">
                <div class="form-row">
                    <?php
						if($home_instant_repair_quote == "b_d_m") {
							$quote_mk_list_array = autocomplete_data_search();
							$quote_mk_list = $quote_mk_list_array['quote_mk_list']; ?>
                    <div class="form-group col-md-4">
                        <label><?=$request_quote_brand_title?></label>
                        <select class="form-control" name="quote_make" id="quote_make"
                            onchange="getQuoteDevice(this.value);">
                            <option value="">-- Select --</option>
                            <?php
								  if(!empty($quote_mk_list)) {
									  foreach($quote_mk_list as $quote_mk_key=>$quote_mk_data) { ?>
                            <option value="<?=$quote_mk_key?>"><?=$quote_mk_data?></option>
                            <?php
									  }
								  } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?=$request_quote_device_title?></label>
                        <select class="form-control add-quote-device" name="quote_device" id="quote_device"
                            onchange="getQuoteModel(this.value);">
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?=$request_quote_model_title?></label>
                        <select class="form-control add-quote-model" name="quote_model" id="quote_model">
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                    <?php
						} else {
							$device_data_list = get_device_data_list(); ?>
                    <div class="form-group col-md-6">
                        <label><?=$request_quote_device_title?></label>
                        <select class="form-control add-quote-device" name="quote_device" id="quote_device"
                            onchange="getQuoteModel(this.value);">
                            <option value="">-- Select --</option>
                            <?php
									if(!empty($device_data_list)) {
										foreach($device_data_list as $device_data) {
											echo '<option value="'.$device_data['id'].'">'.$device_data['title'].'</option>';
										}
									} ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label><?=$request_quote_model_title?></label>
                        <select class="form-control add-quote-model" name="quote_model" id="quote_model">
                            <option value="">-- Select --</option>
                        </select>
                    </div>
                    <?php
						} ?>
                </div>

                <div class="col-md-12 center">
                    <button type="submit" class="button" name="submit_quote"
                        id="submit_quote"><?=$request_instant_quote_sbmt_btn_text?></button>
                </div>
                <?php
					$quote_csrf_token = generateFormToken('get_quote'); ?>
                <input type="hidden" name="csrf_token" value="<?=$quote_csrf_token?>">
            </form>
        </div>
    </section>
    <?php
	}
	elseif($home_page_settings_data['section_name'] == "get_a_quote") { ?>
    <section
        class="section parallax dark notoppadding nobottommargin nobottomborder skrollable skrollable-between <?=$section_color?>"
        <?=$section_bg_style_image?>>
        <div class="container clearfix">
            <div class="clear"></div>
            <div class="heading-block topmargin-lg bottommargin-sm center">
                <?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>
            </div>

            <form action="controllers/contact.php" method="post" id="contact_form">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="name"><?=$name_field_title?> <small>*</small></label>
                        <input type="text" name="name" id="name" value="<?=$user_full_name?>"
                            class="sm-form-control required" />
                    </div>
                    <div class="col-md-4">
                        <label for="email"><?=$email_field_title?> <small>*</small></label>
                        <input type="text" name="email" id="email" value="<?=$user_email?>"
                            class="sm-form-control required" />
                    </div>
                    <div class="col-md-4">
                        <label for="cell_phone"><?=$phone_field_title?> <small>*</small></label>
                        <input type="tel" id="cell_phone" name="cell_phone" class="sm-form-control required"
                            value="<?=$user_phone?>">
                        <input type="hidden" name="phone" id="phone" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 topmargin-sm">
                        <label for="message"><?=$message_field_title?> <small>*</small></label>
                        <textarea name="message" id="message" class="required sm-form-control" rows="6"
                            cols="30"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 topmargin-sm">
                        <button class="button button-3d nomargin" type="submit" id="template-contactform-submit"
                            name="template-contactform-submit" value="submit"><?=$request_quote_sbmt_btn_text?></button>
                        <input type="hidden" name="submit_form" id="submit_form" />
                    </div>
                </div>

                <input type="hidden" name="mode" id="mode" value="home_page" />
                <?php
					$csrf_token = generateFormToken('home_page'); ?>
                <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
            </form>
        </div>
    </section>
    <?php
	}
	elseif($home_page_settings_data['section_name'] == "newsletter") {
		if($newslettter_section == '1') { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-8">
                    <div class="block newsletter">
                        <h3 class="feature-title">More features coming soon...</h3>
                        <p>Enroll for the software updates to receive intime communication about the new features that
                            will
                            make your order management and freight management process easier and more productive.</p>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="block newsletter text-right">
                        <form action="<?=SITE_URL?>controllers/newsletter.php" method="post" id="newsletter_form"
                            class="form-inline">
                            <div class="form-group">
                                <input type="email" name="ftr_signup_email" id="ftr_signup_email"
                                    placeholder="yourmail@mail.com"
                                    class="form-control text-left border-bottom border-top-0 border-right-0 border-left-0 center">
                                <button type="button" class="btn btn-clear" id="clk_ftr_signup_btn"><i
                                        class="fab fa-telegram-plane"></i></button>
                            </div>
                            <?php
								$newsletter_csrf_token = generateFormToken('newsletter'); ?>
                            <input type="hidden" name="csrf_token" value="<?=$newsletter_csrf_token?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "reviews") {
		//Get review list
		$review_list_data = get_review_list_data(1,$number_of_item_show);
		if(!empty($review_list_data)) { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <div style="background-size:cover;"
            class="section mt-0 nobottommargin nobottompadding nobottomborder <?=$section_color?>"
            <?=$section_bg_style_image?>>
            <div class="container clearfix">
                <div class="clear"></div>
                <div class="heading-block topmargin-sm bottommargin-sm center">
                    <?php
							if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
								echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
							}
							if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
								echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
							}
							if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
								echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
							}
							if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
								echo $home_page_settings_data['description'];
							} ?>
                </div>

                <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget clearfix" data-margin="0"
                    data-pagi="true" data-loop="false" data-center="false" data-autoplay="5000" data-items-sm="1"
                    data-items-md="2" data-items-xl="3">
                    <?php
							$rev_read_more_arr = array();
							foreach($review_list_data as $key => $review_data) { ?>
                    <div class="oc-item">
                        <div class="testimonial">
                            <div class="testi-image">
                                <a href="#">
                                    <?php
										if($review_data['photo']) {
											echo '<img class="lazy" src="'.SITE_URL.'images/review/'.$review_data['photo'].'" alt="'.$review_data['name'].'">';							} else {
											echo '<img class="lazy" src="images/placeholder_avatar.jpg" alt="Review Avatar">';
										} ?>
                                </a>
                            </div>
                            <div class="testi-content">
                                <?php
										if($full_review_or_number_of_words == "full_review" || $review_limited_words == '0') {
											echo '<p>'.$review_data['content'].'</p>';
										} else {
											$rev_content = '';
											$rev_con_words = str_word_count($review_data['content']);
											$rev_content = limit_words($review_data['content'],$review_limited_words);
											if($rev_con_words>$review_limited_words) {
												$rev_content .= ' <a href="javascript;" data-toggle="modal" data-target="#reviewModal'.$review_data['id'].'">Read More</a>';
												$rev_read_more_arr[] = array('id'=>$review_data['id'],'name'=>$review_data['name'],'content'=>$review_data['content'],'country'=>$review_data['country'],'state'=>$review_data['state'],'city'=>$review_data['city']);
											}
											echo '<p>'.$rev_content.'</p>';
										} ?>
                                <div class="testi-meta">
                                    <?=$review_data['name']?>
                                    <span><?=($review_data['country']?$review_data['country'].', ':'').$review_data['state'].', '.$review_data['city']?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
							} ?>
                </div>
                <div class="heading-block nobottomborder center pt-4 <?php /*?>topmargin-sm<?php */?>notopmargin">
                    <a href="<?=$reviews_link?>" class="button"><?=$view_all_review_btn_text?> <i
                            class="icon-circle-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <?php
				if(!empty($rev_read_more_arr)) {
					foreach($rev_read_more_arr as $rev_read_more_data) { ?>
        <div class="modal fade" id="reviewModal<?=$rev_read_more_data['id']?>" tabindex="-1" role="dialog"
            aria-labelledby="reviewModalLabel<?=$rev_read_more_data['id']?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel<?=$rev_read_more_data['id']?>">
                            <?=$rev_read_more_data['name']?>
                            (<small><?=($rev_read_more_data['country']?$rev_read_more_data['country'].', ':'').$rev_read_more_data['state'].', '.$rev_read_more_data['city']?></small>)
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?=$rev_read_more_data['content']?>
                    </div>
                </div>
            </div>
        </div>
        <?php
					}
				} ?>
    </section>
    <?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "services") {
		$service_data_list = get_service_data_list($number_of_item_show);
		if(count($service_data_list)>0) { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <div class="container clearfix">
            <div class="clear"></div>
            <div class="heading-block topmargin-lg bottommargin-sm center">
                <?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
            </div>

            <?php
					$sn = 0;
					foreach($service_data_list as $service_data) {
						$row_col_last = false;
						$sn = $sn+1;
						if($sn%3==0) {
							$row_col_last = true;
						} ?>
            <div class="col_one_third <?=($row_col_last == '1'?'col_last':'')?>">
                <div class="feature-box fbox-center fbox-light fbox-plain">
                    <?php
								if($service_data['image']) {
									$srvc_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/service/'.$service_data['image'].'&h=178'; ?>
                    <div class="fbox-icon">
                        <img class="lazy" src="<?=$srvc_img_path?>" alt="<?=$service_data['title']?>" />
                    </div>
                    <?php
								} ?>
                    <h3><?=$service_data['title']?></h3>
                    <p><?=$service_data['description']?></p>
                </div>
            </div>
            <?php
					} ?>
            <div class="clearfix"></div>
            <div class="heading-block nobottomborder center mt-1">
                <a href="<?=$services_link?>" class="button"><?=$view_all_review_btn_text?> <i
                        class="icon-circle-arrow-right"></i></a>
            </div>
        </div>
    </section>
    <?php
		}
	} else { ?>
    <section class="<?=$section_color?>" <?=$section_bg_style_image?>>
        <!-- <div class="container clearfix"> -->
        <div class="clear"></div>
        <?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1'
					|| $home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1'
					|| $home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { ?>
        <div class="heading-block topmargin-lg bottommargin-sm center">
            <?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h3>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h3>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<span class="divcenter">'.$home_page_settings_data['sub_title'].'</span>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					} ?>
        </div>
        <?php
				}

				if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
					echo $home_page_settings_data['description'];
				} ?>
        <!-- </div> -->
    </section>
    <?php
	}
} ?>

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