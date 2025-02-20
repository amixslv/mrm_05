@if (auth()->user() && auth()->user()->role && auth()->user()->role->edit)
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $pageTitle }}
            </h2>
        </x-slot>
        <x-eclayout>
            <form method="POST" action="{{ route('resources.update',$resource->id) }}">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap justify-center space-x-4">
                    <div class="m-4">
                        <x-input-label for="name">Name</x-input-label>
                        <x-text-input type="text" name="name" id="name" value="{{ $resource->name }}" oninput="this.value = this.value.toUpperCase()"/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="quantity" >Quantity</x-input-label>
                        <x-text-input type="number" name="quantity" id="quantity" value="{{ $resource->quantity }}" min="0"/>
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="type" >Type</x-input-label>
                        <x-select name="type" id="type">
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ $resource->type == $type ? 'selected' :  '' }}>{{ $type }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')"/>
                    </div>
                    <div class="m-4">
                        <x-input-label for="status">Status</x-input-label>
                        <x-select name="status" id="status">
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ $resource->status == $status ? 'selected' :  '' }}>{{ $status }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')"/>
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md">Update</x-button>
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