<?php
namespace App\Livewire\Admin;

use App\Models\MenuItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class MenuManager extends Component
{
    public ?int $editingId = null;
    public string $name = '';
    public string $category = 'drink';
    public string $price = '';
    public string $description = '';

    public function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->category = 'drink';
        $this->price = '';
        $this->description = '';
        $this->resetErrorBag();
    }

    public function edit(int $id)
    {
        $item = MenuItem::findOrFail($id);
        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->category = $item->category;
        $this->price = (string) $item->price;
        $this->description = (string) $item->description;
        $this->resetErrorBag();
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:120',
            'category' => 'required|in:drink,food',
            'price' => 'required|numeric|min:0|max:99999',
            'description' => 'nullable|string|max:255',
        ]);

        $item = $this->editingId
            ? MenuItem::findOrFail($this->editingId)
            : new MenuItem(['position' => (MenuItem::max('position') ?? 0) + 1]);

        $item->fill($data)->save();
        $this->resetForm();
    }

    public function delete(int $id)
    {
        MenuItem::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.menu-manager', [
            'items' => MenuItem::orderBy('category')->orderBy('position')->get(),
        ]);
    }
}
