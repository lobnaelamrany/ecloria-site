<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // ==========================================
    // Clients
    // ==========================================
    public function clients()
    {
        $clients = User::where('role', 'client')->latest()->paginate(15);
        return view('admin.users.clients', compact('clients'));
    }

    public function toggleClient(User $user)
    {
        if ($user->role !== 'client') abort(404);
        $user->update(['is_active' => ! $user->is_active]);
        return back()->with('success', 'Statut du client mis à jour.');
    }

    // ==========================================
    // Employees
    // ==========================================
    public function employees()
    {
        $employees = User::where('role', 'employee')->with('permissions')->latest()->paginate(15);
        return view('admin.users.employees', compact('employees'));
    }

    public function createEmployee()
    {
        $permissions = Permission::all();
        return view('admin.users.create-employee', compact('permissions'));
    }

    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $employee = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
            'is_active' => true,
        ]);

        if (! empty($validated['permissions'])) {
            $employee->permissions()->sync($validated['permissions']);
        }

        return redirect()->route('admin.users.employees')->with('success', 'Employé créé.');
    }

    public function editEmployee(User $user)
    {
        if ($user->role !== 'employee') abort(404);
        $permissions = Permission::all();
        return view('admin.users.edit-employee', compact('user', 'permissions'));
    }

    public function updateEmployee(Request $request, User $user)
    {
        if ($user->role !== 'employee') abort(404);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'is_active' => 'boolean',
        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        $user->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('admin.users.employees')->with('success', 'Employé mis à jour.');
    }

    public function destroyEmployee(User $user)
    {
        if ($user->role !== 'employee') abort(404);
        $user->delete();
        return back()->with('success', 'Employé supprimé.');
    }
}
