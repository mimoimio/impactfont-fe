@auth
    <x-app-layout>
        <x-slot name="title">memeoimio</x-slot>
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
                    @forelse ($posts as $post)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg relative group">
                            <!-- Admin Delete Button -->
                            @if (auth()->user()->is_admin)
                                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                    onsubmit="return confirm('Delete this post?');" class="absolute top-2 right-2 z-10">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white rounded-full p-2 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('posts.show', $post) }}" class="block">
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-contain">
                                @endif

                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                                    <div class="text-gray-600 text-sm mb-4">
                                        By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                                    </div>
                                    @if ($post->body)
                                        <p class="text-gray-700">{{ Str::limit($post->body, 100) }}</p>
                                    @endif
                                </div>
                            </a>

                            <!-- Footer with Comments, Share, and Download -->
                            <div class="px-6 pb-4 flex justify-between items-center border-t pt-3">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span class="text-sm">{{ $post->comments_count }}</span>
                                </a>

                                <div class="flex items-center space-x-3">
                                    <button
                                        onclick="sharePostFromCard('{{ route('posts.show', $post) }}', '{{ addslashes($post->title) }}')"
                                        class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        <span class="text-sm">Share</span>
                                    </button>

                                    <a href="{{ asset('storage/' . $post->image_path) }}"
                                        download="{{ $post->title }}.jpg"
                                        class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span class="text-sm">Download</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center text-gray-500">
                            No posts found. Be the first to create one!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <script>
            function sharePostFromCard(url, title) {
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    }).catch(() => {});
                } else {
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            }
        </script>
    </x-app-layout>
@else
    <x-guest-layout>
        <x-slot name="title">memeoimio</x-slot>
        <div class="min-h-screen bg-gray-100 py-12">
            <!-- Guest Header -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
                <div class="flex justify-between items-center">
                    <h2 class="text-3xl font-bold text-gray-900">
                        All Posts
                    </h2>
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
                    @forelse ($posts as $post)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <a href="{{ route('posts.show', $post) }}" class="block">
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-contain">
                                @endif

                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                                    <div class="text-gray-600 text-sm mb-4">
                                        By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                                    </div>
                                    @if ($post->body)
                                        <p class="text-gray-700">{{ Str::limit($post->body, 100) }}</p>
                                    @endif
                                </div>
                            </a>

                            <!-- Footer with Comments, Share, and Download -->
                            <div class="px-6 pb-4 flex justify-between items-center border-t pt-3">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span class="text-sm">{{ $post->comments_count }}</span>
                                </a>

                                <div class="flex items-center space-x-3">
                                    <button
                                        onclick="sharePostFromCard('{{ route('posts.show', $post) }}', '{{ addslashes($post->title) }}')"
                                        class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        <span class="text-sm">Share</span>
                                    </button>

                                    <a href="{{ asset('storage/' . $post->image_path) }}"
                                        download="{{ $post->title }}.jpg"
                                        class="text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span class="text-sm">Download</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center text-gray-500">
                            No posts found. Be the first to create one!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <script>
            function sharePostFromCard(url, title) {
                if (navigator.share) {
                    navigator.share({
                        title: title,

                        
                        url: url
                    }).catch(() => {});
                } else {
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            }
        </script>
    </x-guest-layout>
@endauth
