<flux:breadcrumbs>
    <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>

    @php
        $sections = [
            'vehicles' => ['Vehicles', route('vehicles')],
            'van-logs.index' => ['Van Logs', route('van-logs.index')],
            'mileage-logs.index' => ['Mileage Logs', route('mileage-logs.index')],
            'timesheets.index' => ['Timesheets', route('timesheets.index')],
            'holidays' => ['Holidays', route('holidays')],
            'users.index' => ['Users', route('users.index')],
        ];

        $childPages = [
            'vehicles.create' => 'New Vehicle',
            'vehicles.edit' => 'Edit Vehicle',
            'van-logs.create' => 'New Van Log',
            'mileage-logs.create' => 'New Mileage Log',
            'mileage-logs.edit' => 'Edit Mileage Log',
            'timesheets.create' => 'New Timesheet',
            'timesheets.edit' => 'Edit Timesheet',
            'users.create' => 'New User',
            'users.edit' => 'Edit User',
        ];

        $currentRoute = Route::currentRouteName();
        $baseRoute = explode('.', $currentRoute)[0] . (str_contains($currentRoute, 'index') ? '.index' : '');
    @endphp

    @if (isset($sections[$baseRoute]))
        <flux:breadcrumbs.item href="{{ $sections[$baseRoute][1] }}">
            {{ $sections[$baseRoute][0] }}
        </flux:breadcrumbs.item>
    @endif

    @if (isset($childPages[$currentRoute]))
        <flux:breadcrumbs.item href="#">
            {{ $childPages[$currentRoute] }}
        </flux:breadcrumbs.item>
    @endif
</flux:breadcrumbs>
