<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Navigation Cards -->
                        <a href="{{ route('vehicles.index') }}" class="block p-6 bg-white border rounded-lg shadow hover:bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900">Vehicles</h3>
                            <p class="mt-2 text-gray-600">Manage vehicle fleet and compliance</p>
                        </a>

                        <a href="{{ route('van-logs.index') }}" class="block p-6 bg-white border rounded-lg shadow hover:bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900">Van Logs</h3>
                            <p class="mt-2 text-gray-600">View and manage van logs</p>
                        </a>

                        <a href="{{ route('holidays.index') }}" class="block p-6 bg-white border rounded-lg shadow hover:bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900">Holiday Requests</h3>
                            <p class="mt-2 text-gray-600">Manage holiday requests</p>
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="block p-6 bg-white border rounded-lg shadow hover:bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900">Users</h3>
                                <p class="mt-2 text-gray-600">Manage user accounts</p>
                            </a>
                        @endif
                    </div>

                    @if(auth()->user()->isAdmin())
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Flagged Issues</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flaggedIssues as $issue)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    {{ $issue->type }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    {{ $issue->description }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($issue->status === 'resolved') bg-green-100 text-green-800
                                                        @elseif($issue->status === 'pending') bg-yellow-100 text-yellow-800
                                                        @else bg-red-100 text-red-800 @endif">
                                                        {{ ucfirst($issue->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm">
                                                    <a href="{{ route('issues.show', $issue) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
