<aside
    x-show="sidebarOpen || window.innerWidth >= 1024"
    x-cloak
    class="fixed lg:sticky top-0 left-0 z-40 h-screen w-72 flex-shrink-0 flex flex-col bg-gradient-to-b from-blue-950 to-blue-900 text-white overflow-y-auto"
>
    <!-- Brand -->
    <div class="flex items-center gap-3 px-5 py-6 border-b border-white/10">
        <div class="bg-white rounded-xl p-1.5 flex-shrink-0">
            <img src="{{ asset('images/logo stmik.png') }}" alt="Logo STMIK Bandung" class="w-9 h-9 object-contain">
        </div>
        <div class="min-w-0">
            <p class="font-extrabold text-lg leading-tight tracking-tight">PMS</p>
            <p class="text-[11px] text-blue-200 leading-tight">Performance Management System</p>
            <p class="text-[11px] text-blue-300/80 leading-tight">STMIK Bandung</p>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-5 space-y-1">

        <x-sidebar-link :href="route('dashboard')" icon="home" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-sidebar-link>

        @if(Auth::user()->role == 'admin')

            <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-wider text-blue-400">Master Data</p>

            <x-sidebar-link :href="url('/users')" icon="users" :active="request()->is('users*')">
                User
            </x-sidebar-link>

            <x-sidebar-link :href="url('/dosen')" icon="academic-cap" :active="request()->is('dosen*')">
                Data Dosen
            </x-sidebar-link>

            <x-sidebar-link :href="url('/karyawan')" icon="briefcase" :active="request()->is('karyawan*')">
                Data Karyawan
            </x-sidebar-link>

            <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-wider text-blue-400">Manajemen KPI</p>

<x-sidebar-link :href="url('/kpi-template')" icon="clipboard-check" :active="request()->is('kpi-template*')">
    Input KPI Dosen / Pegawai
</x-sidebar-link>

<p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-wider text-blue-400">Penilaian KPI</p>

<x-sidebar-link :href="url('/kpi-nilai')" icon="star" :active="request()->is('kpi-nilai*')">
    Input Nilai KPI
</x-sidebar-link>

<p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-wider text-blue-400">Penilaian (Lama)</p>

<x-sidebar-link :href="url('/kpi')" icon="target" :active="request()->is('kpi') || request()->is('kpi/*')">
    KPI
</x-sidebar-link>

            <x-sidebar-link :href="url('/periode')" icon="calendar" :active="request()->is('periode*')">
                Periode
            </x-sidebar-link>

            <x-sidebar-link :href="url('/evaluasi')" icon="clipboard-check" :active="request()->is('evaluasi*')">
                Evaluasi
            </x-sidebar-link>

            <x-sidebar-link :href="url('/capaian')" icon="flag" :active="request()->is('capaian*')">
                Capaian
            </x-sidebar-link>

            <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-wider text-blue-400">Laporan</p>

            <x-sidebar-link :href="url('/laporan')" icon="document-text" :active="request()->is('laporan*')">
                Laporan
            </x-sidebar-link>

        @endif

        @if(Auth::user()->role == 'atasan')

    <x-sidebar-link :href="url('/evaluasi')" icon="clipboard-check" :active="request()->is('evaluasi*')">
        Evaluasi
    </x-sidebar-link>

    <x-sidebar-link :href="url('/laporan')" icon="document-text" :active="request()->is('laporan*')">
        Laporan
    </x-sidebar-link>

    <x-sidebar-link :href="url('/monitoring')" icon="presentation" :active="request()->is('monitoring*')">
        Monitoring
    </x-sidebar-link>

@endif

        @if(Auth::user()->role == 'dosen')

            <x-sidebar-link :href="url('/kpi')" icon="target" :active="request()->is('kpi*')">
                KPI
            </x-sidebar-link>

            <x-sidebar-link :href="url('/capaian')" icon="flag" :active="request()->is('capaian*')">
                Capaian
            </x-sidebar-link>

            <x-sidebar-link :href="url('/hasil-evaluasi')" icon="star" :active="request()->is('hasil-evaluasi*')">
                Hasil Evaluasi
            </x-sidebar-link>

        @endif

        @if(Auth::user()->role == 'karyawan')

            <x-sidebar-link :href="url('/kpi')" icon="target" :active="request()->is('kpi*')">
                KPI
            </x-sidebar-link>

            <x-sidebar-link :href="url('/capaian')" icon="flag" :active="request()->is('capaian*')">
                Capaian
            </x-sidebar-link>

            <x-sidebar-link :href="url('/hasil-evaluasi')" icon="star" :active="request()->is('hasil-evaluasi*')">
                Hasil Evaluasi
            </x-sidebar-link>

        @endif

    </nav>

    <!-- Footer: profil & logout -->
    <div class="px-3 py-4 border-t border-white/10 space-y-1">
        <x-sidebar-link :href="route('profile.edit')" icon="user-circle" :active="request()->routeIs('profile.edit')">
            Profil
        </x-sidebar-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-blue-200 hover:bg-blue-800/50 hover:text-white cursor-pointer">
                <x-icon name="logout" class="w-5 h-5 text-blue-300" />
                <span>Logout</span>
            </a>
        </form>
    </div>
</aside>

<!-- Mobile overlay -->
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
     class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>