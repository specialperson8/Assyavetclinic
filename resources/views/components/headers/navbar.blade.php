<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item  has-sub {{ request()->routeIs('inventori') || request()->routeIs('manajemen-stok') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-archive-fill"></i>
                        <span>Inventaris Barang</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item {{ request()->routeIs('inventori') ? 'active' : '' }}">
                            <a href="{{ route('inventori') }}">Manajemen Barang</a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('manajemen-stok') ? 'active' : '' }}"">
                            <a href="{{ route('manajemen-stok') }}">Catatan Pengambilan Barang</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item  has-sub {{ request()->routeIs('booking-uncompleted') || request()->routeIs('booking-completed') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cart-fill"></i>
                        <span>Manajemen Booking</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item  {{ request()->routeIs('booking-uncompleted') ? 'active' : '' }}">
                            <a href="{{ route('booking-uncompleted') }}">Booking Yang Belum diselesaikan</a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('booking-completed') ? 'active' : '' }}">
                            <a href="{{ route('booking-completed') }}">Booking yang telah diselesaikan</a>
                        </li>
                    </ul>
                </li>
                @if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'))
                    <li class="sidebar-item {{ request()->routeIs('karyawan') ? 'active' : '' }}">
                        <a href="{{ route('karyawan') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Manajemen Karyawan</span>
                        </a>
                    </li>
                @endif

                @if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'))
                    <li class="sidebar-item {{ request()->routeIs('layanan') ? 'active' : '' }}">
                        <a href="{{ route('layanan') }}" class='sidebar-link'>
                            <i class="bi bi-gear-fill"></i>
                            <span>Manajemen Layanan</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item {{ request()->routeIs('booking.index') ? 'active' : '' }}">
                    <a href="{{ route('booking.index') }}" class='sidebar-link'>
                        <i class="bi bi-calendar-plus-fill"></i>
                        <span>Pendaftaran Booking</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                    <a href="{{ route('laporan.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Laporan Rawat Hewan</span>
                    </a>
                </li> --}}
                @if(Auth::check() && Auth::user()->role == 'admin')
                <li class="sidebar-item {{ request()->routeIs('pembuatan-pekerjaan.index') ? 'active' : '' }}">
                    <a href="{{ route('pembuatan-pekerjaan.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Pembuatan Pekerjaan</span>
                    </a>
                </li>
                @endif
                @if(Auth::check() && Auth::user()->role == 'karyawan')
                <li class="sidebar-item {{ request()->routeIs('laporan-pekerjaan.index') ? 'active' : '' }}">
                    <a href="{{ route('laporan-pekerjaan.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Laporan Pekerjaan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('pekerjaansaya') ? 'active' : '' }}">
                    <a href="{{ route('pekerjaansaya') }}" class='sidebar-link'>
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Pekerjaan Anda</span>
                    </a>
                </li>
                @endif
                @if(Auth::check() && Auth::user()->role == 'superadmin')
                 <li class="sidebar-item ">
                     <form method="POST" action="{{ route('pindahadmin') }}">
                        @csrf
            
                        <a href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class='sidebar-link'>
                       <i class="bi bi-briefcase-fill"></i>
                       <span>Manajemen Website</span>
                         </a>
                    </form>
                 </li>
                @endif
                <hr class="sidebar-divider">
                <li class="sidebar-item  ">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
            
                        <a href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class='sidebar-link'>
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                         </a>
                    </form>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>