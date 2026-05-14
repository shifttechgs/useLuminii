<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(25);
        return view('crm.users.index', compact('users'));
    }

    public function create()
    {
        return view('crm.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:' . implode(',', array_keys(User::ROLES)),
            'is_active'=> 'boolean',
        ]);

        User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => $data['role'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('crm.users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        return view('crm.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|in:' . implode(',', array_keys(User::ROLES)),
            'is_active'=> 'boolean',
        ]);

        $update = [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'is_active' => $request->boolean('is_active'),
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $user->update($update);

        return redirect()->route('crm.users.index')->with('success', 'User updated.');
    }

    public function show(User $user)
    {
        return redirect()->route('crm.users.edit', $user);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->update(['is_active' => false]);
        return redirect()->route('crm.users.index')->with('success', 'User deactivated.');
    }
}

