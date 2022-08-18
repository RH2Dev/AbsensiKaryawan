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
		header("Content-Disposition: attachment; filename=Data Izin Karyawan-". $today .".xls");
	?>
 
	<center>
		<h1>Data Izin Karayawan</h1>
	</center>
 
	<table border="1">
		<tr>
			<th>No</th>
			<th>Nama Karyawan</th>
			<th>NIK Karyawan</th>
            <th>Tanggal Izin</th>
            <th>Jumlah Hari</th>
            <th>Persyaratan</th>
            <th>Keterangan</th>
		</tr>
        <?php $i = 1 ?>
        <?php foreach($izin_arr as $izin) : ?>
		<tr>
			<td><?= $i++; ?></td>
			<td><?= $izin['user_name']; ?></td>
			<td><?= $izin['izin_nik']; ?></td>
			<td><?= $izin['izin_date']; ?></td>
			<td><?= $izin['izin_hari']; ?></td>
			<td><?= $izin['izin_syarat']; ?></td>
			<td><?= $izin['status_izin_keterangan']; ?></td>
		</tr>
        <?php endforeach; ?>
	</table>
</body>
</html>