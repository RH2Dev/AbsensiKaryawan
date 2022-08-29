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
        <?php foreach($absen_arr as $absen) : ?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $absen['user_name']; ?></td>
			<td><?php echo $absen['absen_nik']; ?></td>
			<td><?php echo $absen['absen_latitude']; ?> <?php echo $absen['absen_longitude']; ?></td>
			<td><?php echo $absen['absen_latitude_checkout']; ?> <?php echo $absen['absen_longitude_checkout']; ?></td>
            <td><?php echo $absen['absen_datetime']; ?></td>
            <td><?php echo $absen['absen_checkout_datetime']; ?></td>
		</tr>
        <?php endforeach; ?>
	</table>
</body>
</html>