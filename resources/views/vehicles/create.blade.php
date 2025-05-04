<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Vehicle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('vehicles.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-label for="registration" :value="__('Registration')" />
                                <x-input id="registration" class="block mt-1 w-full" type="text" name="registration" :value="old('registration')" required />
                                <x-input-error :messages="$errors->get('registration')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="make" :value="__('Make')" />
                                <x-input id="make" class="block mt-1 w-full" type="text" name="make" :value="old('make')" required />
                                <x-input-error :messages="$errors->get('make')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="model" :value="__('Model')" />
                                <x-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model')" required />
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="year" :value="__('Year')" />
                                <x-input id="year" class="block mt-1 w-full" type="number" name="year" :value="old('year')" required />
                                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="user_id" :value="__('Assign to User')" />
                                <select id="user_id" name="user_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Select a user</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('vehicles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <x-button class="ml-4">
                                {{ __('Add Vehicle') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 