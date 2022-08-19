<?php

class GalleryPlusTestModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $this->context->smarty->assign([
            "data" => "Hello Mr. Cat"
        ]);
        $this->setTemplate("module:galleryplus/views/templates/front/test.tpl");
    }

    public function postProcess(){
        
    }
} 