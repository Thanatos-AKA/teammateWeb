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
		$name = isset($_POST["name"]) ? $_POST["name"] : "";
		$id = isset($_POST["id"]) ? $_POST["id"] : "";
		$password = isset($_POST["password"]) ? $_POST["password"] : "";
		$inputlist = array("id"=>"帳號", "password"=>"密碼", "name"=>"姓名");
		$formerrors = array("iderror"=>false, "passworderror"=>false, "nameerror"=>false);
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
			if($name == ""){
				$formerrors["nameerror"] = true;
				$iserror = true;
			}
			
			//sql
			if(!$iserror){
				//prepare hash
				$salt = substr(md5(uniqid(mt_rand(), true)), 0, 5);
				$cryptPassword = hash('sha256', $password . $salt);


				$conn = mysqli_connect("localhost", "iw3htp", "password");
				$query = "INSERT INTO `members` (`id`, `salt`, `cryptPassword`, `name`) VALUES('$id', '$salt', '$cryptPassword', '$name')";
				
				if(!$conn){
					die("<p>can't connect to database</p></body></html>");
				}
				if(!mysqli_select_db($conn,"project_db")){
					die("<p>can't execute query</p>" . mysqli_error($conn) . "</body></html>");
				}
				if(!$result = mysqli_query($conn, $query)){
					die("<p>can't execute query</p>" . mysqli_error($conn) . "</body></html>");
				}
				mysqli_close($conn);
				
				//session
				$_SESSION['user'] = $id;
				
				//3秒後重新導向主業
				die("<p>$name , you have registered.</p><script>window.addEventListener('load', function(){setTimeout(function(){location.href='MainPage.php'}, 1000)})</script></body></html>");
			}
		}
		echo"<h1>註冊帳號</h1>";
		echo"<form method = 'post' action = 'Register.php'>";
		foreach($inputlist as $inputname => $inputalt){
			echo"<div><label>$inputalt: </label><input type = 'text' name = '$inputname' value = '" . $$inputname . "'>";
			if($formerrors[($inputname) . "error"] == true){
				echo"<span class = 'error'>*</span>";
			}
			echo"</div>";
		}
		echo"<p><input type = 'submit' name = 'submit' value = 'Register'></p></form>";
		echo"<a href = 'Login.php'>登入</a></body></html>";
	?>