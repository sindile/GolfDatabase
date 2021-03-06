<?php
	require ("config.php");
	ini_set('display_errors', 'On');
	$conn = new mysqli(mHOST,mDB,mPASS,mUSER);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/gdb.css">
	<title>Insert Tab Title Here</title>
</head>
<body>
	<table id="othertable">
		<tr><td><b>Player Name</b></td><td><b>Course Name</b></td><td><b>Round Score / Course Par</b></td><td><b>Tees Played</b></td><td><b>Team Play</b></td><td><b>Date</b></td><td><b>Hole 1<br>Score/Par</b></td><td><b>Hole 2</b></td><td><b>Hole 3</b></td><td><b>Hole 4</b></td><td><b>Hole 5</b></td><td><b>Hole 6</b></td><td><b>Hole 7</b></td><td><b>Hole 8</b></td><td><b>Hole 9</b></td><td><b>Hole 10</b></td><td><b>Hole 11</b></td><td><b>Hole 12</b></td><td><b>Hole 13</b></td><td><b>Hole 14</b></td><td><b>Hole 15</b></td><td><b>Hole 16</b></td><td><b>Hole 17</b></td><td><b>Hole 18</b></td></tr>
		<?php
			$namearray=null;
			$stmtStart="SELECT p.fname, p.lname, c.course_name,concat((r.hole_1_score+r.hole_2_score+r.hole_3_score+r.hole_4_score+r.hole_5_score+r.hole_6_score+r.hole_7_score+r.hole_8_score+r.hole_9_score+r.hole_10_score+r.hole_11_score+r.hole_12_score+r.hole_13_score+r.hole_14_score+r.hole_15_score+r.hole_16_score+r.hole_17_score+r.hole_18_score),' / ',c.par) as total, r.tee_color, IF(r.teamplay=0,'No', 'Yes') as teamplay, r.play_date, concat(r.hole_1_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_1)) as hole_1_score, concat(r.hole_2_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_2)) as hole_2_score, concat(r.hole_3_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_3)) as hole_3_score, concat(r.hole_4_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_4)) as hole_4_score, concat(r.hole_5_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_5)) as hole_5_score, concat(r.hole_6_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_6)) as hole_6_score, concat(r.hole_7_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_7)) as hole_7_score, concat(r.hole_8_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_8)) as hole_8_score, concat(r.hole_9_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_9)) as hole_9_score, concat(r.hole_10_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_10)) as hole_10_score, concat(r.hole_11_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_11)) as hole_11_score, concat(r.hole_12_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_12)) as hole_12_score, concat(r.hole_13_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_13)) as hole_13_score, concat(r.hole_14_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_14)) as hole_14_score, concat(r.hole_15_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_15)) as hole_15_score, concat(r.hole_16_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_16)) as hole_16_score, concat(r.hole_17_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_17)) as hole_17_score, concat(r.hole_18_score,' / ',(SELECT h.par FROM holes h WHERE h.id=c.hole_18)) as hole_18_score FROM players p JOIN player_rounds pr ON p.id=pr.player_id LEFT JOIN rounds r ON r.id=pr.round_id INNER JOIN courses c on r.course_id=c.id";
			if(isset($_GET['name']) && $_GET['name'] != ""){
				$namearray=str_word_count($_GET['name'],1);
				$stmtStart= $stmtStart . " WHERE p.fname LIKE ? AND p.lname LIKE ?";
			}
			if(!($stmt = $conn->prepare($stmtStart))){
				echo "Prepare failed: "  . $conn->errno . " " . $conn->error;
			}
			if(isset($_GET['name']) && $_GET['name'] != ""){
				if(!($stmt->bind_param("ss",$namearray[0],$namearray[1]))){
						echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}
			}
			if(!$stmt->execute()){
				echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
			}
			if(!$stmt->bind_result($fname, $lname, $course_name, $total, $tee_color, $teamplay, $play_date, $hole_1_score, $hole_2_score, $hole_3_score, $hole_4_score, $hole_5_score, $hole_6_score, $hole_7_score, $hole_8_score, $hole_9_score, $hole_10_score, $hole_11_score, $hole_12_score, $hole_13_score, $hole_14_score, $hole_15_score, $hole_16_score, $hole_17_score, $hole_18_score)){
				echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;			
			}
			while($stmt->fetch()){
 				echo "<tr><td>" . $fname . ' ' . $lname . "</td><td>" . $course_name . "</td><td>" . $total . "</td><td>" . $tee_color . "</td><td>" . $teamplay . "</td><td>" . $play_date . "</td><td>" . $hole_1_score . "</td><td>" . $hole_2_score . "</td><td>" . $hole_3_score . "</td><td>" . $hole_4_score . "</td><td>" . $hole_5_score . "</td><td>" . $hole_6_score . "</td><td>" . $hole_7_score . "</td><td>" . $hole_8_score . "</td><td>" . $hole_9_score . "</td><td>" . $hole_10_score . "</td><td>" . $hole_11_score . "</td><td>" . $hole_12_score . "</td><td>" . $hole_13_score . "</td><td>" . $hole_14_score . "</td><td>" . $hole_15_score . "</td><td>" . $hole_16_score . "</td><td>" . $hole_17_score . "</td><td>" . $hole_18_score . "</td></tr>";
			}
			$stmt->close();
		?>	
	</table>
</body>
</html>
