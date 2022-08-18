<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Absensi</h1>
    <form action="<?php echo base_url(); ?>/Admin/Absensi/export" style="display: flex;">
        <label style="margin: auto 5px;">Tahun</label>
        <select class="form-select" id="jabatan_id" name="year" style="width: 100px;">
            <?php foreach ($absenYear as $year) : ?>
            <option value="<?php echo $year['Year(absen_datetime)'] ?>"><?php echo $year['Year(absen_datetime)'] ?></option>
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
        <h6 class="m-0 font-weight-bold text-primary">Data Absensi Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8 mb-2">
                <a href="<?php echo base_url(); ?>/Admin/Absensi/formInsert" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Absensi</span>
                </a>
            </div>
            <div class="col-lg-4 mb-2">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?= base_url(); ?>/Admin/Absensi">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data Absensi" aria-label="Search" aria-describedby="basic-addon2" name="search" id="search">
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
                        <th>Tanggal</th>
                        <th>Checkout</th>
                        <th>Lokasi</th>
                        <th>Lokasi Checkout</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($absen_arr)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($absen_arr as $absen) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $absen['user_name']; ?></td>
                        <td><?= $absen['absen_datetime']; ?></td>
                        <td><?= $absen['absen_checkout_datetime']; ?></td>
                        <td><?= $absen['absen_latitude'] .' '. $absen['absen_longitude']; ?></td>
                        <td><?= $absen['absen_latitude_checkout'] .' '. $absen['absen_longitude_checkout']; ?></td>
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
        </div>
        <div class="row">
            <div class="col">
                <?= $pager->links('absen', 'pagination') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>