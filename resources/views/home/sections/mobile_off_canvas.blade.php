<div class="mobile-off-canvas-active">
    <a class="mobile-aside-close">
        <i class="sli sli-close"></i>
    </a>

    <div class="header-mobile-aside-wrap">
        <div class="mobile-search">
            <form action="{{route('mobileSearch')}}" id="mbsearch-form">
                <input id="mbuserFilter-search" type="hidden" name="userSearch">
                <div class="form-search">
                    <input id="mbuserSearch-input" class="input-text"  placeholder=" ...جستجو " type="text"
                           value="{{request()->has('userSearch') ? request()->userSearch:''}}"
                    />
                    <button type="button" onclick="mbsearch()" >
                        <i class="sli sli-magnifier"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="mobile-menu-wrap">
            <!-- mobile menu start -->
            <div class="mobile-navigation">
                <!-- mobile menu navigation start -->
                <a href="{{route('home.index')}}">
                    <div class="d-flex justify-content-around">
                        <img src="{{asset('/images/home/Logo.jpg')}}" alt="" width="150" class="mr-0">
                    </div>
                </a>
                <nav>

                    <ul class="mobile-menu text-right">
                        <li class="menu-item-has-children">
                            <a href="{{route('home.index')}}"> صفحه  اصلی </a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">فروشگاه</a>
                            @php
                                $parentCategories = App\Models\Category::query()->where('parent_id' , 0)
                                ->where('is_active',1)->get();
                            @endphp
                            <ul class="dropdown">
                                @foreach ($parentCategories as $parentCategory)
                                    <li class="menu-item-has-children">
                                        <a class="menu-title" href="#">{{ $parentCategory->name }}</a>
                                        <ul class="dropdown">
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

                        <li><a href="{{route('home.contact-us')}}">تماس با ما</a></li>

                        <li><a href="{{route('home.about-us')}}"> درباره ما </a></li>
                        @auth()
                        <li><a href="{{route('home.cart.index')}}">سبد خرید</a></li>
                        @endauth
                    </ul>
                </nav>
                <!-- mobile menu navigation end -->
            </div>
            <!-- mobile menu end -->
        </div>

        <div class="mobile-curr-lang-wrap">
            <div class="single-mobile-curr-lang">
                <ul class="text-right">

                    @auth
                        <li><a href="{{route('home.users_profile.index')}}">پروفایل</a></li>
                    @else
                        <li><a href="{{route('login')}}">ورود</a></li>

                    @endauth

                     @auth
                            <hr>
                            <li><a  href="{{route('home.logout')}}">خروج</a></li>
                    @endauth
                </ul>
            </div>
        </div>

    </div>
</div>
