<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        return $this->form('users.create', new User);
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
        return $this->form('users.edit', $user);
    }



    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('users.show', $user);
    }



    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }



    protected function form($view, User $user)
    {
        return view($view, [
            'user' => $user,
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'roles' => trans('users.roles'),
        ]);
    }
}
