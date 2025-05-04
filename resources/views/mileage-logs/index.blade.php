<x-layouts.app>
    <x-slot name="header">Mileage Logs</x-slot>

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2">
                <flux:select size="sm" wire:model="dateRange">
                    <option value="7">Last 7 days</option>
                    <option value="14">Last 14 days</option>
                    <option value="30" selected>Last 30 days</option>
                    <option value="60">Last 60 days</option>
                    <option value="90">Last 90 days</option>
                </flux:select>
                <flux:subheading class="max-md:hidden whitespace-nowrap">compared to</flux:subheading>
                <flux:select size="sm" class="max-md:hidden" wire:model="comparisonPeriod">
                    <option value="previous" selected>Previous period</option>
                    <option value="last_year">Same period last year</option>
                    <option value="last_month">Last month</option>
                    <option value="last_quarter">Last quarter</option>
                    <option value="last_6_months">Last 6 months</option>
                    <option value="last_12_months">Last 12 months</option>
                </flux:select>
            </div>
            <flux:separator vertical class="max-lg:hidden mx-2 my-2" />
            <div class="max-lg:hidden flex justify-start items-center gap-2">
                <flux:subheading class="whitespace-nowrap">Filter by:</flux:subheading>
                <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">Vehicle</flux:badge>
                <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg" class="max-md:hidden">Driver</flux:badge>
                <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">More filters...</flux:badge>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <flux:button variant="primary" icon="plus" wire:click="$dispatch('open-modal', { component: 'mileage-logs.create' })">
                Add Log
            </flux:button>
            <flux:tabs variant="segmented" class="w-auto! ml-2" size="sm">
                <flux:tab icon="list-bullet" icon:variant="outline" />
                <flux:tab icon="squares-2x2" icon:variant="outline" />
            </flux:tabs>
        </div>
    </div>

    <div class="flex gap-6 mb-6">
        @foreach ($this->stats as $stat)
            <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 {{ $loop->iteration > 1 ? 'max-md:hidden' : '' }} {{ $loop->iteration > 3 ? 'max-lg:hidden' : '' }}">
                <flux:subheading>{{ $stat['title'] }}</flux:subheading>
                <flux:heading size="xl" class="mb-2">{{ $stat['value'] }}</flux:heading>
                <div class="flex items-center gap-1 font-medium text-sm @if ($stat['trendUp']) text-green-600 dark:text-green-400 @else text-red-500 dark:text-red-400 @endif">
                    <flux:icon :icon="$stat['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'" variant="micro" /> {{ $stat['trend'] }}
                </div>
                <div class="absolute top-0 right-0 pr-2 pt-2">
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                </div>
            </div>
        @endforeach
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column></flux:table.column>
            <flux:table.column class="max-md:hidden">ID</flux:table.column>
            <flux:table.column>Date</flux:table.column>
            <flux:table.column class="max-md:hidden">Vehicle</flux:table.column>
            <flux:table.column class="max-md:hidden">Driver</flux:table.column>
            <flux:table.column>Mileage</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->mileageLogs as $log)
                <flux:table.row>
                    <flux:table.cell class="pr-2">
                        <flux:checkbox wire:model="selectedLogs" value="{{ $log->id }}" />
                    </flux:table.cell>
                    <flux:table.cell class="max-md:hidden">#{{ $log->id }}</flux:table.cell>
                    <flux:table.cell>{{ $log->date->format('d/m/Y') }}</flux:table.cell>
                    <flux:table.cell class="max-md:hidden">
                        <div class="flex items-center gap-2">
                            <flux:avatar src="{{ $log->vehicle->image_url }}" size="xs" />
                            <span>{{ $log->vehicle->registration_number }}</span>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell class="max-md:hidden">
                        <div class="flex items-center gap-2">
                            <flux:avatar src="{{ $log->driver->avatar_url }}" size="xs" />
                            <span>{{ $log->driver->name }}</span>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>{{ number_format($log->mileage) }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$log->status_color" size="sm" inset="top bottom">
                            {{ $log->status }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown position="bottom" align="end" offset="-15">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                            <flux:menu>
                                <flux:menu.item icon="eye" wire:click="$dispatch('open-modal', { component: 'mileage-logs.view', arguments: { log: {{ $log->id }} } })">
                                    View
                                </flux:menu.item>
                                <flux:menu.item icon="pencil" wire:click="$dispatch('open-modal', { component: 'mileage-logs.edit', arguments: { log: {{ $log->id }} } })">
                                    Edit
                                </flux:menu.item>
                                <flux:menu.item icon="archive-box" variant="danger" wire:click="delete({{ $log->id }})">
                                    Archive
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:pagination :paginator="$this->mileageLogs" />
</x-layouts.app> 