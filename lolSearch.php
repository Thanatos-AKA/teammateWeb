<?php
	// Start the session
	session_start();
	if(isset($_GET['q'])){
		$conn = new mysqli("localhost", "iw3htp", "password", "project_db");
		$id = $_SESSION['user'];
		$laneNeeded = $_GET['q'];
		$query = "SELECT `name`, `avatar`, `rank`, `lane1`, `lane2` FROM `members` WHERE `rank` >= (SELECT`rank` FROM`members` WHERE `id` = '$id') && (`lane1` = '$laneNeeded'|| `lane2` = '$laneNeeded') && `id` != '$id' ORDER BY `rank`";
		
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
				
				echo "<table>";
				echo "<tr><th>" . $name . "</th></tr>";
				echo "<tr><td><img src = '$imgurl' width='150' height='180'></td><td><div width = 35 height = 42><img id='heart' title='Set as Favorite' onmouseover='overAnimation(this)' onmouseout='outAnimation(this)' onclick='clickAnimation(this)' src = 'heartUnclick.png'  width='20' height='24'></div></td></tr>";
				echo "<tr><td>" . $rank . "</td></tr>";
				echo "<tr><td>" . $lane1 . "</td></tr>";
				echo "<tr><td>" . $lane2 . "</td></tr>";
				echo "</table><br>";
			}
			$result -> free_result();
		}
		else{
			die("0 結果<br>可能是你排位太低");
		}
		mysqli_close($conn);
	}
	else{
		echo"厲害 出現了未知錯誤 可以告訴我你怎搞的嗎";
	}
?>