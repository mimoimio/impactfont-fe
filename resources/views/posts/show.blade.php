@auth
    <x-app-layout>
        <x-slot name="title">{{ $post->title }}</x-slot>
        <x-slot name="ogTags">
            {{-- <meta property="og:title" content="{{ $post->title }}" /> --}}
            <meta property="og:type" content="image/jpeg" />
            <meta property="og:url" content="{{ route('posts.show', $post) }}" />
            <meta property="og:image:width" content="256" />
            <meta property="og:image:height" content="256" />
            @if ($post->image_path)
                <meta property="og:image" content="{{ asset('storage/' . $post->image_path) }}" />
                <meta property="og:image:alt" content="{{ $post->title }}" />
            @endif
            {{-- @if ($post->body)
                <meta property="og:description" content="{{ Str::limit(strip_tags($post->body), 200) }}" />
            @endif --}}
            <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}" />
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:title" content="{{ $post->title }}" />
            @if ($post->image_path)
                <meta name="twitter:image" content="{{ asset('storage/' . $post->image_path) }}" />
            @endif
            @if ($post->body)
                <meta name="twitter:description" content="{{ Str::limit(strip_tags($post->body), 200) }}" />
            @endif
        </x-slot>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $post->title }}
                </h2>
                <div class="flex space-x-4">
                    <button onclick="sharePost()" class="text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>

                    </button>
                    <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800">
                        ← Back to Posts
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Post Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="text-gray-600 text-sm">
                                By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <!-- Owner Actions -->
                        @if (auth()->id() === $post->user_id || auth()->user()->is_admin)
                            <div class="flex space-x-2">
                                @if (auth()->id() === $post->user_id)
                                    <a href="{{ route('posts.edit', $post) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        Edit
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if ($post->image_path)
                        <div class="my-4">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                class="max-w-full h-auto rounded-lg shadow-md mx-auto">
                        </div>
                    @endif

                    @if ($post->body)
                        <p class="text-gray-700 mt-4">{{ $post->body }}</p>
                    @endif
                </div>

                <!-- Comments Section -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Comments ({{ $post->comments->count() }})</h3>

                    <!-- Comment Form -->
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-6">
                        @csrf
                        <textarea name="body" rows="3" placeholder="Write a comment..."
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" required></textarea>
                        @error('body')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-2 flex justify-end">
                            <x-button>Post Comment</x-button>
                        </div>
                    </form>

                    <!-- Comments List -->
                    <div class="space-y-4">
                        @forelse ($post->comments as $comment)
                            <div class="border-b pb-4 last:border-b-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                            <span class="text-gray-500 text-sm">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700">{{ $comment->body }}</p>
                                    </div>

                                    <!-- Delete Comment -->
                                    @if (auth()->id() === $comment->user_id || auth()->user()->is_admin)
                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                                            onsubmit="return confirm('Delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm ml-4">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <script>
            function sharePost() {
                const postUrl = '{{ route('posts.show', $post) }}';
                const postTitle = '{{ $post->title }}';

                if (navigator.share) {
                    navigator.share({
                        title: postTitle,
                        url: postUrl
                    }).catch(() => {});
                } else {
                    navigator.clipboard.writeText(postUrl).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            }
        </script>
    </x-app-layout>
@else
    <x-guest-layout>
        <x-slot name="ogTags">
            <meta property="og:title" content="{{ $post->title }}" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="{{ route('posts.show', $post) }}" />
            @if ($post->image_path)
                <meta property="og:image" content="{{ asset('storage/' . $post->image_path) }}" />
                <meta property="og:image:alt" content="{{ $post->title }}" />
            @endif
            @if ($post->body)
                <meta property="og:description" content="{{ Str::limit(strip_tags($post->body), 200) }}" />
            @endif
            <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}" />
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:title" content="{{ $post->title }}" />
            @if ($post->image_path)
                <meta name="twitter:image" content="{{ asset('storage/' . $post->image_path) }}" />
            @endif
            @if ($post->body)
                <meta name="twitter:description" content="{{ Str::limit(strip_tags($post->body), 200) }}" />
            @endif
        </x-slot>
        <div class="min-h-screen bg-gray-100 py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                    <div class="flex space-x-4">
                        <button onclick="sharePost()"
                            class="text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span>Share</span>
                        </button>
                        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800">
                            ← Back to Posts
                        </a>
                    </div>
                </div>

                <!-- Post Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                    <div class="text-gray-600 text-sm mb-4">
                        By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                    </div>

                    @if ($post->image_path)
                        <div class="my-4">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                class="max-w-full h-auto rounded-lg shadow-md mx-auto">
                        </div>
                    @endif

                    @if ($post->body)
                        <p class="text-gray-700 mt-4">{{ $post->body }}</p>
                    @endif
                </div>

                <!-- Comments Section (Guest View) -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Comments ({{ $post->comments->count() }})</h3>

                    <!-- Login Prompt -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-center">
                        <p class="text-gray-700 mb-2">Want to join the conversation?</p>
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                Log in
                            </a>
                            <span class="text-gray-400">or</span>
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                Sign up
                            </a>
                        </div>
                    </div>

                    <!-- Comments List -->
                    <div class="space-y-4">
                        @forelse ($post->comments as $comment)
                            <div class="border-b pb-4 last:border-b-0">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                    <span class="text-gray-500 text-sm">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-gray-700">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <script>
            function sharePost() {
                const postUrl = '{{ route('posts.show', $post) }}';
                const postTitle = '{{ $post->title }}';

                if (navigator.share) {
                    navigator.share({
                        title: postTitle,
                        url: postUrl
                    }).catch(() => {});
                } else {
                    navigator.clipboard.writeText(postUrl).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            }
        </script>
    </x-guest-layout>
@endauth
