<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getUsers()
    {
        $users = User::query();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                // return '<a href="'.route('profile.edit', $user->id).'" class="btn btn-primary btn-sm">Edit</a>';
                return '<a href="'.route('profile.editUser', ['id' => $user->id]).'" class="btn btn-primary btn-sm">Edit</a>';
            })
            ->rawColumns(['action'])
            ->toJson(); 
    }
}
