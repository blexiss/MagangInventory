@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Inventory Logs</h1>

        @php
            $logs = [
                [
                    'user' => 'Dimas',
                    'action' => 'add',
                    'description' => 'added EPSON L3110 to inventory',
                    'time' => '24/08/2025 17:53:20 - 10 hours ago',
                ],
                [
                    'user' => 'Edgar',
                    'action' => 'edit',
                    'description' => 'edited TP-Link AX3000 configuration',
                    'time' => '24/08/2025 14:20:05 - 13 hours ago',
                ],
                [
                    'user' => 'Mushawawa',
                    'action' => 'delete',
                    'description' => 'deleted Ruijie Reyee EG105W from inventory',
                    'time' => '23/08/2025 09:15:40 - 1 day ago',
                ],
            ];
        @endphp

        <div class="bg-white dark:bg-gray-900 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($logs as $log)
                <div class="flex items-start p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <div class="flex-shrink-0">
                        @switch($log['action'])
                            @case('add')
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 5v10m5-5H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            @break

                            @case('edit')
                                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.414 2.586a2 2 0 010 2.828L8 14l-4 1 1-4 9.414-9.414a2 2 0 012.828 0z" />
                                </svg>
                            @break
                            @case('delete')
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                    <line x1="6" y1="18" x2="18" y2="6"></line>
                                </svg>
                            @break

                            @default
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="5" />
                                </svg>
                        @endswitch
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            <span class="font-semibold">{{ $log['user'] }}</span> {{ $log['description'] }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log['time'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
