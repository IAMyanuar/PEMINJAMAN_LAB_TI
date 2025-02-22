<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/dashboard') }} aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/konfirmasiuserbaru') }} aria-expanded="false"><i data-feather="user" class="feather-icon"></i><span class="hide-menu">Konfirmasi User</span>
                    {{-- <span class="badge badge-primary notify-no rounded-circle">2</span> --}}
                </a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/kalender') }} aria-expanded="false"><i data-feather="calendar" class="feather-icon"></i><span class="hide-menu">Kalender</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/accpeminjaman') }} aria-expanded="false"><i class="icon-check"></i><span class="hide-menu">Konfirmasi Ruangan</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/accpeminjamanAlat&Bahan') }} aria-expanded="false"><i class="icon-check"></i><span class="hide-menu">Konfirmasi Alat dan Bahan</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/riwayat') }} aria-expanded="false"><i class="icon-notebook"></i><span class="hide-menu">Riwayat</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/DataRuangan') }} aria-expanded="false"><i class="far fa-building"></i><span class="hide-menu">Data Ruangan</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/DataFasilitas') }} aria-expanded="false"><i class="fas fa-box-open"></i><span class="hide-menu">Data Fasilitas</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/DataAlat') }} aria-expanded="false"><i class="fas fa-wrench"></i><span class="hide-menu">Data Alat</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href={{ url('/admin/DataBahan') }} aria-expanded="false"><i class="fas fa-microchip"></i><span class="hide-menu">Data Bahan</span></a></li>
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
