@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Inventory Logs</h1>

    <div class="bg-white dark:bg-gray-900 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
        @foreach ($logs as $log)
            @php
                $oldData = json_decode($log->old_data, true) ?? [];
                $newData = json_decode($log->new_data, true) ?? [];
            @endphp

            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @switch($log->action)
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
                            @if ($log->action === 'add')
                                <span class="font-semibold">{{ $log->user }}</span> 
                                add {{ $log->model }}
                                {{ $newData['name'] ?? '-' }} 
                                {{ $newData['category'] ?? '-' }} 
                                {{ $newData['subcategory'] ?? '-' }}
                            @elseif ($log->action === 'delete')
                                <span class="font-semibold">{{ $log->user }}</span> 
                                delete {{ $log->model }}
                                {{ $oldData['name'] ?? '-' }} 
                                {{ $oldData['category'] ?? '-' }} 
                                {{ $oldData['subcategory'] ?? '-' }}
                            @elseif ($log->action === 'edit')
                                <span class="font-semibold">{{ $log->user }}</span> 
                                edit {{ $log->model }}
                                {{ $oldData['name'] ?? '-' }} 
                                {{ $oldData['category'] ?? '-' }} 
                                {{ $oldData['subcategory'] ?? '-' }}
                                to
                                {{ $newData['name'] ?? '-' }} 
                                {{ $newData['category'] ?? '-' }} 
                                {{ $newData['subcategory'] ?? '-' }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $log->created_at->format('d/m/Y H:i:s') }} - {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
