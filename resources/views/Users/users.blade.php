{{-- // Ja lietotājam nav atļauja tiek pārvirzīts uz citu lapu--}}
@if (auth()->user() && (auth()->user()->role->role === 'Admin' || auth()->user()->role->can_assign_roles))   
    <x-app-layout>
        <x-slot name="header">
            <div class="mb-4 flex justify-start">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $pageTitle }}
                </h2>
            </div>
            <div class="flex justify-end">
                <x-button type="button" onclick="window.location='{{ route('departments.index') }}'">Department</x-button>
            </div>
            <div class="mb-4 flex justify-end items-center">
                <x-text-input id="search" placeholder="Search users..."/>                    
            </div>
        </x-slot>
        <x-table class="highlight-rows">
            <thead>
                @foreach ($columns as $column)
                    @if (!in_array($column, ['id', 'created_at', 'updated_at', 'email_verified_at', 'password', 'remember_token', 'country', 'structure', 'sub_structure', 'roleid', 'role_id']))
                        <x-th>
                            {{ ucfirst(str_replace('_', ' ', $column)) }}
                        </x-th>
                    @endif
                @endforeach
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        @foreach ($columns as $column)
                            @if (!in_array($column, ['id', 'created_at', 'updated_at', 'email_verified_at', 'password', 'remember_token', 'country', 'structure', 'sub_structure', 'roleid', 'role_id']))
                                <x-td>
                                    @if (is_bool($user->$column) || is_numeric($user->$column))
                                            {{ $user->$column ? 'Yes' : 'No' }}
                                            @elseif ($column === 'role')
                                            {{ $user->role ? $user->role->role : 'No Role Assigned' }}
                                        @else
                                            {{ $user->$column }}
                                        @endif
                                </x-td>
                            @endif
                        @endforeach
                        @if (auth()->user() && auth()->user()->role->edit)
                        <x-td>
                            <form action="{{ route('users.edit', $user->id) }}" method="GET">
                                @csrf
                                <x-button type="submit">Edit</x-button>
                            </form>
                        </x-td>
                        @endif
                        @if (auth()->user() && auth()->user()->role->delete)
                        <x-td>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" class="dark:bg-red-700">Delete</x-button>
                            </form>
                            
                        </x-td>                                    
                        @endif
                    </tr>
                @endforeach
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