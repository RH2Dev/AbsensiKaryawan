<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<!-- Get Session Data -->
<?php $session = session()->get(); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Izin</h1>
    <form action="<?php echo base_url(); ?>/Admin/Izin/export" style="display: flex;">
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
            <?php foreach ($izinYear as $year) : ?>
            <option value="<?php echo $year['Year(izin_date)'] ?>"><?php echo $year['Year(izin_date)'] ?></option>
            <?php endforeach; ?>
        </select>
        <select class="form-select ml-1" id="month" name="month">
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
                <?php echo session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">            
        <div class="row">
            <?php if ($session['adminStatus'] == 1) {?>
            <div class="col-lg-4 mb-2">
            <?php } else { ?>
            <div class="col-lg-5 mb-2">
            <?php } ?>
                <a href="<?php echo base_url(); ?>/Admin/Izin/formIzin" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-flag"></i>
                    </span>
                    <span class="text">Tambah Data Izin</span>
                </a>
            </div>
            <?php if ($session['adminStatus'] == 1) {?>
            <div class="col-lg-8 mb-2">
            <?php } else { ?>
            <div class="col-lg-7 mb-2">
            <?php } ?>
                <form action="<?php echo current_url(); ?>" style="display: flex;">
                    <?php if ($session['adminStatus'] == 1) {?>
                    <select class="form-select" id="kantor" name="kantor" style="width: 100px;">
                        <option value="" selected disabled>Kantor</option>
                        <?php foreach ($kantor_arr as $kantor) : ?>
                        <option value="<?php echo $kantor['kantor_id'] ?>" <?php echo ($kantorInput == $kantor['kantor_id'] ? 'selected' : ''); ?>><?php echo $kantor['kantor_name'] ?></option>
                        <?php endforeach; ?>
                    </select>         
                    <?php } ?>
                    <select class="form-select ml-1" id="year" name="year" style="width: 100px;">
                        <option value="" selected disabled>Tahun</option>
                        <?php foreach ($izinYear as $year) : ?>
                        <option value="<?php echo $year['Year(izin_date)'] ?>" <?php echo ($year['Year(izin_date)'] == $yearInput ? 'selected' : ''); ?> ><?php echo $year['Year(izin_date)'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="form-select ml-1" id="month" name="month" style="width: 100px;">
                        <option value="" selected>Bulan</option>
                        <option value="01" <?php echo ($monthInput == '01' ? 'selected' : ''); ?>>Jan</option>
                        <option value="02" <?php echo ($monthInput == '02' ? 'selected' : ''); ?>>Feb</option>
                        <option value="03" <?php echo ($monthInput == '03' ? 'selected' : ''); ?>>Mar</option>
                        <option value="04" <?php echo ($monthInput == '04' ? 'selected' : ''); ?>>Apr</option>
                        <option value="05" <?php echo ($monthInput == '05' ? 'selected' : ''); ?>>Mei</option>
                        <option value="06" <?php echo ($monthInput == '06' ? 'selected' : ''); ?>>Jun</option>
                        <option value="07" <?php echo ($monthInput == '07' ? 'selected' : ''); ?>>Jul</option>
                        <option value="08" <?php echo ($monthInput == '08' ? 'selected' : ''); ?>>Agu</option>
                        <option value="09" <?php echo ($monthInput == '09' ? 'selected' : ''); ?>>Sep</option>
                        <option value="10" <?php echo ($monthInput == '10' ? 'selected' : ''); ?>>Okt</option>
                        <option value="11" <?php echo ($monthInput == '11' ? 'selected' : ''); ?>>Nov</option>
                        <option value="12" <?php echo ($monthInput == '12' ? 'selected' : ''); ?>>Des</option>
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
        <?php if (!empty($izin_arr)) { ?>
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
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($izin_arr as $izin) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $izin['user_name']; ?></td>
                        <td><?php echo $izin['izin_nik']; ?></td>
                        <td><?php echo $izin['izin_date']; ?></td>
                        <td><?php echo $izin['izin_hari']; ?></td>
                        <td><?php echo $izin['status_izin_keterangan']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Izin/<?php echo $izin['izin_id']; ?>"><button type="button" class="btn btn-warning mb-1">Details</button></a>
                            <a href="<?php echo base_url(); ?>/Admin/Izin/formEdit/<?php echo $izin['izin_id']; ?>"><button type="button" class="btn btn-warning mb-1">Edit</button></a>
                            <form action="<?php echo base_url(); ?>/Admin/Izin/<?php echo $izin['izin_id']; ?>" method="post" class="d-inline mb-1">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div>
                <?php echo $pager->links('izin', 'pagination') ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger" role="alert">
                Tidak Ada Karyawan Izin
            </div>
        <?php } ?>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>