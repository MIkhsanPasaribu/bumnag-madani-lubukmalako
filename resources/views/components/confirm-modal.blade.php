{{-- Confirmation Modal Component --}}
{{-- 
    Reusable Alpine.js confirmation modal untuk aksi destruktif (hapus, arsipkan, dll).
    Dipanggil via Alpine dispatch event: $dispatch('confirm-action', { ... })
    
    Contoh penggunaan di button:
    <button @click="$dispatch('confirm-action', {
        title: 'Hapus Berita',
        message: 'Yakin ingin menghapus berita ini?',
        actionUrl: '/admin/berita/1',
        method: 'DELETE',
        type: 'danger'
    })">Hapus</button>
    
    Lalu letakkan <x-confirm-modal /> sekali di bagian bawah halaman.
--}}

<div x-data="{
        open: false,
        title: '',
        message: '',
        actionUrl: '',
        method: 'DELETE',
        type: 'danger',
        confirmText: '',
        processing: false,
        
        get computedConfirmText() {
            if (this.confirmText) return this.confirmText;
            const texts = {
                'danger': 'Hapus',
                'warning': 'Ya, Lanjutkan',
                'archive': 'Arsipkan',
            };
            return texts[this.type] || 'Konfirmasi';
        },
        
        get iconColor() {
            const colors = {
                'danger': 'bg-red-100 text-red-600',
                'warning': 'bg-yellow-100 text-yellow-600',
                'archive': 'bg-gray-100 text-gray-600',
            };
            return colors[this.type] || 'bg-red-100 text-red-600';
        },
        
        get buttonColor() {
            const colors = {
                'danger': 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
                'warning': 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500',
                'archive': 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500',
            };
            return colors[this.type] || 'bg-red-600 hover:bg-red-700 focus:ring-red-500';
        },
        
        openModal(detail) {
            this.title = detail.title || 'Konfirmasi';
            this.message = detail.message || 'Apakah Anda yakin?';
            this.actionUrl = detail.actionUrl || '';
            this.method = detail.method || 'DELETE';
            this.type = detail.type || 'danger';
            this.confirmText = detail.confirmText || '';
            this.processing = false;
            this.open = true;
        },
        
        submitAction() {
            this.processing = true;
            this.$refs.confirmForm.action = this.actionUrl;
            this.$refs.methodInput.value = this.method;
            this.$refs.confirmForm.submit();
        }
     }"
     x-show="open"
     x-cloak
     x-init="$el.__openConfirmModal = (e) => openModal(e.detail); window.addEventListener('confirm-action', $el.__openConfirmModal)"
     @keydown.escape.window="if(open && !processing) open = false"
     class="fixed inset-0 overflow-y-auto z-50"
     role="dialog"
     aria-modal="true"
     aria-labelledby="confirm-modal-title">
    
    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"
         @click="if(!processing) open = false">
    </div>
    
    {{-- Modal Dialog --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.stop
             class="relative transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all sm:my-8 w-full sm:max-w-md">
            
            <div class="p-6">
                {{-- Icon --}}
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full mb-4"
                     :class="iconColor">
                    {{-- Danger / Delete Icon --}}
                    <template x-if="type === 'danger'">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </template>
                    {{-- Warning Icon --}}
                    <template x-if="type === 'warning'">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </template>
                    {{-- Archive Icon --}}
                    <template x-if="type === 'archive'">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </template>
                </div>
                
                {{-- Title --}}
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2" id="confirm-modal-title" x-text="title"></h3>
                
                {{-- Message --}}
                <p class="text-sm text-gray-600 text-center leading-relaxed" x-text="message"></p>
            </div>
            
            {{-- Actions --}}
            <div class="px-6 pb-6 flex gap-3">
                <button type="button"
                        @click="open = false"
                        :disabled="processing"
                        class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors disabled:opacity-50">
                    Batal
                </button>
                <button type="button"
                        @click="submitAction()"
                        :disabled="processing"
                        class="flex-1 px-4 py-2.5 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors disabled:opacity-50 flex items-center justify-center gap-2"
                        :class="buttonColor">
                    {{-- Loading spinner --}}
                    <svg x-show="processing" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span x-text="processing ? 'Memproses...' : computedConfirmText"></span>
                </button>
            </div>
            
            {{-- Hidden Form --}}
            <form x-ref="confirmForm" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="_method" x-ref="methodInput" value="DELETE">
            </form>
        </div>
    </div>
</div>
