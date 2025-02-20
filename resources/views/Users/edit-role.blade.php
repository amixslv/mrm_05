@if (auth()->user()&& auth()->user()->role->edit)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $pageTitle }}
            </h2>
            <p class="pl-7 text-gray-800 dark:text-gray-200">
                Active - to allow this right to be granted to the user
            </p>
            <p class="pl-7 text-gray-800 dark:text-gray-200">
                Can be assigned roles – to allow user and role views
            </p>
            <p class="pl-7 text-gray-800 dark:text-gray-200">
                Create - to allow the user group to create new records
            </p>
            <p class="pl-7 text-gray-800 dark:text-gray-200">
                Edit - to allow the user group to edit records
            </p>
            <p class="pl-7 text-gray-800 dark:text-gray-200">
                Delete - to allow the user group to delete records
            </p>
            <p class="pl-7 text-gray-800 dark:text-gray-200">
                Cleaner - Access to resources with status - Maintenance (additionally requires edit rights)
            </p>
        </x-slot>
            <x-eclayout>
                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    <div class=" flex flex-wrap justify-center space-x-4">
                        <div class="m-4">
                            <x-input-label for="role">Role</x-input-label>
                            <x-text-input type="text" name="role" id="role" :value="$role->role" readonly/>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>
                        <div class="m-4">
                            <x-input-label for="active" >Active</x-input-label>
                            <x-checkbox type="checkbox" name="active" id="active" :checked="$role->active"/>
                            <x-input-error class="mt-2" :messages="$errors->get('active')" />
                        </div>
                        <div class="m-4">
                            <x-input-label for="can_assign_roles" >Can Assign Roles</x-input-label>
                            <x-checkbox type="checkbox" name="can_assign_roles" id="can_assign_roles" :checked="$role->can_assign_role"/>
                            <x-input-error class="mt-2" :messages="$errors->get('can cssign roles')" />
                        </div>
                        <div class="m-4">
                            <x-input-label for="create" >Create</x-input-label>
                            <x-checkbox type="checkbox" name="create" id="create" :checked="$role->create"/>
                            <x-input-error class="mt-2" :messages="$errors->get('create')" />
                        </div>
                        <div class="m-4">
                            <x-input-label for="edit" >Edit</x-input-label>
                            <x-checkbox type="checkbox" name="edit" id="edit" :checked="$role->edit"/>
                            <x-input-error class="mt-2" :messages="$errors->get('edit')" />
                        </div>
                        <div class="m-4">
                            <x-input-label for="delete">Delete</x-input-label>
                            <x-checkbox type="checkbox" name="delete" id="delete" :checked="$role->delete"/>
                            <x-input-error class="mt-2" :messages="$errors->get('delete')" />
                        </div>
                        <div class="m-4">
                            <x-input-label for="cleaner">Cleaner</x-input-label>
                            <x-checkbox type="checkbox" name="cleaner" id="cleaner" :checked="$role->cleaner"/>
                            <x-input-error class="mt-2" :messages="$errors->get('cleaner')" />
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <x-button type="submit">Update</x-button>
                    </div>
                </form>
            </x-eclayout>
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