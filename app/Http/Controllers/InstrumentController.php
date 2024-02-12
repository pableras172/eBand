<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $intruments = Instrument::all();

        return view('instrument.index', compact('intruments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instrument.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $inst = new Instrument();
        $inst->name=$request->name;
        $inst->icon=$request->icon;
        $inst->orden=$request->orden;
        $inst->save();
        //Instrument::create($inst);

        $intruments = Instrument::all();

        return view('instrument.index', compact('intruments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Instrument $instrument)
    {
        return view('instrument.show', compact('instrument'));
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
        
        //dd($request->file('icon'));


        //$icon = $request->file('icon');

        // Guarda el archivo en la carpeta de almacenamiento de Laravel (por ejemplo, en public/storage)
        //$iconPath = $icon->store('public/imagenes/instruments');

         //get the image from the form
         $fileNameWithTheExtension = $request->file('icon')->getClientOriginalName();


         //get the name of the file
         $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME); 
         //get extension of the file
         $extension = $request->file('icon')->getClientOriginalExtension(); 
         //create a new name for the file using the timestamp
         $newFileName = $fileName . '_' . time() . '.' . $extension; 
         //save the iamge onto a public directory into a separately folder
         $path = $request->file('icon')->storeAs('public/imagenes/instruments', $newFileName);
        
        
        //dd($iconPath);
        $instrument->icon = $newFileName;
        //dd($iconPath);
        $instrument->update();

        return redirect()->route('instrument.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instrument $instrument)
    {
        //
    }
}
