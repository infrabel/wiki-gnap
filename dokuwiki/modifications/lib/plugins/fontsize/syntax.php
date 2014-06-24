<?php
/**
* Font Size Plugin: Allow different font sizes
* 
* @license    GPL 3 (http://www.gnu.org/licenses/gpl.html)
* @author     Jesús A. Álvarez <zydeco@namedfork.net>
*/
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class  syntax_plugin_fontsize extends DokuWiki_Syntax_Plugin {
 
	function getInfo(){
		return array(
			'author' => 'Jesús A. Álvarez',
			'email'  => 'zydeco@namedfork.net',
			'date'   => '2008-04-25',
			'name'   => 'Font Size Plugin',
			'desc'   => 'Allow different font sizes.',
			'url'    => 'http://wiki.splitbrain.org/plugin:fontsize',
			);
	}

	function getType() { return('formatting'); }
	function getSort() { return 131; }
    
	function connectTo($mode) {
		$this->Lexer->addEntryPattern('##+(?=.*##+)',$mode,'plugin_fontsize');
		$this->Lexer->addEntryPattern(',,+(?=.*,,+)',$mode,'plugin_fontsize');
	}

    function postConnect() {
        $this->Lexer->addExitPattern('##+', 'plugin_fontsize');
        $this->Lexer->addExitPattern(',,+', 'plugin_fontsize');
    }

	function handle($match, $state, $pos, &$handler){
		switch ($state) {
			case DOKU_LEXER_ENTER:
				if ($match{1} == '#')
					$size = (strlen($match)*5)+95 .'%';
				else
					$size = 105-(strlen($match)*5) . '%';
				return array($state, $size);
			case DOKU_LEXER_UNMATCHED:	return array($state, $match);
			case DOKU_LEXER_EXIT:		return array($state, '');
		}
		return array();
	}

	function render($mode, &$renderer, $data) {
		if ($mode == 'xhtml') {
			list($state, $match) = $data;
			switch ($state) {
				case DOKU_LEXER_ENTER:
					$renderer->doc .= "<span style='font-size:$match;'>"; break;
				case DOKU_LEXER_UNMATCHED:
					$renderer->doc .= $renderer->_xmlEntities($match); break;
				case DOKU_LEXER_EXIT:
					$renderer->doc .= '</span>'; break;
			}
			return true;
		}
		return false;
	}

}
//Setup VIM: ex: et ts=4 enc=utf-8 :