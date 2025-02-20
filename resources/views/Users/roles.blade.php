@if (auth()->user() && (auth()->user()->role->role === 'Admin' || auth()->user()->role->can_assign_roles))
    <x-app-layout>
        <x-slot name="header">
            <div class="mb-4 flex justify-start">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $pageTitle }}
                </h2></div>
            <div class="mb-4 flex justify-end items-center">
                <x-text-input type="text" id="search" placeholder="Search roles..."/>
                @if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
                    <form action="{{ route('roles.create') }}" method="get" class="inline">
                        <x-button type="submit" class="dark:bg-yellow-500">Create</x-button>
                    </form>
                @endif
            </div>
        </x-slot>
        
            <x-table  id="roles">
                <thead>
                    <tr>
                        @foreach ($columns as $column)
                            @if (!in_array($column, ['id', 'created_at', 'updated_at'])) 
                                <x-th>{{ ucfirst(str_replace('_', ' ', $column)) }}</x-th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-200">
                    @foreach ($roles as $role)
                        <tr>
                            @foreach ($columns as $column)
                                @if (!in_array($column, ['id', 'created_at', 'updated_at']))
                                    <x-td>
                                        @if (is_bool($role->$column) || is_numeric($role->$column))
                                            {{ $role->$column ? 'Yes' : 'No' }}
                                        @elseif ($column === 'user_count')
                                            {{ $role->users_count }}
                                        @else
                                            {{ $role->$column }}
                                        @endif
                                    </x-td>
                                @endif
                            @endforeach
                            @if (auth()->user() && auth()->user()->role->edit)
                            <x-td>
                                <form action="{{ route('roles.edit', $role->id) }}" method="GET">
                                    @csrf
                                    <x-button type="submit">Edit</x-button>
                                </form>
                            </x-td>
                            @endif
                            @if (auth()->user() && auth()->user()->role->delete)
                            <x-td>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirmDelete()">
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
@elseif (!auth()->user()->active || !auth()->user()->role)
        @php
        header("Location: " . route('dashboard'));
        exit();
        @endphp
@else
        @php
        header("Location: " . route('resources.index'));
        exit();
        @endphp
@endif