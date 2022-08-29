<!DOCTYPE html>
<html>
<head>
	<title>Export Data Ke Excel</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>

    
	<?php
    $today = date('Y-m-d');
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Detail Data Karyawan-". $today .".xls");
	?>
 
    <?php foreach($user_arr as $user) : ?>
	<center>
		<h1>Data Karayawan <?php echo $user['user_name']; ?></h1>
	</center>

    <table border="1">
		<tr>
			<th>Nama : </th>
			<th><?php echo $user['user_name']; ?></th>
			<th>NIK : </th>
			<th><?php echo $user['user_nik']; ?></th>
			<th>Kelamin :</th>
			<th><?php echo $user['user_jenis_kelamin']; ?></th>
			<th>Jabatan : </th>
			<th><?php echo $user['jabatan_nama']; ?></th>
		</tr>
		<tr>
			<th>Kantor : </th>
			<th><?php echo $user['kantor_name']; ?></th>
    <?php endforeach; ?>
			<th>Total Izin :</th>
			<th><?php echo $totalIzin; ?></th>
			<th>Total Izin Cuti :</th>
			<th><?php echo $totalCuti; ?></th>
			<th>Total Izin Bebas :</th>
			<th><?php echo $totalBebas; ?></th>
		</tr>
		<tr>
			<th>Izin Tahun Ini : </th>
			<th><?php echo $totalIzinTahun; ?></th>
			<th>Izin Cuti Tahun Ini  : </th>
			<th><?php echo $totalCutiTahun; ?></th>
			<th>Izin Bebas Tahun Ini :</th>
			<th><?php echo $totalBebasTahun; ?></th>
			<th>Sisa Cuti Tahun Ini : </th>
			<th><?php echo $sisaCuti; ?></th>
		</tr>
    </table>

	<center>
		<h1>Data Izin</h1>
	</center>

    <?php if (!empty($izin_data_arr)) { ?>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jumlah Hari</th>
            <th>Syarat</th>
            <th>Status</th>
        </tr>
        <?php $i = 1 ?>
        <?php foreach($izin_data_arr as $izin) : ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $izin['izin_date']; ?></td>
            <td><?php echo $izin['izin_hari']; ?></td>
            <td><?php echo $izin['izin_syarat']; ?></td>
            <td><?php echo $izin['status_izin_keterangan']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php } else { ?>
    <center>
        <h1>Tidak Ada Data Izin</h1>
    </center>
    <?php } ?>


	<center>
		<h1>Data Absensi</h1>
	</center>

    <?php if (!empty($absen_arr)) { ?>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Checkout</th>
            <th>Lokasi</th>
            <th>Lokasi Checkout</th>
        </tr>
        <?php $i = 1 ?>
        <?php foreach($absen_arr as $absen) : ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $absen['absen_datetime']; ?></td>
            <td><?php echo $absen['absen_checkout_datetime']; ?></td>
            <td><?php echo $absen['absen_latitude']; ?> <?php echo $absen['absen_longitude']; ?></td>
            <td><?php echo $absen['absen_latitude_checkout']; ?> <?php echo $absen['absen_longitude_checkout']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php } else { ?>
    <center>
        <h1>Tidak Ada Data Absen</h1>
    </center>
    <?php } ?>
</body>
</html>