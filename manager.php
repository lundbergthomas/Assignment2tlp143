<?php
	require_once('db_con.php');
	$upload_dir = 'uploads/';
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];

		//select old photo name from database
		$sql = "select image from manager where id = ".$id;
		$result = mysqli_query($con, $sql);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$image = $row['image'];
			unlink($upload_dir.$image);
			//delete record from database
			$sql = "delete from manager where id=".$id;
			if(mysqli_query($con, $sql)){
				header('location:manager.php');
			}
		}
	}
?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Manager</title>
<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap-theme.min.css">

</head>

<body>

	<div class="navbar-default">
		<div class="container">
			<div class="navbar-header">
				<h3 class="navbar-brand">Add New Manager</h3>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="page-header">
			<h3>Your Manager
				<a class="btn btn-default" href="addmanager.php">
					<span class="glyphicon glyphicon-plus"></span>&nbsp;Add New Manager
				</a>
				<a class="btn btn-default" href="index.php">
					<span class="glyphicon glyphicon-th-list"></span>&nbsp;Player List
				</a>
			</h3>
			<table class="table table-bordered table-responsive">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Country</th>
						<th>Image</th>
						<th>Action</th>
						
					</tr>
				</thead>
				<tbody>
				<?php
					
					$sql = "select * from manager";
					$result = mysqli_query($con, $sql);
					if(mysqli_num_rows($result)){
						while($row = mysqli_fetch_assoc($result)){
							
						
					
				?>
					<tr>
					<td><?php echo $row['id'] ?></td>
					<td><?php echo $row['name'] ?></td>
					<td><?php echo $row['country'] ?></td>
					<td><img src="<?php echo $upload_dir.$row['image'] ?>" height="100"></td>
					<td>
						<a class="btn btn-info" href="editmanager.php?id=<?php echo $row['id'] ?>">
							<span class="glyphicon glyphicon-edit"></span>Edit
						</a>
						<a class="btn btn-danger" href="manager.php?delete=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure to delete this record?')">
							<span class="glyphicon glyphicon-remove-circle"></span>Delete
						</a>
					</td>
				</tr>
				<?php
						}
					}
					
				?>
				
					
				</tbody>
			</table>
		</div>
	</div>

</body>
</html>