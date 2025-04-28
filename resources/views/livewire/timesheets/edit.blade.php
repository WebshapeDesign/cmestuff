<div class="space-y-6">
<h2 class="text-2xl font-bold">Edit Timesheet</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1">Week Commencing (Sunday)</label>
            <input type="date" wire:model="week_commencing" class="input w-full" />
        </div>
    </div>

    <div class="overflow-auto">
        <table class="table w-full text-sm">
            <thead>
                <tr>
                    <th>Time</th>
                    @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                        <th class="text-center">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach(range(7,18) as $hour)
                <tr>
                    <td class="font-bold">{{ $hour <= 12 ? $hour . 'am' : ($hour - 12) . 'pm' }}</td>
                    @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                        <td class="text-center">
                            <input type="text" wire:model="entries.{{ $day }}.{{ $hour }}" class="input input-xs w-full" placeholder="Site/Job No" />
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label>Materials (£)</label>
            <input type="number" step="0.01" wire:model="materials" class="input w-full" />
        </div>
        <div>
            <label>Others (£)</label>
            <input type="number" step="0.01" wire:model="others" class="input w-full" />
        </div>
        <div>
            <label>Total Expenses (£)</label>
            <input type="number" step="0.01" wire:model="total_expenses" class="input w-full" readonly />
        </div>
    </div>

    <div class="flex justify-end space-x-4">
        <button wire:click="save" class="btn btn-primary">Save Timesheet</button>
    </div>
</div>
