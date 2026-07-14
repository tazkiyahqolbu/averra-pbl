<div x-data="{ 
    showDeleteModal: false, 
    deleteMessage: '', 
    pendingTarget: null,
    isLink: false
}"
@open-delete-modal.window="
    showDeleteModal = true; 
    deleteMessage = $event.detail.message; 
    pendingTarget = $event.detail.target;
    isLink = $event.detail.isLink || false;
">
    <div x-show="showDeleteModal" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div class="w-full max-w-sm rounded-2xl border border-[#E2D4C0] bg-white p-6 shadow-2xl text-center relative"
            @click.away="showDeleteModal = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <h3 class="font-serif text-2xl font-bold text-[#4A0F1A]">Konfirmasi Hapus</h3>
            <p class="mt-2 text-sm text-[#4A2E28]/70 leading-relaxed" x-text="deleteMessage || 'Apakah Anda yakin ingin menghapus data ini?'"></p>

            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" @click="showDeleteModal = false"
                    class="w-full rounded-full border border-[#E2D4C0] bg-white py-2.5 text-xs font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                    Batal
                </button>
                <button type="button" 
                    @click="
                        showDeleteModal = false; 
                        if (pendingTarget) {
                            if (isLink) {
                                window.location.href = pendingTarget;
                            } else {
                                pendingTarget.submit();
                            }
                        }
                    "
                    class="w-full rounded-full bg-gradient-to-br from-rose-600 to-rose-800 py-2.5 text-xs font-semibold text-white shadow-md hover:from-rose-700 hover:to-rose-900 transition-all duration-200">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
window.confirmDelete = function(event, message) {
    if (event) event.preventDefault();
    const target = event ? event.target : null;
    window.dispatchEvent(new CustomEvent('open-delete-modal', {
        detail: { target: target, message: message, isLink: false }
    }));
    return false;
};

window.confirmDeleteLink = function(event, message, href) {
    if (event) event.preventDefault();
    window.dispatchEvent(new CustomEvent('open-delete-modal', {
        detail: { target: href, message: message, isLink: true }
    }));
    return false;
};
</script>
