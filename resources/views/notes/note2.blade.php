<x-app-layout>
    <x-slot name="title">Blade Templates - Notes</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blade Templates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('notes.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                    ← Back to Notes
                </a>

                <article class="prose max-w-none">
                    <h1>Blade Templates</h1>

                    <h2>Layouts</h2>
                    <p>Blade uses layout inheritance. The <code>&lt;x-app-layout&gt;</code> component wraps your
                        content.</p>

                    <h2>Components</h2>
                    <p>Jetstream provides reusable components:</p>
                    <ul>
                        <li><code>&lt;x-button&gt;</code> - Styled buttons</li>
                        <li><code>&lt;x-nav-link&gt;</code> - Navigation links with active state</li>
                        <li><code>&lt;x-dropdown&gt;</code> - Dropdown menus</li>
                    </ul>

                    <h2>Slots</h2>
                    <p>Pass content to components using slots:</p>
                    <pre><code>&lt;x-slot name="header"&gt;
    &lt;h2&gt;Page Title&lt;/h2&gt;
&lt;/x-slot&gt;</code></pre>

                    <h2>Directives</h2>
                    <p>Common Blade directives:</p>
                    <ul>
                        <li><code>@@if</code>, <code>@@else</code>,
                            <code>@@endif</code>
                        </li>
                        <li><code>@@foreach</code>, <code>@@endforeach</code></li>
                        <li><code>@@auth</code>, <code>@@guest</code></li>
                        <li><code>@@csrf</code> - CSRF token for forms</li>
                    </ul>
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
