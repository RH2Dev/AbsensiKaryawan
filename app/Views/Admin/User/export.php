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
	header("Content-Disposition: attachment; filename=Data Karyawan-". $today .".xls");
	?>
 
	<center>
		<h1>Data Karayawan</h1>
	</center>
 
	<table border="1">
		<tr>
			<th>No</th>
			<th>Nama Karyawan</th>
			<th>NIK Karyawan</th>
			<th>Jenis Kelamin</th>
			<th>Jabatan</th>
		</tr>
        <?php $i = 1 ?>
        <?php foreach($user_arr as $user) : ?>
		<tr>
			<td><?= $i++; ?></td>
			<td><?= $user['user_name']; ?></td>
			<td><?= $user['user_nik']; ?></td>
			<td><?= $user['user_jenis_kelamin']; ?></td>
			<td><?= $user['jabatan_nama']; ?></td>
		</tr>
        <?php endforeach; ?>
	</table>
</body>
</html>