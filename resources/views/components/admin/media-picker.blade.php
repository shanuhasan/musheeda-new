@props(['name', 'current' => null])

<div x-data="mediaPicker('{{ $name }}', '{{ $current }}')" class="mb-5">
    <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">{{ $attributes->get('label', 'Featured Image') }}</label>
    
    <!-- Hidden inputs for form submission -->
    <input type="hidden" :name="inputName + '_existing_id'" x-model="selectedMediaId">
    
    <!-- Selected Image Preview -->
    <div x-show="previewUrl" style="display: none;" class="mb-3 relative w-full max-w-sm rounded-lg border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800">
        <img :src="previewUrl" class="h-auto w-full max-h-48 object-contain rounded" alt="Preview">
        <button type="button" @click="clearSelection()" class="absolute -top-2 -right-2 flex h-6 w-6 items-center justify-center rounded-full bg-error-500 text-white hover:bg-error-600 shadow-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Picker Triggers -->
    <div class="flex items-center gap-3">
        <button type="button" @click="modalOpen = true" class="rounded-lg bg-brand-50 px-4 py-2 text-sm font-medium text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20">
            Select from Library
        </button>
        <span class="text-sm text-slate-500">or</span>
        <label class="cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
            <span>Upload New</span>
            <input type="file" :name="inputName" @change="handleFileUpload" class="hidden" accept="image/*">
        </label>
    </div>

    <!-- Modal for Media Library -->
    <template x-teleport="body">
        <div x-show="modalOpen" class="fixed inset-0 z-9999 flex items-center justify-center bg-black/50 p-4" style="display: none;">
            <div @click.outside="modalOpen = false" class="flex h-[80vh] w-full max-w-5xl flex-col rounded-2xl bg-white shadow-xl dark:bg-slate-800">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b px-6 py-4 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Select Media</h3>
                    <button @click="modalOpen = false" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body (Grid) -->
                <div class="flex-1 overflow-y-auto p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div x-show="loading" class="flex justify-center items-center py-12">
                        <svg class="animate-spin h-8 w-8 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>

                    <div x-show="!loading" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
                        <template x-for="item in media" :key="item.id">
                            <div @click="selectMedia(item)" :class="{'ring-2 ring-brand-500': tempSelected?.id === item.id}" class="cursor-pointer group relative aspect-square rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow dark:border-slate-800 dark:bg-slate-800">
                                <template x-if="item.mime_type.startsWith('image/')">
                                    <img :src="item.original_url" class="w-full h-full object-cover">
                                </template>
                                <div x-show="tempSelected?.id === item.id" class="absolute inset-0 bg-brand-500/20 flex items-center justify-center">
                                    <div class="bg-brand-500 text-white rounded-full p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 border-t px-6 py-4 dark:border-slate-700">
                    <button type="button" @click="modalOpen = false" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="button" @click="confirmSelection" :disabled="!tempSelected" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-50">Use Selected Image</button>
                </div>
            </div>
        </div>
    </template>
</div>

@pushonce('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('mediaPicker', (inputName, currentUrl) => ({
            inputName: inputName,
            previewUrl: currentUrl || null,
            selectedMediaId: null,
            modalOpen: false,
            loading: false,
            media: [],
            tempSelected: null,

            init() {
                // If it's the first time opening, we can fetch
                this.$watch('modalOpen', value => {
                    if (value && this.media.length === 0) {
                        this.fetchMedia();
                    }
                });
            },

            fetchMedia() {
                this.loading = true;
                fetch('{{ route('admin.media.index') }}?type=image', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.media = data.data || [];
                    this.loading = false;
                });
            },

            selectMedia(item) {
                this.tempSelected = item;
            },

            confirmSelection() {
                if (this.tempSelected) {
                    this.selectedMediaId = this.tempSelected.id;
                    this.previewUrl = this.tempSelected.original_url;
                    
                    // Clear any direct file input
                    const fileInput = document.querySelector(`input[type="file"][name="${this.inputName}"]`);
                    if (fileInput) fileInput.value = '';
                }
                this.modalOpen = false;
            },

            handleFileUpload(e) {
                const file = e.target.files[0];
                if (file) {
                    this.previewUrl = URL.createObjectURL(file);
                    this.selectedMediaId = null; // clear library selection
                }
            },

            clearSelection() {
                this.previewUrl = null;
                this.selectedMediaId = null;
                const fileInput = document.querySelector(`input[type="file"][name="${this.inputName}"]`);
                if (fileInput) fileInput.value = '';
            }
        }))
    });
</script>
@endpushonce
