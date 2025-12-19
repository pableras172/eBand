<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class LocationMap extends Component
{
    public string $poblacion = '';
    public ?float $lat = null;
    public ?float $lng = null;
    public $results = [];
    public int $height = 220;


    public function mount($height = 220)
    {
        $this->height = (int) $height;
    }

    
    public function render()
    {
        return view('livewire.location-map');
    }
}
