@extends('layouts.app')

@section('content')
<div class="p-10">
    <div class="flex items-center mb-10">
        <div class="flex-1 h-px bg-gray-300 dark:bg-gray-700"></div>
        <h1 class="px-4 text-2xl text-center text-gray-800 dark:text-white">Audit Logs</h1>
        <div class="flex-1 h-px bg-gray-300 dark:bg-gray-700"></div>
    </div>

    @php
        use Carbon\Carbon;

        // Grouping Harian
        $groupedLogs = $logs->groupBy(function($log) {
            return $log->created_at->format('Y-m-d');
        });
    @endphp

    @forelse ($groupedLogs as $date => $logsPerDay)
        @php
            $carbonDate = Carbon::parse($date);

            if ($carbonDate->isToday()) {
                $label = 'Today';
            } elseif ($carbonDate->isYesterday()) {
                $label = 'Yesterday';
            } else {
                $label = $carbonDate->format('d M Y');
            }
        @endphp

        {{-- Header Tanggal --}}
        <div class="sticky top-0 z-10 py-3 text-sm font-semibold text-center text-gray-700 bg-gray-200 rounded dark:bg-gray-800 dark:text-gray-300">
            {{ $label }}
        </div>

        {{-- Logs per tanggal --}}
        <div class="mb-6 bg-white divide-y divide-gray-200 rounded-lg shadow dark:bg-gray-900 dark:divide-gray-700">
            @foreach ($logsPerDay as $log)
                @php
                    $oldData = json_decode($log->old_data, true) ?? [];
                    $newData = json_decode($log->new_data, true) ?? [];
                @endphp

                <div class="p-4 transition dark:hover:bg-gray-800">
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
                                @case('out')
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                        <line x1="6" y1="18" x2="18" y2="6"></line>
                                    </svg>
                                    @break
                                @case('in')
                                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 5v10m5-5H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
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
                                    {{ $log->user }} <span class="font-bold">added</span>
                                    {{ $newData['name'] ?? '-' }} to {{ $newData['subcategory'] ?? '-' }}
                                @elseif ($log->action === 'delete')
                                    {{ $log->user }} <span class="font-bold">deleted</span>
                                    {{ $oldData['name'] ?? '-' }} in {{ $oldData['subcategory'] ?? '-' }}
                                @elseif ($log->action === 'edit')
                                    {{ $log->user }} <span class="font-bold">edited</span>
                                    {{ $oldData['name'] ?? '-' }} to {{ $newData['name'] ?? '-' }} in {{ $newData['subcategory'] ?? '-' }}
                                @elseif ($log->action === 'in')
                                    {{ $log->user }} <span class="font-bold">input</span>
                                    {{ $oldData['quantity'] ?? '-' }} items to {{ $newData['quantity'] ?? '-' }} items in {{ $newData['name'] ?? '-' }} of {{ $newData['subcategory'] ?? '-' }}
                                @elseif ($log->action === 'out')
                                    {{ $log->user }} <span class="font-bold">clear</span>
                                    {{ $oldData['quantity'] ?? '-' }} items to {{ $newData['quantity'] ?? '-' }} items in {{ $newData['name'] ?? '-' }} of {{ $newData['subcategory'] ?? '-' }}
                                @elseif ($log->action === 'use')
                                    {{ $log->user }} <span class="font-bold">used</span>
                                    {{ $newData['name'] ?? '-' }} in {{ $newData['subcategory'] ?? '-' }} for {{ $newData['use'] ?? '-' }} items
                                @elseif ($log->action === 'damaged')
                                    {{ $log->user }} <span class="font-bold">marked as damaged</span>
                                    {{ $newData['name'] ?? '-' }} in {{ $newData['subcategory'] ?? '-' }}
                                @elseif ($log->action === 'return')
                                    {{ $log->user }} <span class="font-bold">Returning</span>
                                    {{ $newData['name'] ?? '-' }} in {{ $newData['subcategory'] ?? '-' }} 
                                @endif
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $log->created_at->format('H:i:s') }} • {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="p-4 text-sm text-gray-500">Belum ada log</p>
    @endforelse
</div>
@endsection
