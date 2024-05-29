<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('crudpengguna.index', compact('users'));
    }

    public function create()
    {
        return view('crudpengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'photo' => 'image|mimes:jpg|max:2048',
        ]);

        $requestData = $request->except('password');
        $requestData['password'] = bcrypt($request->password);

        // Unggah foto profil jika ada
        if ($request->hasFile('photo')) {
            $imageName = $request->name . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('public/assets/img/profile', $imageName);
            $requestData['photo'] = 'assets/img/profile/' . $imageName;
        }

        // Buat pengguna baru
        User::create($requestData);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('crudpengguna.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'role' => 'required',
            'photo' => 'image|mimes:jpg|max:2048',
        ]);

        // Jika bidang password tidak kosong, sertakan dalam data yang akan diperbarui
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && $user->photo !== 'assets/img/profile/user.webp') {
                $photoPath = public_path($user->photo);
                if (File::exists($photoPath)) {
                    File::delete($photoPath);
                }
            }

            $imageName = $validatedData['name'] . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('assets/img/profile'), $imageName);
            $validatedData['photo'] = 'assets/img/profile/' . $imageName;
        }

        $user->update($validatedData);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // Hapus foto profil pengguna jika ada, kecuali jika itu adalah foto profil default
        if ($user->photo && $user->photo !== 'assets/img/profile/user.webp') {
            $photoPath = public_path($user->photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        // Hapus pengguna dari database
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
