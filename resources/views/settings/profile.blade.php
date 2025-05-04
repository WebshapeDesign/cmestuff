<div>
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
            <flux:navlist.item icon="cog-6-tooth" href="{{ route('settings.profile') }}" current>Settings</flux:navlist.item>
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

    <flux:main container class="max-w-xl lg:max-w-3xl">
        <flux:heading size="xl">Settings</flux:heading>

        <flux:separator variant="subtle" class="my-8" />

        <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
                <div class="w-80">
                    <flux:heading size="lg">Profile</flux:heading>
                    <flux:subheading>Update your personal information and preferences.</flux:subheading>
                </div>

                <div class="flex-1 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img 
                                class="h-24 w-24 rounded-full object-cover" 
                                src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0D8ABC&color=fff' }}" 
                                alt="{{ auth()->user()->name }}"
                            >
                            <label for="avatar" class="absolute bottom-0 right-0 bg-white dark:bg-zinc-800 rounded-full p-1.5 border border-zinc-200 dark:border-zinc-700 cursor-pointer">
                                <svg class="h-4 w-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Profile photo</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Click to change your profile photo</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <flux:input
                            label="First name"
                            name="first_name"
                            value="{{ old('first_name', auth()->user()->first_name) }}"
                            required
                        />

                        <flux:input
                            label="Last name"
                            name="last_name"
                            value="{{ old('last_name', auth()->user()->last_name) }}"
                            required
                        />

                        <flux:input
                            label="Email address"
                            name="email"
                            type="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                        />

                        <flux:input
                            label="Mobile number"
                            name="mobile_number"
                            value="{{ old('mobile_number', auth()->user()->mobile_number) }}"
                        />
                    </div>

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">Save profile</flux:button>
                    </div>
                </div>
            </div>
        </form>

        <flux:separator variant="subtle" class="my-8" />

        <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
            <div class="w-80">
                <flux:heading size="lg">Preferences</flux:heading>
                <flux:subheading>Customize your application preferences.</flux:subheading>
            </div>

            <div class="flex-1 space-y-6">
                <form method="POST" action="{{ route('settings.preferences.update') }}">
                    @csrf
                    @method('PUT')

                    <flux:radio.group label="Theme" name="theme">
                        <flux:radio value="light" {{ auth()->user()->theme === 'light' ? 'checked' : '' }}>Light</flux:radio>
                        <flux:radio value="dark" {{ auth()->user()->theme === 'dark' ? 'checked' : '' }}>Dark</flux:radio>
                        <flux:radio value="system" {{ auth()->user()->theme === 'system' ? 'checked' : '' }}>System</flux:radio>
                    </flux:radio.group>

                    <flux:checkbox.group label="Notifications" description="Select the types of notifications you want to receive.">
                        <flux:checkbox name="notifications[]" value="email" {{ in_array('email', auth()->user()->notifications ?? []) ? 'checked' : '' }}>Email notifications</flux:checkbox>
                        <flux:checkbox name="notifications[]" value="sms" {{ in_array('sms', auth()->user()->notifications ?? []) ? 'checked' : '' }}>SMS notifications</flux:checkbox>
                        <flux:checkbox name="notifications[]" value="push" {{ in_array('push', auth()->user()->notifications ?? []) ? 'checked' : '' }}>Push notifications</flux:checkbox>
                    </flux:checkbox.group>

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">Save preferences</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </flux:main>
</div> 