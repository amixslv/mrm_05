{{-- // Ja lietotājam nav atļauja tiek pārvirzīts uz citu lapu--}}
@if (auth()->user() && auth()->user()->role && auth()->user()->role->create)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $pageTitle }}
            </h2>
            <x-table>
                <tbody class="divide-y divide-gray-200">
                    @foreach($resourceSummary as $resource)
                        <tr >
                            <x-td>{{ $resource->name }}</x-td>
                            <x-td>{{ $resource->type }}</x-td>
                            <x-td>{{ $resource->status }}</x-td>
                            <x-td>{{ $resource->total_quantity }}</x-td>
                            <x-td>{{ $resource->assigned_department }}</x-td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table >
        </x-slot>
        <x-eclayout>
            <form method="POST" action="{{ route('resources.store') }}">
                @csrf
                <div class="flex flex-wrap justify-center space-x-4">
                    <div class="m-4">
                        <x-input-label for="name">Name</x-input-label>
                        <x-text-input type="text" name="name" id="name"  oninput="this.value = this.value.toUpperCase()"/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="quantity" >Quantity</x-input-label>
                        <x-text-input type="number" name="quantity" id="quantity" min="0"/>
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                    </div>
                    <div class="m-4">
                        <x-input-label for="type">Type</x-input-label>
                        <x-select name="type" id="type" >
                            <option value="" disabled selected>Select type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')"/>
                    </div>
                   
                </div>

                <div class="flex justify-end">
                    <x-button type="submit">Create</x-button>
                    <x-button type="button" onclick="window.location='{{ route('resources.index') }}'">Close</x-button>
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