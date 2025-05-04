<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:main container>
        <div class="flex justify-between items-center mb-6">
            @include('partials.breadcrumbs')
        </div>

        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Edit Vehicle</flux:heading>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input label="Registration Number" required>
                    <input type="text" wire:model="vehicle.registration_number" class="input" />
                    @error('vehicle.registration_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </flux:input>

                <flux:input label="Make" required>
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
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    Update Vehicle
                </flux:button>
            </div>
        </form>
    </flux:main>
</div>
