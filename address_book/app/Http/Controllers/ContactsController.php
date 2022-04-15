<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        return Contacts::all();
    }

    public function fetchContacts()
    {
        $contacts = array (
            array(
                'name' => 'Michael Wayne',
                'address' =>'Kottayam District',
                'email' =>'Michael@gmail.com',
                'phone' =>'9633565656'
            ),
            array(
                'name' =>'Mila Kunis',
                'address' =>'Kollam District',
                'email' =>'Mila@gmail.com',
                'phone' =>'96968865656'
            ),
            array(
                'name' =>'Paul Dano',
                'address' =>'Alappuzha District',
                'email' =>'Paul@gmail.com',
                'phone' =>'9696568656'
            ),
            array(
                'name' =>'Dennis Williams',
                'address' =>'Kottayam District',
                'email' =>'Dennis@gmail.com',
                'phone' =>'9696568656'
            ),
            array(
                'name' =>'Tim Drake',
                'address' =>'Tvm District',
                'email' =>'Tim@gmail.com',
                'phone' =>'9696565696'
            ),
            array(
                'name' =>'Erik Bana',
                'address' =>'Kottayam District',
                'email' =>'Erik@gmail.com',
                'phone' =>'9696565656'
            ),
        );
        return response()->json([
            'contacts' => $contacts
        ]);
    }

    public function store(Request $request)
    {
        $user = Contacts::registerUser($request->all());

        return response()->json($user, 201);
    }
}
