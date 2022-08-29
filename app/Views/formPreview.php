<?php echo $this->extend('Layout/template'); ?>
<?php echo $this->section('content'); ?>
<div class="container">
    <div class="p-5">
    <?php if(session()->getFlashData('pesan')) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <div class="text-center mb-4">
        <button id="printPdf" class="btn btn-primary"> Generate PDF</button>
    </div>
        <div id="printSection">
            <h1 class="h4 text-gray-900 mb-4" id="pagetitle">Form Izin Karyawan</h1>
            <form class="user" action="#">
                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $lastInsert[0]['user_name']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label ">NIK Karyawan</label>
                    <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $lastInsert[0]['izin_nik']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label ">Jumlah Hari Izin</label>
                    <input type="text" class="form-control" id="hari" name="hari" value="<?php echo $lastInsert[0]['izin_hari']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan Izin</label>
                    <select class="form-select" id="status" name="status" value=" " disabled="disabled">
                        <option selected disabled>Pilih Keterangan Izin</option>    
                        <?php foreach($statusIzin as $statusIzin) : ?>
                        <option value="<?php echo $statusIzin['status_izin_id']; ?>" <?php echo ($lastInsert[0]['izin_status_id'] === $statusIzin['status_izin_id'] ? 'selected' : ''); ?>><?php echo $statusIzin['status_izin_keterangan']; ?></option>
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
                    <input type="text" id="datepicker" class="datepicker_input form-control" placeholder="DD/MM/YYYY" name="date" value="<?php echo $lastInsert[0]['izin_date']; ?>" readonly>
                    <label for="datepicker">Tanggal Izin</label>
                </div>
            </form>
            <div style="display:flex; justify-content: space-around; margin-top:50px; margin-bottom: 100px;">
                <p style="text-align: center; width: 33%;">Pemohon</p>
                <p style="text-align: center; width: 33%;">Manager</p>
                <p style="text-align: center; width: 33%;">Mengetahui</p>
            </div>
            <div style="display:flex;  justify-content: space-around;">
                <p style="text-align: center; width: 33%;">(<?php echo $lastInsert[0]['user_name'] ?>)</p>
                <p style="text-align: center; width: 33%;">(..............................)</p>
                <p style="text-align: center; width: 33%;">(..............................)</p>
            </div>
        </div>
    </div>
</div>

<script>
    $('#syarat').val('<?php echo (old('syarat') ? old('syarat') : $lastInsert[0]['izin_syarat']); ?>').trigger('change');
</script>
<?php echo $this->endSection(); ?>