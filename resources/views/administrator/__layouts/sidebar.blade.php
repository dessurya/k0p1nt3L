<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('adm.mid.dashboard') }}" class="site_title">
                <i class="fa fa-key"></i> <span>Administrator Area</span>
            </a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <a href="{{ route('adm.mid.account.me') }}">
                    <img src="{{ Auth::guard('administrator')->user()->picture == null ? asset('asset/picture-default/users.png') : asset('asset/picture/administrator/'.Auth::guard('administrator')->user()->picture) }}" alt="..." class="img-circle profile_img">
                </a>
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::guard('administrator')->user()->name }}</h2>
            </div>
        </div>
        <!-- menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li class="{{ Route::is('adm.mid.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('adm.mid.dashboard') }}">
                            <i class="fa fa-desktop"></i> Dashboard
                        </a>
                    </li>
                    <li class="{{ Route::is('adm.mid.account*') ? 'active' : '' }}">
                        <a><i class="fa fa-users"></i> Account<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('adm.mid.account.me') }}">Me</a></li>
                            <li><a href="{{ route('adm.mid.account.list') }}">Accounts</a></li>
                            <li><a href="{{ route('adm.mid.account.logs') }}">Logs Accounts</a></li>
                        </ul>
                    </li>
                    <li class="{{ Route::is('adm.mid.content*') ? 'active' : '' }}">
                        <a><i class="fa fa-globe"></i> Content<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('adm.mid.content', ['index'=>'banner']) }}">Banner</a></li>
                            <li><a href="{{ route('adm.mid.content', ['index'=>'career']) }}">Career</a></li>
                            <li><a href="{{ route('adm.mid.content', ['index'=>'certificate']) }}">Certificate</a></li>
                            <li><a href="{{ route('adm.mid.content', ['index'=>'management']) }}">Management</a></li>
                            <li><a href="{{ route('adm.mid.content', ['index'=>'news-event']) }}">News Event</a></li>
                            <li><a href="{{ route('adm.mid.content', ['index'=>'partner']) }}">Partner</a></li>
                            <li><a href="{{ route('adm.mid.content', ['index'=>'portofolio']) }}">Portofolio</a></li>
                            <li><a href="{{ route('adm.mid.content', ['index'=>'portofolio-galeri']) }}">Portofolio Galeri</a></li>
                        </ul>
                    </li>
                    <li class="{{ Route::is('adm.mid.inbox*') ? 'active' : '' }}">
                        <a><i class="fa fa-inbox"></i> Inbox<span class="fa fa-chevron-down"></span></a></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('adm.mid.inbox', ['index'=>'list']) }}">List</a></li>
                            <li><a href="{{ route('adm.mid.inbox', ['index'=>'email']) }}">Email</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- sidebar menu -->
    </div>
</div>