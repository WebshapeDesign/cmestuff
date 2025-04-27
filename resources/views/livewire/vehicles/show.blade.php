<div class="p-6">
    <h1 class="text-3xl font-bold mb-4">{{ $vehicle->registration_number }}</h1>
    <p><strong>Make:</strong> {{ $vehicle->make }}</p>
    <p><strong>Model:</strong> {{ $vehicle->model }}</p>
    <p><strong>Year:</strong> {{ $vehicle->year }}</p>
    <p><strong>Mileage:</strong> {{ number_format($vehicle->mileage) }} miles</p>

    <a href="{{ route('vehicles.index') }}" class="text-blue-500 hover:underline mt-4 inline-block">Back to Vehicles</a>
</div>
