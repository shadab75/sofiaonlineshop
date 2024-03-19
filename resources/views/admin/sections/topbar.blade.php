<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->


    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline ml-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class=" search form-control bg-light border-0 small order-2" placeholder="جستجو ..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav mr-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small order-2" placeholder="جستجو ..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">

            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in text-right"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    لورم ایپسوم
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div>
                        <div class="small text-gray-500"> مهر 12, 1399 </div>
                        <span class="font-weight-bold"> متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                            طراحان
                            گرافیک است </span>
                    </div>

                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>

                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">

                    <div>
                        <div class="small text-gray-500"> مهر 12, 1399 </div>
                        متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده
                    </div>

                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>

                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">

                    <div>
                        <div class="small text-gray-500"> مهر 12, 1399 </div>
                        متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                    </div>

                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>

                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#"> مشاهده تمام </a>
            </div>
        </li>

        <!-- Nav Item - Messages -->


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span  style="color: #1a9aef;font-weight: bold" class="ml-3 mt-1"> نام و نام خانوادگی :  </span>
               <span class="p-3" style="background-color:#cccccc;border-radius: 3px"><strong style="color: #0b0b0b"> {{auth()->user()->name==null?'کاربر گرامی':auth()->user()->name}}</strong></span>

            </a>
            <!-- Dropdown - User Information -->

        </li>

    </ul>

</nav>

<!-- Logout Modal-->

