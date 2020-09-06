<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('public/admin/images/s.jpg')}}"
                 alt="Al Badr"
                 title="Al Badr"
                 class="rounded-circle img-thumbnail avatar-lg"></a>
            <div class="dropdown">
                <a href="{{route('adminPanal')}}"
                   class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-toggle="dropdown"></a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">الاقسام</li>
                
                 <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span >المستخدمين</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('users.index')}}"><i class="mdi mdi-eye"></i>
                        كل  المستخدمين </a></li>
                    <li><a href="{{route('users.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  مستخدم</a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span >مساحة اعلانية </span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('banners.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الإعلانات </a></li>
                    <li><a href="{{route('banners.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  اعلان  </a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="{{route('country.index')}}">
                    <i class="mdi mdi-theater"></i> <span >الدول</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('country.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الدول </a></li>
                    <li><a href="{{route('country.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  دولة   </a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="{{route('city.index')}}">
                    <i class="mdi mdi-theater"></i> <span >المدن</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('city.index')}}"><i class="mdi mdi-eye"></i>
                        كل  المدن </a></li>
                    <li><a href="{{route('city.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  مدينة   </a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="{{route('area.index')}}">
                    <i class="mdi mdi-theater"></i> <span >المناطق</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('area.index')}}"><i class="mdi mdi-eye"></i>
                        كل  المناطق </a></li>
                    <li><a href="{{route('area.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  منطقه   </a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span >الأقسام  الرئسية</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('categories.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الأقسام </a></li>
                    <li><a href="{{route('categories.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  قسم </a></li>
                  </ul>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span >اقسام فرعية</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('subCategories.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الأقسام الفرعية </a></li>
                    <li><a href="{{route('subCategories.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  قسم فرعية جديدة</a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span >الماركات </span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('detailsSubCategories.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الماركات </a></li>
                    <li><a href="{{route('detailsSubCategories.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  ماركة</a></li>
                  </ul>
                </li>
                 <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span >الفئة </span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('classes.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الفئات </a></li>
                    <li><a href="{{route('classes.create')}}"><i class="mdi mdi-table-edit"></i>
                  اضافة  فئة  جديدة</a></li>
                  </ul>
                </li>
               
                 <li class="treeview">
                  <a href="#">
                    <i class="mdi mdi-theater"></i> <span >الاعلانات</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{route('advertising.index')}}"><i class="mdi mdi-eye"></i>
                        كل  الإعلانات </a></li>
                    
                  </ul>
                </li>
                
                 
                 <li>
                    <a href="{{route('settings.create')}}">
                        <i class="mdi mdi-theater"></i>
                        <span > الاعدادت </span>
                    </a>
                </li>
                
                <li>
                    <a href="{{route('contact.index')}}">
                        <i class="mdi mdi-theater"></i>
                        <span> رسائل تواصل معنا </span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->