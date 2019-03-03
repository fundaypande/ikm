@extends('layoutPublic.public')

@section('content')

<?php
if($produksi -> photo == null){
  $url = 'user.png';
} else {
  $url = $produksi -> photo;
}
?>

<?php
if($produksi -> user_photo == null){
  $fotoPemilik = 'user.png';
} else {
  $fotoPemilik = $produksi -> user_photo;
}
?>


<div class="swiper-container hero-slider" style="    max-height: 650px;">
                <div class="swiper-slide hero-content-wrap" style="background-color: #f0f5f9">
                    <div class="hero-content-overlay position-absolute w-100 h-100">
                        <div class="container h-100" style="margin-top: 150px">



                                  <!-- Untuk Data Barang -->
                                  <div class="container">
                                  <div class="row">



                                  <div class="col-md-6">
                                    <header class="entry-header">
                                        <h1>{{ $produksi -> jenis_produksi }}</h1>
                                    </header><!-- .entry-header -->

                                    <div class="entry-content md-6">
                                        <p>{{ $produksi -> deskripsi }}</p>
                                    </div><!-- .entry-content -->


                                  </div>
                                  <div class="col-md-4">
                                    <!-- <div class="produksi-tumb" style="background-image: url({!! asset('images/produksi/' . $url) !!})"></div> -->
                                    <img height="350px" src="{!! asset('images/produksi/' . $url) !!}" alt="">
                                  </div>
                                  </div>
                                  </div>

                                  <!-- Untuk data pemilik Barang -->
                                  <div class="row" style="margin-left:20px">
                                    <div class="col-ms-2" style="margin-right: 30px; margin-top: 10px">
                                      <div class="profil-produsen" style="background-image: url({!! asset('images/' . $fotoPemilik) !!})"></div>
                                    </div>
                                    <div class="col-ms-10">
                                      <a href="/produsen/{{ $produksi -> id_profilikm }}" target="_blank"> <p><b>{{ $produksi -> nama_usaha }}</p></b> </a>
                                      <p><b>Alamat {{ $produksi -> alamat }}</p></b>
                                      <p><b>Telepon {{ $produksi ->  telpon }}</p></b>
                                    </div>
                                  </div>







                        </div><!-- .container -->
                    </div><!-- .hero-content-overlay -->
                </div><!-- .hero-content-wrap -->

        </div><!-- .hero-slider -->
    </header><!-- .site-header -->



@endsection
