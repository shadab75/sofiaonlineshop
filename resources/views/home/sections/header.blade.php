<header class="header-area sticky-bar">
    <div class="main-header-wrap">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2">
                    <div class="logo pt-2">
                        <a href="{{route('home.index')}}">
                            <img src="{{asset('/images/home/Logo.jpg')}}" alt="icon" width="200">
                        </a>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7">
                    <div class="main-menu text-center">
                        <nav>

                            <ul>
                                <li class="angle-shape">
                                    <a href="{{route('home.about-us')}}"> درباره ما </a>
                                </li>

                                <li><a href="{{route('home.contact-us')}}"> تماس با ما </a></li>
                                @auth()
                                <li><a href="{{route('home.cart.index')}}">سبد خرید </a></li>
                                @endauth


                                <li class="angle-shape">
                                    <a href="#"> فروشگاه </a>
                                    @php
                                        $parentCategories = App\Models\Category::query()
                                        ->where('parent_id' , 0)
                                        ->where('is_active',1)
                                        ->get();
                                    @endphp
                                    <ul class="mega-menu">
                                        @foreach ($parentCategories as $parentCategory)
                                            <li>
                                                <a class="menu-title" href="#">{{ $parentCategory->name }}</a>

                                                <ul>
                                                    @foreach ($parentCategory->children as $childCategory)
                                                        @if($childCategory->is_active=='فعال')
                                                            <li>
                                                         <a href="{{route('home.categories.show',['category'=>$childCategory->slug])}}">{{$childCategory->name}}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="angle-shape">
                                    <a href="{{route('home.index')}}"> صفحه اصلی </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">

                    <div class="header-right-wrap pt-40">

                        <div class="header-search">
                            <a class="search-active" href="#"><i class="sli sli-magnifier"></i></a>
                        </div>
                        <div class="cart-wrap" >
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                     <i class="sli sli-bag"></i></a>

                                    @if(!\Cart::isEmpty())
                                    <span class="count-style">{{\Cart::getContent()->count()}}</span>
                                    @endif
                                </span>
                               </button>

                        </div>
                        @auth()
                            <a class="pl-3" href="{{route('home.cart.index')}}">سبد خرید</a>
                        @endauth

                        <div class="setting-wrap">
                            <button class="setting-active">
                                <i class="fas fa-user"></i>
                            </button>
                            <div class="setting-content">
                                <ul class="text-right">
                                   @auth
                                        <li><a href="{{route('home.users_profile.index')}}">پروفایل</a></li>
                                    @else
                                        <li><a href="{{route('login')}}">ورود و ثبت نام</a></li>
                                  @endauth
                                   @auth
                                           <li><a href="{{route('home.logout')}}">خروج</a></li>
                                    @endauth



                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-search start -->
        <div class="main-search-active">
            <div class="sidebar-search-icon">
                <button class="search-close">
                    <span class="sli sli-close"></span>
                </button>
            </div>
            <div class="sidebar-search-input">
                <form action="{{route('search')}}" id="search-form">
                    <input id="userFilter-search" type="hidden" name="userSearch">
                    <div class="form-search">
                        <input id="userSearch-input" class="input-text"  placeholder=" ...جستجو " type="text"
                          value="{{request()->has('userSearch') ? request()->userSearch:''}}"
                        />
                        <button type="button" onclick="search()" >
                            <i class="sli sli-magnifier"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="header-small-mobile">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                        <a href="{{route('home.index')}}">
                            <img src="{{asset('/images/home/Logo.jpg')}}" alt="" width="150">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">
                        @auth()
                        <a href="{{route('home.cart.index')}}">سبد خرید</a>
                        @endauth

                        <div class="cart-wrap">
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                    <i class="sli sli-bag"></i>
                                         @if(!\Cart::isEmpty())
                                        <span class="count-style">{{\Cart::getContent()->count()}}</span>
                                          @endif
                                </span>
                            </button>

                        </div>
                        <div class="mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="sli sli-menu"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
