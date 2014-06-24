<?php
/**
 * SearchStats Plugin: This plugin records the search words and displays stats in the admin section
 *
 * @license		GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author		Michael Schuh <mike.schuh@gmx.at>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'admin.php';

class admin_plugin_searchstats extends DokuWiki_Admin_Plugin {

	function getInfo() {
		return array(
              'author' => 'Michael Schuh',
              'email'  => 'mike.schuh@gmx.at',
              'date'   => @file_get_contents(DOKU_PLUGIN.'searchstats/VERSION'),
              'name'   => 'Searchstats plugin (action, admin component)',
              'desc'   => 'This plugin records the search words and displays stats in the admin section',
              'url'    => 'http://blog.imho.at/20100902/artikel/dokuwiki-plugin-searchstats',
              );
	}

	function getMenuSort() { return 200; }
	function forAdminOnly() { return false; }

	//Carry out any processing required by the plugin.
	function handle() {
		$dataObject = new action_plugin_searchstats();
		$this->wordArray = $dataObject->getSearchWordArray();
	}
	
	//Render html output for the plugin.
	function html() {
		if(is_array($this->wordArray) && count($this->wordArray) > 0) {
			ptln('<h1>'.$this->getLang('menu').'</h1>');
			//print out bar chart
			ptln('<br />');
			$link = $this->_getBarChartTopKeywords(10);
			ptln('<img src="'.$link.'" />');
			//print out data table
			ptln('<br /><br />');
			ptln('<table class="inline">');
			ptln('<tr class="row0">');
			ptln('<th class="col0 leftalign">'.$this->getLang('th_word').'</th>');
			ptln('<th class="col1">'.$this->getLang('th_count').'</th>');
			ptln('</tr>');
			foreach($this->wordArray as $word => $count) {
				ptln('<tr>');
				ptln('<td class="col0">'.$word.'</td>');
				ptln('<td class="col1">'.$count.'</td>');
				ptln('</tr>');
			}
			ptln('</table>');
		}
		else {
		  ptln('<h1>'.$this->getLang('nosearchwords').'</h1>');
		}
	}

	function _getBarChartTopKeywords($amount = 10) {
		$countArray = count($this->wordArray);
		$amount = ($countArray < $amount ? $countArray : $amount);
		if(is_array($this->wordArray) && $amount > 0) {
			$wordArray = array_slice($this->wordArray, 0, $amount);

			$chxl = "&chxl=0:";
			$chd = "&chd=t:";
			$top = 0;
			$i = 0;
			foreach($wordArray as $word => $count) {
				if($i == 0) {
					if(function_exists('bcpow')) {
						$top = bcpow(10, (int) strlen((string) $count));
					}
					else {
						$strLen = (int) strlen((string) $count);
						$top = 1;
						while($strLen-- >= 1) {
							$top = $top * 10;
						}
					}
				}
				$i++;
				$chxl .= "|".$word;
				$percentage = $count/$top*100;
				$chd .= ($percentage).($i < $amount ? "," : "");
			}
			//$top = $top + (10-($top%10));
			//set chart type to bar chart
			$paramString = "?cht=bvg";
			//set x and y axis visible
			$paramString .= "&chxt=x,y";
			//set min and max for y axis
			$paramString .= "&chxr=1,0,".$top;
			//set width and height for chart
			$paramString .= "&chs=750x300";
			//set color for bars
			$paramString .= "&chco=A2C180";
			//set chart title
			$paramString .= "&chtt=".implode("+", explode(" ", $this->getLang('top10k')));
			//set automatic bar width
			$paramString .= "&chbh=a";
			//chxl for custom axis labels
			$paramString .= $chxl;
			//chd for bar heights
			$paramString .= $chd;

			$link = "http://chart.apis.google.com/chart".$paramString;
			return $link;
		}
		return false;
	}

	var $wordArray = array();

}

?>