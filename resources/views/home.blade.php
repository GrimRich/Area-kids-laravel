@extends('layouts.main')

@section('mainContent')

<!-- Hero Section Start -->
<div class="hero-section section">

    <!-- Hero Slider Start -->
    <div class="hero-slider hero-slider-one fix">

        <!-- Hero Item Start -->
        <div class="hero-item" style="background-image: url(assets/images/banner/banner1.jpg)">

            <!-- Hero Content -->
            <div class="hero-content" style="visibility: collapse;">

                <h1>Get 35% off <br>Latest Baby Product</h1>
                <a href="#">SHOP NOW</a>

            </div>

        </div><!-- Hero Item End -->

        <!-- Hero Item Start -->
        <div class="hero-item" style="background-image: url(assets/images/banner/banner2.jpg)">

            <!-- Hero Content -->
            <div class="hero-content" style="visibility: collapse;">

                <h1>Get 35% off <br>Latest Baby Product</h1>
                <a href="#">SHOP NOW</a>

            </div>

        </div><!-- Hero Item End -->

    </div><!-- Hero Slider End -->

</div><!-- Hero Section End -->

<div class="product-section section section-padding">
    <div class="container">
        <div class="row mbn-40">

            <div class="col-lg-12 col-md-6 col-12 pl-3  mb-40">

                <div class="row">
                    <div class="section-title text-left col mb-30">
                        <h1>Produk Baru</h1>
                        <p>Semua produk baru temukan di sini</p>
                    </div>
                </div>

                <div class="produk-baru row row-7 mbn-40">
                    @foreach ($produkBaru as $prb)
                    <div class="col mb-40">
                        <div class="on-sale-product">
                            <a href="{{ url('') }}/detail/{{ $prb->alias }}" class="image"><img src="{{ url('') }}/storage/{{ $prb->gambar_utama }}" alt=""></a>
                            <div class="content">
                                <h4 class="title"><a href="{{ url('') }}/detail/{{ $prb->alias }}">{{ $prb->nama }}</a></h4>
                                @if ($prb->harga_coret && $prb->diskon != $prb->harga)
                                    <div class="d-flex">
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prb->harga)</h4>
                                        <span class="ml-1 old font-weight-400">Rp</span>
                                        <h4 class="old">@rupiah($prb->harga_coret)</h4>
                                    </div>
                                @elseif ($prb->harga_Min == $prb->harga_max)
                                    <div class="d-flex">
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prb->harga_min)</h4>
                                    </div>
                                @else
                                    <div class="d-flex">
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prb->harga_min)</h4>
                                        -
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prb->harga_max)</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div><!-- Product Section End -->

<!-- Product Section Start -->
<div class="product-section section section-padding">
    <div class="container">

        <div class="row">
            <div class="section-title text-left col mb-30">
                <h1>Semua Produk</h1>
                <p>Semua produk temukan di sini</p>
            </div>
        </div>

        <div class="row mbn-40">
            @foreach ($semuaProduk as $smp)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-40">
                <div class="product-item">
                    <div class="product-inner">
                        <div class="image">
                            <a href="/detail/{{ $smp->alias }}">
                                <img src="storage/{{ $smp->gambar_utama }}" alt="">
                            </a>
                        </div>
                        <div class="content-body pt-3">
                            <h4 class="title"><a href="/detail/{{ $smp->alias }}">{{ $smp->nama }}</a></h4>
                            @if ($smp->harga_coret && $smp->diskon != $smp->harga)
                                <div class="d-flex">
                                    <span class="current font-weight-400">Rp</span>
                                    <h4 class="mr-1 current">@rupiah($smp->harga)</h4>
                                    <span class="ml-1 old font-weight-400">Rp</span>
                                    <h4 class="old">@rupiah($smp->harga_coret)</h4>
                                </div>
                            @elseif ($smp->harga_Min == $smp->harga_max)
                                <div class="d-flex">
                                    <span class="current font-weight-400">Rp</span>
                                    <h4 class="mr-1 current">@rupiah($smp->harga_min)</h4>
                                </div>
                            @else
                                <div class="d-flex">
                                    <span class="current font-weight-400">Rp</span>
                                    <h4 class="mr-1 current">@rupiah($smp->harga_min)</h4>
                                    -
                                    <span class="current font-weight-400">Rp</span>
                                    <h4 class="mr-1 current">@rupiah($smp->harga_max)</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div><!-- Product Section End -->

<!-- Feature Section Start -->
<div class="feature-section bg-theme-two section section-padding fix" style="background-image: url(assets/images/pattern/pattern-dot.png);">
    <div class="container">
        <div class="feature-wrap row justify-content-between mbn-30">

            <div class="col-md-3 col-12 mb-30">
                <div class="feature-item text-center">

                    <div class="icon"><img src="assets/images/feature/feature-1.png" alt=""></div>
                    <div class="content">
                        <h3>Kualitas Jadi Prioritas</h3>
                    </div>

                </div>
            </div>

            <div class="col-md-3 col-12 mb-30">
                <div class="feature-item text-center">

                    <div class="icon"><img src="assets/images/feature/feature-2.png" alt=""></div>
                    <div class="content">
                        <h3>Kemudahan Pembayaran</h3>
                    </div>

                </div>
            </div>

            <div class="col-md-3 col-12 mb-30">
                <div class="feature-item text-center">

                    <div class="icon"><img src="assets/images/feature/feature-1.png" alt=""></div>
                    <div class="content">
                        <h3>Jaminan Pengiriman</h3>
                    </div>

                </div>
            </div>

            <div class="col-md-3 col-12 mb-30">
                <div class="feature-item text-center">

                    <div class="icon"><img src="assets/images/feature/feature-3.png" alt=""></div>
                    <div class="content">
                        <h3>Layanan Pelanggan</h3>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div><!-- Feature Section End -->

@endsection