{{-- // Lapa tiek rādīta tikai reģistrētiel neaktīviem vai bez limas lietotājiem--}}

@if (!auth()->user()->active || !auth()->user()->role)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Idle space') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("You're logged in!") }} <br>
                        {{ __("Wait for the rights to be granted!") }}
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-end">
                        {{ __("Don't want to wait! Press") }}
                        <form class="ml-2 text-red-500" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">{{ __('Log Out!') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </x-app-layout>
@else
    @php
    header("Location: " . route('resources.index'));
    exit();
    @endphp
@endif
