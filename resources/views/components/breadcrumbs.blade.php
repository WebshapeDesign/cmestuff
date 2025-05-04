@php
    $segments = request()->segments();
    $breadcrumbs = [];
    
    // Always start with Dashboard
    $breadcrumbs[] = [
        'label' => 'Dashboard',
        'href' => route('dashboard'),
        'current' => count($segments) === 0
    ];
    
    // Add the main section
    if (count($segments) > 0) {
        $mainSection = $segments[0];
        $mainSectionLabel = match($mainSection) {
            'van-logs' => 'Van Logs',
            'settings' => 'Settings',
            'mileage-logs' => 'Mileage Logs',
            'users' => 'Users',
            'holidays' => 'Holidays',
            'vehicles' => 'Vehicles',
            default => ucfirst($mainSection)
        };
        
        $breadcrumbs[] = [
            'label' => $mainSectionLabel,
            'href' => route($mainSection . '.index'),
            'current' => count($segments) === 1
        ];
        
        // Add the action (create, edit, view)
        if (count($segments) > 1) {
            $action = $segments[1];
            $actionLabel = match($action) {
                'create' => 'Create',
                'edit' => 'Edit',
                default => 'View'
            };
            
            $breadcrumbs[] = [
                'label' => $actionLabel,
                'href' => null,
                'current' => true
            ];
        }
    }
@endphp

<flux:breadcrumbs>
    @foreach($breadcrumbs as $breadcrumb)
        @if($breadcrumb['href'])
            <flux:breadcrumbs.item href="{{ $breadcrumb['href'] }}">{{ $breadcrumb['label'] }}</flux:breadcrumbs.item>
        @else
            <flux:breadcrumbs.item>{{ $breadcrumb['label'] }}</flux:breadcrumbs.item>
        @endif
    @endforeach
</flux:breadcrumbs> 