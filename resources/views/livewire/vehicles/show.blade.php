<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:main container>
        <div class="flex justify-between items-center mb-6">
            @include('partials.breadcrumbs')
        </div>

        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Vehicle Details</flux:heading>
            <flux:button :href="route('vehicles.edit', $vehicle)" variant="primary">
                Edit Vehicle
            </flux:button>
        </div>

        <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg px-6 py-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <flux:subheading>Registration Number</flux:subheading>
                    <p class="text-sm font-medium">{{ $vehicle->registration_number }}</p>
                </div>

                <div>
                    <flux:subheading>Make</flux:subheading>
                    <p class="text-sm font-medium">{{ $vehicle->make }}</p>
                </div>

                <div>
                    <flux:subheading>Model</flux:subheading>
                    <p class="text-sm font-medium">{{ $vehicle->model ?? 'N/A' }}</p>
                </div>

                <div>
                    <flux:subheading>Year</flux:subheading>
                    <p class="text-sm font-medium">{{ $vehicle->year ?? 'N/A' }}</p>
                </div>

                <div>
                    <flux:subheading>Assigned User</flux:subheading>
                    <p class="text-sm font-medium">{{ optional($vehicle->user)->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </flux:main>
</div>
