<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/dashboard') }}" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/PengajuanPeminjaman') }}"aria-expanded="false"><i class="far fa-paper-plane"></i><span class="hide-menu">Pengajuan Ruangan</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/PengajuanAlat&Barang') }}"aria-expanded="false"><i class="far fa-paper-plane"></i><span class="hide-menu">Pengajuan Alat Dan Bahan</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ url('/riwayat') }}"aria-expanded="false"><i class="icon-notebook"></i><span class="hide-menu">Riwayat Peminjaman</span></a></li>
                <form action="{{ route('logout') }}" method="post">
                @csrf
                <li class="sidebar-item"><button class="sidebar-link sidebar-link btn btn-no-outline" aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span class="hide-menu">Logout</span></button></li>
                </form>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
