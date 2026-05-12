@extends('layouts.main')

@section('content')

<!-- 🔥 SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 🔥 BOOTSTRAP ICON -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-4 py-md-5 d-flex justify-content-center">

<div class="card form-card shadow-lg border-0 w-100">
<div class="card-body p-4 p-md-5">

    <h3 class="text-center fw-bold mb-4 judul-form">
        <i class="bi bi-file-text-fill text-primary"></i> 
        Surat Keterangan Tidak Mampu
    </h3>

<form id="formTidakMampu" action="{{ route('tidak-mampu.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row g-3">

    <!-- NIK -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="text" id="nik" name="nik" class="form-control" placeholder="NIK" maxlength="16" required>
            <label>NIK</label>
        </div>
        <small id="errorNik"></small>
    </div>

    <!-- Nama -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
            <label>Nama</label>
        </div>
        <small class="error"></small>
    </div>

    <!-- BIN -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="text" name="bin_binti" class="form-control" placeholder="Bin/Binti">
            <label>Bin / Binti</label>
        </div>
    </div>

    <!-- Tempat Lahir -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="text" name="tempat_lahir" class="form-control" required>
            <label>Tempat Lahir</label>
        </div>
    </div>

    <!-- Tanggal Lahir -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="date" name="tanggal_lahir" class="form-control" required>
            <label>Tanggal Lahir</label>
        </div>
    </div>

    <!-- Gender -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">Pilih</option>
                <option>Laki-laki</option>
                <option>Perempuan</option>
            </select>
            <label>Jenis Kelamin</label>
        </div>
    </div>

    <!-- Agama -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select name="agama" class="form-control" required>
                <option value="">Pilih</option>
                <option>Islam</option>
                <option>Kristen</option>
                <option>Katolik</option>
                <option>Hindu</option>
                <option>Buddha</option>
                <option>Konghucu</option>
            </select>
            <label>Agama</label>
        </div>
    </div>

    <!-- Status -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select name="status" class="form-control" required>
                <option value="">Pilih</option>
                <option>Belum Menikah</option>
                <option>Menikah</option>
            </select>
            <label>Status</label>
        </div>
    </div>

    <!-- Kewarganegaraan -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select name="kewarganegaraan" class="form-control" required>
                <option value="">Pilih</option>
                <option>WNI</option>
                <option>WNA</option>
            </select>
            <label>Kewarganegaraan</label>
        </div>
    </div>

    <!-- Pekerjaan -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="text" name="pekerjaan" class="form-control" required>
            <label>Pekerjaan</label>
        </div>
    </div>

    <!-- Alamat -->
    <div class="col-12">
        <div class="form-floating">
            <textarea name="alamat" class="form-control" style="height:100px" required></textarea>
            <label>Alamat Domisili</label>
             <small class="text-muted">
        Tuliskan alamat lengkap sesuai domisili saat ini.
    </small>

    <small class="text-muted d-block">
        Pastikan berada dalam wilayah Kelurahan Sekarjaya.
    </small>
        </div>
    </div>
    <!-- NO WA -->
<div class="col-12 mt-3">
    <div class="form-floating">
        <input type="text" name="no_wa" class="form-control" placeholder="08xxxxxxxxxx" required>
        <label>No WhatsApp</label>
    </div>

    <small class="text-muted">
        Nomor digunakan untuk notifikasi saat surat selesai diproses.
    </small>
</div>

    <!-- Upload -->
    <div class="col-12">
        <label class="mb-1 fw-semibold">
            <i class="bi bi-upload"></i> Upload KTP 
        </label>
        <input type="file" name="upload_ktp" class="form-control" accept="image/png, image/jpeg">
        <small class="text-muted">

<small class="text-muted d-block">
Format JPG/PNG/PDF maksimal 10MB.
</small>

<small class="text-muted d-block">
Pastikan Foto Ktp  terlihat jelas dan dapat dibaca, data ini Digunakan untuk verifikasi kondisi dan domisili pemohon.

</small>
    </div>

</div>

<div class="mt-4">
    <button type="button" onclick="konfirmasiSubmit()" class="btn btn-primary btn-lg w-100">
        <i class="bi bi-send-fill"></i> Kirim Sekarang
    </button>
</div>

</form>

</div>
</div>

</div>

<script>
// VALIDASI NIK
document.getElementById('nik').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    const error = document.getElementById('errorNik');

    if (this.value.length > 0 && this.value.length < 16) {
        error.innerText = "NIK harus 16 digit!";
        error.style.color = "red";
    } else if (this.value.length == 16) {
        error.innerText = "✔ NIK valid";
        error.style.color = "green";
    } else {
        error.innerText = "";
    }
});

// VALIDASI FILE
document.querySelector('input[name="upload_ktp"]').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    const allowed = ['image/jpeg','image/png','application/pdf'];

    if (!allowed.includes(file.type)) {
        Swal.fire('Error','Format harus JPG/PNG/PDF','error');
        this.value = '';
        return;
    }

    if (file.size > 10 * 1024 * 1024) {
        Swal.fire('Error','File maksimal 10MB','error');
        this.value = '';
    }
});

// SUBMIT
function konfirmasiSubmit() {
    let form = document.getElementById('formTidakMampu');

    let inputs = form.querySelectorAll('[required]');
    let kosong = [];

    inputs.forEach((input) => {
        if (!input.value || input.value.trim() === '') {
            kosong.push(input);
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }
    });

    let nik = document.getElementById('nik').value;
    if (nik.length !== 16) {
        Swal.fire('Error','NIK harus 16 digit','error');
        return;
    }

    if (kosong.length > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Form Belum Lengkap!',
            text: 'Masih ada data yang belum diisi!',
        });
        return;
    }

    Swal.fire({
        title: 'Kirim Data?',
        text: "Pastikan data sudah benar",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Cek Lagi'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// 🔥 POPUP SUCCESS + AUTO REDIRECT
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Permohonan berhasil dikirim',
    confirmButtonText: 'Cek Status'
}).then(() => {
    window.location.href = "/cek-status";
});
@endif

</script>

@if(session('error'))
<script>
Swal.fire({
    title: 'Gagal!',
    text: '{{ session('error') }}',
    icon: 'error',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'OK'
});
</script>
@endif

@endsection