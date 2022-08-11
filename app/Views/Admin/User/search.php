<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Get Session Data -->
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
        <div class="row">
            <div class="col mb-2">
                <?php if($session['adminStatus'] == 3 || $session['adminStatus'] == 1) {; ?>
                <a href="<?php echo base_url(); ?>/Admin/User/formInsert" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Karyawan</span>
                </a>
                <?php } else {} ?>
            </div>
            <div class="col-lg-4 mb-2">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?= base_url(); ?>/Admin/User/search" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data Karyawan" aria-label="Search" aria-describedby="basic-addon2" name="search" id="search">
                            <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($user)) { ?>
                    <?php $i = 1; ?>
                    <?php foreach($user as $user) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['nik']; ?></td>
                        <td><?= $user['jenis_kelamin']; ?></td>
                        <td><?= $user['nama_jabatan']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/User/<?= $user['nik']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                            <?php if(($session['adminStatus'] == $user['jabatan_id'] && $session['adminStatus'] == 3) || $user['jabatan_id'] == 4 || $session['adminStatus'] == 1) {; ?>   
                                <a href="<?php echo base_url(); ?>/Admin/User/formEdit/<?= $user['slug']; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <?php if($user['uid'] == 4 || $session['adminStatus'] == 1) { ?>
                                    <form action="<?php echo base_url(); ?>/Admin/User/<?= $user['user_id']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                                    </form>
                                <?php } else {} ?>
                            <?php } else {} ?>
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
        </div>
    </div>
</div>

<?= $this->endSection(); ?>