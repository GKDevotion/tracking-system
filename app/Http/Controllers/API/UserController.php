<?php

namespace App\Http\Controllers\API;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends BaseApiController
{
    public function index(Request $request)
    {
        $users = User::with('role')
            ->when($request->search, fn($q) => $q
                ->where('full_name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->role_id, fn($q) => $q->where('role_id', $request->role_id))
            ->latest()
            ->paginate(10);

        return $this->paginated('Users retrieved.', $users);
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
        $user = User::create($data);

        return $this->success('User created.', $user->load('role'), 201);
    }

    public function show(User $user)
    {
        $user->load('role');
        $permissions = Permission::where('role_id', $user->role_id)->with('menu')->get();

        return $this->success('User retrieved.', [
            'user'        => $user,
            'permissions' => $permissions,
        ]);
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
        return $this->success('User updated.', $user->load('role'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return $this->error('Cannot delete your own account.', 422);
        }

        $user->delete();
        return $this->success('User deleted.');
    }
}
