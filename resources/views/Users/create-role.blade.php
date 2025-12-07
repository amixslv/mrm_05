{{-- // Ja lietotājam nav atļauja tiek pārvirzīts uz citu lapu--}}
@if (auth()->user() && auth()->user()->role->create)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ $pageTitle }}
            </h2>
            <p class="text-gray-800 pl-7 dark:text-gray-200">
                Active - to allow this right to be granted to the user
            </p>
            <p class="text-gray-800 pl-7 dark:text-gray-200">
                Can be assigned roles – to allow user and role views
            </p>
            <p class="text-gray-800 pl-7 dark:text-gray-200">
                Create - to allow the user group to create new records
            </p>
            <p class="text-gray-800 pl-7 dark:text-gray-200">
                Edit - to allow the user group to edit records
            </p>
            <p class="text-gray-800 pl-7 dark:text-gray-200">
                Delete - to allow the user group to delete records
            </p>
            <p class="text-gray-800 pl-7 dark:text-gray-200">
                Cleaner - Access to resources with status - Maintenance (additionally requires edit rights)
            </p>
        </x-slot>
        <x-ec>
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="flex flex-wrap justify-center space-x-4 ">
                    <div class="m-4">
                        <x-input-label for="role">Role</x-input-label>
                        <x-text-input type="text" name="role" id="role" required autofocus/>
                        <x-input-error class="mt-2" :messages="$errors->get('role')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="active">Active</x-input-label>
                        <x-checkbox type="checkbox" name="active" id="active"/>
                        <x-input-error class="mt-2" :messages="$errors->get('active')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="can_assign_roles">Can Assign Roles</x-input-label>
                        <x-checkbox type="checkbox" name="can_assign_roles" id="can_assign_roles"/>
                        <x-input-error class="mt-2" :messages="$errors->get('can cssign roles')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="create">Create</x-input-label>
                        <x-checkbox type="checkbox" name="create" id="create"/>
                        <x-input-error class="mt-2" :messages="$errors->get('create')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="edit">Edit</x-input-label>
                        <x-checkbox type="checkbox" name="edit" id="edit"/>
                        <x-input-error class="mt-2" :messages="$errors->get('edit')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="delete">Delete</x-input-label>
                        <x-checkbox type="checkbox" name="delete" id="delete"/>
                        <x-input-error class="mt-2" :messages="$errors->get('delete')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="cleaner">Cleaner</x-input-label>
                        <x-checkbox type="checkbox" name="cleaner" id="cleaner"/>
                        <x-input-error class="mt-2" :messages="$errors->get('cleaner')" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit">Create</x-button>
                </div>
            </form>

        </x-ec>
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
