<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<!-- Get Session Data -->
<?php $session = session()->get(); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Kantor</h1>
    <a href="<?php echo base_url(); ?>/Admin/Kantor/export" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-1 font-weight-bold text-primary">Data Kantor</h6>
        <?php if(session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">            
        <div class="row">
            <div class="col-lg-8 mb-2">
                <a href="<?php echo base_url(); ?>/Admin/Kantor/formInsert" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Kantor</span>
                </a>
            </div>
            <div class="col-lg-4 mb-2">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?php echo base_url(); ?>/Admin/Kantor">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data kantor" aria-label="Search" aria-describedby="basic-addon2" name="search" id="search" value="<?php echo $searchInput ?>">
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
            <?php if (!empty($kantor_arr)) { ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kantor</th>
                        <th>Alamat Kantor</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($kantor_arr as $kantor) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $kantor['kantor_name']; ?></td>
                        <td><?php echo $kantor['kantor_alamat']; ?></td>
                        <td><?php echo $kantor['kantor_created_datetime']; ?></td>
                        <td><?php echo $kantor['kantor_updated_datetime']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Kantor/formUpdate/<?php echo $kantor['kantor_id']; ?>"><button type="button" class="btn btn-warning mb-1">Edit</button></a>
                            <form action="<?php echo base_url(); ?>/Admin/Kantor/<?php echo $kantor['kantor_id']; ?>" method="post" class="d-inline mb-1">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="col">
                <?php echo $pager->links('kantor', 'pagination') ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger" role="alert">
                Tidak Ada Data Kantor
            </div>
        <?php } ?>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>