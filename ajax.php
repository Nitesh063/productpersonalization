<?php
require(dirname(__FILE__).'/../../config/config.inc.php');
require(dirname(__FILE__).'/../../init.php');
require(dirname(__FILE__).'/customizedarea.php');
$moduleObj = new Customizedarea();

$id_product = Tools::getValue('id_product');
