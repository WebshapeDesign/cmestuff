<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:main container>
        <!-- Breadcrumbs and View Tabs -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="#">Dashboard</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="#">Timesheets</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>

            <flux:tabs variant="segmented" class="w-auto! ml-2" size="sm">
                <flux:tab icon="list-bullet" icon:variant="outline" />
                <flux:tab icon="squares-2x2" icon:variant="outline" />
            </flux:tabs>
        </div>

        <!-- Page Heading -->
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Timesheets</flux:heading>
        </div>

        <!-- Stats Card -->
        <div class="flex gap-6 mb-6">
            <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Number of Timesheets</flux:subheading>

                <flux:heading size="xl" class="mb-2">{{ $timesheets->total() }}</flux:heading>

                <div class="flex items-center gap-1 font-medium text-sm">
                    <!-- Optional extra info -->
                </div>

                <div class="absolute top-0 right-0 pr-2 pt-2">
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                </div>
            </div>
        </div>

        <!-- Create New Timesheet Button -->
        <div class="flex justify-end mb-4">
            <flux:button href="{{ route('timesheets.create') }}" variant="primary">
                New Timesheet
            </flux:button>
        </div>

        <!-- Timesheets Table -->
        <flux:table :paginate="$timesheets">
            <flux:table.columns>
                <flux:table.column></flux:table.column>

                <flux:table.column sortable :sorted="$sortBy === 'week_commencing'" :direction="$sortDirection" wire:click="sort('week_commencing')">
                    Week Commencing
                </flux:table.column>

                <flux:table.column sortable :sorted="$sortBy === 'total_expenses'" :direction="$sortDirection" wire:click="sort('total_expenses')">
                    Total Expenses (£)
                </flux:table.column>

                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">
                    Created At
                </flux:table.column>

                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($timesheets as $timesheet)
                    <flux:table.row :key="$timesheet->id">
                        <flux:table.cell class="pr-2">
                            <flux:checkbox />
                        </flux:table.cell>

                        <flux:table.cell class="max-md:hidden">
                            {{ \Carbon\Carbon::parse($timesheet->week_commencing)->format('d/m/Y') }}
                        </flux:table.cell>

                        <flux:table.cell class="max-md:hidden">
                            £{{ number_format($timesheet->total_expenses, 2) }}
                        </flux:table.cell>

                        <flux:table.cell class="max-md:hidden">
                            {{ $timesheet->created_at->diffForHumans() }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item as="a" href="{{ route('timesheets.edit', $timesheet) }}" icon="pencil-square">
                                        Edit Timesheet
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
