<?php

include("/var/www/mysql-config2.php");

$mydatabase = $IS_DEVELOPMENT ? "gazillionairedev" : "gazillionaire";

$SHORT_DOMAIN = "www.alegrium.com/bil2";

// IN-GAME COPIES

define('STR_ALERT_INBOX_TITLE1', "FREE CRYSTALS!");
define('STR_ALERT_INBOX_CAPTION1', "Boost your business now!");
define('STR_ALERT_INBOX_TITLE2', "SUBSCRIPTION ALMOST ENDS!");
define('STR_ALERT_INBOX_CAPTION2', "Will you extend the time, Boss?");
define('STR_ALERT_INBOX_TITLE3', "SUBSCRIPTION HAD ENDED!");
define('STR_ALERT_INBOX_CAPTION3', "Go subscribe another one!");
define('STR_ALERT_INBOX_TITLE4', "FREE CASH!");
define('STR_ALERT_INBOX_CAPTION4', "Let's build the other business!");