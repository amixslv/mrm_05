@if (auth()->user() && auth()->user()->role->edit)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ $pageTitle }}
            </h2>
        </x-slot>

        <x-ec>
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap justify-center space-x-4">
                    <div class="m-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" :value="$user->name" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="name" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" :value="$user->email" required autocomplete="email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="role_id" :value="__('Role')" />
                        <x-select name="role_id" id="role_id" :value="$user->role_id">
                            @if(!$user->role_id)
                                <option value="" selected disabled>{{ __('Select role') }}</option>
                            @endif
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                    {{ $role->role }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    </div>

                    <div class="m-4">
                        <x-input-label for="active" :value="__('Active')"/>
                        <x-checkbox id="active" name="active" :checked="$user->active"/>
                        <x-input-error class="mt-2" :messages="$errors->get('active')" />
                    </div>
                </div>
                <div class="flex flex-wrap justify-center space-x-3">
                    <div class="m-4">
                        <x-input-label for="country" :value="__('Country')" />
                        <x-select id="country" name="country">
                            @foreach($enumCountry as $value)
                                <option value="{{ $value }}" {{ $user->country == $value ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('country')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="structure" :value="__('Structure')" />
                        <x-select id="structure" name="structure">
                            @foreach($enumStructure as $value)
                                <option value="{{ $value }}" {{ $user->structure == $value ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('structure')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="sub_structure" :value="__('Sub Structure')" />
                        <x-select id="sub_structure" name="sub_structure">
                            @foreach($enumSubStructure as $value)
                                <option value="{{ $value }}" {{ $user->sub_structure == $value ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('sub_structure')" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-button type="submit">Update</x-button>
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
