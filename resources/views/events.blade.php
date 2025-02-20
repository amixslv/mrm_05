@if (auth()->user()->active && auth()->user()->role)
    <x-app-layout>
        <x-slot name="header">
            <div class="mb-4 flex justify-start">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $pageTitle }}
                </h2>
            </div>
            <div class="mb-4 flex justify-end items-center">
                <x-text-input type="text" id="search" class="bg-gray-700 border-gray-300 rounded-md shadow-sm w-full" placeholder="Search events..."/>
                @if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
                <form action="{{ route('events.create') }}" method="get" class="inline">
                    <x-button type="submit" class="dark:bg-yellow-500">Create</x-button>
                </form>
                <form action="{{ route('events.print') }}" method="get" class="inline">
                    <x-button type="submit" class="dark:bg-blue-500 ml-2">Print</x-button>
                </form>
                @endif                       
            </div>
        </x-slot>
        <x-table>
            <thead>
                <tr>
                    <x-th>Name</x-th>
                    <x-th>Responsible Department</x-th>
                    <x-th>Start Date & Time</x-th>
                    <x-th>End Date & Time</x-th>
                    <x-th>Status</x-th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-200">
                @foreach ($events as $event)
                    <tr>
                        <x-td>{{ $event->name }}</x-td>
                        <x-td>{{ $event->responsible_department }}</x-td>
                        <x-td>{{ $event->start_date_time }}</x-td>
                        <x-td>{{ $event->end_date_time }}</x-td>
                        <x-td>{{ $event->status }}</x-td>

                        <x-td>
                            @if (auth()->user() && auth()->user()->role->edit)
                                <form action="{{ route('events.edit', $event->id) }}" method="GET">
                                    @csrf
                                    <x-button type="submit">Edit</x-button>
                                </form>
                            @endif
                        </x-td>
                        <x-td>
                            @if (auth()->user() && auth()->user()->role->delete)  
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" class="dark:bg-red-700">Delete</x-button>
                                </form>
                            @endif
                        </x-td>
                    </tr>
                    <tr>
                        <x-td>
                            @foreach ($event->resources as $resource)
                            <div class="resource-item">
                                <p>{{ $resource->name }} - {{ $resource->quantity }}</p>
                                @if ($resource->type === 'Ammo')
                                    <x-input-label for="remaining_quantity_{{ $resource->quantity }}">Enter the remaining ammo:</x-input-label>
                                    <x-text-input type="number" id="remaining_quantity_{{ $resource->quantity }}" name="remaining_quantity_{{ $resource->quantity }}" min="0" max="{{ $resource->quantity }}"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('remaining_quantity_{{ $resource->quantity }}')"/>
                                @endif
                                
                            </div>
                        @endforeach
                        </x-td>
                        
                            @if (auth()->user() && auth()->user()->role->edit)
                                <x-td>
                                    <form action="{{ route('events.add-resource', $event->id) }}" method="GET">
                                        @csrf
                                        <x-button type="submit">Add Resource</x-button>
                                    </form>
                                </x-td>
                                <x-td>
                                    <form action="{{ route('events.return-resources', $event->id) }}" method="POST" class="inline">
                                        @csrf
                                        <x-button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md">Return Resources</x-button>
                                    </form>
                                </x-td>
                            @endif
                    </tr>
                @endforeach
            </tbody>
        </x-table>
        @vite(['resources/js/Search.js','resources/js/Delete.js','resources/js/highlightRows.js']) 
    </x-app-layout>
@else
    @php
    header("Location: " . route('dashboard'));
    exit();
    @endphp
@endif
