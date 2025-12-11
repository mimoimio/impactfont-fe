<x-app-layout>
    <x-slot name="title">Laravel Basics - Notes</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laravel Basics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('notes.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                    ← Back to Notes
                </a>

                <article class="prose max-w-none">
                    <h1>Laravel Basics</h1>

                    <h2>Routes</h2>
                    <p>Routes are defined in <code>routes/web.php</code>. Basic syntax:</p>
                    <pre><code>Route::get('/path', function() {
    return view('viewname');
})->name('route.name');</code></pre>

                    <h2>Views</h2>
                    <p>Views are stored in <code>resources/views/</code> and use Blade templating engine.</p>
                    <ul>
                        {{-- <li>Use <code>{{ $variable }}</code> to echo escaped content</li> --}}
                        {{-- <li>Use <code>{!! $html !!}</code> for unescaped HTML</li> --}}
                        <li>Use <code>@@if</code>, <code>@@foreach</code>, etc. for
                            control structures</li>
                    </ul>

                    <h2>Middleware</h2>
                    <p>Middleware filters HTTP requests. The auth middleware protects routes from unauthenticated users.
                    </p>
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
