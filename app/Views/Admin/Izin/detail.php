<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<?php $session = session()->get(); ?>
<div class="p-5">
    <div class="text-center mb-2">
        <h1 class="h3 mb-0 text-gray-800">Detail Izin Karyawan</h1>
    </div>
    <div class="text-center mb-4">
        <button id="printPdf" class="btn btn-primary"> Generate PDF</button>
    </div>
    <div id="printSection">
        <h1 class="h4 text-gray-900 mb-4" id="pagetitle">Form Izin Karyawan</h1>
        <form class="user" action="#">
            <div class="mb-3">
                <label class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $izin[0]['user_name']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label ">NIK Karyawan</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $izin[0]['izin_nik']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label ">Jumlah Hari Izin</label>
                <input type="text" class="form-control" id="hari" name="hari" value="<?php echo $izin[0]['izin_hari']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan Izin</label>
                <select class="form-select" id="status" name="status" value=" " disabled="disabled">
                    <option selected disabled>Pilih Keterangan Izin</option>    
                    <?php foreach($statusIzin as $statusIzin) : ?>
                    <option value="<?= $statusIzin['status_izin_id']; ?>" <?= ($izin[0]['izin_status_id'] === $statusIzin['status_izin_id'] ? 'selected' : ''); ?>><?= $statusIzin['status_izin_keterangan']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Izin dengan syarat</label>
                <select class="form-select" id="syarat" name="syarat" value=" " disabled="disabled">
                    <option selected disabled>Pilih Persyaratan Izin</option>   
                    <option value="Potong Cuti">Potong Cuti</option>
                    <option value="Bebas">Bebas</option>
                </select>
            </div>
            <div class="form-floating input-group mb-4">
                <i class="bi bi-calendar-date input-group-text"></i>
                <input type="text" id="datepicker" class="datepicker_input form-control" placeholder="DD/MM/YYYY" name="date" value="<?php echo $izin[0]['izin_date']; ?>" readonly>
                <label for="datepicker">Tanggal Izin</label>
            </div>
        </form>
        <div style="display:flex; justify-content: space-around; margin-top:50px; margin-bottom: 100px;">
            <p style="text-align: center; width: 33%;">Pemohon</p>
            <p style="text-align: center; width: 33%;">Manager</p>
            <p style="text-align: center; width: 33%;">Mengetahui</p>
        </div>
        <div style="display:flex;  justify-content: space-around;">
            <p style="text-align: center; width: 33%;">(<?php echo $izin[0]['user_name'] ?>)</p>
            <p style="text-align: center; width: 33%;">(..............................)</p>
            <p style="text-align: center; width: 33%;">( <?php echo $session['adminName'] ?> )</p>
        </div>
    </div>
    
    <hr>
</div>

<script src='https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker-full.min.js'></script>
<script>
/* Bootstrap 5 JS included */
/* vanillajs-datepicker 1.1.4 JS included */

$('#syarat').val('<?= (old('syarat') ? old('syarat') : $izin[0]['izin_syarat']); ?>').trigger('change');
    $('#status').val('<?= (old('status') ? old('status') : $izin[0]['izin_status_id']); ?>').trigger('change');
</script>
<?= $this->endSection(); ?>