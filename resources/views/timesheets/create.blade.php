<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Timesheet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('timesheets.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-label for="week_start_date" :value="__('Week Start Date')" />
                                <x-input id="week_start_date" class="block mt-1 w-full" type="date" name="week_start_date" :value="old('week_start_date')" required />
                                <x-input-error :messages="$errors->get('week_start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="notes" :value="__('Notes')" />
                                <x-textarea id="notes" class="block mt-1 w-full" name="notes">{{ old('notes') }}</x-textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('timesheets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <x-button class="ml-4">
                                {{ __('Create Timesheet') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 