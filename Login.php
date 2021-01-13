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
	<?php
		$id = isset($_POST["id"]) ? $_POST["id"] : "";
		$password = isset($_POST["password"]) ? $_POST["password"] : "";
		$inputlist = array("id"=>"帳號", "password"=>"密碼");
		$formerrors = array("iderror"=>false, "passworderror"=>false);
		$iserror = false;
		
		//check format
		if(isset($_POST["submit"])){
			if($id == ""){
				$formerrors["iderror"] = true;
				$iserror = true;
			}
			if($password == ""){
				$formerrors["passworderror"] = true;
				$iserror = true;
			}
			
			//sql
			if(!$iserror){
				$conn = new mysqli("localhost", "iw3htp", "password", "project_db");
				$id = $conn -> real_escape_string($id);
				$password = $conn -> real_escape_string($password);
				
				if($conn -> connect_error){
					die("<p>can't connect to database</p></body></html>");
				}

				$query = "SELECT `cryptPassword`, `salt` FROM `members` WHERE `id` = '$id'";
				$result = $conn -> query($query);
				if($result -> num_rows > 0){
					while($row = $result -> fetch_assoc()){
						$salt = $row["salt"];
						$cryptPassword = $row["cryptPassword"];
						$myCryptPassword = hash('sha256', $password . $salt);
					}
				}
				else{
					die("0 result");
				}
				
				if($cryptPassword = $myCryptPassword){
					$query = "SELECT `name` FROM `members` WHERE `id` = '$id'";
					$result = $conn -> query($query);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
							$name = $row["name"];
						}
					}
				}
				else{
					die("0 result");
				}

				$result -> free_result();
				$conn -> close();
				
				//session
				$_SESSION['user'] = $id;
				
				die("<p>name : $name, id : $id, you have login.</p><script>window.addEventListener('load', function(){setTimeout(function(){location.href='MainPage.php'}, 1000)})</script></body></html>");
			}
		}
		echo"<h1>登入</h1>";
		echo"<form method = 'post' action = 'Login.php'>";
		foreach($inputlist as $inputname => $inputalt){
			echo"<div><label>$inputalt: </label><input type = 'text' name = '$inputname' value = '" . $$inputname . "'>";
			if($formerrors[($inputname) . "error"] == true){
				echo"<span class = 'error'>*</span>";
			}
			echo"</div>";
		}
		echo"<p><input type = 'submit' name = 'submit' value = 'Login'></p></form>";
		echo"<a href = 'Register.php'>註冊</a>";
	?>
</body>
</html>