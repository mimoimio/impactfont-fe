<x-app-layout>
    <x-slot name="title">ICTnIslam W7</x-slot>
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
                    <h1>ICT and Islam Week 7: Topic 5</h1>

                    <h2>Preparedness of ICT Students</h2>
                    {{-- <p>Blade uses layout inheritance. The <code>&lt;x-app-layout&gt;</code> component wraps your
                        content.</p> --}}

                    <h2>Understanding Business Processes and Automation</h2>
                    <h2>Slots</h2>
                    <p>Pass content to components using slots:</p>
                    <ul>
                        <li>
                            <p>

                            </p>
                        </li>
                    </ul>
                    <h2>Latest Technologies in Data Management</h2>
                    <p>Using our knowledge of the current technologies to create solutions</p>

                    <h2>Infostructure: The Foundation of Modern Society</h2>

                    <h2>Check out Italeem</h2>
                    <p>for the PDF</p>

                    <h2>The Individual Assignments</h2>
                    <p>25 marks</p>
                    <p>A set of topics, 20 topics</p>
                    <ol>
                        <li>
                            <h4> Design a poster</h4>
                            <p>Choose one of the topic to do poster promoting it</p>
                        </li>
                        <li>
                            <h4> Short video (15 marks)</h4>
                            <p>2-4 minutes. can submit on any platforms, but finally to Italeem
                            </p>
                        </li>
                    </ol>
                    <h2>The Group Assignments (20%)</h2>
                    <p>CHECK ITALEEM documents</p>
                    <p>Not yet due, but later weeks</p>
                    <ol>
                        <li>
                            <h4>Propose</h4>
                            <p>According to necessities of the Ummah</p>
                        </li>
                        <li>
                            <h4> Short video (15 marks)</h4>
                            <p>2-4 minutes. can submit on any platforms, but finally to Italeem
                            </p>
                        </li>
                    </ol>

                    <h2>Complete your assignments!</h2>
                    <p>due 21 Nov</p>
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
