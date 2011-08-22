<?php
/**
 * DokuWiki Plugin blextra (Helper Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Bernard Ladenthin (SystemhouseSoftware) <bernardladenthin@systemhousesoftware.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

class helper_plugin_blextra extends DokuWiki_Plugin {

	function getInfo() {
		return array('author' => 'Bernard Ladenthin (SystemhouseSoftware)',
					 'email'  => 'bernardladenthin@systemhousesoftware.com',
					 'date'   => '2011-08-22',
					 'name'   => 'blextra Plugin',
					 'desc'   => 'Provide functions for simple template creation',
					 'url'    => 'http://www.dokuwiki.org/plugin:blextra');
	}

	/**
	  * Constructor.
	  */
    function helper_plugin_blextra() {
	}

	/**
	 * Return namespacepart of a wiki ID exploded as array
	 */
	function getNSArray($id) {
		$result = getNS($id);
		if($result) {
			$result = @explode(':',$result);
		}
		return $result;
	}

	/**
	 * Array of available menu items, especially for the function tpl_actionlink_array
	 * Change the order to change the order of the menu
	 */
	public $available_actions = array(
		array(
			'type' => 'login',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'edit',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'history',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'recent',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'profile',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'index',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'admin',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'top',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'back',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'backlink',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			),
		array(
			'type' => 'subscribe',
			'pre'  => '',
			'suf'  => '',
			'inner'  => ''
			)
	);

	/**
	 * Return the menu as string ($return = true) or
	 * return each return value from the tpl_actionlink call as array ($return = false),
	 * an example with $available_actions (from this class):
	 *  array(11) {
	 *   ["edit"]=>
	 *   bool(true)
	 *   ["history"]=>
	 *   bool(true)
	 *   ["recent"]=>
	 *   bool(true)
	 *   ["login"]=>
	 *   bool(true)
	 *   ["profile"]=>
	 *   bool(true)
	 *   ["index"]=>
	 *   bool(true)
	 *   ["admin"]=>
	 *   bool(true)
	 *   ["top"]=>
	 *   bool(true)
	 *   ["back"]=>
	 *   bool(false)
	 *   ["backlink"]=>
	 *   bool(true)
	 *   ["subscribe"]=>
	 *   bool(false)
	 * }
	 */
	function tpl_actionlink_array($types,$array_pre='',$array_after='',$return=false) {
		$out = '';
		if (!$return) {
			$out = array();
		}

		foreach($types as $key => $type) {
			$_type  = htmlspecialchars($type['type']);
			$_pre   = htmlspecialchars($type['pre']);
			$_suf   = htmlspecialchars($type['suf']);
			$_inner = htmlspecialchars($type['inner']);

			if ($return) {
				$out .=
					$array_pre.
					tpl_actionlink($_type,$_pre,$_suf,$_inner,$return).
					$array_after;
			}
			else {
				echo $array_pre;
				$out[$type['type']] = tpl_actionlink($_type,$_pre,$_suf,$_inner,$return);
				echo $array_after;
			}
		}

		return $out;
	}
	/**
	 * Return the links as string ($return = true) or
	 * return each return value from the tpl_link call as array ($return = false)
	 *
	 * an example:
	 *
	 * input:
	 * array(2) {
	 *   [0]=>
	 *   array(3) {
	 *     ["url"]=>
	 *     string(5) "start"
	 *     ["name"]=>
	 *     string(5) "Start"
	 *     ["more"]=>
	 *     string(22) "id='head_menu_1_start'"
	 *   }
	 *   [1]=>
	 *   array(3) {
	 *     ["url"]=>
	 *     string(3) "end"
	 *     ["name"]=>
	 *     string(14) "Thats the end!"
	 *     ["more"]=>
	 *     string(20) "id='head_menu_1_end'"
	 *   }
	 * }
	 *
	 *
	 * result:
	 * array(2) {
	 *   [0]=>
	 *   bool(true)
	 *   [1]=>
	 *   bool(true)
	 * }
	 * 
	 */
	function tpl_link_array($urls,$array_pre='',$array_after='',$return=false) {
		global $ID;
		$out = $linktarget = '';
		if (!$return) {
			$out = array();
		}

		foreach($urls as $key => $url) {
			$_url  = htmlspecialchars($url['url']);
			$_name = htmlspecialchars($url['name']);
			$_more = htmlspecialchars($url['more']);
			$_linktarget = wl(cleanID($_url),$params);
			
			if ($return) {
				$out .=
					$array_pre.
					tpl_link($_linktarget,$_name,$_more,$return).
					$array_after;
			}
			else {
				echo $array_pre;
				$out[] = tpl_link($_linktarget,$_name,$_more,$return);
				echo $array_after;
			}
		}

		return $out;
	}

	function getMethods(){
		$result = array();

		$result[] = array(
			'name'   => 'getNSArray',
			'desc'   => 'Return namespacepart of a wiki ID exploded as array',
			'params' => array(),
			'return' => array('id' => 'string')
		);

		$result[] = array(
			'name'   => 'tpl_actionlink_array',
			'desc'   => 'Return action links as array',
			'params' => array(
				'types' => 'array',
				'array_pre (optional)' => 'string',
				'array_after (optional)' => 'string',
				'return (optional)' => 'bool'
			),
			'return' => array('out' => 'mixed') //string or array
		);

		$result[] = array(
			'name'   => 'tpl_link_array',
			'desc'   => 'Return action links as array',
			'params' => array(
				'urls' => 'array',
				'array_pre (optional)' => 'string',
				'array_after (optional)' => 'string',
				'return (optional)' => 'bool'
			),
			'return' => array('out' => 'mixed') //string or array
		);
		
		return $result;
	}

}

// vim:ts=4:sw=4:et:

