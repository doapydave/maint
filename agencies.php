<style> .cleanlinks { text-decoration:none; } .authenticated { text-align:right;float:right;} </style>

<html>
<?php
session_start();
include('../inc/dbp.php');

#secureit
if (isset($_POST['pass']) && $_POST['pass'] == $dbp OR isset($_SESSION['dbp'])) {
	$_SESSION['dbp'] = $_POST['pass'];
	echo "<div class=authenticated>Authenticated</div>";
	//echo "<p>SESSION dbp: ".$_SESSION['dbp']."</p>";
	$AgencyUserId = str_replace('.doap.com','',$_SERVER['SERVER_NAME']);
	echo "<h1><a class=cleanlinks href=https://www.doap.com/agencies.php>".$_SERVER['SERVER_NAME']."</a></h1>";
	echo "<p>AgencyUserID: ".$AgencyUserId."</p>";
	$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);
	$agenciesQuery = "select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc";
	#fetch and list agency count and agency names.
	$seq = 0;
	if ($queryResults = $mysqli->query($agenciesQuery)) {
		$seq = $seq + 1;
		echo "<h2>".mysqli_num_rows($queryResults)." active agencies</h2>";
		echo "<ol>";
			while($row = mysqli_fetch_array($queryResults)) {
				//echo $row['AgencyUserId']."\n";
				$AgencyDb['seq'] = $row['AgencyUserId'].".doap.com"; 
				echo "<li>";
				//echo "<a class=cleanlinks href=https://".$row['AgencyUserId'].".doap.com/agencies.php>https://".$row['AgencyUserId'].".doap.com</a>";
				echo " DB: ".$AgencyDb['seq']." ";
				$_GET['runon'] = "https://www.doap.com/agencies.php?runon=".$row['AgencyUserId'].".doap.com";
				echo "[<a href=".$_GET['runon'].">Exec</a>]";
				echo "</li>";
			}
		echo "</ol>";
	}
} else {
	echo "<form method=POST>";
		echo "Login "; 
		echo "<input type=text name=pass>";
		echo "<input type=submit name=Go>";
	echo "</form>";
exit;
}
?>
</html>
