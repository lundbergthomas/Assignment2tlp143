<?php
	require_once('db_con.php');
	$upload_dir = 'uploads/';

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sql = "select * from tbl_user where id=".$id;
		$result = mysqli_query($con, $sql);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
		}else{
			$errorMsg = 'Could not select a record';
		}
	}

	if(isset($_POST['btnUpdate'])){
		$name = $_POST['name'];
		$position = $_POST['position'];

		$imgName = $_FILES['myfile']['name'];
		$imgTmp = $_FILES['myfile']['tmp_name'];
		$imgSize = $_FILES['myfile']['size'];

		if(empty($name)){
			$errorMsg = 'Please input name';
		}elseif(empty($position)){
			$errorMsg = 'Please input position';
		}
		//update the image if the user does select a new image to the system
		if($imgName){
			//get image extension
			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
			//allow extenstion
			$allowExt  = array('jpeg', 'jpg', 'png', 'gif');
			//random new name for photo
			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;
			//check a valid image
			if(in_array($imgExt, $allowExt)){
				//check image size less than 5MB
				if($imgSize < 5000000){
					//delete old image
					unlink($upload_dir.$row['image']);
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Image too large';
				}
			}else{
				$errorMsg = 'Please select a valid image';
			}
		}else {
			//if there hasn't been selected a new image, use the old one
			$userPic = $row['image'];
		}

		//check upload file not error than insert data to database
		if(!isset($errorMsg)){
			$sql = "update tbl_user
								set name = '".$name."',
									position = '".$position."',
									image = '".$userPic."'
					where id=".$id; 
			$result = mysqli_query($con, $sql);
			if($result){
				$successMsg = 'New record updated successfully';
				header('refresh:5;index.php');
			}else{
				$errorMsg = 'Error '.mysqli_error($con);
			}
		}

	}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Upload Your Image</title>
<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap-theme.min.css">

</head>

<body>

	<div class="navbar-default">
		<div class="container">
			<div class="navbar-header">
				<h3 class="navbar-brand">Upload Your Picture</h3>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="page-header">
			<h3>Add New
				<a class="btn btn-default" href="index.php">
					<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back
				</a>
			</h3>
			
		</div>
		
		<?php
		if(isset($errorMsg)){		
	?>
		<div class="alert alert-danger">
			<span class="glyphicon glyphicon-info">
				<strong><?php echo $errorMsg; ?></strong>
			</span>
		</div>
	<?php
		}
	?>

	<?php
		if(isset($successMsg)){		
	?>
		<div class="alert alert-success">
			<span class="glyphicon glyphicon-info">
				<strong><?php echo $successMsg; ?> - redirecting</strong>
			</span>
		</div>
	<?php
		}
	?>
		
		<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group">
					<label for="name" class="col-md-2" >Name</label>
					<div class="col-md-10">
						<input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="position" class="col-md-2" >Position</label>
					<div class="col-md-10">
						<input type="text" name="position" class="form-control" value="<?php echo $row['position']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="image" class="col-md-2" >Image</label>
					<div class="col-md-10">
						<img src="<?php echo $upload_dir.$row['image'] ?>" width="200">
						<input type="file" name="myfile">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-success" name="btnUpdate">
						<span class="glyphicon glyphicon-save"></span>&nbsp;Update
						</button>
					</div>
				</div>
			</form>
	</div>

</body>
</html>