<?php
require('Smarty.class.php');
class SmartyUser extends Smarty
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplateDir(array(
            'template' => ROOT_DIR.'/views/tamplates',
            'pages' => ROOT_DIR.'/views/pages'
        ));
        $this->setCompileDir(ROOT_DIR.'/views/tamplates_c');
        $this->setCacheDir(ROOT_DIR.'/views/cache');
        //$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
    }
}