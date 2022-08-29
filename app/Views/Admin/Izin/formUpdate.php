<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Tambah Data Izin Karyawan</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/Izin/update" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" value="<?php echo $izin_arr[0]['izin_id']; ?>" id="id" name="id">
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('name') ? 'is-invalid' : ''); ?>" id="name" name="name" value="<?php echo (old('name') ? old('name') : $izin_arr[0]['user_name']); ?>" readonly="readonly">
            <div class="invalid-feedback"><?php echo $validation->getError('name'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">NIK Karyawan</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik" value="<?php echo (old('nik') ? old('nik') : $izin_arr[0]['izin_nik']); ?>" readonly="readonly">
            <div class="invalid-feedback"><?php echo $validation->getError('nik'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">Jumlah Hari Izin</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('hari') ? 'is-invalid' : ''); ?>" id="hari" name="hari" value="<?php echo (old('hari') ? old('hari') : $izin_arr[0]['izin_hari']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('hari'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan Izin</label>
            <select class="form-select <?php echo ($validation->hasError('status') ? 'is-invalid' : ''); ?>" id="status" name="status" value="<?php echo (old('status') ? old('status') : $izin_arr[0]['izin_status_id']); ?>">
                <option selected disabled>Pilih Keterangan Izin</option>    
                <?php foreach($statusIzin as $statusIzin) : ?>
                <option value="<?php echo $statusIzin['status_izin_id']; ?>"><?php echo $statusIzin['status_izin_keterangan']; ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback"><?php echo $validation->getError('status'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Izin dengan syarat</label>
            <select class="form-select <?php echo ($validation->hasError('syarat') ? 'is-invalid' : ''); ?>" id="syarat" name="syarat" value="<?php echo (old('syarat') ? old('syarat') : $izin_arr[0]['izin_syarat']); ?>">
                <option selected disabled>Pilih Persyaratan Izin</option>   
                <option value="Potong Cuti">Potong Cuti</option>
                <option value="Bebas">Bebas</option>
            </select>
            <div class="invalid-feedback"><?php echo $validation->getError('syarat'); ?></div>
        </div>
        <div class="form-floating input-group mb-4">
            <i class="bi bi-calendar-date input-group-text"></i>
            <input type="text" id="datepicker" class="datepicker_input form-control <?php echo ($validation->hasError('date') ? 'is-invalid' : ''); ?>" placeholder="DD/MM/YYYY" name="date" value="<?php echo (old('date') ? old('date') : $izin_arr[0]['izin_date']); ?>" required>
            <label for="datepicker">Tanggal Izin</label>
            <div class="invalid-feedback"><?php echo $validation->getError('date'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>

<script src='https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker-full.min.js'></script>
<script>
/* Bootstrap 5 JS included */
/* vanillajs-datepicker 1.1.4 JS included */

const getDatePickerTitle = elem => {
  // From the label or the aria-label
  const label = elem.nextElementSibling;
  let titleText = '';
  if (label && label.tagName === 'LABEL') {
    titleText = label.textContent;
  } else {
    titleText = elem.getAttribute('aria-label') || '';
  }
  return titleText;
}

const elems = document.querySelectorAll('.datepicker_input');
for (const elem of elems) {
  const datepicker = new Datepicker(elem, {
    'format': 'yyyy-mm-dd',
    title: getDatePickerTitle(elem)
  });
}      

    $('#syarat').val('<?php echo (old('syarat') ? old('syarat') : $izin_arr[0]['izin_syarat']); ?>').trigger('change');
    $('#status').val('<?php echo (old('status') ? old('status') : $izin_arr[0]['izin_status_id']); ?>').trigger('change');
</script>
<?php echo $this->endSection(); ?>