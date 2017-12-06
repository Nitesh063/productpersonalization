<?php
/**
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'product_personalized_area` (    
	`id_product` int(11) NOT NULL,
	`id_custom` int(11) NOT NULL,
	`custom_type` int(11) NOT NULL,
	`id_image` int(11) NOT NULL,
	`default_value` VARCHAR(100),
	`product_x1` int(11) NOT NULL,
	`product_y1` int(11) NOT NULL,
	`product_x2` int(11) NOT NULL,
	`product_y2` int(11) NOT NULL,
	`product_width` int(11) NOT NULL,
	`character_limit` int(5) NOT NULL,
	`product_height` int(11) NOT NULL,
	`aspectRatio` varchar(50) NOT NULL,
    PRIMARY KEY  (`id_product`,`id_custom`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}

