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
 *  @copyright 2007-2016 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class Productpersonalisation extends Module {

    protected $config_form = false;

    public function __construct() {
        $this->name = 'productpersonalisation';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Norman';
        $this->need_instance = 0;
        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product personalisation');
        $this->description = $this->l('This module enables you to make a product customizable by customer using rules of admin.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall  Product personalisation module?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install() {
        include(dirname(__FILE__) . '/sql/install.php');

        return parent::install() &&
        $this->registerHook('header') &&
        $this->registerHook('backOfficeHeader') &&
        $this->registerHook('actionProductUpdate') &&
        $this->registerHook('displayAdminProductsExtra');
    }

    public function uninstall() {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        return parent::uninstall();
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader() {
        $id_product = Tools::getValue('id_product');
        $product = new Product($id_product);
        $query = 'SELECT * FROM `' . _DB_PREFIX_ . 'product_personalized_area` WHERE `id_product`="'.$product->id.'" ORDER BY `id_custom`';
        $alreadyCustomisedProducts = Db::getInstance()->ExecuteS($query);
        $qtyAlreadyCustomisedProducts = (empty($alreadyCustomisedProducts)) ? 0 : count($alreadyCustomisedProducts);
        if($qtyAlreadyCustomisedProducts > 0){
            $customised_values = $alreadyCustomisedProducts;
        }else{
            $customised_values = array();
        }
        if (!empty($product) && isset($product->id)) {
            $this->context->controller->addCSS($this->_path . 'views/css/imgareaselect-animated.css');
            $this->context->controller->addJS($this->_path . 'views/js/jquery.imgareaselect.pack.js');
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            Media::addJsDef(array(
                'customized_area' => array(
                    'customised_values' => $customised_values
                )
            ));
        }

        if ($this->context->shop->getContext() == Shop::CONTEXT_GROUP) {
            $this->context->controller->addCSS($this->_path . 'views/css/hide_product_tab.css');
        }

    }

    public function hookActionProductUpdate($params)
    {
        $tabs = Tools::getValue('total_custom_tabs');
        $id_product = (int) Tools::getValue('id_product');
        $qs = Db::getInstance()->delete('product_personalized_area','`id_product`='.$id_product);
        for($x=0;$x<$tabs;$x++)
        {
            Db::getInstance()->insert('product_personalized_area', array(
                    'id_product' => $id_product,
                    'id_image' => (int) Tools::getValue('id_image_'.$x),
                    'product_x1' => (int) Tools::getValue('p_x1_'.$x),
                    'product_x2' => (int) Tools::getValue('p_x2_'.$x),
                    'product_y1' => (int) Tools::getValue('p_y1_'.$x),
                    'product_y2' => (int) Tools::getValue('p_y2_'.$x),
                    'product_width' => (int) Tools::getValue('p_width_'.$x),
                    'product_height' => (int) Tools::getValue('p_height_'.$x),
                    'custom_type' => (int)Tools::getValue('customization_type_'.$x),
                    'aspectRatio' => Tools::getValue('p_aspectRatio_'.$x),
                    'default_value' => Tools::getValue('placeholder_'.$x),
                    'character_limit' => Tools::getValue('character_limit_'.$x),
                    'id_custom' => $x,
                ));
        }
    }

    public function prepareNewTab() {
        $id_product = (int) Tools::getValue('id_product');

        $this->context->smarty->assign(array(
            'languages' => $this->context->controller->_languages,
            'default_language' => (int) Configuration::get('PS_LANG_DEFAULT')
        ));
    }

    public function hookdisplayAdminProductsExtra($params) {

        if ($this->context->shop->getContext() != Shop::CONTEXT_GROUP) {
            $id_product = Tools::getValue('id_product');
            $product = new Product($id_product);
            $query = 'SELECT * FROM `' . _DB_PREFIX_ . 'product_personalized_area` WHERE `id_product`="'.$product->id.'"ORDER BY `id_custom`';
            $alreadyCustomisedProducts = Db::getInstance()->ExecuteS($query);
            $qtyAlreadyCustomisedProducts = (empty($alreadyCustomisedProducts)) ? 0 : count($alreadyCustomisedProducts);
            if($qtyAlreadyCustomisedProducts > 0){
                $this->context->smarty->assign(array(
                    'customised_values' =>$alreadyCustomisedProducts,
                    'tabb' => $qtyAlreadyCustomisedProducts -1,
                    'customization_type' => array("Image","Number","Text"),
                ));

            }else{
                $this->context->smarty->assign(array(
                    'customised_values' =>array()
                ));
            }

            $image = Image::getCover($id_product);
            //print_r($image);exit;
            $imagePath = array();
            $product_image_id = array();
            $link = new LinkCore();
            for($x=0;$x<$qtyAlreadyCustomisedProducts;$x++)
            {
                $product_image_id[] =$image['id_image'];
                $imagePath[] = $link->getImageLink($product->link_rewrite[$this->context->language->id], $image['id_image'],"large_default");
            }
            $id_images = Db::getInstance()->ExecuteS('SELECT `id_image` FROM `'._DB_PREFIX_.'image` WHERE `id_product` = '.(int)($id_product));

            foreach ($id_images as $image) {
                $each= $image['id_image'];
                $thumbs_data[$each]['image_id'] = $image['id_image'];
                $thumbs_data[$each]['thumb_imagePath'] = $link->getImageLink($product->link_rewrite[$this->context->language->id], $image['id_image']);

            }

            $this->smarty->assign('thumbs_data', $thumbs_data);

            if(isset($alreadyCustomisedProducts)){
                foreach ($alreadyCustomisedProducts as $image) {
                    if(isset($image['id_image'])){
                        $key = $image['id_custom'];
                        $product_image_id[$key] = $image['id_image'];
                        $imagePath[$key] = $link->getImageLink($product->link_rewrite[$this->context->language->id], $image['id_image'],"large_default");
                    }else{}
                }
            }

            if (!empty($product) && isset($product->id)) {
                $this->prepareNewTab();
                $this->context->smarty->assign(array(
                    'show_product_warning' => false,
                    'product_image' => $imagePath,
                    'product_image_id' => $product_image_id,
                    'largeSize' => Image::getSize(ImageType::getFormatedName('large')),
                ));
            }

            return $this->display(__FILE__, 'views/templates/admin/admin_product.tpl');
        }
    }

    public function isCat_15()
    {
        $p = new Product(Tools::getValue('id_product'));
        if($p->id_category_default == 15)
            return (int)4;
        else
            return (int)1;
    }

}
