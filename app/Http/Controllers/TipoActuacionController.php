<?php

namespace App\Http\Controllers;

use App\Models\Tipoactuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

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
    public function show(Tipoactuacion $tipoActuacion)
    {
        dd($tipoActuacion);
        return view('tipoactuacion.edit-tipoactuacion', compact('tipoActuacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipoactuacion $tipoActuacion)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //dd($tipoActuacion);
        return view('tipoactuacion.edit-tipoactuacion', compact('tipoActuacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipoactuacion $tipoActuacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipoactuacion $tipoActuacion)
    {
        // Elimina el instrumento de la base de datos
        $tipoActuacion->delete();
    
        // Redirige al usuario a la página de índice de instrumentos
        return redirect()->route('tipoactuacion.index', ['success' => true]);
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
                $path = $file->storeAs('imagenes/tipoactuacion', $newFileName);
                
                return $newFileName;
            } else {
                // Si no es una imagen válida, puedes manejar el error aquí
                throw new \Exception('El archivo no es una imagen válida.');
            }
        } 
    }
}
