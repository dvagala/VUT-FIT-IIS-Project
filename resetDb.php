<?php

include "dbConnect.php";

$sql = file_get_contents('script.sql');

$pdo->exec($sql);

echo "Executing script.sql";

?>