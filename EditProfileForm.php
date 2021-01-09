<?php
	session_start();
	$id = $_SESSION['user'];
	
	$rank = isset($_POST["rank"]) ? $_POST["rank"] : "";
	$lane1 = isset($_POST["rank"]) ? $_POST["lane1"] : "";
	$lane2 = isset($_POST["rank"]) ? $_POST["lane2"] : "";

	if ( isset($_POST["submit"])){
		$conn = new mysqli("localhost", "iw3htp", "password", "project_db");
		$query = "UPDATE `members` SET `rank` = $rank ,`lane1` = '$lane1',`lane2` ='$lane2' WHERE `id` = '$id'";
		
		if($conn -> connect_error){
			die("can't connect to database");
		}

		if( !$result = $conn -> query($query) ){
			die("can not execute sql");
		}
		$conn -> close();
		die("<script>window.addEventListener('load', function(){setTimeout(function(){location.href='MainPage.php',1000})})</script>");
	}
	
	echo"<form action='EditProfileForm.php' method='post'>
		<label>排位 : </label>
		<select name = 'rank'>
			<option value = 1>菁英</option>
			<option value = 2>宗師</option>
			<option value = 3>大師</option>
			<option value = 4>鑽石</option>
			<option value = 5>白金</option>
			<option value = 6>金牌</option>
			<option value = 7>銀牌</option>
			<option value = 8>銅牌</option>
			<option value = 9 selected>至尊鐵牌</option>
		</select><br>
		
		<label>擅長線路1 : </label>
		<select name = 'lane1'>
			<option>top</option>
			<option>jungle</option>
			<option>middle</option>
			<option>bottom</option>
			<option>support</option>
			<option selected>notset</option>
		</select><br>
		
		<label>擅長線路2 : </label>
		<select name = 'lane2'>
			<option>top</option>
			<option>jungle</option>
			<option>middle</option>
			<option>bottom</option>
			<option>support</option>
			<option selected>notset</option>
		</select><br>
		
		<input type='submit' value='更新' name='submit' id='submit'>
		</form>";
?>