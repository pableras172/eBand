<?php

namespace App\Livewire\Instrument;

use Livewire\Component;
use App\Models\Instrument;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstrumentClass extends Component
{

    /*public function render()
    {
        return view('livewire.instrument.show-instrument', ['intruments' => Instrument::all()]);
    }*/

        
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('livewire.instrument.show-instrument', ['intruments' => Instrument::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('livewire.instrument.create-instrument');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required|max:100|unique:instruments,name',
            'icon' => 'required|image',
            'orden' => 'required|numeric|unique:instruments,orden'

        ]);

       
        $inst = new Instrument();
        $inst->name=$request->name;
        $inst->icon=$this->saveFile($request);
        $inst->orden=$request->orden;
        $inst->save();
        //Instrument::create($inst);

        $intruments = Instrument::all();

        return view('livewire.instrument.show-instrument', compact('intruments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Instrument $instrument)
    {
        return view('livewire.instrument.edit-instrument', compact('instrument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instrument $instrument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instrument $instrument)
    {  

        $data = request()->validate([
            'name' => 'required|max:100|unique:instruments,name,' . $instrument->id,
            //'icon' => 'required|image',
            'orden' => 'required|numeric|unique:instruments,orden,' . $instrument->id
        ]);
        


        //dd($iconPath);
        $newFileName = $this->saveFile($request);
        if($newFileName){
            $instrument->icon =$newFileName;
        }        
        $instrument->name = $request->name;
        $instrument->orden = $request->orden;
        $instrument->save();
        return redirect()->route('instrument.index');
    }

    public function destroy(Instrument $instrument)
    {
        // Elimina el instrumento de la base de datos
        $instrument->delete();
    
        // Redirige al usuario a la página de índice de instrumentos
        return redirect()->route('instrument.index', ['success' => true]);
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
                $path = $file->storeAs('imagenes/instruments', $newFileName,'public');
                
                return $newFileName;
            } else {
                // Si no es una imagen válida, puedes manejar el error aquí
                throw new \Exception('El archivo no es una imagen válida.');
            }
        } 
    }
    


}
