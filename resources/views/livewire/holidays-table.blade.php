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
                wire:model="filters.status"
                :options="[
                    'approved' => 'Approved',
                    'pending' => 'Pending',
                    'rejected' => 'Rejected',
                ]"
                placeholder="Filter by Status"
            />
            <flux:dropdown
                wire:model="filters.type"
                :options="[
                    'annual' => 'Annual Leave',
                    'sick' => 'Sick Leave',
                    'unpaid' => 'Unpaid Leave',
                    'other' => 'Other',
                ]"
                placeholder="Filter by Type"
            />
            <flux:dropdown
                wire:model="filters.employee"
                :options="$employees->pluck('name', 'id')"
                placeholder="Filter by Employee"
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
                <flux:table.checkbox wire:model="selectedHolidays" />
                <flux:table.column name="id" hidden />
                <flux:table.column name="employee" />
                <flux:table.column name="start_date" />
                <flux:table.column name="end_date" />
                <flux:table.column name="type" hidden />
                <flux:table.column name="status" />
                <flux:table.column name="actions" />
            </flux:table.head>
            <flux:table.body>
                @foreach($holidays as $holiday)
                    <flux:table.row>
                        <flux:table.cell>
                            <flux:checkbox wire:model="selectedHolidays" :value="$holiday->id" />
                        </flux:table.cell>
                        <flux:table.cell hidden>{{ $holiday->id }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex items-center gap-2">
                                <flux:avatar :src="$holiday->user->avatar_url" />
                                <span>{{ $holiday->user->name }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>{{ $holiday->start_date->format('d/m/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $holiday->end_date->format('d/m/Y') }}</flux:table.cell>
                        <flux:table.cell hidden>
                            <flux:badge :color="$holiday->type_color">
                                {{ ucfirst($holiday->type) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$holiday->status_color">
                                {{ ucfirst($holiday->status) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:dropdown.item
                                    wire:click="$dispatch('open-modal', { component: 'holidays.view', arguments: { holiday: {{ $holiday->id }} } })"
                                >
                                    View
                                </flux:dropdown.item>
                                <flux:dropdown.item
                                    wire:click="$dispatch('open-modal', { component: 'holidays.edit', arguments: { holiday: {{ $holiday->id }} } })"
                                >
                                    Edit
                                </flux:dropdown.item>
                                <flux:dropdown.item
                                    wire:click="$dispatch('open-modal', { component: 'holidays.delete', arguments: { holiday: {{ $holiday->id }} } })"
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
            {{ $holidays->links() }}
        </div>
    </div>
</div> 