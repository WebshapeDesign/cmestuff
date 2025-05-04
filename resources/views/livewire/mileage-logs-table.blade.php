<div>
    <div class="flex flex-col gap-4">
        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-4">
            <flux:dropdown
                wire:model="filters.dateRange"
                :options="[
                    '7' => 'Last 7 days',
                    '14' => 'Last 14 days',
                    '30' => 'Last 30 days',
                    '60' => 'Last 60 days',
                    '90' => 'Last 90 days',
                ]"
            />
            <flux:dropdown
                wire:model="filters.comparisonPeriod"
                :options="[
                    'previous' => 'Previous period',
                    'last_year' => 'Same period last year',
                    'custom' => 'Custom period',
                ]"
            />
            <flux:dropdown
                wire:model="filters.vehicle"
                :options="$vehicles->pluck('registration', 'id')"
                placeholder="Filter by Vehicle"
            />
            <flux:dropdown
                wire:model="filters.driver"
                :options="$drivers->pluck('name', 'id')"
                placeholder="Filter by Driver"
            />
            <flux:dropdown
                wire:model="filters.status"
                :options="[
                    'completed' => 'Completed',
                    'pending' => 'Pending',
                    'cancelled' => 'Cancelled',
                ]"
                placeholder="Filter by Status"
            />
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($stats as $stat)
                <flux:card>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-gray-500">{{ $stat['title'] }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-semibold">{{ $stat['value'] }}</span>
                            <flux:badge
                                :color="$stat['trendUp'] ? 'green' : 'red'"
                                :icon="$stat['trendUp'] ? 'arrow-up' : 'arrow-down'"
                            >
                                {{ $stat['trend'] }}
                            </flux:badge>
                        </div>
                    </div>
                </flux:card>
            @endforeach
        </div>

        <!-- Table -->
        <flux:table>
            <flux:table.head>
                <flux:table.checkbox wire:model="selectedLogs" />
                <flux:table.column name="id" hidden />
                <flux:table.column name="date" />
                <flux:table.column name="vehicle" hidden />
                <flux:table.column name="driver" hidden />
                <flux:table.column name="mileage" />
                <flux:table.column name="status" />
                <flux:table.column name="actions" />
            </flux:table.head>
            <flux:table.body>
                @foreach($logs as $log)
                    <flux:table.row>
                        <flux:table.cell>
                            <flux:checkbox wire:model="selectedLogs" :value="$log->id" />
                        </flux:table.cell>
                        <flux:table.cell hidden>{{ $log->id }}</flux:table.cell>
                        <flux:table.cell>{{ $log->date->format('d/m/Y') }}</flux:table.cell>
                        <flux:table.cell hidden>
                            <div class="flex items-center gap-2">
                                <flux:avatar :src="$log->vehicle->avatar_url" />
                                <span>{{ $log->vehicle->registration }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell hidden>
                            <div class="flex items-center gap-2">
                                <flux:avatar :src="$log->user->avatar_url" />
                                <span>{{ $log->user->name }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>{{ number_format($log->total_mileage) }} miles</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$log->status_color">
                                {{ ucfirst($log->status) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:dropdown.item
                                    wire:click="$dispatch('open-modal', { component: 'mileage-logs.view', arguments: { log: {{ $log->id }} } })"
                                >
                                    View
                                </flux:dropdown.item>
                                <flux:dropdown.item
                                    wire:click="$dispatch('open-modal', { component: 'mileage-logs.edit', arguments: { log: {{ $log->id }} } })"
                                >
                                    Edit
                                </flux:dropdown.item>
                                <flux:dropdown.item
                                    wire:click="$dispatch('open-modal', { component: 'mileage-logs.delete', arguments: { log: {{ $log->id }} } })"
                                    class="text-red-600"
                                >
                                    Archive
                                </flux:dropdown.item>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.body>
        </flux:table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div> 