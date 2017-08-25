<?php

$json = json_decode($input);

$data['device_id'] = isset($json->device_id) ? $json->device_id : "";
$data['world'] = isset($json->world) ? $json->world : "1";

if (trim($data['device_id']) == "") {
    return array(
        "error" => 1,
        "message" => "Error: device_id is empty"
    );
}
    
include("config.php");
$connection = new PDO(
    "mysql:dbname=$mydatabase;host=$myhost;port=$myport",
    $myuser, $mypass
);

$sql = "INSERT INTO device_user (device_id, create_date) "
        . "SELECT * FROM (SELECT :device_id, NOW()) t WHERE NOT EXISTS ("
        . "  SELECT 1 FROM device_user WHERE device_id = :device_id1"
        . ")";
$statement1 = $connection->prepare($sql);
$statement1->bindParam(":device_id", $data['device_id']);
$statement1->bindParam(":device_id1", $data['device_id']);
$statement1->execute();
    
$sql = "SELECT * FROM device_user WHERE device_id = :device_id";
$statement1 = $connection->prepare($sql);
$statement1->execute(array(':device_id' => $data['device_id']));
$row = $statement1->fetch(PDO::FETCH_ASSOC);

$sql = "INSERT INTO referral (user_id) "
        . "SELECT * FROM (SELECT :user_id) t WHERE NOT EXISTS ("
        . " SELECT 1 FROM referral WHERE user_id = :user_id1"
        . ")";
$statement1 = $connection->prepare($sql);
$statement1->bindParam(":user_id", $row['user_id']);
$statement1->bindParam(":user_id1", $row['user_id']);
$statement1->execute();

$sql = "UPDATE referral SET world = :world WHERE user_id = :user_id ";
$statement1 = $connection->prepare($sql);
$statement1->bindParam(":user_id", $row['user_id']);
$statement1->bindParam(":world", $data['world']);
$statement1->execute();

$sql1 = "SELECT * FROM referral WHERE user_id = :user_id";
$statement1 = $connection->prepare($sql1);
$statement1->execute(array(':user_id' => $row['user_id']));
$row = $statement1->fetch(PDO::FETCH_ASSOC);

    
return array(
    'shorten_id' => intval($row['shorten_id']),
    'user_id' => $row['user_id'],
    'world' => intval($row['world']),
    'device_id' => $data['device_id'],
    'shorten_url_1' => "http://$SHORT_DOMAIN/".base_convert((int)"{$array['shorten_id']}1" + 100000, 10, 32),
    'shorten_url_2' => "http://$SHORT_DOMAIN/".base_convert((int)"{$array['shorten_id']}2" + 100000, 10, 32),
    'shorten_url_3' => "http://$SHORT_DOMAIN/".base_convert((int)"{$array['shorten_id']}3" + 100000, 10, 32),
    'shorten_url_4' => "http://$SHORT_DOMAIN/".base_convert((int)"{$array['shorten_id']}4" + 100000, 10, 32),
    'error' => 0,
    'message' => 'Success'
);