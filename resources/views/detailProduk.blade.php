@extends('layouts.main')

@section('mainContent')
<div class="page-section section section-padding">
    <div class="container">
        <div class="row row-30 mbn-50">
            <div class="col-12">
                <div class="row row-20 mb-10">
                    <div class="col-lg-6 col-12 mb-40">
                        <div class="pro-large-img mb-10 fix easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="{{ url('') }}/storage/{{ $produkDetail['gambar_utama'] }}">
                                <img src="{{ url('') }}/storage/{{ $produkDetail['gambar_utama'] }}" alt=""/>
                            </a>
                        </div>
                        <ul id="pro-thumb-img" class="pro-thumb-img">
                            @foreach ($produkDetail['produkGambar'] as $pkg)
                            <li><a href="{{ url('') }}/storage/{{ $pkg->gambar }}" data-standard="{{ url('') }}/storage/{{ $pkg->gambar }}"><img src="{{ url('') }}/storage/{{ $pkg->gambar }}" alt="" /></a></li>
                            @endforeach 
                        </ul>
                    </div>

                    <div class="col-lg-6 col-12 mb-40">
                        <div class="single-product-content">
                            <div class="head mb-2">
                                <div class="head-left">
                                    <h3 class="head mb-2 font-weight-bold">{{ $produkDetail['nama'] }}</h3>
                                    @if ($produkDetail['harga_coret'] && $produkDetail['diskon'] != $produkDetail['harga'])
                                        <div class="d-flex">
                                            <span class="current font-weight-400">Rp</span>
                                            <h4 class="mr-1 current">@rupiah($produkDetail['harga'])</h4>
                                            <span class="ml-1 old font-weight-400">Rp</span>
                                            <h4 class="old">@rupiah($produkDetail['harga_coret'])</h4>
                                        </div>
                                    @elseif ($produkDetail['harga_min'] == $produkDetail['harga_max'])
                                        <div class="d-flex">
                                            <span class="current font-weight-400">Rp</span>
                                            <h4 class="mr-1 current">@rupiah($produkDetail['harga'])</h4>
                                        </div>
                                    @else
                                        <div class="d-flex">
                                            <span class="current font-weight-400">Rp</span>
                                            <h4 class="mr-1 current">@rupiah($produkDetail['harga_min'])</h4>
                                            -
                                            <span class="current font-weight-400">Rp</span>
                                            <h4 class="mr-1 current">@rupiah($produkDetail['harga_max'])</h4>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="description">
                                <p>{{ $produkDetail['deskripsi'] }}</p>
                            </div>
                            
                            @if ($produkDetail->nama_variasi != "")
                            <div class="option-produk row">
                                <div class="col-md-12 mt-2">
                                    <div class="d-flex">
                                        <label for="" style="min-width: 100px !important;">{{ $produkDetail->option_one }}</label>
                                        <div class="">
                                            @foreach ($produkDetail['produkVarian'] as $prv)
                                                <button type="button" class="checkoptnew check-optionnew1 produk-varian" data-option="optionnew1" value="1" id="labeloptionnew1-1">{{ $prv->nama }}<span class="checstatval-optionnew1" id="optionnew1-1"></span></button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="d-flex">
                                        <label for="" style="min-width: 100px !important;">{{ $produkDetail->option_two }}</label>
                                        <div class="">
                                            @foreach ($produkDetail['produkVarian'][0]['produkVarianPilihan'] as $prp)
                                                <button type="button" class="checkoptnew check-optionnew1 produk-varian" data-option="optionnew1" value="1" id="labeloptionnew1-1">{{ $prp->nama }}<span class="checstatval-optionnew1" id="optionnew1-1"></span></button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>     
                            @endif
                            <hr>
                            <span class="availability mb-1 text-success">In Stock</span>
                            <div class="actions d-flex">
                                <div class="quantity-colors mr-3 mb-0 align-self-center">
                                    <div class="quantity w-100 mb-0">
                                        <div class="pro-qty"><input type="text" value="1"></div>
                                    </div>     
                                </div>
                                <button onclick="location.href='cart.html'" class="text-white"><i class="ti-shopping-cart"></i><span>Tambahkan Ke Keranjang</span></button>
                            </div>
                            <div class="actions">
                                <button class="text-white btn-wa"><i class="fa fa-whatsapp"></i><span>Order Via Whatsapp</span></button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mb-50">
                    <!-- Nav tabs -->
                    <div class="col-12">
                        <ul class="pro-info-tab-list section nav">
                            <li><a class="active" href="#more-info" data-toggle="tab">Deskripsi</a></li>
                            <li><a href="#data-sheet" data-toggle="tab">Informasi tambahan</a></li>
                        </ul>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content col-12">
                        <div class="pro-info-tab tab-pane active" id="more-info">
                            <p>DETAIL PRODUK :</p>
                            <ul>
                                <li>- Bahan cotton combed reaktif 30s</li>
                                <li>- Jahitan standart distro ori</li>
                                <li>- Overdeck Kumis</li>
                                <li>- Rantai pundak</li>
                                <li>- Bisa dipakai anak laki-laki dan perempua</li>
                            </ul>
                        </div>
                        <div class="pro-info-tab tab-pane" id="data-sheet">
                            <table class="table-data-sheet">
                                <tbody>
                                    <tr class="odd">
                                        <td>BAHAN</td>
                                        <td>Cotton reaktif 30s</td>
                                    </tr>
                                    <tr class="odd">
                                        <td>SIZE</td>
                                        <td>S, M, L, XL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pro-info-tab tab-pane" id="reviews">
                            <a href="#">Be the first to write your review!</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div><!-- Page Section End -->

<!-- Related Product Section Start -->
<div class="section section-padding pt-0">
    <div class="container">
        <div class="row">

            <div class="section-title text-left col col mb-30">
                <h1>Produk Terkait</h1>
            </div>

            <div class="related-product-slider related-product-slider-1 col-12 p-0">

                @foreach ($produkRelated as $prr)
                <div class="col">
                    <div class="product-item">
                        <div class="product-inner">
                            <div class="image">
                                <a href="{{ url('') }}/detail/{{ $prr->alias }}">
                                    <img src="{{ url('') }}/storage/{{ $prr->gambar_utama }}" alt="">
                                </a>
                            </div>
                            <div class="content-body pt-3">
                                <h4 class="title"><a href="{{ url('') }}/detail/{{ $prr->alias }}">{{ $prr->nama }}</a></h4>
                                @if ($prr->harga_coret && $prr->diskon != $prr->harga)
                                    <div class="d-flex">
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prr->harga)</h4>
                                        <span class="ml-1 old font-weight-400">Rp</span>
                                        <h4 class="old">@rupiah($prr->harga_coret)</h4>
                                    </div>
                                @elseif ($prr->harga_Min == $prr->harga_max)
                                    <div class="d-flex">
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prr->harga_min)</h4>
                                    </div>
                                @else
                                    <div class="d-flex">
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prr->harga_min)</h4>
                                        -
                                        <span class="current font-weight-400">Rp</span>
                                        <h4 class="mr-1 current">@rupiah($prr->harga_max)</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection


