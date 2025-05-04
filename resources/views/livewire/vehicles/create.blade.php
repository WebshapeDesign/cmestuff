<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow">
    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Registration Field -->
        <flux:input label="Registration Number" required>
                    <input type="text" wire:model="vehicle.registration_number" class="input" />
                    @error('vehicle.registration_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </flux:input>
                
        <!-- Starting Mileage -->
        <flux:input label="Starting Mileage">
                    <input type="number" wire:model="vehicle.starting_mileage" class="input" />
                    @error('vehicle.starting_mileage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </flux:input>

        <flux:input label="Make">
                    <input type="text" wire:model="vehicle.make" class="input" />
                    @error('vehicle.make') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </flux:input>

                <flux:input label="Model">
                    <input type="text" wire:model="vehicle.model" class="input" />
                    @error('vehicle.model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </flux:input>

                <flux:input label="Year">
                    <input type="number" wire:model="vehicle.year" class="input" />
                    @error('vehicle.year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </flux:input>

        <!-- User Assignment -->
        <x-select label="Assigned User" wire:model="user_id">
            <option value="">No user assigned</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </x-select>

        <!-- Save Button -->
        <x-button type="submit" class="w-full">
            Save Vehicle
        </x-button>
    </form>
</div>
