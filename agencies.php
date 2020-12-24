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
	<?php include('scripts/scripts.js'); ?>
	<?php include('css/style.css'); ?>
</head>

<body class=mainbox>
<?php

if (isset($_SESSION['dbp']) && $_SESSION['dbp'] == $dbp OR ($_POST['pass'] == $dbp)) {
	echo "<div class=\"authenticated bigger\"><a title=Logout class=\"marvel cleanlinks bigger\" href=?logout=yes>Logout</a></div>";
}
if (isset($_POST['pass']) && $_POST['pass'] == $dbp OR isset($_SESSION['dbp'])) {
	$AgencyUserId = str_replace('.doap.com','',$_SERVER['SERVER_NAME']);
	echo "<h1 class=Marvel><a title=\"Click to logout.\" class=\"marvel cleanlinks bigger\" href=https://www.doap.com/agencies.php>".$_SERVER['SERVER_NAME']."</a></h1>";
	$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);
	$agenciesQuery = "select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc";
	$seq = 0;
	
	if ($_SESSION['thequery'] == '')  { 
		echo "<div class=\"marvel bigger centerit toppad\">Run a query on any Doap Agency DB.</div>"; 
	
		echo "	
			<form class=centerit name=setquery method=get>
				<select name=thequery>
					<option value=".urlencode('select * from motd where featured = 1').">"."select * from motd where featured = 1"."</option>
					<option value=".urlencode('select * from motd where featured = 1').">"."select * from motd where featured != 1"."</option>
					<option value=".urlencode('select * from motd where featured = 1').">"."select * from motd"."</option>
				</select>
				<input type=hidden name=runon value=".$_GET['runon'].">
				<input type=submit value=Go>
			</form>
		";

	} else { 
		echo "<div class=\"marvel bigger centerit toppad\">Query selected!</div>"; 

		$thequery = "select * from motd";
	}
		if (isset($_GET['thequery'])) { echo "<div class=\"running marvel bigger centerit toppad\">".urldecode($_GET['thequery'])."</div>";  }
	if ($_GET['runon'] != '')  { echo "<div class=\"marvel bigger centerit\">Targeting<br><span class=\"padit evenbigger\">".$_GET['runon']."</span></div>"; } else { 
	echo "<div class=centerit>Choose a Doap Agency database to update.</div>";	
	}

	if ($queryResults = $mysqli->query($agenciesQuery)) {
		$seq = $seq + 1;
		echo "<h2 class=\"marvel bigger\">".mysqli_num_rows($queryResults)." active agencies</h2>";
		echo "<ol class=\"marvel bigger listwidth\">";
			while($row = mysqli_fetch_array($queryResults)) {
				$AgencyDb['seq'] = $row['AgencyUserId'].".doap.com"; 
				echo "<li>";
				echo "<span class=listitem>".$AgencyDb['seq']."</span> ";
				$_GET['runon'] = "https://www.doap.com/agencies.php?runon=".$row['AgencyUserId'].".doap.com";
				echo "<span class=listitembutton>[<a class=\"marvel cleanlinks execlink bigger\" href=".$_GET['runon'].">Target</a>]</span>";
				echo "</li>";
			}
		echo "</ol>";
	}
} else {
	echo "<div class=listwidth>";
	echo "<h1 class=Marvel>Doap MultiDB Updater</h1>";
	echo "<p>Login to the MultiDB query execution tool here.</p>";
	echo "<form class=\"marvel theform bigger alignright\" method=POST>";
		//echo "Login "; 
		echo "<input title=\"Login to the multidb admin tool.\" placeholder=\"user\" class=\"formelements bigger\" type=text name=pass>";
		echo "<input placeholder=\"Pass\" class=\"formelements bigger\" type=password name=pass>";
		echo "<input class=\"formelementsbutton bigger\" type=submit name=Go>";
	echo "</form>";
	echo "</div>";
exit;
}
?>
</body>
</html>
