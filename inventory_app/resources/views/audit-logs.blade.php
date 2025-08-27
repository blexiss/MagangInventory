@extends('layouts.app')

@section('content')
<div class="p-10">
    <div class="flex items-center mb-10">
        <div class="flex-1 h-px bg-gray-300 dark:bg-gray-700"></div>
        <h1 class="px-4 text-2xl text-center text-gray-800 dark:text-white">Audit Logs</h1>
        <div class="flex-1 h-px bg-gray-300 dark:bg-gray-700"></div>
    </div>
    
    <div class="bg-white divide-y divide-gray-200 rounded-lg shadow dark:bg-gray-900 dark:divide-gray-700">
        @foreach ($logs as $log)
            @php
                $oldData = json_decode($log->old_data, true) ?? [];
                $newData = json_decode($log->new_data, true) ?? [];
            @endphp

            <div class="p-4 transition hover:bg-gray-50 dark:hover:bg-gray-800">
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

                    <div class="flex-1 ml-4">
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            @if ($log->action === 'add')
                                {{ $log->user }}
                                <span class="font-bold">added</span>
                                {{ $newData['name'] ?? '-' }} 
                                in
                                {{ $newData['subcategory'] ?? '-' }}
                            @elseif ($log->action === 'delete')
                                {{ $log->user }}
                                <span class="font-bold">deleted</span>
                                {{ $oldData['name'] ?? '-' }} 
                                in
                                {{ $oldData['subcategory'] ?? '-' }}
                            @elseif ($log->action === 'edit')
                                {{ $log->user }}
                                <span class="font-bold">edited</span>
                                {{ $oldData['name'] ?? '-' }} 
                                {{ $oldData['subcategory'] ?? '-' }}
                                to
                                {{ $newData['name'] ?? '-' }} 
                                {{ $newData['subcategory'] ?? '-' }}
                            @endif
                        </p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{ $log->created_at->format('d/m/Y') }} at {{ $log->created_at->format('H:i:s') }} - {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>  
            </div>
        @endforeach
    </div>
</div>
@endsection