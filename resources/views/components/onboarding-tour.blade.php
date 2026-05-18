<div x-data="{ 
        showTour: !localStorage.getItem('onboarding_completed'),
        step: 1,
        totalSteps: 3,
        completeTour() {
            localStorage.setItem('onboarding_completed', 'true');
            this.showTour = false;
        }
    }" 
    x-show="showTour" 
    class="fixed inset-0 z-[100] overflow-y-auto" 
    x-cloak>
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6 border border-primary/20">
            
            <!-- Step 1: Meetings -->
            <div x-show="step === 1">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-primary/10 rounded-full text-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Board Meetings') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('Manage all your board and committee meetings here. View agendas, join virtual rooms, and access secure documents in real-time.') }}
                </p>
            </div>

            <!-- Step 2: Voting -->
            <div x-show="step === 2">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-primary/10 rounded-full text-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Voting & Resolutions') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('Cast your vote on resolutions securely. Track live quorum status and review legally binding texts before signing.') }}
                </p>
            </div>

            <!-- Step 3: Tasks -->
            <div x-show="step === 3">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-primary/10 rounded-full text-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Execution Tasks') }}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('Monitor the execution of board decisions. Assign tasks to executives, track SLAs, and upload evidence of completion.') }}
                </p>
            </div>

            <!-- Controls -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                <button @click="completeTour()" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    {{ __('Skip Tour') }}
                </button>
                
                <div class="flex gap-2">
                    <button x-show="step > 1" @click="step--" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        {{ __('Previous') }}
                    </button>
                    
                    <button x-show="step < totalSteps" @click="step++" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary/90 transition-colors">
                        {{ __('Next') }}
                    </button>
                    
                    <button x-show="step === totalSteps" @click="completeTour()" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                        {{ __('Get Started') }}
                    </button>
                </div>
            </div>

            <!-- Progress Dots -->
            <div class="flex justify-center gap-2 mt-4">
                <template x-for="i in totalSteps">
                    <div class="h-1.5 w-1.5 rounded-full transition-all duration-300" 
                         :class="step === i ? 'w-4 bg-primary' : 'bg-gray-300 dark:bg-gray-600'"></div>
                </template>
            </div>
        </div>
    </div>
</div>
