<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class CategoryManager extends Component
{
    use WithPagination;

    public $name = '';
    public $slug = '';
    public $description = '';
    public $is_active = true;
    public $editingCategoryId = null;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|min:3|unique:categories,name',
        'slug' => 'required|unique:categories,slug',
        'description' => 'nullable',
        'is_active' => 'boolean',
    ];

    public function updatedName($value)
    {
        if (!$this->editingCategoryId) {
            $this->slug = Str::slug($value);
        }
    }

    public function mount()
    {
        if (!auth()->user()->can('manage categories')) {
            abort(403);
        }
    }

    public function create()
    {
        if (!auth()->user()->can('manage categories')) {
            return;
        }
        $this->reset(['name', 'slug', 'description', 'is_active', 'editingCategoryId']);
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        if (!auth()->user()->can('manage categories')) {
            return;
        }
        $category = Category::findOrFail($id);
        $this->editingCategoryId = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->isModalOpen = true;
    }

    public function save()
    {
        if (!auth()->user()->can('manage categories')) {
            return;
        }
        $rules = $this->rules;
        if ($this->editingCategoryId) {
            $rules['name'] = 'required|min:3|unique:categories,name,' . $this->editingCategoryId;
            $rules['slug'] = 'required|unique:categories,slug,' . $this->editingCategoryId;
        }

        $this->validate($rules);

        if ($this->editingCategoryId) {
            Category::find($this->editingCategoryId)->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Category updated successfully.');
        } else {
            Category::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'Category created successfully.');
        }

        $this->isModalOpen = false;
        $this->reset(['name', 'slug', 'description', 'is_active', 'editingCategoryId']);
    }

    public function delete($id)
    {
        if (!auth()->user()->can('manage categories')) {
            return;
        }
        Category::find($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function toggleStatus($id)
    {
        if (!auth()->user()->can('manage categories')) {
            return;
        }
        $category = Category::find($id);
        $category->is_active = !$category->is_active;
        $category->save();
    }

    public function render()
    {
        return view('livewire.admin.categories.category-manager', [
            'categories' => Category::latest()->paginate(10),
        ]);
    }
}
