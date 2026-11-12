<div id="logout-confirm-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-sm w-full p-6 flex flex-col gap-5 shadow-2xl text-slate-800">
    <div class="flex items-start gap-3.5">
      <div class="size-10 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center shrink-0">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" x2="9" y1="12" y2="12"/>
        </svg>
      </div>
      <div class="flex flex-col gap-1 min-w-0">
        <h3 class="text-base font-bold text-slate-900 leading-tight">Konfirmasi Keluar</h3>
        <p class="text-xs text-slate-500 leading-relaxed">
          Apakah Anda yakin ingin keluar dari akun? Sesi Anda akan berakhir dan Anda perlu masuk kembali untuk mengakses akun.
        </p>
      </div>
    </div>

    <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-100">
      <button type="button" onclick="closeLogoutModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition cursor-pointer">
        Batal
      </button>
      <button type="button" onclick="executeLogout()" class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 transition shadow-xs cursor-pointer">
        Ya, Keluar
      </button>
    </div>
  </div>
</div>

<script>
let activeLogoutFormId = null;

function confirmLogout(formId) {
  activeLogoutFormId = formId || null;
  const modal = document.getElementById('logout-confirm-modal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
}

function closeLogoutModal() {
  const modal = document.getElementById('logout-confirm-modal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
  activeLogoutFormId = null;
}

function executeLogout() {
  if (activeLogoutFormId) {
    const form = document.getElementById(activeLogoutFormId);
    if (form) {
      form.submit();
      return;
    }
  }
  const anyLogoutForm = document.querySelector('form[action="{{ route('logout') }}"]');
  if (anyLogoutForm) {
    anyLogoutForm.submit();
  }
}

document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    closeLogoutModal();
  }
});

document.addEventListener('click', function(event) {
  const modal = document.getElementById('logout-confirm-modal');
  if (modal && event.target === modal) {
    closeLogoutModal();
  }
});
</script>
