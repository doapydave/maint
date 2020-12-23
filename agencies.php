<?php
#fetch mysql pass
include('../inc/dbp.php');
$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);

$agencies = "select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc";

#fetch and list agency count and agency names.

if ($queryResults = $mysqli->query($agencies)) {
	echo "<h2>".mysqli_num_rows($queryResults)." agencies</h2>";
	echo "<ol>";
                while($row = mysqli_fetch_array($queryResults)) {
			//echo $row['AgencyUserId']."\n";
			echo "<li>".$row['AgencyUserId'].".doap.com</li>";
			$AgencyDb = $row['AgencyUserId'].".doap.com";
                }
	echo "</ol>";
}


?>
