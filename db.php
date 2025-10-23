<?php
if(!isset($_SESSION))session_start();
try {

    $con = new PDO("mysql:host=localhost;dbname=alwarqa", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException  $e) {
    echo "Error: " . $e;
}
function getData($db, $query, $parm = [])
{
    $stmt = $db->prepare($query);
    $stmt->execute($parm);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function setData($db, $query, $parm = [])
{
    $stmt = $db->prepare($query);
    $stmt->execute($parm);
    $count = $stmt->rowCount();
    return $count;
}

?>