<?php
namespace App\Livewire\Admin;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class EventManager extends Component
{
    public ?int $editingId = null;
    public string $title = '';
    public string $event_date = '';
    public string $description = '';

    public function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->event_date = '';
        $this->description = '';
        $this->resetErrorBag();
    }

    public function edit(int $id)
    {
        $event = Event::findOrFail($id);
        $this->editingId = $event->id;
        $this->title = $event->title;
        $this->event_date = $event->event_date->format('Y-m-d');
        $this->description = (string) $event->description;
        $this->resetErrorBag();
    }

    public function save()
    {
        $data = $this->validate([
            'title' => 'required|string|max:150',
            'event_date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $event = $this->editingId ? Event::findOrFail($this->editingId) : new Event();
        $event->fill($data)->save();
        $this->resetForm();
    }

    public function delete(int $id)
    {
        Event::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.event-manager', [
            'events' => Event::orderBy('event_date')->get(),
        ]);
    }
}
