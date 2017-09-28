<?php

function get_user_id($device_id) 
{
    global $connection, $IS_DEVELOPMENT;
    
    $key = $IS_DEVELOPMENT ? "gazdev_user_" . $device_id : "gaz_user_" . $device_id;
    $user_id = apcu_fetch($key);

    if ($user_id === FALSE) {        
        $sql = "INSERT INTO device_user (device_id, create_date) "
        . "SELECT * FROM (SELECT :device_id, NOW()) t WHERE NOT EXISTS ("
        . "  SELECT 1 FROM device_user WHERE device_id = :device_id1"
        . ")";
        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(":device_id", $device_id);
        $statement1->bindParam(":device_id1", $device_id);
        $statement1->execute();

        $sql = "SELECT * FROM device_user WHERE device_id = :device_id";
        $statement1 = $connection->prepare($sql);
        $statement1->execute(array(':device_id' => $device_id));
        $row = $statement1->fetch(PDO::FETCH_ASSOC);

        $user_id = $row['user_id'];    
        apcu_store($key, $user_id, 900);
    }
    
    return $user_id;
}

function get_referral($user_id, $world) 
{
    global $connection, $IS_DEVELOPMENT;
    
    $key = $IS_DEVELOPMENT ? "gazdev_ref_" . $device_id : "gaz_ref_" . $device_id;
    $row = apcu_fetch($key);
    $is_update_cache = false;
    
    if ($row === FALSE) {
        $sql = "INSERT INTO referral (user_id) "
                . "SELECT * FROM (SELECT :user_id) t WHERE NOT EXISTS ("
                . " SELECT 1 FROM referral WHERE user_id = :user_id1"
                . ")";
        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(":user_id", $user_id);
        $statement1->bindParam(":user_id1", $user_id);
        $statement1->execute();

        $sql1 = "SELECT * FROM referral WHERE user_id = :user_id";
        $statement1 = $connection->prepare($sql1);
        $statement1->execute(array(':user_id' => $user_id));
        $row = $statement1->fetch(PDO::FETCH_ASSOC);                        
        
        $is_update_cache = true;
    }

    if ($row['world'] != $world) {
        $sql = "UPDATE referral SET world = :world WHERE user_id = :user_id ";
        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(":user_id", $user_id);
        $statement1->bindParam(":world", $world);
        $statement1->execute();
        
        $row['world'] = $world;
        $is_update_cache = true;
    }
    
    if ($is_update_cache) {
        apcu_store($key, $row, 900);        
    }
    
    return $row;
}