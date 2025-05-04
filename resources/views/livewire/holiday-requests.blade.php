<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Holiday Requests</h2>
        <button wire:click="$set('showModal', true)" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Request Holiday
        </button>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Search by name..." class="w-full px-4 py-2 border rounded">
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('user_id')">
                            User
                            @if ($sortField === 'user_id')
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('start_date')">
                            Start Date
                            @if ($sortField === 'start_date')
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('end_date')">
                            End Date
                            @if ($sortField === 'end_date')
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Days Requested
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('status')">
                            Status
                            @if ($sortField === 'status')
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($holidayRequests as $request)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            {{ $request->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            {{ $request->start_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            {{ $request->end_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            {{ $request->days_requested }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->status === 'approved') bg-green-100 text-green-800
                                @elseif($request->status === 'denied') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm">
                            @if ($request->status === 'pending')
                                @if (auth()->user()->isAdmin())
                                    <button wire:click="approve({{ $request->id }})" class="text-green-600 hover:text-green-900 mr-2">
                                        Approve
                                    </button>
                                    <button wire:click="deny({{ $request->id }})" class="text-red-600 hover:text-red-900">
                                        Deny
                                    </button>
                                @else
                                    <button wire:click="edit({{ $request->id }})" class="text-blue-600 hover:text-blue-900">
                                        Edit
                                    </button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $holidayRequests->links() }}
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white rounded-lg p-8 max-w-md w-full">
                <h3 class="text-lg font-medium mb-4">{{ $modalType === 'create' ? 'Request Holiday' : 'Edit Holiday Request' }}</h3>
                
                <form wire:submit="{{ $modalType === 'create' ? 'create' : 'update' }}">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">
                            Start Date
                        </label>
                        <input type="date" wire:model="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">
                            End Date
                        </label>
                        <input type="date" wire:model="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="days_requested">
                            Days Requested
                        </label>
                        <input type="number" wire:model="days_requested" id="days_requested" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100">
                    </div>

                    <div class="flex justify-end">
                        <button type="button" wire:click="$set('showModal', false)" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            {{ $modalType === 'create' ? 'Submit' : 'Update' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div> 