<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<!-- Get Session Data -->
<?php $session = session()->get(); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Karayawan</h1>
    <?php if ($session['adminStatus'] == 1) {?>
        <form action="<?php echo base_url(); ?>/Admin/User/export" style="display: flex;">
            <select class="form-select" id="kantor" name="kantor" style="width: 100px;">
                <option value="" selected disabled>Kantor</option>
                <?php foreach ($kantor_arr as $kantor) : ?>
                <option value="<?php echo $kantor['kantor_id'] ?>"><?php echo $kantor['kantor_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ml-1"><i class="fas fa-download fa-sm text-white-50" ></i> Generate Report</button>
        </form>
    <?php } else { ?>
        <a href="<?php echo base_url(); ?>/Admin/User/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    <?php } ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-1 font-weight-bold text-primary">Data Karyawan</h6>
        <?php if(session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">            
        <div class="row">
            <?php if ($session['adminStatus'] == 1) {?>
            <div class="col-lg-6 mb-2">
            <?php } else { ?>
            <div class="col-lg-8 mb-2">
            <?php } ?>
                <?php if($session['adminStatus'] == 3 || $session['adminStatus'] == 1) {; ?>
                <a href="<?php echo base_url(); ?>/Admin/User/formInsert" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Karyawan</span>
                </a>
                <?php }?>
            </div>
            <?php if ($session['adminStatus'] == 1) {?>
            <div class="col-lg-6 mb-2">
            <?php } else { ?>
            <div class="col-lg-4 mb-2">
            <?php } ?>
                <form action="<?php echo current_url(); ?>" style="display: flex;">
                    <?php if ($session['adminStatus'] == 1) {?>
                    <select class="form-select" id="kantor" name="kantor" style="width: 100px;">
                        <option value="" selected disabled>Kantor</option>
                        <?php foreach ($kantor_arr as $kantor) : ?>
                        <option value="<?php echo $kantor['kantor_id'] ?>" <?php echo ($kantorInput == $kantor['kantor_id'] ? 'selected' : ''); ?>><?php echo $kantor['kantor_name'] ?></option>
                        <?php endforeach; ?>
                    </select>         
                    <button class="btn btn-primary ml-1" type="submit">
                        <i class="fas fa-search fa-sm"></i> Filter
                    </button>
                    <?php } ?>
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data Absensi" aria-label="Search" aria-describedby="basic-addon2" name="search" id="search" value="<?php echo $search ?>">
                                <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <?php if (!empty($user_arr)) { ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Jabatan</th>
                        <th>Kantor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($user_arr as $user) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['user_nik']; ?></td>
                        <td><?php echo $user['user_jenis_kelamin']; ?></td>
                        <td><?php echo $user['jabatan_nama']; ?></td>
                        <td><?php echo $user['kantor_name']; ?></td>
                        <td>
                            <?php if ($user['user_jabatan_id'] == 4) {?>
                            <a href="<?php echo base_url(); ?>/Admin/User/<?php echo $user['user_nik']; ?>"><button type="button" class="btn btn-warning mb-1">Details</button></a>
                            <?php } ?>
                            <?php if($session['adminStatus'] !== 2) {; ?>   
                                <?php if (($session['adminStatus'] == $user['user_jabatan_id'] && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3) || $user['user_jabatan_id'] == 4 && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3)) || $session['adminStatus'] == 1) {?>
                                <a href="<?php echo base_url(); ?>/Admin/User/formEdit/<?php echo $user['user_nik']; ?>"><button type="button" class="btn btn-warning mb-1">Edit</button></a>
                                <?php } ?>
                                <?php if((($session['adminStatus'] == $user['user_jabatan_id'] && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3) || $user['user_jabatan_id'] == 4 && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3)) && $user['user_name'] !== $session['adminName']) || ($session['adminStatus'] == 1 && $user['user_name'] !== $session['adminName'])) { ?>
                                    <form action="<?php echo base_url(); ?>/Admin/User/<?php echo $user['user_id']; ?>" method="post" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger mb-1" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                                    </form>
                                <?php }?>
                            <?php }?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div>
                <?php echo $pager->links('user', 'pagination') ?>
            </div>
            <?php } else { ?>
            <div class="alert alert-danger" role="alert">
                Tidak Ada data Karyawan
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>