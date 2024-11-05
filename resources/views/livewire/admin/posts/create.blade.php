<?php

use Livewire\Volt\Component;
use App\Models\Category;
use Mary\Traits\Toast;
use Livewire\Attributes\{Layout, Validate, Rule};
use Livewire\WithFileUploads;

new #[Layout('components.layouts.admin')] 
class extends Component {
    use WithFileUploads, Toast;

	public int $category_id;

    #[Rule('required|image|max:2000')]
	public ?TemporaryUploadedFile $photo = null;

	#[Rule('required|string|max:16777215')]
	public string $body = '';

	#[Rule('required|string|max:255')]
	public string $title = '';

	#[Rule('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
	public string $slug = '';

	#[Rule('required')]
	public bool $active = false;

	#[Rule('required')]
	public bool $pinned = false;

	#[Rule('required|max:70')]
	public string $seo_title = '';

	#[Rule('required|max:160')]
	public string $meta_description = '';

	#[Rule('required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/')]
	public string $meta_keywords = '';

    public function mount(): void
	{
		$category          = Category::first();
		$this->category_id = $category->id;
	}

    public function updatedTitle($value)
	{
        $this->slug      = Str::slug($value);
        $this->seo_title = $value;
	}

	public function save()
	{
       
		$data = $this->validate();

		// $date = now()->format('Y/m');Missing [$rules/rules()] property/method on: [admin.posts.create]. 
		// $path = $date . '/' . basename($this->photo->store('photos/' . $date, 'public'));

        // $data['body'] = replaceAbsoluteUrlsWithRelative($data['body']);
        
		Post::create(
			$data + [
				'user_id'     => Auth::id(),
				'category_id' => $this->category_id,
				// 'image'       => $path,
			],
		);

		$this->success(__('Post added with success.'), redirectTo: '/admin/posts/index');
	}
    

    public function with(): array
	{
		return [
			'categories' => Category::orderBy('title')->get(),
		];
	}
    
}; ?>

<div>
    <x-header title="{{ __('Add a post') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-form wire:submit="save">
            <x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id"
                wire:change="$refresh" />
            <br>
            <div class="flex gap-6">
                <x-checkbox label="{{ __('Published') }}" wire:model="active" />
                <x-checkbox label="{{ __('Pinned') }}" wire:model="pinned" />
            </div>
            <x-input type="text" wire:model="title" label="{{ __('Title') }}"
                placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
                folder="{{ 'photos/' . now()->format('Y/m') }}" />
            <x-card title="{{ __('SEO') }}" shadow separator>
                <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
                <br>
                <x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
                    hint="{{ __('Max 160 chars') }}" rows="2" inline />
                <br>
                <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
                    hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
            </x-card>
            <hr>
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
