<x-layouts.app :title="__('Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:main container>
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    @include('partials.breadcrumbs')
                </div>

                <flux:tabs variant="segmented" class="w-auto! ml-2" size="sm">
                    <flux:tab icon="list-bullet" icon:variant="outline" />
                    <flux:tab icon="squares-2x2" icon:variant="outline" />
                </flux:tabs>
            </div>

            <div class="flex justify-between items-center mb-6">
                <flux:heading size="lg">Users</flux:heading>
            </div>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <flux:button href="{{ route('users.create') }}" variant="primary">
                    New User
                </flux:button>
            </div>

            @livewire('users-table')
        </flux:main>
    </div>
</x-layouts.app>
