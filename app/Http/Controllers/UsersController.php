<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\UsersExportMail;
use App\Models\Instrument;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_access');

        $instrument_id = $request->input('instrument_id');
        $soloPadres = $request->boolean('padres');
        $nombre = $request->input('nombre');
        $activo = $request->input('activo');

        $usersQuery = User::with(['roles', 'instrument', 'hijos'])->orderBy('name', 'asc');

        if ($instrument_id) {
            $usersQuery->where('instrument_id', $instrument_id);
        }

        if ($soloPadres) {
            $usersQuery->whereHas('hijos');
        }

        if ($nombre) {
            $usersQuery->where('name', 'like', '%'.$nombre.'%');
        }

        if ($activo !== null && $activo !== '') {
            $usersQuery->where('activo', (int) $activo);
        }

        $users = $usersQuery->paginate(15)->appends($request->query());

        $instruments = Instrument::select('id', 'name', 'icon')
            ->withCount('users')
            ->groupBy('id', 'name', 'icon')
            ->get();

        return view('users.index', compact('users', 'instruments', 'nombre', 'activo', 'instrument_id'));
    }

    public function create()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->authorize('admin_access');

        $roles = Role::whereNotIn('title', ['SuperAdmin'])->pluck('title', 'id');
        $instruments = Instrument::all();

        $todosLosUsuarios = User::orderBy('name')->get();

        return view('users.create', compact('roles', 'instruments', 'todosLosUsuarios'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('admin_access');
        // Crear el usuario con los datos validados del formulario
        $user = User::create($request->validated());

        // Si la creación del usuario ha sido exitosa
        if ($user) {
            // Asignar hijos si se han seleccionado
            if ($request->has('hijos')) {
                foreach ($request->input('hijos') as $hijoId) {
                    $hijo = User::find($hijoId);
                    if ($hijo) {
                        $hijo->parent_id = $user->id;
                        $hijo->save();
                    }
                }
            }
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
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->authorize('admin_access');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->authorize('admin_access');

        $roles = Role::whereNotIn('title', ['SuperAdmin'])->pluck('title', 'id');
        $todosLosUsuarios = User::orderBy('name')->get();

        $user->load(['roles', 'hijos']);

        $instruments = Instrument::all();

        return view('users.create', compact('user', 'roles', 'instruments', 'todosLosUsuarios'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('admin_access');

        if ($request->activo) {
            $user->activo = 1;
        } else {
            $user->activo = 0;
        }

        if ($request->forastero) {
            $user->forastero = 1;
        } else {
            $user->forastero = 0;
        }

        foreach ($user->hijos as $hijoActual) {
            $hijoActual->parent_id = null;
            $hijoActual->save();
        }

        $user->update($request->validated());
        $user->roles()->sync($request->input('roles', []));

        if ($request->has('hijos')) {
            foreach ($request->input('hijos') as $hijoId) {
                $hijo = User::find($hijoId);
                if ($hijo) {
                    $hijo->parent_id = $user->id;
                    $hijo->save();
                }
            }
        }

        return redirect()->route('users.index');
    }

    public function toggleActive(Request $request, User $user)
    {
        $this->authorize('admin_access');

        $request->validate([
            'activo' => ['required', 'boolean'],
        ]);

        $user->update([
            'activo' => (bool) $request->boolean('activo'),
        ]);

        return back();
    }

    public function export(Request $request)
    {
        $this->authorize('admin_access');

        $validated = $request->validate([
            'mode' => ['required', 'in:download,email'],
            'email' => ['nullable', 'email', 'required_if:mode,email'],
            'instrument_id' => ['nullable', 'integer'],
            'nombre' => ['nullable', 'string'],
            'activo' => ['nullable', 'in:0,1'],
            'padres' => ['nullable', 'in:0,1'],
        ]);

        $fileName = 'users_'.now()->format('Ymd_His').'.xlsx';

        $export = new UsersExport(
            instrumentId: $request->integer('instrument_id') ?: null,
            nombre: $request->filled('nombre') ? $request->string('nombre')->value() : null,
            activo: $request->filled('activo') ? (string) $request->input('activo') : null,
            soloPadres: $request->boolean('padres'),
        );

        if ($validated['mode'] === 'download') {
            return Excel::download($export, $fileName);
        }

        $excelContent = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

        Mail::to($validated['email'])->send(new UsersExportMail($excelContent, $fileName));

        return redirect()->route('users.index', $request->only(['nombre', 'instrument_id', 'activo', 'padres']))
            ->with('success_message', __('Exportación enviada por correo correctamente.'));
    }

    public function destroy(User $user)
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->authorize('admin_access');

        $user->delete();

        return redirect()->route('users.index');
    }

    public function getuuid(User $user)
    {
        try {
            if (! $user->uuid) {
                $uuid = Uuid::uuid4()->toString();
                $user->uuid = $uuid;
                $user->save();
            } else {
                $uuid = $user->uuid;
            }

            return response()->json(['uuid' => $uuid]);
        } catch (\Throwable $e) {
            Log::error('Error generando/obteniendo UUID de usuario', [
                'user_id' => $user->id ?? null,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Error al obtener UUID'], 500);
        }
    }

    public function getInstrumentMusiciansStats(): JsonResponse
    {
        $instrumentStats = Instrument::query()
            ->select(['id', 'name'])
            ->withCount('users')
            ->orderBy('orden')
            ->get()
            ->map(function (Instrument $instrument): array {
                return [
                    'id' => $instrument->id,
                    'name' => $instrument->name,
                    'musicians' => (int) $instrument->users_count,
                ];
            })
            ->values();

        return response()->json([
            'total_musicians' => (int) $instrumentStats->sum('musicians'),
            'instruments' => $instrumentStats,
        ]);
    }
}
