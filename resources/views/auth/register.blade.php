<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{ role: '{{ old('role', 'karyawan') }}' }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Daftar Sebagai')" />
            <select id="role" name="role" x-model="role" required
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="atasan" {{ old('role') == 'atasan' ? 'selected' : '' }}>Atasan</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Jabatan (semua role) -->
<!-- Jabatan (semua role) -->
<div class="mt-4">
    <x-input-label for="jabatan" :value="__('Jabatan')" />
    <select id="jabatan" name="jabatan" required
            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">-- Pilih Jabatan --</option>
        @foreach($jabatans as $j)
            <option value="{{ $j->nama_jabatan }}" {{ old('jabatan') == $j->nama_jabatan ? 'selected' : '' }}>
                {{ $j->nama_jabatan }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
</div>

<!-- NIDN (Dosen) / NIP (Karyawan) -->
<div class="mt-4" x-show="role === 'dosen' || role === 'karyawan'">
    <x-input-label for="nidn_nip" :value="__('NIDN / NIP')" />
    <x-text-input id="nidn_nip" class="block mt-1 w-full" type="text" name="nidn_nip" :value="old('nidn_nip')" />
    <x-input-error :messages="$errors->get('nidn_nip')" class="mt-2" />
</div>

        <div class="mt-4" x-show="role === 'dosen'">
            <x-input-label for="program_studi" :value="__('Program Studi')" />
            <x-text-input id="program_studi" class="block mt-1 w-full" type="text" name="program_studi" :value="old('program_studi')" />
            <x-input-error :messages="$errors->get('program_studi')" class="mt-2" />
        </div>

        <!-- Karyawan & Atasan -->
        <div class="mt-4" x-show="role === 'karyawan' || role === 'atasan'">
            <x-input-label for="departemen" :value="__('Departemen')" />
            <x-text-input id="departemen" class="block mt-1 w-full" type="text" name="departemen" :value="old('departemen')" />
            <x-input-error :messages="$errors->get('departemen')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>