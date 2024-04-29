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
use Ramsey\Uuid\Uuid;

class UsersController extends Controller
{

   public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $instrument_id = $request->input('instrument_id');

        $usersQuery = User::with('roles')
            ->orderBy('name', 'asc');

        // Filtrar por instrumento si se proporciona un instrument_id
        if ($instrument_id) {
            $users = $usersQuery->where('instrument_id', $instrument_id);
            $users = $usersQuery->paginate(100);
        }else{
            $users = $usersQuery->paginate(10);
        }       

        $instruments = Instrument::select('id', 'name', 'icon')
            ->withCount('users')
            ->groupBy('id', 'name', 'icon')
            ->get();

        return view('users.index', compact('users', 'instruments'));
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
        // Crear el usuario con los datos validados del formulario
        $user = User::create($request->validated());
    
        // Si la creación del usuario ha sido exitosa
        if ($user) {
            // Actualizar el campo email_verified_at con la fecha y hora actual
            $user->update(['email_verified_at' => now()]);
            
            // Sincronizar los roles del usuario
            $user->roles()->sync($request->input('roles', []));
    
            // Redireccionar al índice de usuarios con un mensaje de éxito
            return redirect()->route('users.index', ['success' => true]);
        } else {
            // Si la creación del usuario ha fallado, redireccionar al formulario con un mensaje de error
            return redirect()->back()->withErrors(['message' => 'Error al crear el usuario']);
        }
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

        if($request->forastero){
            $user->forastero=1;
        }else{
            $user->forastero=0;
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

    public function getuuid(User $user)
    {
        // Verificar si el usuario ya tiene un UUID
        if (!$user->uuid) {
            // Generar un nuevo UUID
            $uuid = Uuid::uuid4()->toString();

            // Asignar el UUID al usuario y guardarlo en la base de datos
            $user->uuid = $uuid;
            $user->save();
        } else {
            // El usuario ya tiene un UUID, simplemente obtenerlo
            $uuid = $user->uuid;
        }

        // Devolver el UUID como respuesta en formato JSON
        return response()->json(['uuid' => $uuid]);
    }
}
