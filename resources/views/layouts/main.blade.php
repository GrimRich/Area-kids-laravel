<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Area KIDS</title>
    <meta name="description" content="Aread KIDS">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('') }}/assets/images/favicon.png">
    
    <!-- CSS
	============================================ -->
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/bootstrap.min.css">
    
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/icon-font.min.css">
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/plugins.css">
    
    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/helper.css">
    
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/style.css">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/custom.css">
    
    <!-- Modernizer JS -->
    <script src="{{ url('') }}/assets/js/vendor/modernizr-3.7.1.min.js"></script>
</head>

<body>

<div class="main-wrapper">

    <!-- Header Section Start -->
    <div class="header-section section">

        <!-- Header Top Start -->
        <div class="header-top header-top-one bg-theme-two">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center">

                    <div class="col mt-10 mb-10 d-none d-md-flex">
                        <div class="header-top-left">
                            <p class="text-white">Welcome to AreaKids</p>
                            <p class="text-white">Whatsapp: <a href="tel:0123456789">+62 897 8791 7171</a></p>
                        </div>
                    </div>
                    <div class="col mt-10 mb-10">
                        <div class="header-top-right">
                            <p class="text-white"><a href="account.html">My Account</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- Header Top End -->

        <!-- Header Bottom Start -->
        <div class="header-bottom header-bottom-one header-sticky">
            <div class="container-fluid">
                <div class="row menu-center align-items-center justify-content-between">

                    <div class="col mt-15 mb-15">
                        <!-- Logo Start -->
                        <div class="header-logo">
                            <a href="index.html">
                                <img src="{{ url('') }}/assets/images/LogoAreaKids.png" alt="Jadusona" style="width: 60%;">
                            </a>
                        </div><!-- Logo End -->
                    </div>

                    <div class="col order-2 order-lg-3">
                        <!-- Header Advance Search Start -->
                        <div class="header-shop-links">

                            <div class="header-search">
                                <button class="search-toggle"><img src="{{ url('') }}/assets/images/icons/search.png" alt="Search Toggle"><img class="toggle-close" src="{{ url('') }}/assets/images/icons/close.png" alt="Search Toggle"></button>
                                <div class="header-search-wrap">
                                    <form action="#">
                                        <input type="text" placeholder="Type and hit enter">
                                        <button><img src="{{ url('') }}/assets/images/icons/search.png" alt="Search"></button>
                                    </form>
                                </div>
                            </div>


                            <div class="header-mini-cart">
                                <a href="cart.html"><img src="{{ url('') }}/assets/images/icons/cart.png" alt="Cart"></a>
                            </div>

                        </div><!-- Header Advance Search End -->
                    </div>

                    <div class="col order-3 order-lg-2">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li><a href="shop.html">SHOP</a></li>
                                    <li><a href="online-shop.html">NEW-IN</a></li>
                                    <li><a href="online-shop.html" class="text-danger">8.8 SALE</a></li>
                                    <li><a href="onlineshop.html">Online Shopping</a></li>
                                    <li><a href="blog.html">Discover</a>
                                        <ul class="sub-menu">
                                            <li><a href="blog.html">Contact Us</a></li>
                                            <li><a href="single-blog.html">About Us</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div class="mobile-menu order-12 d-block d-lg-none col"></div>

                </div>
            </div>
        </div><!-- Header BOttom End -->

    </div><!-- Header Section End -->

    
    @yield('mainContent')


    <!-- Footer Top Section Start -->
    <div class="footer-top-section section bg-theme-two-light section-padding">
        <div class="container">
            <div class="row mbn-40">

                <div class="footer-widget col-lg-4 col-md-6 col-12 mb-40">
                    <h4 class="title">CONTACT</h4>
                    <p>Jl. Moch. Ramdan No. 28 Ciateul, Regol, Kota Bandung Jawa Barat 40252</p>
                    <p>+62 821 2211 0097</p>
                    <p>admin@areakids.id</p>
                </div>

                <div class="footer-widget col-lg-4 col-md-6 col-12 mb-40">
                    <h4 class="title">FAQ</h4>
                    <ul>
                        <li><a href="#">Konfirmasi Pembayaran</a></li>
                        <li><a href="#">Cara Pengembalian</a></li>
                        <li><a href="#">Persyaratan & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div class="footer-widget col-lg-4 col-md-6 col-12 mb-40">
                    <h4 class="title">DISCOVER</h4>
                    <ul>
                        <li><a href="#">Lookbook</a></li>
                        <li><a href="#">News</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Stores</a></li>
                    </ul>
                </div>

                
            </div>
        </div>
    </div><!-- Footer Top Section End -->

    <!-- Footer Bottom Section Start -->
    <div class="footer-bottom-section section bg-theme-two pt-15 pb-15">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <p class="footer-copyright">Copyright &copy; AREAKIDS All rights reserved</p>
                </div>
            </div>
        </div>
    </div><!-- Footer Bottom Section End -->

</div>

<!-- JS
============================================ -->

<!-- jQuery JS -->
<script src="{{ url('') }}/assets/js/vendor/jquery-3.4.1.min.js"></script>
<!-- Popper JS -->
<script src="{{ url('') }}/assets/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="{{ url('') }}/assets/js/bootstrap.min.js"></script>
<!-- Plugins JS -->
<script src="{{ url('') }}/assets/js/plugins.js"></script>
<!-- Ajax Mail -->
<script src="{{ url('') }}/assets/js/ajax-mail.js"></script>
<!-- Main JS -->
<script src="{{ url('') }}/assets/js/main.js"></script>

<script>
    $('.produk-baru').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        pagination: false,
        arrows: false,
    });
</script>
</body>

</html>