<?php 

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

function url($route, $params = array())
{
    return Yii::app()->createAbsoluteUrl($route, $params);
}

?>