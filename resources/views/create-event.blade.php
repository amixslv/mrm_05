{{-- // Ja lietotājam nav atļauja tiek pārvirzīts uz citu lapu--}}
@if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $pageTitle }}
            </h2>
        </x-slot>
        <x-eclayout>
            <form method="POST" action="{{ route('events.store') }}">
                @csrf
                <div class="flex flex-wrap justify-center space-x-4">
                    <div class="m-4">
                        <x-input-label for="name">Name</x-input-label>
                        <x-text-input type="text" name="name" id="name"  oninput="this.value = this.value.toUpperCase()"/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="responsible_department">Responsible Department</x-input-label>
                        <x-select name="responsible_department" id="responsible_department">
                            <option value="" disabled selected>Select department</option>
                            @foreach($enumDep as $department)
                                <option value="{{ $department->name }}">{{ $department->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('responsible_department')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="start_date_time">Start Date & Time</x-input-label>
                        <x-text-input type="datetime-local" name="start_date_time" id="start_date_time" />
                        <x-input-error class="mt-2" :messages="$errors->get('start_date_time')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="end_date_time">End Date & Time</x-input-label>
                        <x-text-input type="datetime-local" name="end_date_time" id="end_date_time"/>
                        <x-input-error class="mt-2" :messages="$errors->get('end_date_time')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="status">Status</x-input-label>
                        <x-select name="status" id="status">
                            <option value="" disabled selected>Select status</option>
                            @foreach($enumStatus as $status)
                                <option value="{{ $status}}">{{ $status }}</option>
                            @endforeach
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </x-select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit">Create</x-button>
                    <x-button type="button" onclick="window.location='{{ route('events.index') }}'">Close</x-button>
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