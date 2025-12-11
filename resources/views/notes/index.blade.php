<x-app-layout>
    <x-slot name="title">Notes</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">My Learning Notes</h3>

                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('notes.show', 'note1') }}"
                            class="text-blue-600 hover:text-blue-800 hover:underline">
                            📝 Laravel Basics
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notes.show', 'note2') }}"
                            class="text-blue-600 hover:text-blue-800 hover:underline">
                            📝 Blade Templates
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notes.show', 'ictandislam_w7') }}"
                            class="text-blue-600 hover:text-blue-800 hover:underline">
                            👀 ICT and Islam W7
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notes.show', 'iai_assignment') }}"
                            class="text-blue-600 hover:text-blue-800 hover:underline">
                            🖇️ ICT and Islam Assignment
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
