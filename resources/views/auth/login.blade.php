@extends('layouts.app')

@section('title', 'Masuk - Toko Mas Sumatra')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <div class="row g-0">
                        {{-- Left: Login form --}}
                        <div class="col-md-7 p-4">
                            <div class="mb-4 text-center">
                                <h3 class="fw-bold mb-0">Masuk ke Akun</h3>
                                <p class="small text-muted mb-0">Akses layanan digital Toko Mas Sumatra</p>
                            </div>

                            {{-- Flash / status --}}
                            @if(session('status'))
                                <div class="alert alert-info">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{-- Validation errors --}}
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0 small">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Email Address</label>
                                    <input name="email" type="email" required
                                           value="{{ old('email') }}"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           placeholder="nama@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3 position-relative">
                                    <label class="form-label small fw-semibold">Password</label>
                                    <div class="input-group">
                                        <input name="password" id="login-password" type="password" required
                                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               placeholder="Masukkan password">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Tampilkan/ sembunyikan password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="remember">Remember me</label>
                                    </div>
                                    <div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
                                        @else
                                            <a href="{{ url('/password/reset') }}" class="small">Lupa password?</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-dark btn-lg">MASUK SEKARANG</button>
                                </div>
                            </form>

                            <div class="text-center small text-muted my-3">atau akses sebagai</div>

                            {{-- Optional: role toggle (visual only) --}}
                            <div class="d-flex gap-2 justify-content-center mb-3">
                                <button class="btn btn-outline-secondary btn-sm px-3">Pelanggan</button>
                                <button class="btn btn-outline-warning btn-sm px-3">Staff Admin</button>
                            </div>

                            <hr>

                            <div class="text-center small text-muted">
                                Belum punya akun? <a href="{{ route('register.show') }}">Daftar sekarang</a>
                            </div>
                        </div>

                        {{-- Right: Social / Phone / CTA --}}
                        <div class="col-md-5 bg-light p-4 d-flex flex-column justify-content-center">
                            <div class="text-center mb-3">
                                <h6 class="fw-semibold mb-2">Masuk dengan</h6>
                                <p class="small text-muted mb-0">Gunakan akun media sosial atau nomor telepon</p>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                {{-- Google --}}
                                <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('img/icons/google.svg') }}" alt="Google" style="height:18px; margin-right:8px;">
                                    Masuk dengan Google
                                </a>

                                {{-- Nomor Telepon --}}
                                <button class="btn btn-outline-dark d-flex align-items-center justify-content-center" id="openPhoneRegister">
                                    <i class="bi bi-phone me-2"></i> Daftar / Masuk dengan Nomor Telepon
                                </button>
                            </div>

                            <div class="small text-muted text-center mt-auto">
                                Dengan masuk, Anda setuju dengan <a href="{{ url('/terms') }}">Syarat & Ketentuan</a> kami.
                            </div>
                        </div>
                    </div> {{-- /.row --}}
                </div> {{-- /.card --}}
            </div>
        </div>
    </div>
</div>

{{-- Modal: Phone registration / OTP starter --}}
<div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="phoneModalLabel">Daftar / Masuk via Nomor Telepon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p class="small text-muted">Masukkan nomor telepon Anda. Kami akan mengirim kode OTP untuk verifikasi.</p>

        <form id="phoneRegisterForm" method="POST" action="{{ route('register.phone.sendOtp') ?? '#' }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small">Nomor Telepon</label>
                <input type="tel" name="phone_number" id="phone_number" class="form-control" placeholder="+6281234567890" required>
            </div>

            <div id="phoneFormMsg" class="small text-danger mb-2" style="display:none;"></div>

            <div class="d-grid">
                <button type="submit" class="btn btn-dark">Kirim Kode OTP</button>
            </div>
        </form>

        <div class="mt-3 small text-muted">
            Untuk percobaan developer, Anda bisa mengatur nomor uji di Firebase Console (jika menggunakan Firebase).
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // toggle password visibility
    const pwToggle = document.getElementById('togglePassword');
    const pwInput = document.getElementById('login-password');
    if (pwToggle && pwInput) {
        pwToggle.addEventListener('click', function () {
            if (pwInput.type === 'password') {
                pwInput.type = 'text';
                pwToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                pwInput.type = 'password';
                pwToggle.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    }

    // open phone modal
    const openPhoneBtn = document.getElementById('openPhoneRegister');
    if (openPhoneBtn) {
        openPhoneBtn.addEventListener('click', function () {
            var phoneModal = new bootstrap.Modal(document.getElementById('phoneModal'));
            phoneModal.show();
        });
    }

    // phone form submit: simple UX handler (actual OTP flow implemented server-side / Firebase later)
    const phoneForm = document.getElementById('phoneRegisterForm');
    if (phoneForm) {
        phoneForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const msgEl = document.getElementById('phoneFormMsg');
            msgEl.style.display = 'none';
            // basic validation
            const phone = document.getElementById('phone_number').value.trim();
            if (!phone) {
                msgEl.textContent = 'Nomor telepon diperlukan.';
                msgEl.style.display = 'block';
                return;
            }
            // show loading state then POST via fetch (expects backend endpoint register.phone.sendOtp)
            const btn = phoneForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Mengirim...';
            fetch(phoneForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ phone_number: phone })
            })
            .then(r => r.json())
            .then(data => {
                if (data.status && data.status === 'ok') {
                    // close modal and redirect to OTP page or show input
                    location.href = '{{ route("register.show") }}?phone=' + encodeURIComponent(phone);
                } else {
                    msgEl.textContent = data.message || 'Gagal mengirim OTP. Coba lagi.';
                    msgEl.style.display = 'block';
                }
            })
            .catch(err => {
                msgEl.textContent = 'Terjadi kesalahan jaringan.';
                msgEl.style.display = 'block';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    }
});
</script>
@endsection