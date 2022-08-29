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
	header("Content-Disposition: attachment; filename=Data Kantor-". $today .".xls");
	?>
 
	<center>
		<h1>Data Kantor</h1>
	</center>
 
	<table border="1">
		<tr>
			<th>No</th>
			<th>Nama Kantor</th>
			<th>Alamat</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th>Created At</th>
			<th>Updated At</th>
		</tr>
        <?php $i = 1 ?>
        <?php foreach($kantor_arr as $kantor) : ?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $kantor['kantor_name']; ?></td>
			<td><?php echo $kantor['kantor_alamat']; ?></td>
			<td><?php echo $kantor['kantor_latitude']; ?></td>
			<td><?php echo $kantor['kantor_longitude']; ?></td>
			<td><?php echo $kantor['kantor_created_datetime']; ?></td>
			<td><?php echo $kantor['kantor_updated_datetime']; ?></td>
		</tr>
        <?php endforeach; ?>
	</table>
</body>
</html>