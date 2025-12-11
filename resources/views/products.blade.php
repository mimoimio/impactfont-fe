<x-app-layout>
    <x-slot name="title">
        My Products!!!
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg  scroll">
                @foreach ($items as $item)
                    <div class="p-6 sm:px-20 max-w-sm bg-blue-200 border-b border-gray-900">
                        <div class="h-2 mt-8 font-bold text-xl">
                            {{ $item['name'] }}
                        </div>
                        <div class="mt-8 text-sm">
                            RM {{ $item['price'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
