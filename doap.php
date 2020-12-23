<?php
#fetch mysql pass
include('../inc/dbp.php');

#check dbu and dbp are good
echo "

Code located at: /mnt/efs/doap/maint
";

echo "
dbh, dbu, dbp and dbname set

";

$mysqli = new mysqli($dbh, $dbu, $dbp, $dbname);

#connect to mysql
#list agencies
#if arg given run query on each agency db


?>
