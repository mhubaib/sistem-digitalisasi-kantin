<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('santri')->get();

        return view('admin.users.index', compact('users'));
    }

    // Menampilkan detail user
    public function show($id)
    {
        $user = User::with('santri')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }
}
