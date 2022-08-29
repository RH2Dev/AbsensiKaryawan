<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Akun Admin</h1>
        <a href="<?php echo base_url(); ?>/Admin/Admin/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<!-- Get Session data -->
<?php $session = session()->get(); ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-1 font-weight-bold text-primary">Data Akun Admin</h6>
        <?php if(session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8 mb-2">
                <a href="<?php echo base_url(); ?>/Admin/Admin/formInsert" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Buat Akun Baru</span>
                </a>
            </div>
            <div class="col-lg-4 mb-2">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?php echo base_url(); ?>/Admin/Admin">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data akun" aria-label="Search" aria-describedby="basic-addon2" name="search" id="search" value="<?php echo $searchInput ?>">
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
        <?php if (!empty($admin_arr)) { ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Crated At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($admin_arr as $admin) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $admin['user_name']; ?></td>
                        <td><?php echo $admin['auth_username']; ?></td>
                        <td><?php echo $admin['auth_email']; ?></td>
                        <td><?php echo $admin['jabatan_nama']; ?></td>
                        <td><?php echo $admin['auth_created_datetime']; ?></td>
                        <td>
                            <?php if($admin['user_jabatan_id'] == $session['adminStatus'] || $session['adminStatus'] == 1 || $session['adminStatus'] == 3) { ?>
                                <a href="<?php echo base_url(); ?>/Admin/Admin/formEdit/<?php echo $admin['auth_nik']; ?>"><button type="button" class="btn btn-warning mb-1">Edit</button></a>
                                <?php if($admin['user_name'] !== $session['adminName']) {?>
                                    <form action="<?php echo base_url(); ?>/Admin/Admin/<?php echo $admin['auth_id']; ?>" method="post" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                                    </form>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div>
                <?php echo $pager->links('admin', 'pagination') ?>
            </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">
                    Tidak Ada data Akun
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>