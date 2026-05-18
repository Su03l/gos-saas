<x-tenant-layout>
    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h1 class="text-xl font-bold text-gray-900">{{ __('Bulk User Import') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ __('Upload a CSV or Excel file to import multiple board members or managers at once.') }}</p>
            </div>

            <form action="{{ route('users.import.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">{{ __('Choose File') }}</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none">
                                    <span>{{ __('Upload a file') }}</span>
                                    <input id="file-upload" name="file" type="file" class="sr-only" required>
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-500">CSV, XLS, XLSX {{ __('up to 10MB') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-md flex items-start space-x-3 space-x-reverse">
                    <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-bold mb-1">{{ __('Instructions:') }}</p>
                        <ul class="list-disc list-inside space-y-1 opacity-90">
                            <li>{{ __('The file must contain headers: name, email, role.') }}</li>
                            <li>{{ __('Valid roles are: member, manager, observer.') }}</li>
                            <li>{{ __('Passwords will be automatically generated and sent via email.') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ route('users.import.template') }}" class="text-sm font-medium text-gray-600 hover:text-primary flex items-center">
                        <svg class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        {{ __('Download CSV Template') }}
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        {{ __('Import Users') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-tenant-layout>
