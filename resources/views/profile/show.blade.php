<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <!-- My Posts Section -->

            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 flex justify-between">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium text-gray-900">My Posts</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Manage your meme posts.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                            @if (auth()->user()->posts->isEmpty())
                                <p class="text-gray-500 text-center py-4">You haven't created any posts yet.</p>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 space-y-4">
                                    @foreach (auth()->user()->posts as $post)
                                        <div
                                            class="flex items-start justify-between border-b pb-4 last:border-b-0 last:pb-0">
                                            <div class="flex-1">
                                                @if ($post->image_path)
                                                    <img src="{{ asset('storage/' . $post->image_path) }}"
                                                        alt="{{ $post->title }}"
                                                        class="w-32 h-32 object-cover rounded mb-2">
                                                @endif
                                                <h4 class="font-semibold text-gray-900">{{ $post->title }}</h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $post->created_at->format('M d, Y') }}
                                                </p>
                                                @if ($post->body)
                                                    <p class="text-sm text-gray-600 mt-2">
                                                        {{ Str::limit($post->body, 100) }}</p>
                                                @endif
                                            </div>

                                            <!-- Dropdown Actions -->
                                            <div class="ml-4" x-data="{ open: false }">
                                                <button @click="open = !open"
                                                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                    </svg>
                                                </button>

                                                <div x-show="open" @click.away="open = false"
                                                    class="relative right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                                    <a href="{{ route('posts.edit', $post) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        Edit Post
                                                    </a>
                                                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                            Delete Post
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <x-section-border />

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
