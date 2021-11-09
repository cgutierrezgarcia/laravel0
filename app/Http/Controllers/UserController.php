<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Profession;
use App\Skill;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
//        if (request()->has('empty')) {
//            $users = [];
//        } else {
//            $users = [
//                'Joel',
//                'Ellie',
//                'Tess',
//                'Tommy',
//                'Bill',
//                // '<script>alert("Click aquí")</script>'
//            ];
//        }

        // $users = DB::table('users')->get();
        $users = User::all(); // get() (?)
        $title = 'Usuarios';$professions = Profession::orderBy('title', 'ASD')->get();

        // return view('users.create', compact('professions'));
        return view('users.index', compact('users', 'title'));

//        return view('users.index')
//            ->with('users', User::all())
//            ->with('title', 'Listado de usuarios');
    }



    public function create()
    {
        $professions = Profession::orderBy('title', 'ASC')->get();
        $skills = Skill::orderBy('name', 'ASC')->get();
        $roles = trans('users.roles');

        return view('users.create', compact('professions', 'skills', 'roles'));
    }



    public function store(CreateUserRequest $request)
    {
        $request->createUser();
        // User::createUser($request->validated());

        return redirect()->route('users.index');
    }



    public function show(User $user)
    {
        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }



    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }



    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => '',
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.show', $user);
    }



    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}