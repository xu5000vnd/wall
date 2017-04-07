<?php
define('STATUS_INACTIVE', 0);
define('STATUS_ACTIVE', 1);
define('TYPE_YES', 1);
define('TYPE_NO', 0);
define('ROLE_ADMIN', 1);
define('ROLE_MANAGER', 2);
define('COOKIE_ADMIN', md5('icancook'));
define('COOKIE_USERNAME', md5('username'));
define('COOKIE_PASSWORD', md5('password'));
if (isset($_SERVER['HTTP_HOST']))
{
    //for local site
    $MYSQL_HOSTNAME = 'localhost'; //Your hostname here
    $MYSQL_USERNAME = 'root'; //Your username here
    $MYSQL_PASSWORD = ''; //Your password here
    $MYSQL_DATABASE = 'wall'; //Your database
}
?>