<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        return Contacts::all();
    }

    public function showUser(Contacts $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $user = Contacts::registerUser($request->all());

        return response()->json($user, 201);
    }
}
