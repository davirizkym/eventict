@extends('layouts.app')

@section('title', 'Invoice Pembayaran — ' . $registration->registration_code . ' — Eventict')

@section('content')
<div class="w-full min-h-screen bg-slate-100/70 flex flex-col justify-start items-center font-['Poppins']">
  <header class="self-stretch h-16 px-6 lg:px-20 bg-blue-950 border-b border-slate-900 flex justify-between items-center sticky top-0 z-50">
    <a href="{{ route('home') }}" class="flex items-center group">
      <img src="{{ asset('logo_white.svg') }}" alt="Eventict" class="h-8 w-auto">
    </a>

    <div class="flex items-center gap-3">
      <a href="{{ route('peserta.dashboard', ['tab' => 'tiket']) }}" class="px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg flex items-center gap-1.5 transition text-xs font-medium">
        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m15 18-6-6 6-6"/>
        </svg>
        <span>Tiket Saya</span>
      </a>
    </div>
  </header>

  <div class="w-full max-w-xl mx-auto px-4 py-8 pb-24 md:pb-8 flex flex-col gap-4">
    @if(session('success'))
      <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2.5 text-xs text-emerald-900 shadow-2xs">
        <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-2.5 text-xs text-rose-900 shadow-2xs">
        <svg class="size-4 text-rose-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
      </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
      <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between gap-3">
        <div>
          <span class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase block">Invoice Tagihan</span>
          <h1 class="text-base sm:text-lg font-bold text-slate-900 font-mono mt-0.5">{{ $registration->registration_code }}</h1>
        </div>
        <div>
          @if($registration->payment_status === 'pending')
            @if($expiresAt->isPast())
              <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-xs font-semibold">
                Kedaluwarsa
              </span>
            @else
              <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-xs font-semibold">
                Menunggu Pembayaran
              </span>
            @endif
          @elseif($registration->payment_status === 'paid')
            <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-semibold">
              Lunas
            </span>
          @else
            <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-semibold">
              Gratis
            </span>
          @endif
        </div>
      </div>

      @if($registration->payment_status === 'pending')
        <div class="px-5 sm:px-6 py-3 bg-amber-50/80 border-b border-amber-200/70 flex items-center justify-between gap-2 text-xs text-amber-950">
          <div class="flex items-center gap-2">
            <svg class="size-4 text-amber-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span class="text-[11px] text-amber-900 font-medium">Batas Waktu:</span>
          </div>
          <div class="font-mono font-bold text-xs text-amber-900">
            <span id="countdown-display">Memuat...</span>
          </div>
        </div>
      @elseif($registration->payment_status === 'paid')
        <div class="px-5 sm:px-6 py-3 bg-emerald-50 border-b border-emerald-200 flex items-center justify-between gap-2 text-xs text-emerald-950">
          <div class="flex items-center gap-2 font-medium">
            <svg class="size-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>Pembayaran terverifikasi</span>
          </div>
          @if($registration->event->format === 'offline' && $registration->qr_pass)
            <span class="font-mono font-semibold text-[11px] text-emerald-800">
              PASS: #{{ $registration->qr_pass }}
            </span>
          @else
            <span class="font-semibold text-[11px] text-emerald-800">
              Akses Online Aktif
            </span>
          @endif
        </div>
      @endif

      <div class="p-5 sm:p-6 flex flex-col gap-5">
        <div class="flex flex-col gap-1.5 pb-4 border-b border-slate-100">
          <div class="flex items-center gap-2 text-[11px] text-slate-500">
            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded font-semibold uppercase text-[10px]">{{ $registration->event->category }}</span>
            <span>&bull;</span>
            <span>{{ $registration->event->start_date ? $registration->event->start_date->format('d M Y') : '' }} ({{ substr($registration->event->start_time ?? '', 0, 5) }} WIB)</span>
          </div>
          <a href="{{ route('events.show', $registration->event->slug) }}" class="text-sm sm:text-base font-bold text-slate-900 hover:text-blue-950 transition leading-snug">
            {{ $registration->event->title }}
          </a>
          <div class="text-xs text-slate-500 mt-0.5">
            Format: <strong class="text-slate-700 font-medium">{{ ($registration->attendance_mode ?? $registration->event->format) === 'offline' ? 'Luring' : 'Daring' }}</strong> &bull; Lokasi: {{ $registration->event->location }}
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3 pb-4 border-b border-slate-100 text-xs">
          <div>
            <span class="text-slate-400 text-[11px] block">Nama Peserta</span>
            <span class="font-semibold text-slate-800 mt-0.5 block truncate">{{ $registration->user->name }}</span>
          </div>
          <div>
            <span class="text-slate-400 text-[11px] block">Kontak</span>
            <span class="font-medium text-slate-700 mt-0.5 block truncate">{{ $registration->user->phone ?: $registration->user->email }}</span>
          </div>
        </div>

        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/80 flex flex-col gap-2">
          <div class="flex justify-between items-center text-xs text-slate-600">
            <span>Harga Tiket</span>
            <span class="font-semibold text-slate-900">
              Rp {{ number_format($registration->amount_paid > 0 ? $registration->amount_paid : $registration->event->price, 0, ',', '.') }}
            </span>
          </div>
          <div class="pt-2 border-t border-slate-200 flex justify-between items-center">
            <span class="text-xs font-bold text-slate-900">Total Pembayaran</span>
            <span class="text-lg font-bold text-blue-950 font-mono">
              Rp {{ number_format($registration->amount_paid > 0 ? $registration->amount_paid : $registration->event->price, 0, ',', '.') }}
            </span>
          </div>
        </div>

        @if($registration->payment_status === 'pending')
          @php
            $isExpired = $expiresAt->isPast();
          @endphp
          <div id="payment-active-container" class="{{ $isExpired ? 'hidden' : 'flex' }} flex-col gap-2.5 pt-1">
            <button
              type="button"
              id="pay-action-btn"
              onclick="startPayment()"
              class="w-full py-3 px-4 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 shadow-2xs cursor-pointer"
            >
              <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect width="20" height="14" x="2" y="5" rx="2"/>
                <line x1="2" y1="10" x2="22" y2="10"/>
              </svg>
              <span>Bayar Sekarang</span>
            </button>

            <div class="grid grid-cols-2 gap-2">
              <button
                type="button"
                id="check-status-btn"
                onclick="checkPaymentStatus(true)"
                class="py-2.5 px-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-xl text-xs font-medium transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer"
              >
                <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                  <path d="M3 3v5h5"/>
                  <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                  <path d="M16 21h5v-5"/>
                </svg>
                <span>Cek Status</span>
              </button>

              <form method="POST" action="{{ route('peserta.registration.cancel', $registration->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran kegiatan ini?');" class="w-full">
                @csrf
                @method('DELETE')
                <button
                  type="submit"
                  class="w-full py-2.5 px-3 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-xs font-medium transition cursor-pointer text-center"
                >
                  Batalkan
                </button>
              </form>
            </div>
          </div>

          <div id="payment-expired-container" class="{{ $isExpired ? 'flex' : 'hidden' }} flex-col gap-2.5 pt-1">
            <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-center text-xs text-rose-800">
              <span class="font-bold block">Batas Waktu Pembayaran Habis</span>
              <span class="text-[11px] text-rose-600 mt-0.5 block">Sesi pembayaran 10 menit telah kedaluwarsa. Kuota tiket telah dikembalikan. Silakan daftar ulang.</span>
            </div>
            <a
              href="{{ route('events.register.form', $registration->event->slug) }}"
              class="w-full py-3 px-4 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition text-center shadow-2xs"
            >
              Daftar Ulang Kegiatan &rarr;
            </a>
          </div>
        @else
          <div class="flex flex-col gap-2 pt-1">
            <a
              href="{{ route('peserta.dashboard', ['tab' => 'tiket']) }}"
              class="w-full py-3 px-4 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-semibold transition text-center shadow-2xs"
            >
              Buka E-Tiket di Portal Peserta &rarr;
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
const registrationId = '{{ $registration->id }}';
let paymentToken = '{{ $registration->snap_token }}';
const expiresTimestamp = {{ $expiresAt->timestamp * 1000 }};

