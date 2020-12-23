<style> .cleanlinks { text-decoration:none; } </style>
<html>
<?php
include('../inc/dbp.php');
$AgencyUserId = str_replace('.doap.com','',$_SERVER['SERVER_NAME']);
echo "<h1>".$_SERVER['SERVER_NAME']."</h1>";
echo "<p>AgencyUserID: ".$AgencyUserId."</p>";
$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);
$agenciesQuery = "select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc";
#fetch and list agency count and agency names.
if ($queryResults = $mysqli->query($agenciesQuery)) {
	echo "<h2>".mysqli_num_rows($queryResults)." Doap agencies</h2>";
	echo "<ol>";
                while($row = mysqli_fetch_array($queryResults)) {
			//echo $row['AgencyUserId']."\n";
			echo "<li><a class=cleanlinks href=https://".$row['AgencyUserId'].".doap.com/agencies.php>".$row['AgencyUserId'].".doap.com</a></li>";
			$AgencyDb = $row['AgencyUserId'].".doap.com";
                }
	echo "</ol>";
}
?>
</html>
