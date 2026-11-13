<?php

namespace App\Livewire\Instrument;

use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

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
        return view('livewire.instrument.show-instrument', [
            'intruments' => Instrument::orderBy('orden')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextOrder = (Instrument::max('orden') ?? 0) + 1;

        return view('livewire.instrument.create-instrument', compact('nextOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100|unique:instruments,name',
            'icon' => 'nullable|image|max:2048',
            'orden' => 'required|numeric|unique:instruments,orden',
        ]);

        $inst = new Instrument;
        $inst->name = $request->name;
        if ($request->hasFile('icon')) {
            $inst->icon = $this->saveFile($request);
        }
        $inst->orden = $request->orden;
        $inst->save();

        session()->flash('message', __('Instrument creat correctament.'));

        return redirect()->route('instrument.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instrument $instrument)
    {
        $instrument->load(['users' => function ($query) {
            $query->orderBy('name');
        }]);

        return view('livewire.instrument.edit-instrument', compact('instrument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instrument $instrument)
    {
        return $this->show($instrument);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instrument $instrument)
    {
        $data = $request->validate([
            'name' => 'required|max:100|unique:instruments,name,'.$instrument->id,
            'icon' => 'nullable|image|max:2048',
            'orden' => 'required|numeric|unique:instruments,orden,'.$instrument->id,
        ]);

        if ($request->hasFile('icon')) {
            $newFileName = $this->saveFile($request);
            if ($newFileName) {
                $instrument->icon = $newFileName;
            }
        }

        $instrument->name = $request->name;
        $instrument->orden = $request->orden;
        $instrument->save();

        session()->flash('message', __('Instrument actualitzat correctament.'));

        return redirect()->route('instrument.index');
    }

    public function updateOrder(Request $request)
    {
        $ordenes = $request->input('ordenes');
        Log::info('Actualizando orden de instrumentos', ['ordenes' => $ordenes]);

        foreach ($ordenes as $orden) {
            Instrument::where('id', $orden['id'])->update(['orden' => $orden['orden']]);
        }

        return response()->json(['status' => 'success', 'alert_type' => 'success', 'message' => 'Orden actualizado correctamente']);
    }

    public function destroy(Instrument $instrument)
    {
        $instrument->users()->update(['instrument_id' => null]);
        $instrument->delete();

        session()->flash('message', __('Instrument eliminat correctament.'));

        return redirect()->route('instrument.index', ['success' => true]);
    }

    private function saveFile(Request $request)
    {
        // Verificar si se ha cargado un archivo
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');

            // Verificar si el archivo es una imagen
            if ($file->isValid() && Str::startsWith($file->getMimeType(), 'image/')) {
                $fileNameWithTheExtension = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $newFileName = $fileName.'_'.time().'.'.$extension;
                $path = $file->storeAs('imagenes/instruments', $newFileName, 'public');

                return $newFileName;
            } else {
                // Si no es una imagen válida, puedes manejar el error aquí
                throw new \Exception('El archivo no es una imagen válida.');
            }
        }
    }
}
