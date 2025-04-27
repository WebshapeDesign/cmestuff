<x-layouts.app :title="__('Vehicles')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">


    <flux:main container>
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <flux:select size="sm" class="">
                        <option>Last 7 days</option>
                        <option>Last 14 days</option>
                        <option selected>Last 30 days</option>
                        <option>Last 60 days</option>
                        <option>Last 90 days</option>
                    </flux:select>

                    <flux:subheading class="max-md:hidden whitespace-nowrap">compared to</flux:subheading>

                    <flux:select size="sm" class="max-md:hidden">
                        <option selected>Previous period</option>
                        <option>Same period last year</option>
                        <option>Last month</option>
                        <option>Last quarter</option>
                        <option>Last 6 months</option>
                        <option>Last 12 months</option>
                    </flux:select>
                </div>

                <flux:separator vertical class="max-lg:hidden mx-2 my-2" />

                <div class="max-lg:hidden flex justify-start items-center gap-2">
                    <flux:subheading class="whitespace-nowrap">Filter by:</flux:subheading>

                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">Amount</flux:badge>
                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg" class="max-md:hidden">Status</flux:badge>
                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">More filters...</flux:badge>
                </div>
            </div>

            <flux:tabs variant="segmented" class="w-auto! ml-2" size="sm">
                <flux:tab icon="list-bullet" icon:variant="outline" />
                <flux:tab icon="squares-2x2" icon:variant="outline" />
            </flux:tabs>
        </div>

        <div class="flex gap-6 mb-6">
            
                <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Number of Vehicles</flux:subheading>

                    <flux:heading size="xl" class="mb-2">12</flux:heading>

                    <div class="flex items-center gap-1 font-medium text-sm">
                        
                    </div>

                    <div class="absolute top-0 right-0 pr-2 pt-2">
                        <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                    </div>
                </div>
            
        </div>

        <div class="flex justify-end mb-4">
    <flux:button href="{{ route('vehicles.create') }}" variant="primary">
        New Vehicle
    </flux:button>
</div>

        <flux:table :paginate="$vehicles">
    <flux:table.columns>
        <flux:table.column></flux:table.column>

        <flux:table.column sortable :sorted="$sortBy === 'registration_number'" :direction="$sortDirection" wire:click="sort('registration_number')">
            Registration
        </flux:table.column>

        <flux:table.column sortable :sorted="$sortBy === 'current_mileage'" :direction="$sortDirection" wire:click="sort('current_mileage')">
            Mileage
        </flux:table.column>

        <flux:table.column sortable :sorted="$sortBy === 'condition'" :direction="$sortDirection" wire:click="sort('condition')">
            Condition
        </flux:table.column>

        <flux:table.column sortable :sorted="$sortBy === 'user_id'" :direction="$sortDirection" wire:click="sort('user_id')">
            Assignee
        </flux:table.column>

        <flux:table.column></flux:table.column>
    </flux:table.columns>

    <flux:table.rows>

        @foreach ($vehicles as $vehicle)
            <flux:table.row :key="$vehicle->id">
                <flux:table.cell class="pr-2">
                    <flux:checkbox />
                </flux:table.cell>

                <flux:table.cell class="max-md:hidden">
                    {{ $vehicle->registration_number }}
                </flux:table.cell>

                <flux:table.cell class="max-md:hidden">
                    {{ number_format($vehicle->current_mileage) }}
                </flux:table.cell>

                <flux:table.cell class="max-md:hidden">
                    <flux:badge color="green" size="sm" inset="top bottom">
                        Good
                    </flux:badge>
                </flux:table.cell>

                <flux:table.cell class="max-w-6 truncate">
                    {{ optional($vehicle->user)->name ?? 'Unassigned' }}
                </flux:table.cell>

                <flux:table.cell>
                    <flux:dropdown position="bottom" align="end" offset="-15">
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                        <flux:menu>
    <flux:menu.item as="a" href="{{ route('vehicles.show', $vehicle) }}" icon="document-text">
        View Vehicle
    </flux:menu.item>
    <flux:menu.item as="a" href="{{ route('vehicles.edit', $vehicle) }}" icon="receipt-refund">
        Edit Vehicle
    </flux:menu.item>
</flux:menu>
                    </flux:dropdown>
                </flux:table.cell>
            </flux:table.row>
        @endforeach

    </flux:table.rows>
</flux:table>


       
    </flux:main>
</div>
</x-layouts.app>
