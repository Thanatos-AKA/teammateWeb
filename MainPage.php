<?php
	// Start the session
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<!--導覽列-->
	<nav>
		<ul class="flex-nav">
			<li><a href="EditProfileForm.php">修改個人資料</a></li>
			<li><a href="lolSearch.html">英雄聯盟</a></li>
			<li><a href="#">Apex</a></li>
			<li><a href="#">Rainbow Six: Siege</a></li>
			<li><a href="Login.php">登出</a></li>
		</ul>
    </nav>
	<?php
		$conn = new mysqli("localhost", "iw3htp", "password", "project_db");
		$id = $_SESSION['user'];
		$query = "SELECT `name`, `avatar`, `rank`, `lane1`, `lane2` FROM `members` WHERE `id` = '$id'";
		
		if($conn -> connect_error){
			die("can't connect to database");
		}
		
		$result = $conn -> query($query);
		if($result -> num_rows > 0){
			while($row = $result -> fetch_assoc()){
				$name = $row['name'];
				$imgurl = 'uploads/' . $row['avatar'];
				$rank = $row['rank'];
				$lane1 = $row['lane1'];
				$lane2 = $row['lane2'];
			}
			$result -> free_result();
		}
		else{
			die("0 result");
		}
		mysqli_close($conn);
		
		//轉換rank為牌位名稱
		if($rank == 1){
			$rank = '菁英';
		}
		else if($rank == 2){
			$rank = '宗師';
		}
		else if($rank == 3){
			$rank = '大師';
		}
		else if($rank == 4){
			$rank = '鑽石';
		}
		else if($rank == 5){
			$rank = '白金';
		}
		else if($rank == 6){
			$rank = '金牌';
		}
		else if($rank == 7){
			$rank = '銀牌';
		}
		else if($rank == 8){
			$rank = '銅牌';
		}
		else{
			$rank = '至尊鐵牌';
		}
		
		//產生個人資料
		echo"<h1>召喚師名稱 : " . $name . "</h1>";
		
		echo"<img src = '$imgurl' width='150' height='180'>";
		
		echo"<form action='UploadImg.php' method='post' enctype='multipart/form-data'>
		<input type='button' onclick = 'displayUploadImgButton()' value = '換頭像'></br>
		<input type='file' name='fileToUpload' id='fileToUpload'  style='display:none'></br>
		<input type='submit' value='Upload Image' name='submit' id='submit' style='display:none'>
		</form>";
		
		echo"<table>
		<tr><td>排位 : </td><td>$rank</td></tr>
		<tr><td>擅長路線 : </td><td>$lane1 , $lane2</td></tr>
		</table>";
	?>
	<script>
		function displayUploadImgButton(){
			document.getElementById('fileToUpload').style.display = "block";
			document.getElementById('submit').style.display = "block";
	}
	</script>
</body>
</html>