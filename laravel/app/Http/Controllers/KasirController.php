<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $kasirs = User::when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
        return view('kasirs.index', compact('kasirs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kasirs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,cashier',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        if ($request->has('create_another')) {
            return redirect()->route('kasirs.create')->with('success', 'Kasir berhasil ditambahkan. Tambah lagi?');
        }

        return redirect()->route('kasirs.index')->with('success', 'Kasir berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $kasir)
    {
        return view('kasirs.show', compact('kasir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $kasir)
    {
        return view('kasirs.edit', compact('kasir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $kasir)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $kasir->id,
            'role' => 'required|in:admin,cashier',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->password) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $data['password'] = $request->password;
        }

        $kasir->update($data);

        return redirect()->route('kasirs.index')->with('success', 'Kasir berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $kasir)
    {
        $kasir->delete();
        return redirect()->route('kasirs.index')->with('success', 'Kasir berhasil dihapus');
    }
}