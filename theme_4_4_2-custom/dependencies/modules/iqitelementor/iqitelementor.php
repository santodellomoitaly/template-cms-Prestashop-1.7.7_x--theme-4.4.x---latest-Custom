<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 * @copyright 2017 IQIT-COMMERCE.COM
 * @license   GNU General Public License version 2
 *
 * You can not resell or redistribute this software.
 */


use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use Elementor\PluginElementor;
use Symfony\Component\HttpFoundation\Request;

if (!defined('_PS_VERSION_')) {
    exit;
}
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/IqitElementorLanding.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/IqitElementorTemplate.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/IqitElementorProduct.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/IqitElementorCategory.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/IqitElementorContent.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/iqitElementorWpHelper.php';

require_once _PS_MODULE_DIR_ . '/iqitelementor/includes/plugin-elementor.php';

require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_Brands.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_ProductsList.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_ProductsListTabs.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_Modules.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_CustomTpl.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_Menu.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_RevolutionSlider.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_Newsletter.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_Blog.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_Search.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_Links.php';
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/widgets/IqitElementorWidget_ContactForm.php';



class IqitElementor extends Module implements WidgetInterface
{
    const INSTALL_SQL_FILE = '/sql/install.sql';
    const UNINSTALL_SQL_FILE = '/sql/uninstall.sql';

    public static $WIDGETS = [
        'Brands',
        'ProductsList',
        'ProductsListTabs',
        'RevolutionSlider',
        'Menu',
        'ContactForm',
        'Newsletter',
        'Search',
        'Links',
        'Blog',
        'Modules',
        'CustomTpl',
    ];

    public function __construct()
    {
        $this->name = 'iqitelementor';
        $this->tab = 'front_office_features';
        $this->version = '1.1.9';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;
        $this->controllers = array('preview','widget');

        parent::__construct();


        $this->displayName = $this->l('IQITELEMENTOR - drag&drop front-end page builder');
        $this->description = $this->l('Flexible page builder based on Wordpress Elementor plugin by POJO.me');

    }

    public function install()
    {

        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }


