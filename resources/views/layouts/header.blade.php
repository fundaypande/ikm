<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="logo-pro">
                <a href="{{ url('/') }}"><img class="main-logo" src="{!! asset('images/buleleng-kecil.png') !!}" alt="" /></a>
            </div>
        </div>
    </div>
</div>
<div class="header-advance-area">
    <div class="header-top-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="header-top-wraper">
                        <div class="row">
                            <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                <div class="menu-switcher-pro">
                                    <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                  <i class="fa fa-bars"></i>
                </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-6 col-xs-12">
                                <div class="header-top-menu tabl-d-n">
                                    <ul class="nav navbar-nav mai-top-nav">
                                        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a>
                                        </li>
                                        <li class="nav-item"><a href="{{ url('/tentang') }}" class="nav-link">Tentang</a>
                                        </li>
                                        <li class="nav-item"><a href="{{ url('/produk') }}" class="nav-link">Produk IKM</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="header-right-info" style="padding-right: 100px">
                                    <ul class="nav navbar-nav mai-top-nav header-right-menu">


                                        <li class="nav-item">
                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">

                      <span class="admin-name">{{ Auth::user()->name }}</span>
                      <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                    </a>
                                            <ul role="menu" class="dropdown-header-top author-log dropdown-menu">
                                                <li><a href="{{ url('/user') }}"><span class="edu-icon edu-user-rounded author-log-ic"></span>My Profile</a>
                                                </li>
                                                <li><a href="{{ url('/ubah-password') }}"><span class="edu-icon edu-user-rounded author-log-ic"></span>Ubah Password</a>
                                                </li>
                                                <li>
                                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                                     onclick="event.preventDefault();
                                                                   document.getElementById('logout-form').submit();">
                                                      {{ __('Logout') }}
                                                  </a>
                                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                      @csrf
                                                  </form>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul class="mobile-menu-nav">


                              @include('layouts.sidebar')


                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu end -->

</div>
