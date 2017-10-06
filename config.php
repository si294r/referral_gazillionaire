<?php

include("/var/www/mysql-config2.php");

$mydatabase = $IS_DEVELOPMENT ? "gazillionairedev" : "gazillionaire";

$SHORT_DOMAIN = "www.alegrium.com/bil2";

// IN-GAME COPIES

define('STR_VERIFIED_INSTALL_CRYSTALS1', "FREE CRYSTALS!");
define('STR_VERIFIED_INSTALL_CRYSTALS2', "Your friend has installed Billionaire 2.");
define('STR_VERIFIED_INSTALL_CASH1', "CASH REWARD!");
define('STR_VERIFIED_INSTALL_CASH2', "Your friend has installed Billionaire 2.");

define('STR_ALERT_INBOX_TITLE1', "FREE CRYSTALS!");
define('STR_ALERT_INBOX_CAPTION1', "Boost your business now!");
define('STR_ALERT_INBOX_TITLE2', "SUBSCRIPTION ALMOST ENDS!");
define('STR_ALERT_INBOX_CAPTION2', "Extend time to enjoy the benefits even longer!");
define('STR_ALERT_INBOX_TITLE3', "SUBSCRIPTION HAD ENDED!");
define('STR_ALERT_INBOX_CAPTION3', "Let's get another!");
define('STR_ALERT_INBOX_TITLE4', "FREE CASH!");
define('STR_ALERT_INBOX_CAPTION4', "Let's build the other business!");
define('STR_ALERT_INBOX_TITLE_WEST', "FREE CASH!");
define('STR_ALERT_INBOX_CAPTION_WEST', "Let's build a business!");
define('STR_ALERT_INBOX_TITLE_EAST', "CASH BONUS!");
define('STR_ALERT_INBOX_CAPTION_EAST', "Continue your business journey now!");

// REFERRAL REWARD

$referral_reward = array(
    "1" => "0.06,CASH,INVITE_REWARD_1", // reward = 6% from networth user
    "2" => "50,CRYSTAL,INVITE_REWARD_2", // reward = 50 crystal
    "3" => "0.06,CASH,INVITE_REWARD_3", // reward = 6% from networth user
    "4" => "50,CRYSTAL,INVITE_REWARD_4", // reward = 50 crystal
);