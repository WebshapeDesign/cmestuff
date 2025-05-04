<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Mileage Log') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('mileage-logs.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-label for="vehicle_id" :value="__('Vehicle')" />
                                <select id="vehicle_id" name="vehicle_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select a vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->registration }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="week_start_date" :value="__('Week Start Date')" />
                                <x-input id="week_start_date" class="block mt-1 w-full" type="date" name="week_start_date" :value="old('week_start_date')" required />
                                <x-input-error :messages="$errors->get('week_start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="start_mileage" :value="__('Start Mileage')" />
                                <x-input id="start_mileage" class="block mt-1 w-full" type="number" name="start_mileage" :value="old('start_mileage')" required />
                                <x-input-error :messages="$errors->get('start_mileage')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="end_mileage" :value="__('End Mileage')" />
                                <x-input id="end_mileage" class="block mt-1 w-full" type="number" name="end_mileage" :value="old('end_mileage')" required />
                                <x-input-error :messages="$errors->get('end_mileage')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="notes" :value="__('Notes')" />
                                <x-textarea id="notes" class="block mt-1 w-full" name="notes">{{ old('notes') }}</x-textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('mileage-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <x-button class="ml-4">
                                {{ __('Create Mileage Log') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 