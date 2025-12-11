<x-app-layout>
    <x-slot name="title">Edit Post</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Show the meme image (cannot be changed) -->
                @if ($post->image_path)
                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Current Meme</label>
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                            class="max-w-full h-auto rounded-lg shadow-md">
                        <p class="text-sm text-gray-500 mt-2">Note: You cannot change the meme image.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('posts.update', $post) }}">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <x-label for="title" value="{{ __('Title') }}" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $post->title)" required autofocus />
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Body -->
                    <div class="mb-6">
                        <x-label for="body" value="{{ __('Description') }}" />
                        <textarea id="body" name="body" rows="4"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('body', $post->body) }}</textarea>
                        @error('body')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-gray-900">
                            Cancel
                        </a>
                        <x-button>
                            {{ __('Update Post') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
