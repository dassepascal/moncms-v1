<?php

use App\Models\Post;
use App\Repositories\PostRepository;
use Livewire\Volt\Component;

new class extends Component {

    public Post $post;
      public int $commentsCount;

    public function mount($slug): void
    {
        $postRepository = new PostRepository();
        $this->post = $postRepository->getPostBySlug($slug);
        $this->commentsCount = $this->post->valid_comments_count;
    }
   


  

}; ?>


<div class="relative grid items-center w-full py-5 mx-auto md:px-12 max-w-7xl">
    @section('title', $post->seo_title ?? $post->title)
    @section('description', $post->meta_description)
    @section('keywords', $post->meta_keywords)

    <div id="top" class="flex justify-end gap-4 ">
        
        <x-popover>
            <x-slot:trigger>
                <x-button class="btn-sm"><a
                        href="{{ url('/category/' . $post->category->slug) }}">{{ $post->category->title }}</a></x-button>
            </x-slot:trigger>
            <x-slot:content class="pop-small">
                @lang('Show this category')
            </x-slot:content>
        </x-popover>
    </div>
    <x-header title="{!! $post->title !!}" subtitle="{{ ucfirst($post->created_at->isoFormat('LLLL')) }} "
        size="text-2xl sm:text-3xl md:text-4xl" />
    <div class="relative items-center w-full py-5 mx-auto prose md:px-12 max-w-7xl ">
        @if ($post->image)
            <div class="flex flex-col items-center mb-4">
                <img src="{{ asset('storage/photos/' . $post->image) }}" />
            </div>
            <br>
        @endif
        <div class="text-justify">
            {!! $post->body !!}
        </div>
    </div>
    <br>
    <hr>
    
  <div class="flex justify-between">
        <p>@lang('By ') {{ $post->user->name }}</p>
        <em>
            @if ($commentsCount > 0)
                @lang('Number of comments: ') {{ $commentsCount }}
            @else
                @lang('No comments')
            @endif
        </em>
    </div>

    <div id="bottom" class="relative items-center w-full py-5 mx-auto md:px-12 max-w-7xl">
        @if ($commentsCount > 0)
            <div class="flex justify-center">
                <x-button label="{{ $commentsCount > 1 ? __('View comments') : __('View comment') }}" class="btn-outline" spinner />
            </div>
        @endif
    </div>

</div>
</div>


