@php
    $user = auth()->user();
    $isAdmin = $user->admin_status ?? false;
@endphp

<flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <flux:brand href="{{ route('dashboard') }}" logo="{{ asset('images/CME-White-Logo.png') }}" name="CME" class="px-2 dark:hidden" />
    <flux:brand href="{{ route('dashboard') }}" logo="{{ asset('images/CME-Normal-Icon.png') }}" name="CME" class="px-2 hidden dark:flex" />

    <flux:input as="button" variant="filled" placeholder="Search..." icon="magnifying-glass" wire:loading.attr="disabled" />

    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="{{ route('dashboard') }}" @class(['current' => request()->routeIs('dashboard')]) wire:navigate wire:loading.class="opacity-50">
            Dashboard
        </flux:navlist.item>
        
        <flux:navlist.item icon="truck" href="{{ route('vehicles.index') }}" @class(['current' => request()->routeIs('vehicles.*')]) wire:navigate wire:loading.class="opacity-50">
            Vehicles
            @if($isAdmin)
                <flux:badge color="blue">Admin</flux:badge>
            @endif
        </flux:navlist.item>
        
        <flux:navlist.item icon="document-text" href="{{ route('van-logs.index') }}" @class(['current' => request()->routeIs('van-logs.*')]) wire:navigate wire:loading.class="opacity-50">
            Van Logs
        </flux:navlist.item>
        
        <flux:navlist.item icon="map" href="{{ route('mileage-logs.index') }}" @class(['current' => request()->routeIs('mileage-logs.*')]) wire:navigate wire:loading.class="opacity-50">
            Mileage Logs
        </flux:navlist.item>
        
        <flux:navlist.item icon="clock" href="{{ route('timesheets.index') }}" @class(['current' => request()->routeIs('timesheets.*')]) wire:navigate wire:loading.class="opacity-50">
            Timesheets
        </flux:navlist.item>
        
        <flux:navlist.item icon="calendar" href="{{ route('holidays.index') }}" @class(['current' => request()->routeIs('holidays.*')]) wire:navigate wire:loading.class="opacity-50">
            Holidays
            @if($isAdmin)
                <flux:badge color="blue">Admin</flux:badge>
            @endif
        </flux:navlist.item>
    </flux:navlist>

    <flux:spacer />

    <flux:navlist variant="outline">
        @if($isAdmin)
            <flux:navlist.item icon="users" href="{{ route('users.index') }}" @class(['current' => request()->routeIs('users.*')]) wire:navigate wire:loading.class="opacity-50">
                Users
                <flux:badge color="blue">Admin</flux:badge>
            </flux:navlist.item>
        @endif
        
        <flux:navlist.item icon="cog-6-tooth" href="{{ route('settings.profile') }}" @class(['current' => request()->routeIs('settings.*')]) wire:navigate wire:loading.class="opacity-50">
            Settings
        </flux:navlist.item>
    </flux:navlist>

    <flux:dropdown position="top" align="left" class="max-lg:hidden">
        <flux:profile 
            avatar="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff" 
            name="{{ $user->name }}"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>{{ $user->name }}</flux:menu.radio>
                @if($isAdmin)
                    <flux:badge color="blue" class="ml-2">Admin</flux:badge>
                @endif
            </flux:menu.radio.group>

            <flux:menu.separator />

            <livewire:auth.logout />
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:spacer />

    <flux:profile 
        avatar="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff" 
        name="{{ $user->name }}"
    />
</flux:header> 