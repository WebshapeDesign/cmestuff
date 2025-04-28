<div>
    <div class="flex justify-between mb-6">
        <input type="text" wire:model="search" placeholder="Search Users..." class="input input-bordered w-full max-w-xs" />
    </div>

    <flux:table :paginate="$users">
        <flux:table.columns>
            <flux:table.column></flux:table.column>

            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">
                Name
            </flux:table.column>

            <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection" wire:click="sort('email')">
                Email
            </flux:table.column>

            <flux:table.column>
                Role
            </flux:table.column>

            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($users as $user)
                <flux:table.row :key="$user->id">
                    <flux:table.cell class="pr-2">
                        <flux:checkbox />
                    </flux:table.cell>

                    <flux:table.cell class="max-md:hidden">
                        {{ $user->name }}
                    </flux:table.cell>

                    <flux:table.cell class="max-md:hidden">
                        {{ $user->email }}
                    </flux:table.cell>

                    <flux:table.cell class="max-w-6 truncate">
                        {{ ucfirst($user->role ?? 'User') }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:dropdown position="bottom" align="end" offset="-15">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                            <flux:menu>
                                <flux:menu.item as="a" href="{{ route('users.edit', $user) }}" icon="receipt-refund">
                                    Edit User
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
