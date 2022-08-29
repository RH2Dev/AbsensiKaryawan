<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<?php $session = session()->get(); ?>
<!-- Page Heading -->
<?php
    $fullURL 
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Absensi</h1>
    <form action="<?php echo base_url(); ?>/Admin/Absensi/export" style="display: flex;">
        <?php if ($session['adminStatus'] == 1) {?>
        <select class="form-select" id="kantor" name="kantor" style="width: 100px;">
            <option value="" selected disabled>Kantor</option>
            <?php foreach ($kantor_arr as $kantor) : ?>
            <option value="<?php echo $kantor['kantor_id'] ?>"><?php echo $kantor['kantor_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <?php } ?>
        <select class="form-select ml-1" id="jabatan_id" name="year" style="width: 100px;">
            <option value="" selected disabled>Tahun</option>
            <?php foreach ($absenYear as $year) : ?>
            <option value="<?php echo $year['Year(absen_datetime)'] ?>"><?php echo $year['Year(absen_datetime)'] ?></option>
            <?php endforeach; ?>
        </select>
        <select class="form-select ml-1" id="month" name="month">
            <option value="" selected disabled>Bulan</option>
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
        <div class="row justify-content-between">
            <?php if ($session['adminStatus'] == 1) {?>
                <div class="col-lg-3 mb-2">
            <?php } else { ?>
                <div class="col-lg-4 mb-2">
            <?php } ?>
                <a href="<?php echo base_url(); ?>/Admin/Absensi/formInsert" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Absensi</span>
                </a>
            </div>
            <?php if ($session['adminStatus'] == 1) {?>
                <div class="col-lg-8 mb-2">
            <?php } else { ?>
                <div class="col-lg-7 mb-2">
            <?php } ?>
                <form action="<?php echo $fullURL; ?>" style="display: flex;">
                    <?php if ($session['adminStatus'] == 1) {?>
                    <select class="form-select" id="kantor" name="kantor" style="width: 100px;">
                        <option value="" selected disabled>Kantor</option>
                        <?php foreach ($kantor_arr as $kantor) : ?>
                        <option value="<?php echo $kantor['kantor_id'] ?>"  <?php echo ($kantorInput == $kantor['kantor_id'] ? 'selected' : ''); ?>><?php echo $kantor['kantor_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php } ?>
                    <select class="form-select ml-1" id="year" name="year" style="width: 100px;">
                        <option value="" selected disabled>Tahun</option>
                        <?php foreach ($absenYear as $year) : ?>
                        <option value="<?php echo $year['Year(absen_datetime)'] ?>" <?php echo ($yearInput == $year['Year(absen_datetime)'] ? 'selected' : ''); ?>><?php echo $year['Year(absen_datetime)'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php 
                        function isSelected($refMonth, $val)
                        {
                            return $refMonth == $val ? 'selected' : '';
                        }
                    ?>
                    <select class="form-select ml-1" id="month" name="month" style="width: 100px;">
                        <option value="" <?php echo isSelected($month, "") ?>>Bulan</option>
                        <option value="01" <?php echo isSelected($month, "01") ?>>Jan</option>
                        <option value="02" <?php echo isSelected($month, "02") ?>>Feb</option>
                        <option value="03" <?php echo isSelected($month, "03") ?>>Mar</option>
                        <option value="04" <?php echo isSelected($month, "04") ?>>Apr</option>
                        <option value="05" <?php echo isSelected($month, "05") ?>>Mei</option>
                        <option value="06" <?php echo isSelected($month, "06") ?>>Jun</option>
                        <option value="07" <?php echo isSelected($month, "07") ?>>Jul</option>
                        <option value="08" <?php echo isSelected($month, "08") ?>>Agu</option>
                        <option value="09" <?php echo isSelected($month, "09") ?>>Sep</option>
                        <option value="10" <?php echo isSelected($month, "10") ?>>Okt</option>
                        <option value="11" <?php echo isSelected($month, "11") ?>>Nov</option>
                        <option value="12" <?php echo isSelected($month, "12") ?>>Des</option>
                    </select>                            
                    <button class="btn btn-primary ml-1" type="submit">
                        <i class="fas fa-search fa-sm"></i> Filter
                    </button>
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data Absensi" aria-label="Search" aria-describedby="basic-addon2" name="search" id="search" value="<?php echo $searchInput ?>">
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
            
        <?php if (!empty($absen_arr)) { ?>  
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
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($absen_arr as $absen) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $absen['user_name']; ?></td>
                        <td><?php echo $absen['absen_datetime']; ?></td>
                        <td><?php echo $absen['absen_checkout_datetime']; ?></td>
                        <td><?php echo $absen['absen_latitude'] .' '. $absen['absen_longitude']; ?></td>
                        <td><?php echo $absen['absen_latitude_checkout'] .' '. $absen['absen_longitude_checkout']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Absensi/<?php echo $absen['absen_id']; ?>"><button type="button" class="btn btn-warning">Details</button></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div>
                <?php echo $pager->links('absen', 'pagination') ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger" role="alert">
                Tidak Ada data Absensi
            </div>
        <?php } ?>
    </div>
</div>
<?php echo $this->endSection(); ?>