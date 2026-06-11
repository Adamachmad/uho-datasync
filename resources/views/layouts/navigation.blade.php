@php
    $pengajuAuth = Auth::guard('pengaju')->user();
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" style="box-shadow: 0 1px 3px rgba(15,37,87,0.06);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Logo --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    @if($pengajuAuth)
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 no-underline">
                            <img src="{{ asset('storage/Logo-UHO-Normal-1.png') }}" alt="UHO Logo" style="height: 38px; width: auto;">
                            <span style="font-weight:700; font-size:.9rem; color:#0f2557; line-height:1.1;">
                                UHO-Datasync<br>
                                <span style="font-size:.65rem; font-weight:500; color:#6b7280; letter-spacing:.03em;">Portal Data Mahasiswa</span>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
                            <img src="{{ asset('storage/Logo-UHO-Normal-1.png') }}" alt="UHO Logo" style="height: 38px; width: auto;">
                            <span style="font-weight:700; font-size:.9rem; color:#0f2557; line-height:1.1;">
                                UHO-Datasync<br>
                                <span style="font-size:.65rem; font-weight:500; color:#6b7280; letter-spacing:.03em;">Portal Data Mahasiswa</span>
                            </span>
                        </a>
                    @endif
                </div>

                {{-- Nav links (logged in) --}}
                @if($pengajuAuth)
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('dashboard.detail')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @endif
            </div>

            {{-- Right side --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @if($pengajuAuth)
                    {{-- Logged-in: account dropdown --}}
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button style="
                                display:flex; align-items:center; gap:.5rem;
                                padding:.4rem .85rem .4rem .5rem;
                                background:#f0f4ff;
                                border:1.5px solid rgba(15,37,87,0.12);
                                border-radius:50px;
                                cursor:pointer;
                                transition:all .2s;
                                font-family:inherit;
                            "
                            onmouseover="this.style.borderColor='#0f2557'; this.style.background='white';"
                            onmouseout="this.style.borderColor='rgba(15,37,87,0.12)'; this.style.background='#f0f4ff';">
                                {{-- Avatar --}}
                                <div style="
                                    width:32px; height:32px;
                                    background:#0f2557;
                                    border-radius:50%;
                                    display:flex; align-items:center; justify-content:center;
                                    color:white; font-size:.8rem; font-weight:700;
                                    flex-shrink:0;
                                ">
                                    {{ strtoupper(substr($pengajuAuth->nama_lengkap, 0, 1)) }}
                                </div>
                                <span style="font-size:.875rem; font-weight:600; color:#0f2557; max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $pengajuAuth->nama_lengkap }}
                                </span>
                                <svg style="color:#6b7280;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Header info --}}
                            <div style="padding:.75rem 1rem .6rem; border-bottom:1px solid #f1f5f9;">
                                <div style="font-weight:700; color:#0f2557; font-size:.875rem;">{{ $pengajuAuth->nama_lengkap }}</div>
                                <div style="font-size:.72rem; color:#6b7280;">{{ $pengajuAuth->email }}</div>
                                <div style="font-size:.72rem; color:#6b7280;">NIM: {{ $pengajuAuth->nim }}</div>
                            </div>

                            <x-dropdown-link :href="route('dashboard')">
                                <div style="display:flex; align-items:center; gap:.6rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                                    Dashboard
                                </div>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                <div style="display:flex; align-items:center; gap:.6rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ __('Profil Saya') }}
                                </div>
                            </x-dropdown-link>

                            <div style="height:1px; background:#f1f5f9; margin:.25rem 0;"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    style="color:#dc2626;">
                                    <div style="display:flex; align-items:center; gap:.6rem; color:#dc2626;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                        {{ __('Keluar') }}
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                @else
                    {{-- Guest: Login & Daftar buttons --}}
                    <a href="{{ route('login') }}" style="
                        display:flex; align-items:center; gap:.4rem;
                        padding:.45rem 1rem;
                        background:#f0f4ff;
                        color:#0f2557;
                        border:1.5px solid rgba(15,37,87,0.15);
                        border-radius:10px;
                        font-size:.875rem; font-weight:600;
                        text-decoration:none;
                        transition:all .2s;
                    "
                    onmouseover="this.style.background='#0f2557'; this.style.color='white'; this.style.borderColor='#0f2557';"
                    onmouseout="this.style.background='#f0f4ff'; this.style.color='#0f2557'; this.style.borderColor='rgba(15,37,87,0.15)';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Masuk
                    </a>
                    <a href="{{ route('daftar') }}" style="
                        display:flex; align-items:center; gap:.4rem;
                        padding:.45rem 1.1rem;
                        background:#0f2557;
                        color:white;
                        border:1.5px solid #0f2557;
                        border-radius:10px;
                        font-size:.875rem; font-weight:600;
                        text-decoration:none;
                        transition:all .2s;
                    "
                    onmouseover="this.style.background='#1a3a8f'; this.style.boxShadow='0 4px 12px rgba(15,37,87,0.3)';"
                    onmouseout="this.style.background='#0f2557'; this.style.boxShadow='none';">
                        Daftar
                    </a>
                @endif
            </div>

            {{-- Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if($pengajuAuth)
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('dashboard.detail')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @else
            <x-responsive-nav-link :href="route('login')">Masuk</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('daftar')">Daftar</x-responsive-nav-link>
            @endif
        </div>

        @if($pengajuAuth)
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ $pengajuAuth->nama_lengkap }}</div>
                <div class="font-medium text-sm text-gray-500">{{ $pengajuAuth->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endif
    </div>
</nav>