<?php
	require_once('db_con.php');
	$upload_dir = 'uploads/';

	if(isset($_POST['btnSave'])){
		$name = $_POST['name'];
		$country = $_POST['country'];

		$imgName = $_FILES['myfile']['name'];
		$imgTmp = $_FILES['myfile']['tmp_name'];
		$imgSize = $_FILES['myfile']['size'];

		if(empty($name)){
			$errorMsg = 'Please input name';
		}elseif(empty($country)){
			$errorMsg = 'Please input country';
		}elseif(empty($imgName)){
			$errorMsg = 'Please select image';
		}else{
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
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Image too large';
				}
			}else{
				$errorMsg = 'Please select a valid image';
			}
		}

		//check upload file not error than insert data to database
		if(!isset($errorMsg)){
			$sql = "insert into manager(name, country, image)
					values('".$name."', '".$country."', '".$userPic."')";
			$result = mysqli_query($con, $sql);
			if($result){
				$successMsg = 'New record added successfully';
				header('refresh:5;manager.php');
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
				<a class="btn btn-default" href="manager.php">
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
						<input type="text" name="name" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label for="country" class="col-md-2" >Country</label>
					<div class="col-md-10">
						<input type="text" name="country" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label for="image" class="col-md-2" >Image</label>
					<div class="col-md-10">
						<input type="file" name="myfile">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-success" name="btnSave">
						<span class="glyphicon glyphicon-save"></span>&nbsp;Save
						</button>
					</div>
				</div>
			</form>
	</div>

</body>
</html>