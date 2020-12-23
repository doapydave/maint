<?php
#fetch mysql pass
include('../inc/dbp.php');

#check dbu and dbp are good
echo " \n\n Code located at: /mnt/efs/doap/maint \n";

echo "\n dbh, dbu, dbp and dbname set \n\n";

echo "Agency query: 
	select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc \n\n";

#set agency query
$agencies = "select * from motd where appType = 'agency' and featured = 1 order by AgencyUserId asc";

#connect to mysql
$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);

#fetch and list agency count and agency names.
if ($queryResults = $mysqli->query($agencies)) {
                echo "\n\n".mysqli_num_rows($queryResults)." agencies.\n";
                while($row = mysqli_fetch_array($queryResults)) {
			//echo $row['AgencyUserId']."\n";
			echo $row['AgencyUserId']." ";
                }
                echo "\n\n";
}

#todo: if arg given run query on each agency db

?>
