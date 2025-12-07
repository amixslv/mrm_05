{{-- Ja lietotājam nav atļauja, tiek pārvirzīts uz citu lapu --}}
@if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
    <x-app-layout>
        <x-slot name="header">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ $pageTitle }}
                </h2>
            </div>
            <div>
                <x-table-layout>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($resourceSummary as $resource)
                            <tr>
                                <x-td-layout>{{ $resource->name }}</x-td-layout>
                                <x-td-layout>{{ $resource->total_quantity }}</x-td-layout>
                                <x-td-layout>{{ $resource->assigned_department }}</x-td-layout>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table-layout>
            </div>
        </x-slot>
        <x-ec>
            <form method="POST" action="{{ route('events.add-resource', $event->id) }}">
                @csrf
                <div class="flex flex-wrap justify-center space-x-4">
                    <div class="m-4">
                        <x-input-label for="resource_id" >Resource</x-input-label>
                        <x-select name="resource_id" id="resource_id">
                            <option value="" selected disabled>{{ __('Select Resource') }}</option>
                            @foreach ($enumResource as $resource)
                                <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('resource_id')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="quantity">Quantity</x-input-label>
                        <x-text-input type="number" name="quantity" id="quantity" />
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')"/>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <x-button type="submit">Add Resource</x-button>
                    <x-button type="button" onclick="window.location='{{ route('events.index') }}'">Close</x-button>
                </div>
            </form>
        </x-ec>
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
