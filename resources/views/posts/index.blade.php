@auth
    <x-app-layout>
        <x-slot name="title">All Posts</x-slot>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('All Posts') }}
                </h2>
                <a href="{{ route('posts.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    New Post
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 relative">
                            <!-- Admin Delete Button -->
                            @if (auth()->check() && auth()->user()->is_admin)
                                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                    class="absolute top-2 right-2"
                                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            <h3 class="text-2xl font-bold mb-2">{{ $post->title }}</h3>
                            <div class="text-gray-600 text-sm mb-4">
                                By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                            </div>

                            @if ($post->image_path)
                                <div class="my-4">
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                        class="max-w-full h-auto rounded-lg shadow-md">
                                </div>
                            @endif

                            @if ($post->body)
                                <p class="text-gray-700 mt-4">{{ $post->body }}</p>
                            @endif
                        </div>
                    @endforeach

                    @if ($posts->isEmpty())
                        <div
                            class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center text-gray-500 col-span-full">
                            No posts found. Be the first to create one!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>
@else
    <x-guest-layout>
        <div class="min-h-screen bg-gray-100 py-12">
            <!-- Guest Header -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">All Posts</h1>
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                            Log in
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Sign up to post
                        </a>
                    </div>
                </div>
            </div>

            <!-- Posts List -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <h3 class="text-2xl font-bold mb-2">{{ $post->title }}</h3>
                            <div class="text-gray-600 text-sm mb-4">
                                By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                            </div>

                            @if ($post->image_path)
                                <div class="my-4">
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                        class="max-w-full h-auto rounded-lg shadow-md">
                                </div>
                            @endif

                            @if ($post->body)
                                <p class="text-gray-700 mt-4">{{ $post->body }}</p>
                            @endif
                        </div>
                    @endforeach

                    @if ($posts->isEmpty())
                        <div
                            class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center text-gray-500 col-span-full">
                            No posts yet. <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Sign
                                up</a> to create the first one!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-guest-layout>
@endauth
