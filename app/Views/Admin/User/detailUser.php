<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>

<?php $session = session()->get(); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
        <div>
            <a href="<?php echo current_url(); ?>/exportDetail" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Generate Excel</a>
            <button id="printPdf"  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ml-1">Generate PDF</button>
        </div>
</div>
<div id="printSection">
    <?php foreach($user_arr as $user) : ?>
    <div class="d-flex justify-content-between mb-1">
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Nama Karyawan
                <div class="text-white-50 small"><?php echo $user['user_name']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                NIK Karyawan
                <div class="text-white-50 small"><?php echo $user['user_nik']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Jenis Kelamin
                <div class="text-white-50 small"><?php echo $user['user_jenis_kelamin']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Jabatan
                <div class="text-white-50 small"><?php echo $user['jabatan_nama']; ?></div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-1">
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Kantor
                <div class="text-white-50 small"><?php echo $user['kantor_name']; ?></div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Total Izin
                <div class="text-white-50 small"><?php echo $totalIzin; ?> Hari</div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Total Izin Cuti
                <div class="text-white-50 small"><?php echo $totalCuti; ?> Hari</div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Total Izin Bebas
                <div class="text-white-50 small"><?php echo $totalBebas; ?> Hari</div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <div class="d-flex justify-content-between mb-4">
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Izin Tahun Ini
                <div class="text-white-50 small"><?php echo $totalIzinTahun; ?> Hari</div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Izin Cuti Tahun Ini
                <div class="text-white-50 small"><?php echo $totalCutiTahun; ?> Hari</div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Izin Bebas Tahun Ini
                <div class="text-white-50 small"><?php echo $totalBebasTahun; ?> Hari</div>
            </div>
        </div>
        <div class="card bg-dark text-white shadow" style="width: 24.5%;">
            <div class="card-body">
                Sisa Jatah Cuti Tahun Ini
                <div class="text-white-50 small"><?php echo $sisaCuti; ?> Hari</div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 justify-content-between d-flex">
            <h6 class="m-1 font-weight-bold text-primary">Data Izin Karyawan</h6>
            <form action="<?php echo current_url(); ?>" style="display: flex;">
                <input type="hidden" name="year" id="year" value="<?php echo $year ?>">
                <input type="hidden" name="month" id="month" value="<?php echo $month ?>">
                <select class="form-select" id="yearIzin" name="yearIzin" style="width: 100px;">
                    <option value="">Tahun</option>
                    <?php foreach ($izinYear as $year) : ?>
                    <option value="<?php echo $year['Year(izin_date)'] ?>" <?php echo ($year['Year(izin_date)'] == $yearIzin ? 'selected' : ''); ?> ><?php echo $year['Year(izin_date)'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="form-select ml-1" id="monthIzin" name="monthIzin" style="width: 100px;">
                    <option value="">Bulan</option>
                    <option value="01" <?php echo ($monthIzin == '01' ? 'selected' : ''); ?>>Jan</option>
                    <option value="02"<?php echo ($monthIzin == '02' ? 'selected' : ''); ?>>Feb</option>
                    <option value="03"<?php echo ($monthIzin == '03' ? 'selected' : ''); ?>>Mar</option>
                    <option value="04"<?php echo ($monthIzin == '04' ? 'selected' : ''); ?>>Apr</option>
                    <option value="05"<?php echo ($monthIzin == '05' ? 'selected' : ''); ?>>Mei</option>
                    <option value="06"<?php echo ($monthIzin == '06' ? 'selected' : ''); ?>>Jun</option>
                    <option value="07"<?php echo ($monthIzin == '07' ? 'selected' : ''); ?>>Jul</option>
                    <option value="08"<?php echo ($monthIzin == '08' ? 'selected' : ''); ?>>Agu</option>
                    <option value="09"<?php echo ($monthIzin == '09' ? 'selected' : ''); ?>>Sep</option>
                    <option value="10"<?php echo ($monthIzin == '10' ? 'selected' : ''); ?>>Okt</option>
                    <option value="11"<?php echo ($monthIzin == '11' ? 'selected' : ''); ?>>Nov</option>
                    <option value="12"<?php echo ($monthIzin == '12' ? 'selected' : ''); ?>>Des</option>
                </select>                            
                <button class="btn btn-primary ml-1" type="submit">
                    <i class="fas fa-search fa-sm"></i> Filter
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah Hari</th>
                        <th>Syarat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <?php if (!empty($izin_data_arr)) { ?>
                    <?php $i = 1 + (10 * ($currentPageIzin - 1)); ?>
                    <?php foreach($izin_data_arr as $izin) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $izin['izin_date']; ?></td>
                        <td><?php echo $izin['izin_hari']; ?></td>
                        <td><?php echo $izin['izin_syarat']; ?></td>
                        <td><?php echo $izin['status_izin_keterangan']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Izin/<?php echo $izin['izin_id']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Tidak Ada Izin Karyawan
                        </div>
                    <?php } ?>
                </table>
                <div>
                    <?php if (!empty($pagerIzin)) { ?>
                    <?php echo $pagerIzin->links('izin', 'pagination') ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 justify-content-between d-flex">
            <h6 class="m-1 font-weight-bold text-primary">Absensi Karyawan</h6>
            <form action="<?php echo current_url(); ?>" style="display: flex;">
                <input type="hidden" name="yearIzin" id="yearIzin" value="<?php echo $yearIzin ?>">
                <input type="hidden" name="monthIzin" id="monthIzin" value="<?php echo $monthIzin ?>">
                <select class="form-select" id="year" name="year" style="width: 100px;">
                    <option value="">Tahun</option>
                    <?php foreach ($absenYear as $y) : ?>
                    <option value="<?php echo $y['Year(absen_datetime)'] ?>" <?php echo ($y['Year(absen_datetime)'] == $yearIzin ? 'selected' : ''); ?>><?php echo $y['Year(absen_datetime)'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="form-select ml-1" id="month" name="month" style="width: 100px;">
                    <option value="">Bulan</option>
                    <option value="01" <?php echo ($month == '01' ? 'selected' : ''); ?>>Jan</option>
                    <option value="02"<?php echo ($month == '02' ? 'selected' : ''); ?>>Feb</option>
                    <option value="03"<?php echo ($month == '03' ? 'selected' : ''); ?>>Mar</option>
                    <option value="04"<?php echo ($month == '04' ? 'selected' : ''); ?>>Apr</option>
                    <option value="05"<?php echo ($month == '05' ? 'selected' : ''); ?>>Mei</option>
                    <option value="06"<?php echo ($month == '06' ? 'selected' : ''); ?>>Jun</option>
                    <option value="07"<?php echo ($month == '07' ? 'selected' : ''); ?>>Jul</option>
                    <option value="08"<?php echo ($month == '08' ? 'selected' : ''); ?>>Agu</option>
                    <option value="09"<?php echo ($month == '09' ? 'selected' : ''); ?>>Sep</option>
                    <option value="10"<?php echo ($month == '10' ? 'selected' : ''); ?>>Okt</option>
                    <option value="11"<?php echo ($month == '11' ? 'selected' : ''); ?>>Nov</option>
                    <option value="12"<?php echo ($month == '12' ? 'selected' : ''); ?>>Des</option>
                </select>                            
                <button class="btn btn-primary ml-1" type="submit">
                    <i class="fas fa-search fa-sm"></i> Filter
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Checkout</th>
                        <th>Lokasi</th>
                        <th>Lokasi Checkout</th>
                        <th>Aksi</th>
                    </tr>
                    <?php if (!empty($absen_arr)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($absen_arr as $absen) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $absen['absen_datetime']; ?></td>
                        <td><?php echo $absen['absen_checkout_datetime']; ?></td>
                        <td><?php echo $absen['absen_latitude']; ?> <?php echo $absen['absen_longitude']; ?></td>
                        <td><?php echo $absen['absen_latitude_checkout']; ?> <?php echo $absen['absen_longitude_checkout']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Absensi/<?php echo $absen['absen_id']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Tidak Ada Absensi Karyawan
                        </div>
                    <?php } ?>
                </table>
                <div>
                    <?php if (!empty($pager)) { ?>
                    <?php echo $pager->links('absen', 'pagination') ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>