<?php

/**
 * @file
 * Include Smartlook tracking script.
 */

$prefs = e107::getPlugConfig('smartlook')->getPref();
$account = varset($prefs['account'], '');

if(!empty($account))
{
	$visibilityPages = smartlook_visibility_pages();
	$visibilityRoles = smartlook_visibility_roles();

	if($visibilityPages && $visibilityRoles)
	{
		// Build tracker code.
		$script = "window.smartlook||(function(d) {";
		$script .= "var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];";
		$script .= "var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';";
		$script .= "c.charset='utf-8';c.src='//rec.smartlook.com/recorder.js';h.appendChild(c);";
		$script .= "})(document);";
		$script .= "smartlook('init', '" . $account . "');";

		e107::js('inline', $script, null, 2);
	}
}

/**
 * Based on visibility setting this function returns TRUE if Smartlook
 * code should be added to the current user class and otherwise FALSE.
 */
function smartlook_visibility_roles()
{
	$prefs = e107::getPlugConfig('smartlook')->getPref();
	$class = (int) varset($prefs['visibility_roles'], 0);
	return check_class($class);
}

/**
 * Based on visibility setting this function returns TRUE if Smartlook
 * code should be added to the current page and otherwise FALSE.
 */
function smartlook_visibility_pages()
{
	$prefs = e107::getPlugConfig('smartlook')->getPref();
	$cusPagePref = explode(PHP_EOL, varset($prefs['pages'], ''));

	$match = false;

	if(is_array($cusPagePref) && count($cusPagePref) > 0)
	{
		$c_url = str_replace(array('&amp;'), array('&'), e_REQUEST_URL);
		$c_url = rtrim(rawurldecode($c_url), '?');

		foreach($cusPagePref as $cusPage)
		{
			if($cusPage == 'FRONTPAGE' && ($c_url == SITEURL || rtrim($c_url, '/') == SITEURL . 'index.php'))
			{
				$match = true;
				break;
			}

			$matchPath = smartlook_match_path($c_url, $cusPage);
			if(!empty($cusPage) && $matchPath)
			{
				$match = true;
				break;
			}
		}
	}

	// The listed pages only.
	if((int) varset($prefs['visibility_pages'], 0) === 1)
	{
		if($match === true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// Every page except the listed pages.
	if((int) varset($prefs['visibility_pages'], 0) === 0)
	{
		if($match === true)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	return false;
}

/**
 * Check if a path matches any pattern in a set of patterns.
 *
 * Example:
 * <code>
 * <?php
 * smartlook_match_path('my/path/here', 'my/path/*'); // returns true
 * smartlook_match_path('my/path/here', '*path*'); // returns true
 * ?>
 * </code>
 *
 * @param $path
 *   The path to match.
 * @param $patterns
 *   String containing a set of patterns separated by \n, \r or \r\n.
 *
 * @return bool
 *   Boolean value: TRUE if the path matches a pattern, FALSE otherwise.
 */
function smartlook_match_path($path, $patterns)
{
	$path = str_replace(SITEURL, '', $path);
	$patterns = trim($patterns);
	$patterns = preg_quote($patterns, '/');
	$patterns = str_replace('*', '.*', $patterns);
	$patterns = str_replace('\.*', '.*', $patterns);
	$regexps = '/^(' . $patterns . ')$/';
	return (bool) preg_match($regexps, $path);
}
