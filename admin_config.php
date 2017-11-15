<?php

/**
 * @file
 * Admin UI.
 */

require_once("../../class2.php");

if(!e107::isInstalled('smartlook') || !getperms("P"))
{
	e107::redirect(e_BASE . 'index.php');
}

// [PLUGINS]/smartlook/languages/[LANGUAGE]/[LANGUAGE]_admin.php
e107::lan('smartlook', true, true);


/**
 * Class smartlook_admin.
 */
class smartlook_admin_config extends e_admin_dispatcher
{

	/**
	 * Required (set by child class).
	 *
	 * Controller map array in format.
	 * @code
	 *  'MODE' => array(
	 *      'controller' =>'CONTROLLER_CLASS_NAME',
	 *      'path' => 'CONTROLLER SCRIPT PATH',
	 *      'ui' => 'UI_CLASS', // extend of 'comments_admin_form_ui'
	 *      'uipath' => 'path/to/ui/',
	 *  );
	 * @endcode
	 *
	 * @var array
	 */
	protected $modes = array(
		'main' => array(
			'controller' => 'smartlook_admin_ui',
			'path'       => null,
			'ui'         => 'smartlook_admin_form_ui',
			'uipath'     => null,
		),
	);

	/**
	 * Optional (set by child class).
	 *
	 * Required for admin menu render. Format:
	 * @code
	 *  'mode/action' => array(
	 *      'caption' => 'Link title',
	 *      'perm' => '0',
	 *      'url' => '{e_PLUGIN}plugname/admin_config.php',
	 *      ...
	 *  );
	 * @endcode
	 *
	 * Note that 'perm' and 'userclass' restrictions are inherited from the $modes, $access and $perm, so you don't
	 * have to set that vars if you don't need any additional 'visual' control.
	 *
	 * All valid key-value pair (see e107::getNav()->admin function) are accepted.
	 *
	 * @var array
	 */
	protected $adminMenu = array(
		'main/prefs' => array(
			'caption' => LAN_PLUGIN_SMARTLOOK_ADMIN_01,
			'perm'    => 'P',
		),
	);

	/**
	 * Optional (set by child class).
	 *
	 * @var string
	 */
	protected $menuTitle = LAN_PLUGIN_SMARTLOOK_NAME;

}


/**
 * Class smartlook_admin_ui.
 */
class smartlook_admin_ui extends e_admin_ui
{

	/**
	 * Could be LAN constant (multi-language support).
	 *
	 * @var string plugin name
	 */
	protected $pluginTitle = LAN_PLUGIN_SMARTLOOK_NAME;

	/**
	 * Plugin name.
	 *
	 * @var string
	 */
	protected $pluginName = "smartlook";

	protected $preftabs = array(
		LAN_PLUGIN_SMARTLOOK_ADMIN_01,
	);

	protected $prefs = array(
		'account'          => array(
			'title' => LAN_PLUGIN_SMARTLOOK_ADMIN_04,
			'type'  => 'text',
			'data'  => 'str',
			'tab'   => 0,
		),
		'visibility_pages' => array(
			'title'      => LAN_PLUGIN_SMARTLOOK_ADMIN_11,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_PLUGIN_SMARTLOOK_ADMIN_08,
				1 => LAN_PLUGIN_SMARTLOOK_ADMIN_09,
			),
			'tab'        => 0,
		),
		'pages'            => array(
			'title' => LAN_PLUGIN_SMARTLOOK_ADMIN_07,
			'help'  => LAN_PLUGIN_SMARTLOOK_ADMIN_10,
			'type'  => 'textarea',
			'data'  => 'str',
			'tab'   => 0,
		),
		'visibility_roles' => array(
			'title' => LAN_PLUGIN_SMARTLOOK_ADMIN_12,
			'type'  => 'userclass',
			'data'  => 'int',
			// 'writeParms' => 'classlist=nobody,member,admin',
			'tab'   => 0,
		),
	);

	/**
	 * Init.
	 */
	public function init()
	{
		$tp = e107::getParser();

		$this->prefs['account']['help'] = $tp->lanVars(LAN_PLUGIN_SMARTLOOK_ADMIN_05, array(
			'x' => '<a href="https://www.smartlook.com" target="_blank">' . LAN_PLUGIN_SMARTLOOK_ADMIN_06 . '</a>',
		));
	}

}


/**
 * Class smartlook_admin_form_ui.
 */
class smartlook_admin_form_ui extends e_admin_form_ui
{

}


new smartlook_admin_config();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();
require_once(e_ADMIN . "footer.php");
exit;
