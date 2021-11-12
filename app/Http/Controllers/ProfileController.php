<?php

namespace App\Http\Controllers;

use App\Profession;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::first(); // $user = auth->user();

        return view('profile.edit', [
            'user' => $user,
            'professions' => Profession::orderBy('title')->get(),
        ]);
    }

    public function update()
    {

    }
}
