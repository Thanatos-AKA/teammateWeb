<?php
	if(isset($_POST["submit"])) {
		// Start the session
		session_start();
		
		//UPLOAD IMAGE
		$target_dir = "uploads/";
		$target_file = $target_dir . $_FILES["fileToUpload"]["name"];
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} 
		else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} 
		else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$conn = new mysqli("localhost", "iw3htp", "password", "project_db");
				$filename = $_FILES['fileToUpload']['name'];
				$id = $_SESSION['user'];
				$query = "UPDATE `members` SET `avatar`= '$filename' WHERE `id` = '$id'";
				
				if($conn -> connect_error){
					die("can't connect to database");
				}
				
				if(!$conn -> query($query)){
					die(mysqli_error($conn));
				}
				
				mysqli_close($conn);
				echo"The file ". htmlspecialchars($_FILES["fileToUpload"]["name"]). " has been uploaded.<br>" . $_FILES["fileToUpload"]["type"];
				echo"<script>window.addEventListener('load', function(){setTimeout(function(){location.href='MainPage.php'}, 1000)})</script>";
			} 
			else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	else{
		echo("nothig was uploaded");
	}
?>