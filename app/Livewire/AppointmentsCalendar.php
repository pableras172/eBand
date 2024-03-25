<?php

namespace App\Livewire;

use Livewire\Component;
use Omnia\LivewireCalendar\LivewireCalendar;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\View\View;


class AppointmentsCalendar extends LivewireCalendar
{

public function onDayClick($year, $month, $day)
{
    return view('livewire.calendario.new-event', [
        'year' => $year,
        'month' => $month,
        'day' => $day,
    ]);
}

public function onEventClick($eventId)
{
    // This event is triggered when an event card is clicked
    // You will be given the event id that was clicked
}

public function onEventDropped($eventId, $year, $month, $day)
{
    // This event will fire when an event is dragged and dropped into another calendar day
    // You will get the event id, year, month and day where it was dragged to
}


    public function events() : Collection
{
    return collect([
        [
            'id' => 1,
            'title' => 'Breakfast',
            'description' => 'Pancakes! 🥞',
            'date' => Carbon::today(),
        ],
        [
            'id' => 2,
            'title' => 'Meeting with Pamela',
            'description' => 'Work stuff',
            'date' => Carbon::tomorrow(),
        ],
    ]);
}

public function addEvent()
{
    try {
        // Aquí deberías agregar la lógica para guardar el nuevo evento en tu base de datos
        // Por ejemplo, podrías utilizar Eloquent para crear un nuevo registro en tu tabla de eventos
        /*Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
        ]);*/

        // Una vez que el evento se haya guardado exitosamente, puedes limpiar los campos del formulario
        $this->title = '';
        $this->description = '';
        $this->date = '';

        // También podrías emitir un evento Livewire para actualizar la interfaz de usuario del calendario después de agregar el evento
        $this->emit('eventAdded');
    } catch (Exception $e) {
        // Manejar cualquier excepción que ocurra durante el proceso de agregar el evento
        // Por ejemplo, podrías mostrar un mensaje de error al usuario
        session()->flash('error', 'Hubo un error al agregar el evento. Por favor, inténtalo de nuevo.');
    }
}


}
