@if (auth()->user() && auth()->user()->role->edit)
    <x-app-layout>
        <x-slot name="header">
            <div class="mb-4 flex justify-start">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $pageTitle }}
                </h2>
            </div>
            <div>
                <x-table>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($events as $event)
                            <tr >
                                <x-td>{{ $event->name }}</x-td>
                                <x-td>{{ $event->responsible_department }}</x-td>
                                <x-td>{{ $event->start_date_time }}</x-td>
                                <x-td>{{ $event->end_date_time }}</x-td>
                                <x-td>{{ $event->status }}</x-td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table >
                
            </div>
        </x-slot>

        <x-eclayout>
            <form method="POST" action="{{ route('events.update', $event->id) }}">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap justify-center space-x-4">
                    <div class="m-4">                            
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" :value="$event->name" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>                        
                    <div class="m-4">
                        <x-input-label for="responsible_department" :value="__('Responsible Department')" />
                        <x-select name="responsible_department" id="responsible_department">
                            @if(!$event->responsible_department)
                                <option value="" selected disabled>{{ __('Select department') }}</option>
                            @endif
                            @foreach($enumDep as $department)
                                <option value="{{ $department->name }}" {{ $department->name == $event->responsible_department ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('responsible_department')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="start_date_time" :value="__('Start Date & Time')" />
                        <x-text-input id="start_date_time" name="start_date_time" type="datetime-local" :value="$event->start_date_time" required />
                        <x-input-error class="mt-2" :messages="$errors->get('start_date_time')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="end_date_time" :value="__('End Date & Time')" />
                        <x-text-input id="end_date_time" name="end_date_time" type="datetime-local" :value="$event->end_date_time" required />
                        <x-input-error class="mt-2" :messages="$errors->get('end_date_time')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <x-select name="status" id="status">
                            @if(!$event->status)
                                <option value="" selected disabled>{{ __('Select status') }}</option>
                            @endif
                            @foreach($enumStatus as $status)
                                <option value="{{ $status }}" {{ $status == $event->status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
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
