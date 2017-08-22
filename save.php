<?php

$json = json_decode($input);

$data['user_id'] = isset($json->user_id) ? $json->user_id : "";
$data['referrer'] = isset($json->referrer) ? $json->referrer : "";
$data['url_type'] = isset($json->url_type) ? $json->url_type : "1"; // 4 type shorten url

if (trim($data['user_id']) == "") {
    return array(
        "error" => 1,
        "message" => "Error: user_id is empty"
    );
}
if (trim($data['referrer']) == "") {
    return array(
        "error" => 1,
        "message" => "Error: referrer is empty"
    );
}

include("config.php");
$connection = new PDO(
    "mysql:dbname=$mydatabase;host=$myhost;port=$myport",
    $myuser, $mypass
);
    
$sql = "INSERT INTO referral (user_id) "
        . "SELECT :user_id WHERE NOT EXISTS ("
        . " SELECT 1 FROM referral WHERE user_id = :user_id1"
        . ")";
$statement1 = $connection->prepare($sql);
$statement1->bindParam(":user_id", $data['user_id']);
$statement1->bindParam(":user_id1", $data['user_id']);
$statement1->execute();

$sql2 = "UPDATE referral "
        . "SET referrer = :referrer "
        . "WHERE user_id = :user_id and coalesce(referrer, 0) <> :referrer1 ";
$statement2 = $connection->prepare($sql2);
$statement2->bindParam(":referrer", $data['referrer']);
$statement2->bindParam(":user_id", $data['user_id']);
$statement2->bindParam(":referrer1", $data['referrer']);
$statement2->execute();
$affected_row = $statement2->rowCount();

if ($affected_row > 0) {
    // TODO - integrate to inbox
    $sql = "SELECT * FROM referral WHERE user_id = :user_id ";
    $statement1 = $connection->prepare($sql);
    $statement1->execute(array(':user_id' => $data['referrer']));
    $row = $statement1->fetch(PDO::FETCH_ASSOC);

    $tier = is_numeric($row["tier"]) ? intval($row["tier"]) : 1;

    // get reward based on tier and url_type
    // $reward = get_reward($tier, $data['url_type'])
    $reward = "1000,CASH";

    if (strpos($reward, "CASH") !== FALSE) {
        $title = STR_ALERT_INBOX_TITLE4;
        $caption = STR_ALERT_INBOX_CAPTION4;
    } else {
        $title = STR_ALERT_INBOX_TITLE1;
        $caption = STR_ALERT_INBOX_CAPTION1;
    }
    
    $device_id = $data['referrer'];
    $facebook_id = "";

    $sql = "INSERT INTO master_inbox (type, header, message, data, target_device, target_fb, os, status, valid_from, valid_to)
            VALUES ('gift', :title, :caption, :data, :target_device, :target_fb, 'All', 1, null, null)";
    $statement1 = $connection->prepare($sql);
    $statement1->bindParam(":title", $title);
    $statement1->bindParam(":caption", $caption);
    $statement1->bindParam(":data", $reward);
    $statement1->bindParam(":target_device", $device_id);
    $statement1->bindParam(":target_fb", $facebook_id);
    $statement1->execute();
}

$data['affected_row'] = $affected_row;
$data['error'] = 0;
$data['message'] = 'Success';

return $data;