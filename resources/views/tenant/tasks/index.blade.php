<x-tenant-layout>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('My Execution Tasks') }}</h1>

        <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-right" dir="rtl">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Resolution') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Task Description') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Deadline (SLA)') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Evidence') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tasks as $task)
                        <tr x-data="{ open: false }">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $task->resolution->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $task->task_description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-bold">
                                {{ $task->sla_deadline->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-bold rounded-full 
                                    {{ $task->status === 'closed' ? 'bg-green-100 text-green-700' : 
                                       ($task->status === 'escalated' ? 'bg-red-100 text-red-700 font-black animate-pulse' : 'bg-yellow-100 text-yellow-700') }} uppercase">
                                    {{ str_replace('_', ' ', $task->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($task->status === 'pending' || $task->status === 'in_progress')
                                    <button @click="open = !open" class="text-primary hover:underline font-bold">
                                        {{ __('Submit Evidence') }}
                                    </button>
                                @else
                                    <span class="text-gray-400 italic">{{ __('Submitted') }}</span>
                                @endif

                                <!-- Evidence Modal/Form -->
                                <div x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="open = false"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div class="inline-block align-middle bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
                                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Upload Evidence') }}</h3>
                                            <form action="{{ route('tasks.evidence', $task) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                                @csrf
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">{{ __('File (PDF/Image)') }}</label>
                                                    <input type="file" name="evidence" required class="mt-1 block w-full text-sm text-gray-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">{{ __('Notes') }}</label>
                                                    <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                                                </div>
                                                <div class="flex justify-end space-x-reverse space-x-2">
                                                    <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">{{ __('Cancel') }}</button>
                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/90">{{ __('Submit') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No tasks assigned to you.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-tenant-layout>
