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
?>
<html>
<head>
</head>
<?php include('css/style.css'); ?>
<body class=mainbox>
<div class=mainbox>
<?php

if (isset($_SESSION['dbp']) && $_SESSION['dbp'] == $dbp OR ($_POST['pass'] == $dbp)) {
	echo "<div class=\"authenticated bigger\"><a title=Logout class=\"marvel cleanlinks bigger\" href=?logout=yes>Authenticated</a></div>";
}
if (isset($_POST['pass']) && $_POST['pass'] == $dbp OR isset($_SESSION['dbp'])) {
	$AgencyUserId = str_replace('.doap.com','',$_SERVER['SERVER_NAME']);
	echo "<h1><a title=\"Click to logout.\" class=\"marvel cleanlinks bigger\" href=https://www.doap.com/agencies.php>".$_SERVER['SERVER_NAME']."</a></h1>";
	$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);
	$agenciesQuery = "select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc";
	$seq = 0;
	
	if ($_GET['runon'] != '')  { echo "<div class=\"marvel bigger centerit\">Running query on <br><span class=\"padit evenbigger\">".$_GET['runon']."</span></div>"; }

	if ($queryResults = $mysqli->query($agenciesQuery)) {
		$seq = $seq + 1;
		echo "<h2 class=\"marvel bigger\">".mysqli_num_rows($queryResults)." active agencies</h2>";
		echo "<ol class=\"marvel bigger listwidth\">";
			while($row = mysqli_fetch_array($queryResults)) {
				$AgencyDb['seq'] = $row['AgencyUserId'].".doap.com"; 
				echo "<li>";
				echo "<span class=listitem>".$AgencyDb['seq']."</span> ";
				$_GET['runon'] = "https://www.doap.com/agencies.php?runon=".$row['AgencyUserId'].".doap.com";
				echo "<span class=listitembutton>[<a class=\"marvel cleanlinks execlink bigger\" href=".$_GET['runon'].">Exec</a>]</span>";
				echo "</li>";
			}
		echo "</ol>";
	}
} else {
	echo "<form class=\"marvel theform bigger\" method=POST>";
		//echo "Login "; 
		echo "<input class=\"formelements bigger\" type=password name=pass>";
		echo "<input class=\"formelementsbutton bigger\" type=submit name=Go>";
	echo "</form>";
exit;
}
?>
</div>
</body>
</html>
