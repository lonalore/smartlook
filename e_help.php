<?php

/**
 * @file
 * Addon file to display help block on Admin UI.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/smartlook/languages/[LANGUAGE]/[LANGUAGE]_admin.php
e107::lan('smartlook', true, true);


/**
 * Class smartlook_help.
 */
class smartlook_help
{

	/**
	 * Admin UI action.
	 *
	 * @var mixed
	 */
	private $action;

	/**
	 * smartlook_help constructor.
	 */
	public function __construct()
	{
		$this->action = varset($_GET['action'], '');
		$this->renderHelpBlock();
	}

	/**
	 * Renders help block.
	 */
	public function renderHelpBlock()
	{
		switch($this->action)
		{
			default:
				$block = $this->getHelpBlockGeneral();
				break;
		}

		if(!empty($block))
		{
			e107::getRender()->tablerender($block['title'], $block['body']);
		}
	}

	/**
	 * Gets the general block contents.
	 *
	 * @return array
	 */
	public function getHelpBlockGeneral()
	{
		e107::js('footer', 'https://buttons.github.io/buttons.js');

		$content = '';

		$issue = array(
			'href="https://github.com/lonalore/smartlook/issues"',
			'class="github-button"',
			'data-icon="octicon-issue-opened"',
			'data-style="mega"',
			'data-count-api="/repos/lonalore/smartlook#open_issues_count"',
			'data-count-aria-label="# issues on GitHub"',
			'aria-label="Issue lonalore/smartlook on GitHub"',
		);

		$star = array(
			'href="https://github.com/lonalore/smartlook"',
			'class="github-button"',
			'data-icon="octicon-star"',
			'data-style="mega"',
			'data-count-href="/lonalore/smartlook/stargazers"',
			'data-count-api="/repos/lonalore/smartlook#stargazers_count"',
			'data-count-aria-label="# stargazers on GitHub"',
			'aria-label="Star lonalore/smartlook on GitHub"',
		);

		$content .= '<p class="text-center">' . LAN_PLUGIN_SMARTLOOK_ADMIN_HELP_03 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a ' . implode(" ", $issue) . '>' . LAN_PLUGIN_SMARTLOOK_ADMIN_HELP_04 . '</a>';
		$content .= '</p>';

		$content .= '<p class="text-center">' . LAN_PLUGIN_SMARTLOOK_ADMIN_HELP_02 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a ' . implode(" ", $star) . '>' . LAN_PLUGIN_SMARTLOOK_ADMIN_HELP_05 . '</a>';
		$content .= '</p>';

		$beerImage = '<img src="https://beerpay.io/lonalore/smartlook/badge.svg" />';
		$beerWishImage = '<img src="https://beerpay.io/lonalore/smartlook/make-wish.svg" />';

		$content .= '<p class="text-center">' . LAN_PLUGIN_SMARTLOOK_ADMIN_HELP_06 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a href="https://beerpay.io/lonalore/smartlook">' . $beerImage . '</a>';
		$content .= '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a href="https://beerpay.io/lonalore/smartlook">' . $beerWishImage . '</a>';
		$content .= '</p>';

		$block = array(
			'title' => LAN_PLUGIN_SMARTLOOK_ADMIN_HELP_01,
			'body'  => $content,
		);

		return $block;
	}

}


new smartlook_help();
