<?php

include "db.php";

header("Content-Type:text/csv");
header("Content-Disposition:attachment;filename=user.csv");

$output=fopen("php://output","w");

fputcsv($output,array("id","Name","author","isbn","category","price"));

$result=$conn->query("select * from books");

while($row=$result->fetch_assoc()){
    fputcsv($output,$row);
}

fclose($output);

exit;
?>  