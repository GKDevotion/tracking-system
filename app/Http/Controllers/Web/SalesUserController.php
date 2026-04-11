<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SalesUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')
            ->when($request->search, fn($q) => $q->where('full_name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->role_id, fn($q) => $q->where('role_id', $request->role_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $roles = Role::where('is_active', true)->get();

        return view('backend.pages.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::where('is_active', true)->get();
        return view('backend.pages.users.form', ['user' => new User(), 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'username'  => 'required|string|max:50|unique:users,username|alpha_dash',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|max:20',
            'role_id'   => 'required|exists:roles,id',
            'password'  => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],//'required|string|min:8|confirmed',
            'status'    => 'in:active,inactive',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('web.sales-user.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('role');
        $permissions = Permission::where('role_id', $user->role_id)->with('menu')->get();

        return view('backend.pages.users.view', compact('user', 'permissions'));
    }

    public function edit(User $user)
    {
        $roles = Role::where('is_active', true)->get();
        return view('backend.pages.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:150',
            'username'  => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'     => 'required|string|max:20',
            'role_id'   => 'required|exists:roles,id',
            'status'    => 'in:active,inactive',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('web.sales-user.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
