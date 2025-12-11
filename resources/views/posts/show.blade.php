@auth
    <x-app-layout>
        <x-slot name="title">{{ $post->title }}</x-slot>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $post->title }}
                </h2>
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Posts
                </a>
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
    </x-app-layout>
@else
    <x-guest-layout>
        <div class="min-h-screen bg-gray-100 py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                    <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800">
                        ← Back to Posts
                    </a>
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
    </x-guest-layout>
@endauth