        return (parent::install()
            && $this->registerHook('displayHome')
            && $this->registerHook('displayBackOfficeHeader')
            && $this->registerHook('displayManufacturerElementor')
            && $this->registerHook('actionObjectCmsUpdateBefore')
            && $this->registerHook('actionObjectCmsUpdateAfter')
            && $this->registerHook('actionObjectSimpleBlogPostUpdateAfter')
            && $this->registerHook('actionObjectSimpleBlogPostAddAfter')
            && $this->registerHook('actionObjectCmsDeleteAfter')
            && $this->registerHook('actionObjectProductDeleteAfter')
            && $this->registerHook('displayCMSDisputeInformation')
            && $this->registerHook('displayBlogElementor')
            && $this->registerHook('displayProductElementor')
            && $this->registerHook('displayCategoryElementor')
            && $this->registerHook('actionObjectManufacturerUpdateAfter')
            && $this->registerHook('actionObjectManufacturerDeleteAfter')
            && $this->registerHook('actionObjectManufacturerAddAfter')
            && $this->registerHook('actionObjectProductUpdateAfter')
            && $this->registerHook('actionObjectProductAddAfter')
            && $this->registerHook('actionObjectCategoryUpdateAfter')
            && $this->registerHook('actionObjectCategoryAddAfter')
            && $this->registerHook('actionObjectCategoryDeleteAfter')
            && $this->registerHook('header')
            && $this->registerHook('isJustElementor')
            && $this->registerHook('registerGDPRConsent')
            && $this->registerHook('actionProductAdd')
            && $this->installTab()
            && $this->installSQL()
            && $this->installFixtures()
        );
    }


    public function isUsingNewTranslationSystem()
    {
        return false;
    }

    public function refreshInstagramToken($apiHost = 'https://graph.instagram.com/refresh_access_token', $params, $method = 'GET')
    {
        $paramString = null;

        if (isset($params) && is_array($params)) {
            $paramString = '?' . http_build_query($params);
        }

        $apiCall = $apiHost . (('GET' === $method) ? $paramString : null);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiCall);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 90000);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        $jsonData = curl_exec($ch);
        curl_close($ch);
        if (!$jsonData) {
            return;
        }



        return json_decode($jsonData);
    }

    public static function instaTokenExpirationDate($expires_in){
        return strtotime(date('Y-m-d H:i:s')) + $expires_in - 1;
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        $instagramExpDate = (int) Configuration::get('iqit_elementor_inst_token_exp');

        if($instagramExpDate){
            $date = strtotime(date('Y-m-d H:i:s'));
            $date = strtotime("+15 day", $date);

            if($date > $instagramExpDate ){
                $instagramToken = Configuration::get('iqit_elementor_inst_token');
                if($instagramToken){
                    $apiData = array(
                        'grant_type' => 'ig_refresh_token',
                        'access_token' => $instagramToken
                    );
                    $newToken = $this->refreshInstagramToken('https://graph.instagram.com/refresh_access_token', $apiData);
                    Configuration::updateValue('iqit_elementor_inst_token', $newToken->access_token);
                    Configuration::updateValue('iqit_elementor_inst_token_exp', self::instaTokenExpirationDate($newToken->expires_in));
                }
            }
        }

        $this->context->controller->addCSS($this->_path . 'views/css/backoffice.css');

        $onlyElementor = array();
        $justElementorCategory = false;
        $idLang = (int) $this->context->language->id;
        $newContent = 0;
        $contentType = 'default';


        if (
            $this->context->controller->controller_name == 'AdminCmsContent' ||
            $this->context->controller->controller_name == 'AdminProducts' ||
            $this->context->controller->controller_name == 'AdminCategories' ||
            $this->context->controller->controller_name == 'AdminManufacturers' ||
            $this->context->controller->controller_name == 'AdminSimpleBlogPosts'
            ) {

           $this->context->controller->addJS($this->_path . 'views/js/backoffice.js');


            if ($this->context->controller->controller_name == 'AdminCmsContent'){

                global $kernel;

                $request = $kernel->getContainer()->get('request_stack')->getCurrentRequest();
                if (!isset($request->attributes)) {
                    return;
                }

                $idPage = (int) $request->attributes->get('cmsPageId');
                $pageType = 'cms';


                if($idPage){
                    $cms = new CMS($idPage);



                    foreach ($cms->content as $key => $contentLang ){

                        $strippedCms = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $contentLang);
                        $strippedCms = str_replace(array("\r\n", "\n", "\r"), '', $strippedCms);
                        $content = json_decode($strippedCms, true);

                        if (json_last_error() == JSON_ERROR_NONE){
                            if (empty($content)){
                                $onlyElementor[$key] = 0;
                            } else{
                                $onlyElementor[$key] = 1;
                            }

                        } else{
                            $onlyElementor[$key] = 0;
                        }
                    }
                }

            } elseif ($this->context->controller->controller_name == 'AdminSimpleBlogPosts'){
                $idPage = (int) Tools::getValue('id_simpleblog_post');
                $pageType = 'blog';

                if($idPage){
                    $cms = new SimpleBlogPost($idPage);

                    foreach ($cms->content as $key => $contentLang ){

                        $strippedCms = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $contentLang);
                        $strippedCms = str_replace(array("\r\n", "\n", "\r"), '', $strippedCms);
                        $content = json_decode($strippedCms, true);

                        if (json_last_error() == JSON_ERROR_NONE){
                            if (empty($content)){
                                $onlyElementor[$key] = 0;
                            } else{
                                $onlyElementor[$key] = 1;
                            }

                        } else{
                            $onlyElementor[$key] = 0;
                        }
                    }
                }

            } elseif ($this->context->controller->controller_name == 'AdminCategories'){
                global $kernel;

                $request = $kernel->getContainer()->get('request_stack')->getCurrentRequest();
                if (!isset($request->attributes)) {
                    return;
                }

                $idPage = (int) $request->attributes->get('categoryId');
                $pageType = 'category';

                $justElementorCategory = (bool) IqitElementorCategory::isJustElementor($idPage);

            } elseif ($this->context->controller->controller_name == 'AdminManufacturers'){
                global $kernel;

                $request = $kernel->getContainer()->get('request_stack')->getCurrentRequest();
                if (!isset($request->attributes)) {
                    return;
                }
                $idPage  = (int) $request->attributes->get('manufacturerId');

                $contentType = 'brand';
                $pageType = 'content';
            }
            else{
                global $kernel;

                $request = $kernel->getContainer()->get('request_stack')->getCurrentRequest();

                if (!isset($request->attributes)) {
                    return;
                }

                $idPage = (int) $request->attributes->get('id');
                $pageType = 'product';
            }



            if (!$idPage) {
                if($newContent){
                    $url = $this->context->link->getAdminLink('IqitElementorEditor').'&pageType='.$pageType.'&contentType='.$contentType.'&newContent='.$newContent.'&pageId=' . $idPage . '&idLang='. (int) $this->context->language->id;
                } else{
                    $url = '';
                }
                $this->context->smarty->assign(array(
                    'urlElementor' => $url
                ));
            }
            else{
                $url = $this->context->link->getAdminLink('IqitElementorEditor').'&pageType='.$pageType.'&contentType='.$contentType.'&newContent='.$newContent.'&pageId=' . $idPage . '&idLang='. (int) $this->context->language->id;

                $this->context->smarty->assign(array(
                    'urlElementor' => $url
                ));
            }

            Media::addJsDef(array(
                'onlyElementor'  =>  $onlyElementor,
                'elementorAjaxUrl' => $this->context->link->getAdminLink('AdminIqitElementor').'&ajax=1'
            ));

            $this->context->smarty->assign(array(
                'onlyElementor' => $onlyElementor,
                'pageType' => $pageType,
                'justElementorCategory' => $justElementorCategory,
                'idPage' => $idPage
            ));

            return $this->fetch(_PS_MODULE_DIR_ .'/'. $this->name . '/views/templates/hook/backoffice_header.tpl');
        }
    }


    public function uninstall()
    {
        return ($this->uninstallSQL() && $this->uninstallTab() &&  parent::uninstall());
    }

    public function hookHeader()
    {
     //   $this->context->controller->requireAssets(array('font-awesome'));
        $this->registerCssFiles();
        $this->registerJSFiles();



        Media::addJsDef(
            array('elementorFrontendConfig' => [
                'isEditMode' => '',
                'stretchedSectionContainer' =>'',
                'instagramToken' => Configuration::get('iqit_elementor_inst_token'),
                'is_rtl' => (bool)$this->context->language->is_rtl,
            ]));
    }

    public function registerCssFiles(){

        $this->context->controller->registerStylesheet('modules-'.$this->name.'-eicons', 'modules/'.$this->name.'/views/lib/eicons/css/elementor-icons.min.css', ['media' => 'all', 'priority' => 150]);
        if($this->context->language->is_rtl){
            $this->context->controller->registerStylesheet('modules-'.$this->name.'-style', 'modules/'.$this->name.'/views/css/frontend-rtl.min.css', ['media' => 'all', 'priority' => 150]);
        } else{
            $this->context->controller->registerStylesheet('modules-'.$this->name.'-style', 'modules/'.$this->name.'/views/css/frontend.min.css', ['media' => 'all', 'priority' => 150]);
        }

    }

    public function registerJSFiles(){

        $this->context->controller->registerJavascript('modules'.$this->name.'-instagram', 'modules/'.$this->name.'/views/lib/instagram-lite-master/instagramLite.min.js', ['position' => 'bottom', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules'.$this->name.'-jquery-numerator', 'modules/'.$this->name.'/views/lib/jquery-numerator/jquery-numerator.min.js', ['position' => 'bottom', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules'.$this->name.'-lottie-player', 'modules/'.$this->name.'/views/lib/lottie-player/lottie-player.js', ['position' => 'bottom', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules'.$this->name.'-script', 'modules/'.$this->name.'/views/js/frontend.js', ['position' => 'bottom', 'priority' => 150]);
    }

    public function installTab()
    {
        //editor
        $tab = new Tab();
        $tab->active = 0;
        $tab->class_name = "IqitElementorEditor";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "IqitElementorEditor";
        }
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->module = $this->name;
        $tab->add();

        //parent
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminParentIqitElementor";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "IqitElementor - Page builder";
        }
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->module = $this->name;
        $tab->add();
        $parentId = $tab->id;

        //homepage
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminIqitElementor";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "Homepage/General options";
        }
        $tab->id_parent = $parentId;
        $tab->module = $this->name;
        $tab->add();

        //content
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminIqitElementorContent";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "Content on hooks";
        }
        $tab->id_parent = $parentId;
        $tab->module = $this->name;
        $tab->add();

        return true;
    }

    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('IqitElementorEditor');
        if($id_tab){
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        $id_tab = (int)Tab::getIdFromClassName('AdminIqitElementor');
        if($id_tab){
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        $id_tab = (int)Tab::getIdFromClassName('AdminIqitElementorContent');
        if($id_tab){
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        $id_tab = (int)Tab::getIdFromClassName('AdminParentIqitElementor');
        if($id_tab){
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        return true;
    }


    public function installFixtures()
    {
        $success = true;
        $templateSource = json_decode(Tools::file_get_contents(_PS_MODULE_DIR_ . 'iqitelementor/initial_homepage.json'));

        $shops = Shop::getShopsCollection();
        foreach ($shops as $shop) {
            $layout = new IqitElementorLanding();
            $layout->id_shop = (int)$shop->id;
            $layout->title = 'Homepaga layout #1';
            $layout->data = $templateSource->data;
            $layout->add();
        }

        Configuration::updateValue('iqit_homepage_layout', 1);
        Configuration::updateValue('iqit_elementor_cache', 0);


        return $success;
    }

    public function getContent()
    {
       Tools::redirectAdmin(
           $this->context->link->getAdminLink('AdminIqitElementor')
        );
    }

    public function renderIqitElementorWidget($name, $options, $preview = false){
       $templateFile = strtolower($name) . '.tpl';
       $this->smarty->assign($this->getIqitElementorWidgetVariables($name, $options, $preview ));
       return $this->fetch(_PS_MODULE_DIR_ .'/iqitelementor/views/templates/widgets/' . $templateFile);
    }

    public function getIqitElementorWidgetVariables($name, $options = [], $preview = false)
    {
        $className = 'IqitElementorWidget_' . $name;
        $widget = new $className($this->context);
        return $widget->parseOptions($options, $preview);
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $templateFile = 'generated_content.tpl';
        $cacheId = $hookName;

        if (preg_match('/^displayHome\d*$/', $hookName)) {
            $cacheId = 'iqitelementor|'.$hookName;
        } elseif (preg_match('/^displayCMSDisputeInformation\d*$/', $hookName)){
            $cmsId = (int) $configuration['smarty']->tpl_vars['cms']->value['id'];
            $templateFile = 'generated_content_cms.tpl';
            $cacheId = 'iqitelementor|'.$hookName.'|'.$cmsId;
        } elseif (preg_match('/^displayProductElementor\d*$/', $hookName)){
            $productId = (int)  $configuration['smarty']->tpl_vars['product']->value['id'];
            $cacheId = 'iqitelementor|'.$hookName.'|'.$productId;
        }  elseif (preg_match('/^displayCategoryElementor\d*$/', $hookName)){
            $categoryId = (int)  $configuration['smarty']->tpl_vars['category']->value['id'];
            $cacheId = 'iqitelementor|'.$hookName.'|'.$categoryId;
        } elseif (preg_match('/^displayBlogElementor\d*$/', $hookName)){
            $blogId = (int)  $configuration['smarty']->tpl_vars['post']->value->id_simpleblog_post;
            $templateFile = 'generated_content_cms.tpl';
            $cacheId = 'iqitelementor|'.$hookName.'|'.$blogId;
        } elseif (preg_match('/^displayManufacturerElementor\d*$/', $hookName)){
            $manfuacturerId = (int) $configuration['manufacturerId'];
            $templateFile = 'generated_content_cms.tpl';
            $cacheId = 'iqitelementor|'.$hookName.'|'. $manfuacturerId;
        } elseif (preg_match('/^display.*$/', $hookName)){
            $templateFile = 'generated_content_content.tpl';
            $cacheId = 'iqitelementor|'.$hookName;
        }

        if (!$this->isCached('module:' . $this->name . '/views/templates/hook/' .$templateFile, $this->getCacheId($cacheId))){
            $vars = $this->getWidgetVariables($hookName, $configuration);
            if(!$vars['content']){
                return;
            }
            $this->smarty->assign($vars);
        }

        return $this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile, $this->getCacheId($cacheId));
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }
        $content = '';
        $options = [];

        if (preg_match('/^displayHome\d*$/', $hookName)) {

            $layoutId = (int) Configuration::get('iqit_homepage_layout');
            $layout =  new IqitElementorLanding($layoutId, $this->context->language->id);

            if (Validate::isLoadedObject($layout)) {
                ob_start();
                PluginElementor::instance()->get_frontend((array) json_decode($layout->data, true));
                $content = ob_get_clean();
            }
        }
        elseif (preg_match('/^displayCMSDisputeInformation\d*$/', $hookName)){
            $cmsContent =  $configuration['smarty']->tpl_vars['cms']->value['content'];
            $strippedCms = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $cmsContent);
            $strippedCms = str_replace(array("\r\n", "\n", "\r"), '', $strippedCms);
            $content = json_decode($strippedCms, true);

            if (json_last_error() == JSON_ERROR_NONE){
                ob_start();
                PluginElementor::instance()->get_frontend((array) $content);
                $options['elementor'] = true;
                $content = ob_get_clean();
            } else {
                $options['elementor'] = false;
                $content = $cmsContent;
            }
        } elseif (preg_match('/^displayProductElementor\d*$/', $hookName)){
            $productId = (int) $configuration['smarty']->tpl_vars['product']->value['id'];
            $id_shop = (int) $this->context->shop->id;
            $id = IqitElementorProduct::getIdByProduct($productId, $id_shop);

            if ($id){
                $layout =  new IqitElementorProduct($id, $this->context->language->id, $id_shop);

                if (Validate::isLoadedObject($layout)) {
                    ob_start();
                    PluginElementor::instance()->get_frontend((array) json_decode($layout->data, true));
                    $content = ob_get_clean();
                }
            }
        } elseif (preg_match('/^displayCategoryElementor\d*$/', $hookName)){
            $categoryId = (int) $configuration['smarty']->tpl_vars['category']->value['id'];
            $id_shop = (int) $this->context->shop->id;
            $id = IqitElementorCategory::getIdByCategory($categoryId, $id_shop);

            if ($id){
                $layout =  new IqitElementorCategory($id, $this->context->language->id, $id_shop);

                if (Validate::isLoadedObject($layout)) {
                    ob_start();
                    PluginElementor::instance()->get_frontend((array) json_decode($layout->data, true));
                    $content = ob_get_clean();
                }
            }
        } elseif (preg_match('/^displayBlogElementor\d*$/', $hookName)){
            $blogContent =  $configuration['smarty']->tpl_vars['post']->value->content;
            $strippedBlog = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $blogContent);
            $strippedBlog = str_replace(array("\r", "\n"), '', $strippedBlog);

            $content = json_decode($strippedBlog, true);

            if (json_last_error() == JSON_ERROR_NONE){
                ob_start();
                PluginElementor::instance()->get_frontend((array) $content);
                $options['elementor'] = true;
                $content = ob_get_clean();
            } else {
                $options['elementor'] = false;
                $content = $blogContent;
            }
        }  elseif (preg_match('/^displayManufacturerElementor\d*$/', $hookName)){

            $options['elementor'] = false;
            $manfuacturerId = (int) $configuration['manufacturerId'];
            $id_shop = (int) $this->context->shop->id;
            $hookId = (int) Hook::getIdByName($hookName);
            $id = IqitElementorContent::getIdByObjectAndHook($hookId, $manfuacturerId, $id_shop);

            if ($id){
                $layout =  new IqitElementorContent($id, $this->context->language->id, $id_shop);

                if (Validate::isLoadedObject($layout)) {
                    ob_start();
                    PluginElementor::instance()->get_frontend((array) json_decode($layout->data, true));
                    $content = ob_get_clean();
                }
            }
        } elseif (preg_match('/^display.*$/', $hookName)){
            $id_hook = Hook::getIdByName($hookName);
            $contents = IqitElementorContent::getByHook($id_hook);
            if(is_array($contents)){
                foreach($contents as $contentId){
                    $layout =  new IqitElementorContent((int) $contentId['id_elementor'], $this->context->language->id);
                    if (Validate::isLoadedObject($layout)) {
                        ob_start();
                        PluginElementor::instance()->get_frontend((array) json_decode($layout->data, true));
                        $content .= ob_get_clean();
                    }
                }
            }
        }


        return array(
            'content' => $content,
            'options' => $options,
            'hook' => $hookName
        );
    }

    public function checkEnvironment()
    {
        $cookie = new Cookie('psAdmin', '', (int)Configuration::get('PS_COOKIE_LIFETIME_BO'));
        return isset($cookie->id_employee) && isset($cookie->passwd) && Employee::checkPassword($cookie->id_employee, $cookie->passwd);
    }

    public function getFrontEditorToken()
    {
        return Tools::getAdminToken($this->name.(int)Tab::getIdFromClassName($this->name)
            .(is_object(Context::getContext()->employee) ? (int)Context::getContext()->employee->id :
                Tools::getValue('id_employee')));
    }

    private function installSQL()
    {
        if (!file_exists(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }

        unset($sql, $q, $replace);
        return true;
    }

    private function uninstallSQL()
    {
        if (!file_exists(dirname(__FILE__)  . self::UNINSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::UNINSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }
            
        unset($sql, $q, $replace);

        return true;
    }

    public function clearHomeCache() {
        $templateFile = 'module:' . $this->name . '/views/templates/hook/generated_content.tpl';
        $cacheId = 'iqitelementor|displayHome';
        $this->_clearCache($templateFile, $cacheId);
    }

    public function clearHookCache($idHook) {
        $hookName = Hook::getNameById($idHook);
        $templateFile = 'module:' . $this->name . '/views/templates/hook/generated_content_content.tpl';
        $cacheId = 'iqitelementor|'.$hookName;
        $this->_clearCache($templateFile, $cacheId);
    }


    public function clearProductCache($idProduct) {
        $templateFile = 'module:' . $this->name . '/views/templates/hook/generated_content.tpl';
        $cacheId = 'iqitelementor|displayProductElementor|'.(int)$idProduct;
        $this->_clearCache($templateFile, $cacheId);
    }

    public function clearCategoryCache($idCategory) {
        $templateFile = 'module:' . $this->name . '/views/templates/hook/generated_content.tpl';
        $cacheId = 'iqitelementor|displayCategoryElementor|'.(int)$idCategory;
        $this->_clearCache($templateFile, $cacheId);
    }

    public function hookActionObjectCmsDeleteAfter($params) {
        $templateFile = 'module:' . $this->name . '/views/templates/hook/generated_content.tpl';
        $cmsId = (int) $params['object']->id_cms;
        $cacheId = 'iqitelementor|displayCMSDisputeInformation|'.$cmsId;
        $this->_clearCache($templateFile, $cacheId);
    }

    public function hookActionObjectCmsUpdateAfter($params) {

        $pur = (int) Configuration::get('PS_USE_HTMLPURIFIER_TMP');
        Configuration::updateValue('PS_USE_HTMLPURIFIER', $pur);

        $templateFile = 'module:' . $this->name . '/views/templates/hook/generated_content_cms.tpl';
        $cmsId = (int) $params['object']->id_cms;
        $cacheId = 'iqitelementor|displayCMSDisputeInformation|'.$cmsId;
        $this->_clearCache($templateFile, $cacheId);
    }


    public function hookIsJustElementor($params) {
        return  IqitElementorCategory::isJustElementor((int )$params['categoryId']);
    }

    public function hookActionObjectSimpleBlogPostUpdateAfter($params) {

        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }

        $templateFile = 'module:' . $this->name . '/views/templates/hook/generated_content_cms.tpl';
        $postId = (int) $params['object']->id_simpleblog_post;
        $cacheId = 'iqitelementor|displayBlogElementor|'.$postId ;
        $this->_clearCache($templateFile, $cacheId);
    }

    public function hookActionObjectSimpleBlogPostAddAfter($params) {

        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }
    }


    public function hookActionObjectCmsUpdateBefore($params) {
        $pur = (int) Configuration::get('PS_USE_HTMLPURIFIER');
        Configuration::updateValue('PS_USE_HTMLPURIFIER_TMP', $pur);
        Configuration::updateValue('PS_USE_HTMLPURIFIER', 0);
    }

    public function hookActionObjectProductDeleteAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }
        $this->clearProductCache((int)$params['object']->id);

        IqitElementorProduct::deleteElement($params['object']->id);

        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }
    }


    public function hookActionObjectManufacturerUpdateAfter($params) {
        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }
    }

    public function hookActionObjectManufacturerDeleteAfter($params) {
        if (!isset($params['object']->id)) {
            return;
        }

        $hookId = Hook::getIdByName('displayManufacturerElementor');
        $idElementor = IqitElementorContent::getIdByObjectAndHook($hookId, $params['object']->id);

        if($idElementor){
            IqitElementorContent::deleteElement($idElementor);
        }

        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }
    }

    public function hookActionObjectManufacturerAddAfter($params) {
        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }
    }

    public function hookActionObjectProductUpdateAfter($params) {
        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }
    }

    public function hookActionObjectCategoryDeleteAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }
        $this->clearCategoryCache((int)$params['object']->id);

        IqitElementorCategory::deleteElement($params['object']->id);
    }

    public function hookActionObjectProductAddAfter($params) {
        if (Configuration::get('iqit_elementor_cache')){
            $this->clearHomeCache();
        }
    }

    public function hookActionProductAdd($params){
        if(isset($params['id_product_old'])) {

            $idProductOld = (int) $params['id_product_old'];
            $idProduct = (int) $params['id_product'];

            $id = IqitElementorProduct::getIdByProduct($idProductOld);

            if ($id){
                $elementor  = new IqitElementorProduct($id);
                $elementor->id_product = $idProduct;
                $elementor->add();
            }

        }
    }

}
