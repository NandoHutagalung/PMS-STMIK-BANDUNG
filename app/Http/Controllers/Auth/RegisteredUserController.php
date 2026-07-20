<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Atasan;
use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
public function create(): View
{
    $jabatans = Jabatan::orderBy('nama_jabatan')->get();

    return view('auth.register', compact('jabatans'));
}
    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:dosen,karyawan,atasan'],
            'jabatan' => ['required', 'string', 'max:255'],
            'nidn_nip' => ['required_if:role,dosen,karyawan', 'nullable', 'string', 'max:255'],
            'departemen' => ['required_if:role,karyawan,atasan', 'nullable', 'string', 'max:255'],
            'program_studi' => ['required_if:role,dosen', 'nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

match ($request->role) {
    'karyawan' => Karyawan::create([
        'nama' => $request->name,
        'nip' => $request->nidn_nip,
        'jabatan' => $request->jabatan,
        'departemen' => $request->departemen,
    ]),
    'dosen' => Dosen::create([
        'nama' => $request->name,
        'nidn' => $request->nidn_nip,
        'jabatan' => $request->jabatan,
        'program_studi' => $request->program_studi,
    ]),
    'atasan' => Atasan::create([
        'nama' => $request->name,
        'jabatan' => $request->jabatan,
        'departemen' => $request->departemen,
    ]),
};

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}