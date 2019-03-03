@include('layouts.meta')
@yield('css')


</head>

<body>
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
    <!-- Start Left menu area -->
    <div class="left-sidebar-pro">
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <a href="{{ url('/') }}"><img class="main-logo" src="{!! asset('images/buleleng-kecil.png') !!}" alt="" /></a>
                <strong><a href="{{ url('/') }}"><img src="{!! asset('images/buleleng-kecil.png') !!}" alt="" /></a></strong>
            </div>
            <div class="left-custom-menu-adp-wrap comment-scrollbar">
                <nav class="sidebar-nav left-sidebar-menu-pro">
                    <ul class="metismenu" id="menu1">

                        @include('layouts.sidebar')

                    </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- End Left menu area -->
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">


				@include('layouts.header')

        <div class="product-sales-area mg-tb-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-sales-chart">

													@yield('content')


                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

    @include('layouts.footer')
