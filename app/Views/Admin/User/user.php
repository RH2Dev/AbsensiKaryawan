<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Get Session Data -->
<?php $session = session()->get(); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Karayawan</h1>
    <a href="<?= base_url(); ?>/Admin/User/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
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
            <div class="col-lg-8 mb-2">
                <?php if($session['adminStatus'] == 3 || $session['adminStatus'] == 1) {; ?>
                <a href="<?php echo base_url(); ?>/Admin/User/formInsert" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Karyawan</span>
                </a>
                <?php }?>
            </div>
            <div class="col-lg-4 mb-2">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?= base_url(); ?>/Admin/User">
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
                    <?php if (!empty($user_arr)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($user_arr as $user) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $user['user_name']; ?></td>
                        <td><?= $user['user_nik']; ?></td>
                        <td><?= $user['user_jenis_kelamin']; ?></td>
                        <td><?= $user['jabatan_nama']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/User/<?= $user['user_nik']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                            <?php if($session['adminStatus'] !== 2) {; ?>   
                                <?php if (($session['adminStatus'] == $user['user_jabatan_id'] && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3) || $user['user_jabatan_id'] == 4 && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3)) || $session['adminStatus'] == 1) {?>
                                <a href="<?php echo base_url(); ?>/Admin/User/formEdit/<?= $user['user_nik']; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <?php } ?>
                                <?php if((($session['adminStatus'] == $user['user_jabatan_id'] && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3) || $user['user_jabatan_id'] == 4 && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3)) && $user['user_name'] !== $session['adminName']) || ($session['adminStatus'] == 1 && $user['user_name'] !== $session['adminName'])) { ?>
                                    <form action="<?php echo base_url(); ?>/Admin/User/<?= $user['user_id']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                                    </form>
                                <?php }?>
                            <?php }?>
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
        
        <div class="row">
            <div class="col">
                <?= $pager->links('user', 'pagination') ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>