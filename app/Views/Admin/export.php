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
	header("Content-Disposition: attachment; filename=Data Akun Admin-". $today .".xls");
	?>
 
	<center>
		<h1>Data Akun Admin Absensi</h1>
	</center>
 
	<table border="1">
		<tr>
			<th>No</th>
			<th>Nama Karyawan</th>
			<th>Username</th>
			<th>Email</th>
			<th>NIK Karyawan</th>
			<th>Jabatan</th>
			<th>Kantor</th>
			<th>Created At</th>
			<th>Updated At</th>
		</tr>
        <?php $i = 1 ?>
        <?php foreach($admin_arr as $admin) : ?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $admin['user_name']; ?></td>
			<td><?php echo $admin['auth_username']; ?></td>
			<td><?php echo $admin['auth_email']; ?></td>
			<td><?php echo $admin['auth_nik']; ?></td>
			<td><?php echo $admin['jabatan_nama']; ?></td>
			<td><?php echo $admin['kantor_name']; ?></td>
			<td><?php echo $admin['auth_created_datetime']; ?></td>
			<td><?php echo $admin['auth_updated_datetime']; ?></td>
		</tr>
        <?php endforeach; ?>
	</table>
</body>
</html>