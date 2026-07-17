@php
    use App\Models\KpiTemplate;
    use App\Models\KpiNilai;

    $jumlahNotif = 0;
    if (auth()->check() && auth()->user()->role === 'admin') {
        $jumlahNotif = KpiTemplate::where('status', 'diajukan')->count()
                     + KpiNilai::where('status', 'Menunggu Verifikasi')->count();
    }
@endphp

<header class="sticky top-0 z-20 bg-white border-b border-gray-100">
    <div class="flex items-center justify-between gap-4 px-4 sm:px-6 py-3.5">

        <div class="flex items-center gap-3 min-w-0">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 hover:text-slate-700 p-1.5 rounded-lg hover:bg-gray-100">
                <x-icon name="menu" class="w-6 h-6" />
            </button>
            <span class="font-semibold text-slate-700 hidden sm:block">Performance Management System</span>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">

            {{-- Icon Notifikasi (hanya admin) --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('kpi-approval.index') }}"
               class="relative p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-gray-100 transition">
                <x-icon name="bell" class="w-5 h-5" />
                @if($jumlahNotif > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                        {{ $jumlahNotif > 9 ? '9+' : $jumlahNotif }}
                    </span>
                @endif
            </a>
            @endif

            <x-dropdown align="right" width="52">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2.5 rounded-lg px-2 py-1.5 hover:bg-gray-50 transition">
                        <span class="hidden sm:flex flex-col items-end leading-tight">
                            <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                            <span class="text-xs text-slate-400 capitalize">{{ Auth::user()->role }}</span>
                        </span>
                        <span class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-sm flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <x-icon name="chevron-down" class="w-4 h-4 text-slate-400 hidden sm:block" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>