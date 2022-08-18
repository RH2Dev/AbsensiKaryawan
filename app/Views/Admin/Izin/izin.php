<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Get Session Data -->
<?php $session = session()->get(); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Izin</h1>
    <form action="<?php echo base_url(); ?>/Admin/Izin/export" style="display: flex;">
        <label style="margin: auto 5px;">Tahun</label>
        <select class="form-select" id="jabatan_id" name="year" style="width: 100px;">
            <?php foreach ($izinYear as $year) : ?>
            <option value="<?php echo $year['Year(izin_date)'] ?>"><?php echo $year['Year(izin_date)'] ?></option>
            <?php endforeach; ?>
        </select>
        <label style="margin: auto 5px;">Bulan</label>
        <select class="form-select" id="month" name="month">
            <option value="" selected>Bulan</option>
            <option value="01">Jan</option>
            <option value="02">Feb</option>
            <option value="03">Mar</option>
            <option value="04">Apr</option>
            <option value="05">Mei</option>
            <option value="06">Jun</option>
            <option value="07">Jul</option>
            <option value="08">Agu</option>
            <option value="09">Sep</option>
            <option value="10">Okt</option>
            <option value="11">Nov</option>
            <option value="12">Des</option>
        </select>
        <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ml-1"><i class="fas fa-download fa-sm text-white-50" ></i> Generate Report</button>
    </form>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-1 font-weight-bold text-primary">Data Izin Karyawan</h6>
        <?php if(session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">            
        <div class="row">
            <div class="col-lg-8 mb-2">
                <a href="<?php echo base_url(); ?>/Admin/Izin/formIzin" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Izin</span>
                </a>
            </div>
            <div class="col-lg-4 mb-2">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?= base_url(); ?>/Admin/Izin">
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
                        <th>Tanggal Cuti</th>
                        <th>Jumlah Hari Cuti</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($izin_arr)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($izin_arr as $izin) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $izin['user_name']; ?></td>
                        <td><?= $izin['izin_nik']; ?></td>
                        <td><?= $izin['izin_date']; ?></td>
                        <td><?= $izin['izin_hari']; ?></td>
                        <td><?= $izin['status_izin_keterangan']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Izin/<?= $izin['izin_id']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                            <a href="<?php echo base_url(); ?>/Admin/Izin/formEdit/<?= $izin['izin_id']; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <form action="<?php echo base_url(); ?>/Admin/Izin/<?= $izin['izin_id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Tidak Ada Karyawan Izin
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="row">
            <div class="col">
                <?= $pager->links('izin', 'pagination') ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>