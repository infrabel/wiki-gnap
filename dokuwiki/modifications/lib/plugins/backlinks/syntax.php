<?php
/**
 * DokuWiki Syntax Plugin Backlinks
 *
 * Shows a list of pages that link back to a given page.
 *
 * Syntax:  {{backlinks>[pagename]}}
 *
 *   [pagename] - a valid wiki pagename
 * 
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  Michael Klier <chi@chimeric.de>
 * @author  Mark C. Prins <mprins@users.sf.net>
 */
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
if(!defined('DW_LF')) define('DW_LF',"\n");

require_once(DOKU_PLUGIN.'syntax.php');
require_once(DOKU_INC.'inc/parserutils.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_backlinks extends DokuWiki_Syntax_Plugin {
    /**
     * Syntax Type.
     *
     * Needs to return one of the mode types defined in $PARSER_MODES in parser.php
     * @see DokuWiki_Syntax_Plugin::getType()
     */
    function getType()  { return 'substition'; }

    /**
     * @see DokuWiki_Syntax_Plugin::getPType()
     */
    function getPType() { return 'block'; }

    /**
     * @see Doku_Parser_Mode::getSort()
     */
    function getSort()  { return 304; }
    
    /**
     * Connect pattern to lexer.
     * @see Doku_Parser_Mode::connectTo()
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{backlinks>.+?\}\}', $mode, 'plugin_backlinks');
    }

    /**
     * Handler to prepare matched data for the rendering process.
     * @see DokuWiki_Syntax_Plugin::handle()
     */
    function handle($match, $state, $pos, &$handler){
        global $ID;
		
        $match = substr($match,12,-2); //strip {{backlinks> from start and }} from end
        $match = ($match == '.') ? $ID : $match;

		$filterpos = strpos($match, '|');
		
		if ($filterpos === false) {
			$filter = '';
		} else {
			$filter = substr($match, $filterpos + 1);
			$match = substr($match, 0, $filterpos);
		}

        if(strstr($match,".:")) {
            resolve_pageid(getNS($ID),$match,$exists);
        }

        return (array($match, $filter));
    }
	
    /**
     * Handles the actual output creation.
     * @see DokuWiki_Syntax_Plugin::render()
     */
    function render($mode, &$renderer, $data) {
        global $lang;

        if($mode == 'xhtml'){
            $renderer->info['cache'] = false;
            
            @require_once(DOKU_INC.'inc/fulltext.php');
            $all_backlinks = ft_backlinks($data[0]);
            $filter = $data[1];
			
			if ($filter != '' ) {
				$backlinks = array_filter($all_backlinks, function ($element) use ($filter) { 
					$length = strlen($filter);
					return (substr($element, 0, $length) === $filter);
				}); 
			} else {
				$backlinks = $all_backlinks;
			}
						
            $renderer->doc .= '<div id="plugin__backlinks">' . DW_LF;

            if(!empty($backlinks)) {

                $renderer->doc .= '<ul class="idx">';

                foreach($backlinks as $backlink){
                    $name = p_get_metadata($backlink,'title');
                    if(empty($name)) $name = $backlink;
                    $renderer->doc .= '<li><div class="li">';
                    $renderer->doc .= html_wikilink(':'.$backlink,$name,'');
                    $renderer->doc .= '</div></li>';
                }

                $renderer->doc .= '</ul>';
            } else {
                $renderer->doc .= '<ul class="idx"><li><div class="li">' . $lang['nothingfound'] . '</div></li></ul>';
            }
            
            $renderer->doc .= '</div>' . DW_LF;

            return true;
        }
        return false;
    }
}