function updateCountdown() {
  const display = document.getElementById('countdown-display');
  if (!display) return;

  const now = Date.now();
  const diff = expiresTimestamp - now;

  if (diff <= 0) {
    display.textContent = 'Kedaluwarsa';
    display.className = 'text-rose-600 font-bold';
    const activeCont = document.getElementById('payment-active-container');
    const expiredCont = document.getElementById('payment-expired-container');
    if (activeCont && expiredCont) {
      activeCont.classList.add('hidden');
      activeCont.classList.remove('flex');
      expiredCont.classList.remove('hidden');
      expiredCont.classList.add('flex');
    }
    return;
  }

  const hours = Math.floor(diff / (1000 * 60 * 60));
  const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((diff % (1000 * 60)) / 1000);

  const formatted = 
    String(hours).padStart(2, '0') + 'j ' + 
    String(minutes).padStart(2, '0') + 'm ' + 
    String(seconds).padStart(2, '0') + 's';

  display.textContent = formatted;
}

setInterval(updateCountdown, 1000);
updateCountdown();

function startPayment() {
  if (paymentToken && paymentToken !== '') {
    launchPayment(paymentToken);
    return;
  }

  const btn = document.getElementById('pay-action-btn');
  const originalText = btn ? btn.innerHTML : '';
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<span>Memuat Pembayaran...</span>';
  }

  fetch('/pembayaran/' + registrationId + '/snap-token', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = originalText;
    }
    if (data.status === 'already_paid') {
      window.location.reload();
      return;
    }
    if (data.status === 'success' && data.snap_token) {
      paymentToken = data.snap_token;
      launchPayment(data.snap_token);
    } else {
      alert(data.message || 'Gagal memuat sesi pembayaran.');
    }
  })
  .catch(err => {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = originalText;
    }
    alert('Terjadi kesalahan jaringan saat memuat sesi pembayaran.');
  });
}

