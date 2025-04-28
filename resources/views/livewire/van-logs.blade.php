<div class="space-y-6">
    <flux:form wire:submit.prevent="save">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Vehicle Selection -->
            <flux:select label="Vehicle" wire:model="vehicle_id" required>
                <option value="">Select a Vehicle</option>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}">{{ $vehicle->registration }}</option>
                @endforeach
            </flux:select>

            <!-- Mileage (Auto-filled) -->
            <flux:input label="Mileage" wire:model="vehicle_mileage" readonly />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Oil Level Action -->
            <flux:input label="Oil Level Action" wire:model.defer="oil_level_action" />
            <flux:input label="Oil Level Signed" wire:model.defer="oil_level_signed" maxlength="3" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Water Level Action -->
            <flux:input label="Water Level Action" wire:model.defer="water_level_action" />
            <flux:input label="Water Level Signed" wire:model.defer="water_level_signed" maxlength="3" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Tyres Action -->
            <flux:input label="Tyres Action" wire:model.defer="tyres_action" />
            <flux:input label="Tyres Signed" wire:model.defer="tyres_signed" maxlength="3" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Screen Action -->
            <flux:input label="Screen Action" wire:model.defer="screen_action" />
            <flux:input label="Screen Signed" wire:model.defer="screen_signed" maxlength="3" />
        </div>

        <!-- Vehicle Defects -->
        <flux:textarea label="Vehicle Defects" wire:model.defer="vehicle_defects" rows="4" />

        <!-- Divider -->
        <flux:spacer />
        <flux:heading size="lg">Van Equipment Checks</flux:heading>

        <!-- Van Items Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left">
                        <th class="p-2">Item</th>
                        <th class="p-2">Visual Check</th>
                        <th class="p-2">Signed</th>
                        <th class="p-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vanItems as $index => $item)
                        <tr>
                            <td class="p-2">{{ $item['label'] }}</td>
                            <td class="p-2">
                                <flux:checkbox wire:model="vanItems.{{ $index }}.checked" />
                            </td>
                            <td class="p-2">
                                <flux:input wire:model="vanItems.{{ $index }}.signed" maxlength="3" />
                            </td>
                            <td class="p-2">
                                <flux:input type="date" wire:model="vanItems.{{ $index }}.date" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Divider -->
        <flux:spacer />
        <flux:heading size="lg">PPE / Health & Safety Equipment Checks</flux:heading>

        <!-- PPE Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left">
                        <th class="p-2">Item</th>
                        <th class="p-2">No. Required</th>
                        <th class="p-2">Actual No.</th>
                        <th class="p-2">Visual Check</th>
                        <th class="p-2">Signed</th>
                        <th class="p-2">Defects</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ppeItems as $index => $item)
                        <tr>
                            <td class="p-2">{{ $item['label'] }}</td>
                            <td class="p-2">1</td>
                            <td class="p-2">
                                <flux:input type="number" wire:model="ppeItems.{{ $index }}.actual" min="0" />
                            </td>
                            <td class="p-2">
                                <flux:checkbox wire:model="ppeItems.{{ $index }}.checked" />
                            </td>
                            <td class="p-2">
                                <flux:input wire:model="ppeItems.{{ $index }}.signed" maxlength="3" />
                            </td>
                            <td class="p-2">
                                <flux:input wire:model="ppeItems.{{ $index }}.defects" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <flux:button type="submit" class="w-full md:w-auto">
                Save Van Log
            </flux:button>
        </div>

    </flux:form>
</div>
