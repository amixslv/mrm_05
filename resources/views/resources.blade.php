@if (auth()->user()->active && auth()->user()->role)
    <x-app-layout>
        <x-slot name="header">
            <div class="mb-4 flex justify-start">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $pageTitle }}
                </h2>
            </div>
            <div class="mb-4 flex justify-end items-center">
                <x-text-input type="text" id="search" class="bg-gray-700 border-gray-300 rounded-md shadow-sm w-full" placeholder="Search resources..."/>
                @if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
                        <a href="{{ route('resources.create') }}" class="ml-2  bg-yellow-500 text-gray px-4 py-2 rounded-md">Create</a>
                @endif
            </div>
            <div>  
                <x-table>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($resourceSummary as $resource)
                            <tr >
                                <x-td>{{ $resource->name }}</x-td>
                                <x-td>{{ $resource->type }}</x-td>
                                <x-td>{{ $resource->status }}</x-td>
                                <x-td>{{ $resource->total_quantity }}</x-td>
                                <x-td>{{ $resource->assigned_department }}</x-td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table >
                {{-- <x-table>
                    <tbody class="divide-y divide-gray-200">      
                        @foreach($resourceTotal as $resource)
                            <tr >
                                <x-td>{{ $resource->name }}</x-td>
                                <x-td>{{ $resource->total_quantity }}</x-td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table > --}}
            </div>
           
        </x-slot>

        <x-table >
            <thead>
                
                @foreach ($columns as $column)
                    @if (!in_array($column, ['id', 'created_at', 'updated_at', 'user_id']))
                        <x-th>
                            {{ ucfirst(str_replace('_', ' ', $column)) }}
                        </x-th>
                    @endif
                @endforeach
                <x-th>
                    User Name
                </x-th>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-200">
                @foreach ($resources as $resource)
                    <tr>
                        @foreach ($columns as $column)
                            @if (!in_array($column, ['id', 'created_at', 'updated_at', 'user_id']))
                                <x-td>
                                    {{ $resource->$column }}
                                </x-td>
                            @endif
                        @endforeach
                        <x-td>
                            {{ $resource->user_name }}
                        </x-td>

                        @if (auth()->user() && auth()->user()->role->edit && (auth()->user()->role->edit || $resource->status = 'in use'))
                        <x-td>
                            <form action="{{ route('resources.edit', $resource->id) }}" method="GET">
                                @csrf
                                <x-button type="submit">Edit</x-button>
                            </form>
                        </x-td>
                        @endif
                        
                        @if (auth()->user() && auth()->user()->role && (auth()->user()->role->delete && $resource->status != 'Write off'))
                            <x-td>
                                <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" class="dark:bg-red-700">Delete</x-button>
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