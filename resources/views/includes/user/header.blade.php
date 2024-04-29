<!-- Page Header Start-->
<div class="page-header">
    <div class="header-wrapper row m-0">
        <form class="form-inline search-full col" action="{{ route('index') }}" method="get">
            <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                            autocomplete="off" placeholder="Search ..." name="q" title="" autofocus>
                        <div class="spinner-border Typeahead-spinner" role="status"><span
                                class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                    </div>
                    <div class="Typeahead-menu"></div>
                </div>
            </div>
        </form>
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper">
                <a href="/">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                </a>
            </div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
            <ul class="nav-menus">
                <li>
                    <span class="header-search">
                        <svg>
                            <use href="{{ asset('assets/svg/icon-sprite.svg#search') }}"></use>
                        </svg>
                    </span>
                </li>

                @if (Auth::check())
                    <li class="cart-nav onhover-dropdown">
                        <a class="cart-box" href="{{ route('cart') }}">
                            <svg>
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                            </svg>
                            @if (auth()->user()->cart && auth()->user()->cartItems->count())
                                <span
                                    class="badge rounded-pill badge-success">{{ auth()->user()->cartItems->count() }}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="profile-nav onhover-dropdown pe-0 py-0">
                    @if (Auth::guard('admin')->check())
                        <div class="media profile-media">
                            <img class="b-r-10" src="{{ asset('assets/images/avatar.png') }}" alt=""
                                style="width: 30px">
                            <div class="media-body">
                                <span>{{ auth()->guard('admin')->user()->name }}</span>
                                <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li>
                                <a href="{{ route('admin.dashboard') }}">
                                    <i data-feather="layout"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li><a href="#"><i data-feather="user"></i><span>Account </span></a></li>
                            <li><a href="{{ route('admin.logout') }}"><i data-feather="log-out">
                                    </i><span>Logout</span></a></li>
                        </ul>
                    @elseif (Auth::check())
                        <div class="media profile-media">
                            <img class="b-r-10" src="{{ asset('assets/images/avatar.png') }}" alt=""
                                style="width: 30px">
                            <div class="media-body">
                                <span>{{ auth()->user()->name }}</span>
                                <p class="mb-0 font-roboto">User <i class="middle fa fa-angle-down"></i></p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li><a href="{{ route('account') }}"><i data-feather="user"></i><span>Account </span></a>
                            </li>
                            <li><a href="{{ route('orders') }}"><i data-feather="shopping-bag"></i><span>Orders
                                    </span></a></li>
                            <li><a href="{{ route('cart') }}"><i data-feather="shopping-cart"></i><span>Cart
                                    </span></a></li>
                            <li><a href="{{ route('logout') }}"><i data-feather="log-out"> </i><span>Logout</span></a>
                            </li>
                        </ul>
                    @else
                        <button class="btn btn-primary"
                            onclick="document.location.href = '{{ route('login') }}'">Login</button>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Header Ends -->
