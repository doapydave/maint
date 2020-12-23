<style> 
	.cleanlinks { text-decoration:none; } 
	.authenticated { text-align:right;float:right;} 
	.execlink { color:#006000;} 
</style>

<html>
<?php
session_start();
include('../inc/dbp.php');

#logout if asked
if (isset($_GET['logout'])) {
	unset($_SESSION['dbp']);
}

#secureit if need be
if (isset($_GET['runon'])) { 
	$_SESSION['dbp'] = $dbp;
}


if (isset($_SESSION['dbp']) && $_SESSION['dbp'] == $dbp OR ($_POST['pass'] == $dbp)) {
	echo "<div class=authenticated><a title=Logout class=cleanlinks href=?logout=yes>Authenticated</a></div>";
}
if (isset($_POST['pass']) && $_POST['pass'] == $dbp OR isset($_SESSION['dbp'])) {
	//echo "<p>SESSION dbp: ".$_SESSION['dbp']."</p>";
	$AgencyUserId = str_replace('.doap.com','',$_SERVER['SERVER_NAME']);
	echo "<h1><a class=cleanlinks href=https://www.doap.com/agencies.php>".$_SERVER['SERVER_NAME']."</a></h1>";
	//echo "<p>AgencyUserID: ".$AgencyUserId."</p>";
	$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);
	$agenciesQuery = "select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc";
	#fetch and list agency count and agency names.
	$seq = 0;
	
	#run selected query on db
	if ($_GET['runon'] != '')  { echo "<p>Running query on ".$_GET['runon']."</p>"; }

	if ($queryResults = $mysqli->query($agenciesQuery)) {
		$seq = $seq + 1;
		echo "<h2>".mysqli_num_rows($queryResults)." active agencies</h2>";
		echo "<ol>";
			while($row = mysqli_fetch_array($queryResults)) {
				//echo $row['AgencyUserId']."\n";
				$AgencyDb['seq'] = $row['AgencyUserId'].".doap.com"; 
				echo "<li>";
				//echo "<a class=cleanlinks href=https://".$row['AgencyUserId'].".doap.com/agencies.php>https://".$row['AgencyUserId'].".doap.com</a>";
				echo $AgencyDb['seq']." ";
				$_GET['runon'] = "https://www.doap.com/agencies.php?runon=".$row['AgencyUserId'].".doap.com";
				echo "[<a class=\"cleanlinks execlink\" href=".$_GET['runon'].">Exec</a>]";
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
