<?php

namespace App\Http\Controllers;

use App\Models\Tipoactuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;


class TipoActuacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoactuacions = Tipoactuacion::all();
        return view('tipoactuacion.show-tipos', compact('tipoactuacions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipoactuacion.create-tipo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required|max:100|unique:tipoactuacions,nombre',
            'icon' => 'required|image'          

        ]);
       
        $tipoa = new Tipoactuacion();
        $tipoa->nombre=$request->name;
        $tipoa->icon=$this->saveFile($request);

        $tipoa->save();       

        $tipoactuacions = Tipoactuacion::all();

        return view('tipoactuacion.show-tipos', compact('tipoactuacions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipoactuacion $tipoactuacion)
    {
        $this->authorize('admin_access');
        return view('tipoactuacion.edit-tipoactuacion', compact('tipoactuacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipoactuacion $tipoActuacion)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('tipoactuacion.edit-tipoactuacion', compact('tipoActuacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipoactuacion $tipoactuacion)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => [
                'required',
                'max:100',
                Rule::unique('tipoactuacions')->ignore($tipoactuacion->id),
            ],
            'icon' => 'required|image',    
        ]);
        
    
        // Actualizar el nombre del tipo de actuación
        $tipoactuacion->nombre = $request->nombre;
    
        // Si se proporcionó una nueva imagen, actualizarla
        if ($request->hasFile('icon')) {
            $imagePath = $this->saveFile($request);
            $tipoactuacion->icon = $imagePath;
        }
    
        // Guardar los cambios en la base de datos
        $tipoactuacion->save();
    
        // Redireccionar a la página de detalles del tipo de actuación actualizado
        return redirect()->route('tipoactuacion.index')
                         ->with('success', 'Tipo de actuación creada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipoactuacion $tipoactuacion)
    {
        // Elimina el instrumento de la base de datos
        if($tipoactuacion->delete()){
            return redirect()->route('tipoactuacion.index', ['success' => 'Se ha eliminado el tipo de actuación']);
        }else{
            return redirect()->route('tipoactuacion.index', ['error' => 'No se ha eliminado el tipo de actuación']);
        }
    
        // Redirige al usuario a la página de índice de instrumentos
        
    }

    private function saveFile(Request $request){
        // Verificar si se ha cargado un archivo
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            
            // Verificar si el archivo es una imagen
            if ($file->isValid() && Str::startsWith($file->getMimeType(), 'image/')) {
                $fileNameWithTheExtension = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME); 
                $extension = $file->getClientOriginalExtension(); 
                $newFileName = $fileName . '_' . time() . '.' . $extension; 
                $path = $file->storeAs('imagenes/tipoactuacion', $newFileName,'public');
                
                return $newFileName;
            } else {
                // Si no es una imagen válida, puedes manejar el error aquí
                throw new \Exception('El archivo no es una imagen válida.');
            }
        } 
    }
}