function launchPayment(token) {
  if (typeof window.snap === 'undefined') {
    alert('Sistem pembayaran sedang disiapkan. Silakan muat ulang halaman.');
    return;
  }

  window.snap.pay(token, {
    onSuccess: function(result) {
      checkPaymentStatus(false, result ? result.order_id : null);
    },
    onPending: function(result) {
      checkPaymentStatus(false, result ? result.order_id : null);
    },
    onError: function(result) {
      alert('Pembayaran gagal diproses atau transaksi dibatalkan.');
    },
    onClose: function() {
    }
  });
}

function checkPaymentStatus(showAlert, orderId) {
  const checkBtn = document.getElementById('check-status-btn');
  const originalBtnText = checkBtn ? checkBtn.innerHTML : '';
  if (checkBtn && showAlert) {
    checkBtn.disabled = true;
    checkBtn.innerHTML = '<span>Memeriksa...</span>';
  }

  fetch('/pembayaran/' + registrationId + '/check-status', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ order_id: orderId || null })
  })
  .then(res => res.json())
  .then(data => {
    if (checkBtn && showAlert) {
      checkBtn.disabled = false;
      checkBtn.innerHTML = originalBtnText;
    }
    if (data.status === 'paid') {
      alert(data.message || 'Pembayaran berhasil dikonfirmasi! E-Tiket Anda telah aktif.');
      window.location.reload();
    } else {
      if (showAlert) {
        alert(data.message || 'Status pembayaran belum terkonfirmasi.');
      }
    }
  })
  .catch(err => {
    if (checkBtn && showAlert) {
      checkBtn.disabled = false;
      checkBtn.innerHTML = originalBtnText;
    }
    if (showAlert) {
      alert('Gagal menghubungi server untuk memverifikasi pembayaran.');
    }
  });
}
</script>

@include('partials.public-bottom-nav')
@endsection
