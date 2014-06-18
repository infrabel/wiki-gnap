<?php
/**
 * Template Functions
 *
 * This file provides template specific custom functions that are
 * not provided by the DokuWiki core.
 * It is common practice to start each function with an underscore
 * to make sure it won't interfere with future core functions.
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle) {
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

function contains($haystack, $needle) {
	return strpos($haystack, $needle) !== false;
}

function _tpl_username() {
	global $conf;
	global $USERINFO;

	return ($conf['authtype'] == 'authplain')
		? $USERINFO['name'] . ' (' . $USERINFO['mail'] . ')'
		: $USERINFO['name'] . ' (' . $USERINFO['uid'] . ')';
}

function _tpl_searchform($ajax = true, $autocomplete = true) {
	global $lang;
	global $ACT;
	global $QUERY;
 
	// don't print the search form if search action has been disabled
	if(!actionOK('search')) return false;
 
 	print '<div class="nav-search" id="nav-search">';
	print '<form action="' . wl() . '"  class="form-search">';
	print '<input type="hidden" name="do" value="search" />';
	print '<span class="input-icon">';
	print '<input type="text" placeholder="' . $lang['btn_search'] . '..." ';
	if($ACT == 'search') print 'value="' . htmlspecialchars($QUERY). '" ';
 	if(!$autocomplete) print 'autocomplete="off" ';
	print 'class="nav-search-input" id="qsearch__in"  name="id" accesskey="f" title="[F]" />';
	print '<i class="icon-search nav-search-icon"></i>';
	print '</span>';
	print '</form>';
	print '</div><!-- #nav-search -->';
 
	/*
 	print '<form action="'.wl().'" accept-charset="utf-8" class="search" id="dw__search" method="get" role="search"><div class="no">';
 	print 'class="edit"  />';
 	print '<input type="submit" value="'.$lang['btn_search'].'" class="button" title="'.$lang['btn_search'].'" />';
 	if($ajax) print '<div id="qsearch__out" class="ajax_qsearch JSpopup"></div>';
	*/
	
 	return true;
 }
 
function _tpl_youarehere($uselinks = true) {
    global $conf;
    global $ID;
    global $lang;

    // check if enabled
    if(!$conf['youarehere']) return false;

    $parts = explode(':', $ID);
    $count = count($parts);

	/*
							
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active">Standard Examples</li>
						</ul><!-- .breadcrumb -->
	*/
	
    echo '<ul class="breadcrumb">';

    // always print the startpage
    echo '<li>';
	if ($uselinks)
		echo '<i class="icon-home home-icon"></i>';
		
    _tpl_pagelink($uselinks, ':' . $conf['start'], 'Home');
    echo '</li>';

    // print intermediate namespace links
    $part = '';
    for($i = 0; $i < $count - 1; $i++) {
        $part .= $parts[$i].':';
        $page = $part;
        if($page == $conf['start']) continue; // Skip startpage

        // output
		echo '<li>';
        _tpl_pagelink($uselinks, $page);
		echo '</li>';
    }

    // print current page, skipping start page, skipping for namespace index
    resolve_pageid('', $page, $exists);
    if(isset($page) && $page == $part.$parts[$i]) return true;
    $page = $part.$parts[$i];
    if($page == $conf['start']) return true;
    
	echo '<li class="active">';
    _tpl_pagelink($uselinks, $page);
	echo '</li>';
    return true;
}

function _tpl_pagelink($uselinks, $id, $name = null) {
	if ($uselinks) {
		print html_wikilink($id, $name);
	} else {
		if (endsWith($id, ':'))
			$id .= 'start';

		tpl_pagetitle($id);
	}
		
    return true;
}

function _tpl_pageinfo($ret = false) {
    global $conf;
    global $lang;
    global $INFO;
    global $ID;

    // return if we are not allowed to view the page
    if(!auth_quickaclcheck($ID)) {
        return false;
    }

    // prepare date and path
    $fn = $INFO['filepath'];
    if(!$conf['fullpath']) {
        if($INFO['rev']) {
            $fn = str_replace(fullpath($conf['olddir']).'/', '', $fn);
        } else {
            $fn = str_replace(fullpath($conf['datadir']).'/', '', $fn);
        }
    }
    $fn   = utf8_decodeFN($fn);
    $date = dformat($INFO['lastmod']);

    // print it
    if($INFO['exists']) {
        $out = '';
        //$out .= '<bdi>'.$fn.'</bdi>';
        //$out .= ' Â· ';
        $out .= $lang['lastmod'];
        $out .= ': ';
        $out .= $date;
        if($INFO['editor']) {
            $out .= ' '.$lang['by'].' ';
            $out .= '<bdi>'.editorinfo($INFO['editor']).'</bdi>';
        } else {
            $out .= ' ('.$lang['external_edit'].')';
        }
        if($INFO['locked']) {
            $out .= ' Â· ';
            $out .= $lang['lockedby'];
            $out .= ': ';
            $out .= '<bdi>'.editorinfo($INFO['locked']).'</bdi>';
        }
        if($ret) {
            return $out;
        } else {
            echo $out;
            return true;
        }
    }
    return false;
}

