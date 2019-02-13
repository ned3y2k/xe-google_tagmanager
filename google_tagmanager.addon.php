<?php
/**
 * User: Kyeongdae
 * Date: 2019-02-12
 * Time: 오후 9:03
 */

/** @var stdClass $addon_info */
/** @var string $called_position */
if (!defined("__XE__")) exit();

require_once 'GoogleTagManagerAddOn.php';

define('ADDON_GOOGLE_TAG_MANAGER', '__AddonGoogleTagManager__');

if(!array_key_exists(ADDON_GOOGLE_TAG_MANAGER, $GLOBALS) || !$GLOBALS[ADDON_GOOGLE_TAG_MANAGER] instanceof GoogleTagManagerAddOn) {
	$GLOBALS[ADDON_GOOGLE_TAG_MANAGER] = new GoogleTagManagerAddOn();
	$GLOBALS[ADDON_GOOGLE_TAG_MANAGER]->setInfo($addon_info);
	$GLOBALS[ADDON_GOOGLE_TAG_MANAGER]->setPath(_XE_PATH_.'addons/google_tagmanager');
}
/** @var GoogleTagManagerAddOn $addon */
$addon = $GLOBALS[ADDON_GOOGLE_TAG_MANAGER];

$invoke_method_name = $called_position . '_' . $addon_act_postfix;

if(method_exists($addon, $called_position))
{
	if(!call_user_func_array(array(&$addon, $called_position), array(&$this)))
	{
		return false;
	}
}