<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-1 font-weight-bold text-primary">Data Akun Admin</h6>
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>NIK</th>
                        <th>Jabatan</th>
                        <th>Crated At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($admin)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($admin as $admin) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $admin['name']; ?></td>
                        <td><?= $admin['username']; ?></td>
                        <td><?= $admin['email']; ?></td>
                        <td><?= $admin['nik']; ?></td>
                        <td><?= $admin['nama_jabatan']; ?></td>
                        <td><?= $admin['created_at']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Admin/formEdit/<?= $admin['nik']; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <form action="<?php echo base_url(); ?>/Admin/Admin/<?= $admin['admin_id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                            </form>
                        </td>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Tidak Ada data Karyawan
                        </div>
                    <?php } ?>
                </tbody>
            </table>
            
            <div class="row">
                <div class="col-lg-4">
                    <a href="<?php echo base_url(); ?>/Admin/Admin/formInsert" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-flag"></i>
                        </span>
                        <span class="text">Buat Akun Baru</span>
                    </a>
                </div>
                <div class="col-lg-8 end-0">
                    <?= $pager->links('admin', 'pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>