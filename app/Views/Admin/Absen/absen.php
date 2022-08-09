<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<?php if(session()->getFlashData('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Absensi Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($absen)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($absen as $absen) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $absen['name']; ?></td>
                        <td><?= $absen['tanggal']; ?></td>
                        <td><?= $absen['latitude'] .' '. $absen['longitude']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Absensi/<?= $absen['absen_id']; ?>"><button type="button" class="btn btn-warning">Details</button></a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Tidak Ada data Absensi
                        </div>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-4">
                    <a href="<?php echo base_url(); ?>/Admin/Absensi/formInsert" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-flag"></i>
                        </span>
                        <span class="text">Tambah Data Absensi</span>
                    </a>
                </div>
                <div class="col-lg-8 end-0">
                    <?= $pager->links('absen', 'pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>