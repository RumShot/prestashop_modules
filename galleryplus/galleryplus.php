<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class GalleryPlus extends Module
{
    public function __construct()
    {
        $this->name = 'galleryplus';
        $this->tab = 'front_office_features';
        $this->version = '0.2';
        $this->author = 'Rum Shot';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Gallery plus');
        $this->description = $this->l('Gallery image extender. Opens possibility to show more than one image');
        $this->confirmUninstall = $this->l('Reconfirm, pur favor');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        // if (!Configuration::get('MYMODULE_NAME')) {
        //     $this->warning = $this->l('No name provided');
        // }

    }

    //INSTALL
    public function install()
    {
       return parent::install()
            && $this->registerHook('registerGDPRConsent')
            && $this->dbInstall();
    }

    //UNINSTALL
    public function uninstall()
    {
        return parent::uninstall();
    }

    //SQL install
    public function dbInstall()
    {
        $sqlQueries = [];
        $sqlQueries[] = ' CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'galleryplus` (
            `id_galimage` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `id_product` int(10) unsigned NOT NULL,
            `user_name` varchar(255) NULL,
            `date_add` datetime NOT NULL,
            PRIMARY KEY (`id_galimage`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';
        
        foreach ($sqlQueries as $query) {
            if (Db::getInstance()->execute($query) == false) {
                return false;
            }
        }
    }

    //HOOK
    public function hookdisplayAfterProductThumbs($params)
    {
        // print_r($this->context->cart->id);
        $this->context->smarty->assign([
            'nametext' => "The image"
        ]);
        return $this->display(__FILE__, 'views/templates/hook/gplus.tpl');
    }

    public function getContent()
    {
        return $this->fetch("module:galleryplus/views/templates/admin/configuration.tpl");
        // return $this->display(__FILE__, 'views/templates/admin/configuration.tpl');
    }

    public function hookDisplayAdminProductsExtra()
    {
        if (isset($params['id_product']) && (int)$params['id_product']) {
            $this->context->smarty->assign('form', 2);
            $this->bootstrap = true;
            return $this->display(__FILE__,'views/templates/admin/configuration.tpl');
        }
    }

}