/**
 * Create link/button to discussion page and back
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_discussion($discussionPage, $title, $backTitle, $link=0, $wrapper=0) {
    global $ID;

    $discussPage    = str_replace('@ID@', $ID, $discussionPage);
    $discussPageRaw = str_replace('@ID@', '', $discussionPage);
    $isDiscussPage  = strpos($ID, $discussPageRaw) !== false;
    $backID         = str_replace($discussPageRaw, '', $ID);

    if ($wrapper) echo "<$wrapper>";

    if ($isDiscussPage) {
        if ($link)
            tpl_pagelink($backID, $backTitle);
        else
            echo html_btn('back2article', $backID, '', array(), 'get', 0, $backTitle);
    } else {
        if ($link)
            tpl_pagelink($discussPage, $title);
        else
            echo html_btn('discussion', $discussPage, '', array(), 'get', 0, $title);
    }

    if ($wrapper) echo "</$wrapper>";
}

/**
 * Create link/button to user page
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_userpage($userPage, $title, $link=0, $wrapper=0) {
    if (empty($_SERVER['REMOTE_USER'])) return;

    global $conf;
    $userPage = str_replace('@USER@', $_SERVER['REMOTE_USER'], $userPage);

    if ($wrapper) echo "<$wrapper>";

    if ($link)
        tpl_pagelink($userPage, $title);
    else
        echo html_btn('userpage', $userPage, '', array(), 'get', 0, $title);

    if ($wrapper) echo "</$wrapper>";
}

/**
 * Wrapper around custom template actions
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_action($type, $link=0, $wrapper=0) {
    switch ($type) {
        case 'discussion':
            if (tpl_getConf('discussionPage')) {
                _tpl_discussion(tpl_getConf('discussionPage'), tpl_getLang('discussion'), tpl_getLang('back_to_article'), $link, $wrapper);
            }
            break;
        case 'userpage':
            if (tpl_getConf('userPage')) {
                _tpl_userpage(tpl_getConf('userPage'), tpl_getLang('userpage'), $link, $wrapper);
            }
            break;
    }
}

/**
 * Create event for tools menues
 *
 * @author Anika Henke <anika@selfthinker.org>
 */
function _tpl_toolsevent($toolsname, $items, $view='main') {
    $data = array(
        'view'  => $view,
        'items' => $items
    );

    $hook = 'TEMPLATE_'.strtoupper($toolsname).'_DISPLAY';
    $evt = new Doku_Event($hook, $data);
    if($evt->advise_before()){
        foreach($evt->data['items'] as $k => $html) {
			echo preg_replace('/<a(.*)>(.*)\|(.*)<\/a>/i', '<a$1><i class="$2"></i>$3</a>', $html);
		}
    }
    $evt->advise_after();
}

function _tpl_pageevent($toolsname, $items, $view='main') {
    $data = array(
        'view'  => $view,
        'items' => $items
    );

    $hook = 'TEMPLATE_'.strtoupper($toolsname).'_DISPLAY';
    $evt = new Doku_Event($hook, $data);
    if($evt->advise_before()){
        foreach($evt->data['items'] as $k => $html) {
			$html = preg_replace('/<a(.*)class="(.*?)"(.*)>(.*)\|(.*)\|(.*)<\/a>/i', 
								 '<a class="btn btn-$6"$1$3 data-rel="tooltip" data-placement="bottom">' . "\n" . '<i class="$4"></i></a>' . "\n", $html);

			echo $html;
		}
    }
    $evt->advise_after();
}

/**
 * copied from core (available since Binky)
 */
if (!function_exists('tpl_classes')) {
    function tpl_classes() {
        global $ACT, $conf, $ID, $INFO;
        $classes = array(
            'dokuwiki',
            'mode_'.$ACT,
            'tpl_'.$conf['template'],
            !empty($_SERVER['REMOTE_USER']) ? 'loggedIn' : '',
            $INFO['exists'] ? '' : 'notFound',
            ($ID == $conf['start']) ? 'home' : '',
        );
        return join(' ', $classes);
    }
}
