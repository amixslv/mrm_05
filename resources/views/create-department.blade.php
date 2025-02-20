{{-- // Ja lietotājam nav atļauja tiek pārvirzīts uz citu lapu--}}
@if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $pageTitle }}
            </h2>
        </x-slot>
        <x-eclayout>
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="flex flex-wrap justify-center space-x-4">
                    <div class="m-4">
                        <x-input-label for="name">Name</x-input-label>
                        <x-select name="name" id="name">
                            <option value="" disabled selected>Select department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department}}">{{ $department }}</option>
                            @endforeach
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </x-select>
                    </div>
                    <div class="m-4">
                        <x-input-label for="description" >Description</x-input-label>
                        <x-textarea name="description" id="description"  required>{{ old('description') }}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit">Create</x-button>
                    <x-button type="button" onclick="window.location='{{ route('departments.index') }}'">Close</x-button>
                </div>
                
            </form>
        </x-eclayout>
    </x-app-layout>
@else
    @if (!auth()->user()->active && !auth()->user()->role)
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

@endif