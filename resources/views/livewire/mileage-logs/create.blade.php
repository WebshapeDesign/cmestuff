<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Create Mileage Log</h1>

    <div class="mb-4">
        <label class="block">Vehicle</label>
        <select wire:model="vehicle_id" class="border p-2 w-full">
            <option value="">Select Vehicle</option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block">User</label>
        <select wire:model="user_id" class="border p-2 w-full">
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block">Date</label>
        <input type="date" wire:model="date" class="border p-2 w-full">
    </div>

    <table class="w-full table-auto border mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Date</th>
                <th class="border p-2">Time</th>
                <th class="border p-2">Purpose/Description</th>
                <th class="border p-2">Location</th>
                <th class="border p-2">Start</th>
                <th class="border p-2">Finish</th>
                <th class="border p-2">Total Mileage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $index => $entry)
                <tr>
                    <td><input type="date" wire:model="entries.{{ $index }}.date" class="border p-2 w-full"></td>
                    <td><input type="time" wire:model="entries.{{ $index }}.time" class="border p-2 w-full"></td>
                    <td><input type="text" wire:model="entries.{{ $index }}.purpose" class="border p-2 w-full"></td>
                    <td><input type="text" wire:model="entries.{{ $index }}.location" class="border p-2 w-full"></td>
                    <td><input type="number" wire:model="entries.{{ $index }}.start" class="border p-2 w-full"></td>
                    <td><input type="number" wire:model="entries.{{ $index }}.finish" class="border p-2 w-full"></td>
                    <td class="border p-2 text-center">{{ $entry['total_mileage'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button wire:click="addEntry" type="button" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add Row</button>

    <div class="mt-6">
        <button wire:click="saveDraft" type="button" class="bg-yellow-500 text-white px-4 py-2 rounded mr-2">Save</button>
        <button wire:click="submit" type="button" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
    </div>

    @if (session()->has('message'))
        <div class="text-green-600 mt-4">{{ session('message') }}</div>
    @endif
</div>
