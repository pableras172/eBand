<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Instrument;
class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')
        ->orderBy('name', 'asc')
        ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');
        $instruments = Instrument::all();

        return view('users.create', compact('roles'), compact('instruments'));
    }

    public function store(StoreUserRequest $request)
    {
       
        $user = User::create($request->validated());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index',['success' => true]);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $user->load('roles');       

        $instruments = Instrument::all();

        return view('users.create', compact('user', 'roles', 'instruments'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if($request->activo){
            $user->activo=1;
        }else{
            $user->activo=0;
        }

        $user->update($request->validated());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return redirect()->route('users.index');
    }
}
