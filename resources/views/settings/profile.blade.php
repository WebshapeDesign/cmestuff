<x-layouts.app>
    <x-slot name="header">Settings</x-slot>

    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
        <div class="w-80">
            <flux:heading size="lg">Profile</flux:heading>
            <flux:subheading>This is how others will see you on the site.</flux:subheading>
        </div>

        <div class="flex-1 space-y-6">
            <form wire:submit="updateProfile">
                <flux:input
                    label="First Name"
                    wire:model="first_name"
                    placeholder="Enter your first name"
                />

                <flux:input
                    label="Last Name"
                    wire:model="last_name"
                    placeholder="Enter your last name"
                />

                <flux:input
                    label="Email"
                    type="email"
                    wire:model="email"
                    placeholder="Enter your email address"
                />

                <flux:input
                    label="Mobile Number"
                    wire:model="mobile_number"
                    placeholder="Enter your mobile number"
                />

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary">Save profile</flux:button>
                </div>
            </form>
        </div>
    </div>

    <flux:separator variant="subtle" class="my-8" />

    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
        <div class="w-80">
            <flux:heading size="lg">Preferences</flux:heading>
            <flux:subheading>Customize your layout and notification preferences.</flux:subheading>
        </div>

        <div class="flex-1 space-y-6">
            <form wire:submit="updatePreferences">
                <flux:radio.group label="Theme" wire:model="theme">
                    <flux:radio value="light" label="Light" />
                    <flux:radio value="dark" label="Dark" />
                    <flux:radio value="system" label="System" />
                </flux:radio.group>

                <flux:separator variant="subtle" class="my-8" />

                <flux:checkbox.group label="Notifications" wire:model="notifications">
                    <flux:checkbox value="email" label="Email notifications" />
                    <flux:checkbox value="sms" label="SMS notifications" />
                    <flux:checkbox value="push" label="Push notifications" />
                </flux:checkbox.group>

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary">Save preferences</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app> 