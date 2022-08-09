<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<?php $session = session()->get(); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-1 font-weight-bold text-primary">Data Karyawan</h6>
        <?php if(session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($user)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($user as $user) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['nik']; ?></td>
                        <td><?= $user['jenis_kelamin']; ?></td>
                        <td><?= $user['absenLabel']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/User/<?= $user['nik']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Tidak Ada data Karyawan
                        </div>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col">
                    <?= $pager->links('user', 'pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>