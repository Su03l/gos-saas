<div x-data="{ 
    open: false, 
    search: '', 
    results: { meetings: [], resolutions: [], tasks: [] },
    loading: false,
    async performSearch() {
        if (this.search.length < 2) {
            this.results = { meetings: [], resolutions: [], tasks: [] };
            return;
        }
        this.loading = true;
        try {
            const response = await fetch(`/search?keyword=${encodeURIComponent(this.search)}`);
            this.results = await response.json();
        } catch (e) {
            console.error('Search failed', e);
        } finally {
            this.loading = false;
        }
    }
}" 
@keydown.window.prevent.cmd.k="open = true" 
@keydown.window.prevent.ctrl.k="open = true" 
class="relative">
    
    <!-- Search Trigger Bar -->
    <button @click="open = true" class="flex items-center space-x-reverse space-x-3 px-4 py-2 bg-gray-100 rounded-lg text-gray-400 hover:bg-gray-200 transition-colors w-64 text-right">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <span class="text-sm flex-1">{{ __('Search...') }}</span>
        <kbd class="hidden sm:inline-block text-xs font-semibold text-gray-500">⌘K</kbd>
    </button>

    <!-- Modal Backdrop -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20" role="dialog" aria-modal="true">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" @click="open = false"></div>

        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="mx-auto max-w-2xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all text-right" dir="rtl">
            <div class="relative">
                <svg class="pointer-events-none absolute top-3.5 right-4 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                <input type="text" x-model="search" @input.debounce.300ms="performSearch()" class="h-12 w-full border-0 bg-transparent pr-11 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="{{ __('Search meetings, resolutions, or tasks...') }}" autofocus>
            </div>

            <!-- Results -->
            <div x-show="search.length > 0" class="max-h-96 overflow-y-auto p-4 space-y-4">
                <template x-if="loading">
                    <div class="py-14 px-6 text-center sm:px-14">
                        <svg class="mx-auto h-6 w-6 animate-spin text-primary" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.062 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                </template>

                <!-- Meetings -->
                <div x-show="results.meetings.length > 0">
                    <h3 class="text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Meetings') }}</h3>
                    <ul class="space-y-1">
                        <template x-for="item in results.meetings" :key="item.id">
                            <li>
                                <a :href="'/meetings/' + item.id" class="block px-3 py-2 rounded-md hover:bg-primary/5 text-sm text-gray-700 font-medium" x-text="item.title"></a>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Resolutions -->
                <div x-show="results.resolutions.length > 0">
                    <h3 class="text-xs font-bold text-gray-500 uppercase mb-2">{{ __('Resolutions') }}</h3>
                    <ul class="space-y-1">
                        <template x-for="item in results.resolutions" :key="item.id">
                            <li>
                                <a :href="'/resolutions/' + item.id" class="block px-3 py-2 rounded-md hover:bg-primary/5 text-sm text-gray-700 font-medium" x-text="item.title"></a>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Empty State -->
                <div x-show="!loading && results.meetings.length === 0 && results.resolutions.length === 0 && results.tasks.length === 0" class="py-14 px-6 text-center sm:px-14">
                    <p class="text-sm text-gray-500">{{ __('No results found for your search.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
