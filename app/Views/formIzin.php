<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">Form Izin Karyawan</h1>
        </div>
        <?php if(session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <form class="user" action="<?php echo base_url(); ?>/Izin/insert" method="POST">
            <?= csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control <?= ($validation->hasError('name') ? 'is-invalid' : ''); ?>" id="name" name="name" value="<?= old('name'); ?>">
                <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label ">NIK Karyawan</label>
                <input type="text" class="form-control <?= ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik" value="<?= old('nik'); ?>">
                <div class="invalid-feedback"><?= $validation->getError('nik'); ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label ">Jumlah Hari Izin</label>
                <input type="text" class="form-control <?= ($validation->hasError('hari') ? 'is-invalid' : ''); ?>" id="hari" name="hari" value="<?= old('hari'); ?>">
                <div class="invalid-feedback"><?= $validation->getError('hari'); ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan Izin</label>
                <select class="form-select <?= ($validation->hasError('status') ? 'is-invalid' : ''); ?>" id="status" name="status" value="<?= old('status'); ?>">
                    <option selected disabled>Pilih Keterangan Izin</option>    
                    <?php foreach($statusIzin as $statusIzin) : ?>
                    <option value="<?= $statusIzin['status_izin_id']; ?>" <?= (old('status') === $statusIzin['status_izin_id'] ? 'selected' : ''); ?>><?= $statusIzin['status_izin_keterangan']; ?></option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback"><?= $validation->getError('status'); ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label">Izin dengan syarat</label>
                <select class="form-select <?= ($validation->hasError('syarat') ? 'is-invalid' : ''); ?>" id="syarat" name="syarat" value="<?= old('syarat'); ?>">
                    <option selected disabled>Pilih Persyaratan Izin</option>   
                    <option value="Potong Cuti">Potong Cuti</option>
                    <option value="Bebas">Bebas</option>
                </select>
                <div class="invalid-feedback"><?= $validation->getError('syarat'); ?></div>
            </div>
            <div class="form-floating input-group mb-4">
                <i class="bi bi-calendar-date input-group-text"></i>
                <input type="text" id="datepicker" class="datepicker_input form-control <?= ($validation->hasError('date') ? 'is-invalid' : ''); ?>" placeholder="DD/MM/YYYY" name="date" value="<?= old('date'); ?>" required>
                <label for="datepicker">Tanggal Izin</label>
                <div class="invalid-feedback"><?= $validation->getError('date'); ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <hr>
    </div>
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
</script>
<?= $this->endSection(); ?>