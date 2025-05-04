
    <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="{{ route('dashboard') }}" logo="{{ asset('images/CME-White-Logo.png') }}" name="CME" class="px-2 dark:hidden" />
        <flux:brand href="{{ route('dashboard') }}" logo="{{ asset('images/CME-Normal-Icon.png') }}" name="CME" class="px-2 hidden dark:flex" />

        <flux:input as="button" variant="filled" placeholder="Search..." icon="magnifying-glass" />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('dashboard') }}" {{ request()->routeIs('dashboard') ? 'current' : '' }}>Dashboard</flux:navlist.item>
            <flux:navlist.item icon="truck" href="{{ route('vehicles.index') }}" {{ request()->routeIs('vehicles.*') ? 'current' : '' }}>Vehicles</flux:navlist.item>
            <flux:navlist.item icon="document-text" href="{{ route('van-logs.index') }}" {{ request()->routeIs('van-logs.*') ? 'current' : '' }}>Van Logs</flux:navlist.item>
            <flux:navlist.item icon="map" href="{{ route('mileage-logs.index') }}" {{ request()->routeIs('mileage-logs.*') ? 'current' : '' }}>Mileage Logs</flux:navlist.item>
            <flux:navlist.item icon="clock" href="{{ route('timesheets.index') }}" {{ request()->routeIs('timesheets.*') ? 'current' : '' }}>Timesheets</flux:navlist.item>
            <flux:navlist.item icon="calendar" href="{{ route('holidays.index') }}" {{ request()->routeIs('holidays.*') ? 'current' : '' }}>Holidays</flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="{{ route('settings.profile') }}">Settings</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="left" class="max-lg:hidden">
            <flux:profile 
                avatar="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" 
                name="{{ auth()->user()->name }}"
            />

            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{ auth()->user()->name }}</flux:menu.radio>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item icon="arrow-right-start-on-rectangle">
                        <button type="submit" class="w-full text-left">Logout</button>
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:profile 
            avatar="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" 
            name="{{ auth()->user()->name }}"
        />
    </flux:header>
