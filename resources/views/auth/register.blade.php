<x-guest-layout>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
            <!-- Name -->
            <div class="m-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="m-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="m-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="m-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Country -->
            <div class="m-4">
                <x-input-label for="country" :value="__('Country')" />
                <x-select id="country" name="country" required>
                    <option value="">Select Country</option>
                    @foreach ($enumCountry as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>

            <!-- Structure -->
            <div class="m-4">
                <x-input-label for="structure" :value="__('Structure')" />
                <x-select id="structure" name="structure" required>
                    <option value="">Select Structure</option>
                    @foreach ($enumStructure as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('structure')" class="mt-2" />
            </div>

            <!-- Sub Structure -->
            <div class="m-4">
                <x-input-label for="sub_structure" :value="__('Sub Structure')" />
                <x-select id="sub_structure" name="sub_structure" required>
                    <option value="">Select Sub Structure</option>
                    @foreach ($enumSubStructure as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('sub_structure')" class="mt-2" />
            </div>
        
        
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
   
</x-guest-layout>
