<?php
/*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class IqitElementorTemplate extends ObjectModel
{
	public $id;
    public $id_template;
    public $title;
    public $data;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'iqit_elementor_template',
		'primary' => 'id_template',
		'multilang' => false,
		'fields' => array(
            'title' =>              array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 255),
            'data' =>           array('type' => self::TYPE_HTML, 'validate' => 'isJson'),
		)

	);

    public static function getTemplates(){

        $sql = 'SELECT `id_template`, `title`  FROM '._DB_PREFIX_.'iqit_elementor_template';
        return $results = Db::getInstance()->ExecuteS($sql);
    }

}
