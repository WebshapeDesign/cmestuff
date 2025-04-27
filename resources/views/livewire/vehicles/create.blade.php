<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow">
    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Registration Field -->
        <x-input label="Registration" wire:model="registration" placeholder="Enter registration..." />

        <!-- Starting Mileage -->
        <x-input label="Starting Mileage" type="number" wire:model="starting_mileage" placeholder="Enter starting mileage..." />

        <!-- Make -->
        <x-select label="Make" wire:model="make">
            <option value="">Select Make</option>
            @foreach($makes as $makeOption)
                <option value="{{ $makeOption }}">{{ $makeOption }}</option>
            @endforeach
        </x-select>

        <!-- Model -->
        <x-select label="Model" wire:model="model">
            <option value="">Select Model</option>
            @foreach($models as $modelOption)
                <option value="{{ $modelOption }}">{{ $modelOption }}</option>
            @endforeach
        </x-select>

        <!-- Current Mileage -->
        <x-input label="Current Mileage" type="number" wire:model="current_mileage" placeholder="Enter current mileage..." />

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
