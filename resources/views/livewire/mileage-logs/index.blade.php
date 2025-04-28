<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:main container>
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="#">Dashboard</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="#">Mileage Logs</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>

            <flux:tabs variant="segmented" class="w-auto! ml-2" size="sm">
                <flux:tab icon="list-bullet" icon:variant="outline" />
                <flux:tab icon="squares-2x2" icon:variant="outline" />
            </flux:tabs>
        </div>

        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Mileage Logs</flux:heading>
        </div>

        <div class="flex gap-6 mb-6">
            <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Number of Mileage Logs</flux:subheading>

                <flux:heading size="xl" class="mb-2">{{ $mileageLogs->total() }}</flux:heading>

                <div class="flex items-center gap-1 font-medium text-sm">
                    <!-- Optional extra info -->
                </div>

                <div class="absolute top-0 right-0 pr-2 pt-2">
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                </div>
            </div>
        </div>

        <div class="flex justify-end mb-4">
            <flux:button href="{{ route('mileage-logs.create') }}" variant="primary">
                New Mileage Log
            </flux:button>
        </div>

        <flux:table :paginate="$mileageLogs">
            <flux:table.columns>
                <flux:table.column></flux:table.column>

                <flux:table.column sortable :sorted="$sortBy === 'vehicle_id'" :direction="$sortDirection" wire:click="sort('vehicle_id')">
                    Vehicle
                </flux:table.column>

                <flux:table.column sortable :sorted="$sortBy === 'user_id'" :direction="$sortDirection" wire:click="sort('user_id')">
                    User
                </flux:table.column>

                <flux:table.column sortable :sorted="$sortBy === 'date'" :direction="$sortDirection" wire:click="sort('date')">
                    Date
                </flux:table.column>

                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($mileageLogs as $log)
                    <flux:table.row :key="$log->id">
                        <flux:table.cell class="pr-2">
                            <flux:checkbox />
                        </flux:table.cell>

                        <flux:table.cell class="max-md:hidden">
                            {{ optional($log->vehicle)->registration_number ?? 'Unknown' }}
                        </flux:table.cell>

                        <flux:table.cell class="max-md:hidden">
                            {{ optional($log->user)->name ?? 'Unknown' }}
                        </flux:table.cell>

                        <flux:table.cell class="max-md:hidden">
                            {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item as="a" href="{{ route('mileage-logs.edit', $log) }}" icon="receipt-refund">
                                        Edit Mileage Log
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
