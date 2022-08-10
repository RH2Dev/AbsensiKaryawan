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
	header("Content-Disposition: attachment; filename=Data Absensi-". $today .".xls");
	?>
 
	<center>
		<h1>Data Absensi Karayawan</h1>
	</center>
 
	<table border="1">
		<tr>
			<th>No</th>
			<th>Nama Karyawan</th>
			<th>NIK Karyawan</th>
            <th>Lokasi Absen</th>
            <th>Lokasi Checkout</th>
            <th>Tanggal Absen</th>
            <th>Tanggal Checkout</th>
		</tr>
        <?php $i = 1 ?>
        <?php foreach($absen as $absen) : ?>
		<tr>
			<td><?= $i++; ?></td>
			<td><?= $absen['name']; ?></td>
			<td><?= $absen['nik']; ?></td>
			<td><?= $absen['latitude']; ?> <?= $absen['longitude']; ?></td>
			<td><?= $absen['latCheckout']; ?> <?= $absen['longCheckout']; ?></td>
            <td><?= $absen['tanggal']; ?></td>
            <td><?= $absen['checkout']; ?></td>
		</tr>
        <?php endforeach; ?>
	</table>
</body>
</html>