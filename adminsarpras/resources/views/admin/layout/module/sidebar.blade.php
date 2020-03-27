<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home')}}">SIM SARPRAS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home')}}"><img src="{{asset('img/logo.png')}}" alt="" width="100%"></a>
        </div>
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li>
                <a class="nav-link" href="{{ route('home')}}"><i class="fas fa-fire"></i>
                    <span>
                        Dashboard
                    </span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('report.index')}}"><i class="fas fa-hammer"></i>
                    <span>
                        Report Kerusakan Barang
                    </span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('laporan.index')}}"><i class="fas fa-file"></i>
                    <span>
                        Data Laporan
                    </span>
                </a>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('rooms.index')}}">Data Ruangan</a></li>
                    <li><a class="nav-link" href="{{ route('items.index')}}">Data Barang</a></li>
                    <li><a class="nav-link" href="{{ route('user.index')}}">Data Akun</a></li>
                    <li><a class="nav-link" href="{{ route('tipe.index')}}">Data Tipe</a></li>
                    <li><a class="nav-link" href="{{ route('satuan.index')}}">Data Satuan Barang</a></li>                    
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Peminjaman & Pengembalian </span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('borrow.index')}}">Data Peminjaman </a></li>
                    <li><a class="nav-link" href="{{ route('pengembalian')}}">Data Pengembalian </a></li>
                </ul>
            </li>

        </ul>
    </aside>
</div>
