@if (auth()->user()->active && auth()->user()->role)
    <x-app-layout>
        <x-slot name="header">
            <div class="mb-4 flex justify-start">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $pageTitle }}
                </h2>
            </div>
           
            <div class="mb-4 flex justify-end items-center">
                <x-text-input type="text" id="search" placeholder="Search departments..."/>
                @if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
                    <form action="{{ route('departments.create') }}" method="get" class="inline">
                        <x-button type="submit" class="dark:bg-yellow-500">Create</x-button>
                    </form>
                @endif
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
                @foreach ($departments as $department)
                    <tr>
                        @foreach ($columns as $column)
                            @if (!in_array($column, ['id', 'created_at', 'updated_at', 'user_id']))
                                <x-td>
                                    {{ $department->$column }}
                                </x-td>
                            @endif
                        @endforeach
                        <x-td>
                            {{ $department->user_name }}
                        </x-td>

                        @if (auth()->user() && auth()->user()->role && auth()->user()->role->edit)
                            <x-td>
                                <a href="{{ route('departments.edit', $department->id) }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Edit</a>
                            </x-td>
                        @endif

                        @if (auth()->user() && auth()->user()->role && auth()->user()->role->delete)
                            <x-td>
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit">Delete</x-button>
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