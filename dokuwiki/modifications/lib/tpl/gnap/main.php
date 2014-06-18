<?php
/**
 * DokuWiki GNaP Template
 *
 * @link     https://github.com/infrabel/GNaP.Wiki
 * @author   NDCC, Infrabel <dotnet@infrabel.be>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');

global $INFO;

?><!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>">
	<head>
		<meta charset="utf-8" />
		<title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>

		<?php tpl_metaheaders() ?>
		<?php echo tpl_favicon(array('favicon', 'mobile')) ?>
		
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!-- basic styles -->

		<link href="<?php echo tpl_basedir() ?>css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/jquery.gritter.css" />
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/chosen.css" />
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/datepicker.css" />
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/daterangepicker.css" />

		<!-- fonts -->

		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/ace-fonts.min.css" />

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->
		<link rel="stylesheet" href="<?php echo tpl_basedir() ?>css/dokuwiki.css" />
		
		<!-- ace settings handler -->
		<script src="<?php echo tpl_basedir() ?>js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo tpl_basedir() ?>js/html5shiv.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/respond.min.js"></script>
		<![endif]-->

		<script src="<?php echo tpl_basedir() ?>js/modernizr.min.js"></script>
	</head>

	<body class="navbar-fixed breadcrumbs-fixed">
		<!--[if lte IE 7 ]><div id="IE7"><![endif]--><!--[if IE 8 ]><div id="IE8"><![endif]-->
		
		<div id="dokuwiki__top"></div>
		
		<div class="navbar navbar-default navbar-fixed-top" id="navbar">
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="/" class="navbar-brand" accesskey="h" title="[H]">
						<small>
							<i class="team-logo"></i>
							<!-- <?php echo $conf['title'] ?> -->
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li  class="star">
							<?php
								$starred = plugin_load('action','starred');
								$starred->tpl_starred();
							?>
						</li>
						
						<li class="light green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-cloud-download"></i>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li><a href="?do=export_xhtml" class="action recent" accesskey="r" rel="nofollow" title="Export as HTML"><i class="icon-globe icon-fixed-width"></i>Export as HTML</a></li>
								
								<li><a href="?do=export_pdf" class="action recent" accesskey="r" rel="nofollow" title="Export as PDF"><i class="icon-file-text icon-fixed-width"></i>Export as PDF</a></li>
								
								<li class="divider"></li>
								
								<?php _tpl_toolsevent('pagetools', array(
									'subscribe' => tpl_action('subscribe', 1, 'li', 1, 'icon-envelope icon-fixed-width|')
								)); ?>
							</ul>
						</li>
					
						<li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-cogs"></i>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<?php _tpl_toolsevent('sitetools', array(
									'recent'    => tpl_action('recent', 1, 'li', 1, 'icon-comments icon-fixed-width|'),
									'media'     => tpl_action('media', 1, 'li', 1, 'icon-film icon-fixed-width|'),
									'index'     => tpl_action('index', 1, 'li', 1, 'icon-sitemap icon-fixed-width|')
								)); ?>

								<li><a href="/feed.php?type=rss2&num=50" class="action recent" accesskey="r" rel="nofollow" title="RSS Feed"><i class="icon-rss icon-fixed-width"></i>RSS Feed</a></li>

								<?php if ($conf['useacl'] && $showTools && $INFO['isadmin']): ?>
								<li class="divider"></li>
                    
								<?php _tpl_toolsevent('usertools', array(
									'admin'     => tpl_action('admin', 1, 'li', 1, 'icon-cog icon-fixed-width|')
								)); ?>
								<?php endif ?>
							</ul>
						</li>
					
						<li class="light-blue">
							<?php if ($conf['useacl'] && $showTools && $conf['authtype'] == 'authplain') { ?>
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<?php } else { ?>
							<a>
							<?php } ?>
								<span class="icon-user">&nbsp;</span>

								<span class="user-info">
									<small>Welcome,</small>
									<?php 
									if (!empty($_SERVER['REMOTE_USER'])) {
										echo _tpl_username(); 
									} else {
										echo 'Anonymous';
									}
									?>
								</span>
								
								<?php if (($conf['useacl'] && $showTools && $conf['authtype'] == 'authplain') || 
										  ($conf['subscribers'] && !contains($conf['disableactions'], 'subscribe'))
										 ): ?>
								<i class="icon-caret-down"></i>
								<?php endif ?>
							</a>
														
							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<?php if (!empty($_SERVER['REMOTE_USER'])) { ?>
						
								<?php if ($conf['useacl'] && $showTools && $conf['authtype'] == 'authplain' &&
										  (!contains($conf['disableactions'], 'profile'))
										 ): ?>
								<?php _tpl_toolsevent('usertools', array(
									'userpage'  => _tpl_action('userpage', 1, 'li', 1, 'icon-cog icon-fixed-width|'),
									'profile'   => tpl_action('profile', 1, 'li', 1, 'icon-cog icon-fixed-width|'),
								)); ?>
								<?php endif ?>
								
								<?php if ($conf['subscribers'] && !contains($conf['disableactions'], 'subscribe')): ?>								
								<li><a href="/?do=listeabo" class="action recent" accesskey="s" rel="nofollow" title="View Subscriptions"><i class="icon-envelope icon-fixed-width"></i>View Subscriptions</a></li>
								<?php endif ?>
								
								<li><a href="/favorites" class="action recent" accesskey="f" rel="nofollow" title="View Favorites"><i class="icon-heart icon-fixed-width"></i>View Favorites</a></li>
								
								<?php if (($conf['useacl'] && $showTools && $conf['authtype'] == 'authplain' && (!contains($conf['disableactions'], 'profile'))) ||
										  ($conf['subscribers'] && !contains($conf['disableactions'], 'subscribe'))
										 ): ?>								
								<li class="divider"></li>
								<?php endif ?>
								<?php } ?>

								<?php if ($conf['useacl'] && $showTools && $conf['authtype'] == 'authplain'): ?>
								<?php _tpl_toolsevent('usertools', array(
									'register'  => tpl_action('register', 1, 'li', 1, 'icon-cog icon-fixed-width|'),
									'login'     => tpl_action('login', 1, 'li', 1, 'icon-off|'),
								)); ?>
								<?php endif ?>
							</ul>
							
							</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
	
		<div class="main-container" id="main-container">
			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				
				<?php tpl_flush() ?>
				<div class="sidebar sidebar-fixed" id="sidebar">
					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<?php _tpl_pageevent('pagetools', array(
								'edit'      => tpl_action('edit',      1, '', 1, 'icon-pencil|', '|info'),
								//'revert'    => tpl_action('revert',    1, '', 1
								'revisions' => tpl_action('revisions', 1, '', 1, 'icon-calendar|', '|success'),
								'backlink'  => tpl_action('backlink',  1, '', 1, 'icon-external-link|', '|warning'),
								//'subscribe' => tpl_action('subscribe', 1, '', 1),
								//'top'       => tpl_action('top',       1, '', 1, 'icon-arrow-up|', '|danger'),
							)); ?>
							<a class="btn btn-danger btn-scroll-up-click" href="#dokuwiki__top" accesskey="t" rel="nofollow" title="" data-rel="tooltip" data-placement="bottom" data-original-title="Back to top [T]">
								<i class="icon-arrow-up"></i>
							</a>
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-info"></span>

							<span class="btn btn-success"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<?php 
					ob_start();
					tpl_include_page($conf['sidebar'], 1, 1); /* includes the nearest sidebar page */ 
					$buffer = ob_get_clean();
					
					$buffer = str_replace('<ul>' . "\n". '<li class="level1">', '<ul class="nav nav-list"><li class="level1">', $buffer);
					$buffer = str_replace('<ul>' . "\n". '<li class="level2">', '<ul class="submenu"><li class="level2">', $buffer);
					$buffer = str_replace('<span class="curid">', '', $buffer);
					$buffer = str_replace('</span>', '', $buffer);
					$buffer = str_replace('<div class="li">', '', $buffer);
					$buffer = str_replace('</div>', '', $buffer);
					$buffer = preg_replace('/<a(.*?)class="(.*?)"(.*?)>(.*?)\|(.*?)\|(.*?)\|(.*)<\/a>/i', 
										   '<a$1class="$2 $4"$3><i class="$5"></i><span class="menu-text">$6</span><b class="$7"></b></a>',
										   $buffer);
					
					$nsDivider = strrpos($INFO['id'], ':');
					if ($nsDivider === false) {
						$selector = $INFO['id'];
					} else {
						$selector = substr($INFO['id'], 0, $nsDivider);
					}
					
					preg_match_all('/href="(.*?)"/i', $buffer, $matches);
					foreach ($matches[1] as $key => $title) {
						$title = substr($title, 1, strlen($title) - 1);
						$title = str_replace('/', ':', $title);
						$title = str_replace(':start', '', $title);
											
						if (startsWith($selector, $title)) {
							//echo $title . "-" . $matches[0][$key] . "<br>";
							
							$regexhref = str_replace('/', '\/', $matches[0][$key]);
							//<li class="level1"> <a href="/cc/start" class="wikilink1 dropdown-toggle" title="cc:start">
							$buffer = preg_replace('/<li class="(.*?)">.*?<a ' . $regexhref . ' class="(.*?) dropdown-toggle" title="(.*?)">/i', 
												   '<li class="$1 open"> <a ' . $matches[0][$key] . ' class="$2 dropdown-toggle" title="$3">',
												   $buffer);
												   
							//<li class="level1"> <a href="/applications/start" class="wikilink1 " title="applications:start">
							$buffer = preg_replace('/<li class="(.*?)">.*?<a ' . $regexhref . ' class="(.*?)" title="(.*?)">/i', 
												   '<li class="$1 active"> <a ' . $matches[0][$key] . ' class="$2" title="$3">',
												   $buffer);
						}
					}
					
					echo $buffer;
					?>

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>
				</div>

				<?php tpl_flush() ?>
				<div class="main-content">
					<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
						<?php if($conf['youarehere']){ ?>
							<div class="breadcrumbs"><?php _tpl_youarehere() ?></div>
						<?php } ?>
					
						<?php _tpl_searchform() ?>
					</div>

					<?php tpl_flush() ?>
					<div class="page-content dokuwiki">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php html_msgarea() ?>
								
								<div class="row">
									<div class="col-xs-12">
										<div class="page group">
											<div class="printonly"><?php _tpl_youarehere(false) ?></div>
											<?php tpl_flush() /* flush the output buffer */ ?>
											<?php tpl_content() /* the main content */ ?>
										</div>
									</div>

									<script type="text/javascript">
										var $path_assets = "";//this will be used in gritter alerts containing images
									</script>
								</div>

								<div class="docInfo"><?php _tpl_pageinfo() /* 'Last modified' etc */ ?></div>
								<?php tpl_flush() ?>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
			</div><!-- /.main-container-inner -->

			<!--<a href="#dokuwiki__top" class="btn-scroll-up btn btn-sm btn-inverse btn-scroll-up-click">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>-->
		</div><!-- /.main-container -->
		
		<div style="display: inline; margin: 0; padding: 0;"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
		<!--[if ( lte IE 7 | IE 8 ) ]></div><![endif]-->
	
		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo tpl_basedir() ?>js/jquery-1.11.0.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo tpl_basedir() ?>js/jquery-1.11.0.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo tpl_basedir() ?>js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<script src="<?php echo tpl_basedir() ?>js/bootstrap.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="<?php echo tpl_basedir() ?>js/jquery.gritter.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/spin.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/chosen.jquery.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/date-time/moment.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/date-time/daterangepicker.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/jquery.maskedinput.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/jquery.hotkeys.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/bootstrap-wysiwyg.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/jquery.dataTables.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/jquery.dataTables.bootstrap.js"></script>

		<!-- ace scripts -->
		<script src="<?php echo tpl_basedir() ?>js/ace-elements.min.js"></script>
		<script src="<?php echo tpl_basedir() ?>js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function ($) {		
			    //Used for tooltip
			    $('[data-rel=tooltip]').tooltip();
			    			
			    //Used for defining the spinner options
			    $.fn.spin = function (opts) {
			        this.each(function () {
			            var $this = $(this),
			                data = $this.data();
			
			            if (data.spinner) {
			                data.spinner.stop();
			                delete data.spinner;
			            }
			            if (opts !== false) {
			                data.spinner = new Spinner($.extend({ color: $this.css('color') }, opts)).spin(this);
			            }
			        });
			        return this;
			    };
			
			    var spinnerOptions = {};
			    spinnerOptions["lines"] = parseFloat(9);
			    spinnerOptions["length"] = parseFloat(2);
			    spinnerOptions["width"] = parseFloat(5);
			    spinnerOptions["radius"] = parseFloat(12);
			    spinnerOptions["corners"] = parseFloat(0.6);
			    spinnerOptions["rotate"] = parseFloat(14);
			    spinnerOptions["trail"] = parseFloat(78);
			    spinnerOptions["speed"] = parseFloat(1.7);
			    spinnerOptions["color"] = '#0cf';
			    
			    $('#spinner').spin(spinnerOptions);
			   
			    ////////////////////////////////////////////////////////////
			
			    //forms elements
			
			    //for options, check following page http://rustyjeans.com/jquery-plugins/input-limiter
			    $('textarea.limited').inputlimiter({
			        boxId: 'limiterbox',
			        boxAttach: false,
			        remTextHideOnBlur: false,
			        remText: '%n',
			        limitTextShow: false
			    });
				
			    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
			        $(this).prev().focus();
			    });
			
			    var today = new Date();
			    $('input[name=date-range-picker]').daterangepicker(
			        {
			            format: 'DD-MM-YYYY',
			            startDate: '' + today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear(),
			            endDate: '' + (today.getDate() + 5) + '-' + (today.getMonth() + 1) + '-' + today.getFullYear(),
			        }).prev().on(ace.click_event, function () {
			            $(this).next().focus();
			    });
							
			    $('#timepicker1').timepicker({
			        minuteStep: 1,
			        showSeconds: false,
			        showMeridian: false,
			        defaultTime: false
			    }).next().on(ace.click_event, function(){
			        $(this).prev().focus();
			    });
			
			    $.mask.definitions['~'] = '[+-]';
			    $('.input-mask-time').mask('99:99');
			    $('.input-mask-date').mask('99-99-9999');
			    $(".input-mask-product").mask("a*-999-a999", { placeholder: " ", completed: function () { alert("You typed the following: " + this.val()); } });
			
			    $(".chosen-select").chosen();
			    
			    //file input
			    $('#id-input-file-2').ace_file_input({
			        no_file: 'No File ...',
			        btn_choose: 'Choose',
			        btn_change: 'Change',
			        droppable: false,
			        onchange: null,
			        thumbnail: false //| true | large
			        //whitelist:'gif|png|jpg|jpeg'
			        //blacklist:'exe|php'
			        //onchange:''
			        //
			    });
			
			    $('#id-input-file-3').ace_file_input({
			        style: 'well',
			        btn_choose: 'Drop files here or click to choose',
			        btn_change: null,
			        no_icon: 'icon-cloud-upload',
			        droppable: true,
			        thumbnail: 'small'//large | fit
			        //,icon_remove:null//set null, to hide remove/reset button
			        /**,before_change:function(files, dropped) {
			            //Check an example below
			            //or examples/file-upload.html
			            return true;
			        }*/
			        /**,before_remove : function() {
			            return true;
			        }*/
								,
			        preview_error: function (filename, error_code) {
			            //name of the file that failed
			            //error_code values
			            //1 = 'FILE_LOAD_FAILED',
			            //2 = 'IMAGE_LOAD_FAILED',
			            //3 = 'THUMBNAIL_FAILED'
			            //alert(error_code);
			        }
			
			    }).on('change', function () {
			        //console.log($(this).data('ace_input_files'));
			        //console.log($(this).data('ace_input_method'));
			    });
			
			    //dynamically change allowed formats by changing before_change callback function
			    $('#id-file-format').removeAttr('checked').on('change', function () {
			        var before_change
			        var btn_choose
			        var no_icon
			        if (this.checked) {
			            btn_choose = "Drop images here or click to choose";
			            no_icon = "icon-picture";
			            before_change = function (files, dropped) {
			                var allowed_files = [];
			                for (var i = 0 ; i < files.length; i++) {
			                    var file = files[i];
			                    if (typeof file === "string") {
			                        //IE8 and browsers that don't support File Object
			                        if (!(/\.(jpe?g|png|gif|bmp)$/i).test(file)) return false;
			                    }
			                    else {
			                        var type = $.trim(file.type);
			                        if ((type.length > 0 && !(/^image\/(jpe?g|png|gif|bmp)$/i).test(type))
			                                || (type.length == 0 && !(/\.(jpe?g|png|gif|bmp)$/i).test(file.name))//for android's default browser which gives an empty string for file.type
			                            ) continue;//not an image so don't keep this file
			                    }
			
			                    allowed_files.push(file);
			                }
			                if (allowed_files.length == 0) return false;
			
			                return allowed_files;
			            }
			        }
			        else {
			            btn_choose = "Drop files here or click to choose";
			            no_icon = "icon-cloud-upload";
			            before_change = function (files, dropped) {
			                return files;
			            }
			        }
			        var file_input = $('#id-input-file-3');
			        file_input.ace_file_input('update_settings', { 'before_change': before_change, 'btn_choose': btn_choose, 'no_icon': no_icon })
			        file_input.ace_file_input('reset_input');
			    });
			
			    //WYSIWYG
			    function showErrorAlert (reason, detail) {
        var msg='';
        if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
        else {
            console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
    }
			
			    $('#editor1').ace_wysiwyg(
        { 'wysiwyg': { fileUploadError: showErrorAlert }
			        }).prev().addClass('wysiwyg-style1');
			    
			    //fix width of the single chosen and multi chosen ddl in form use
			    $('.chosen-container.chosen-container-single').attr("style", "");
			    $('.chosen-container.chosen-container-single').addClass("input-xlarge");
			    $('.chosen-container.chosen-container-multi').attr("style", "");
			    $('.chosen-container.chosen-container-multi').addClass("input-xlarge");
			
			    ////////////////////////////////////////////////////////////
			
			    //Tables jquery.dataTables
			
			    var oTable1 = $('#sample-table-2').dataTable({
			        "aoColumns": [
			          { "bSortable": false },
			          null, null, null, null, null,
			          { "bSortable": false }
			        ]
			    });
			
			
			    $('table th input:checkbox').on('click', function () {
			        var that = this;
			        $(this).closest('table').find('tr > td:first-child input:checkbox')
			        .each(function () {
			            this.checked = that.checked;
			            $(this).closest('tr').toggleClass('selected');
			        });
			
			    });

			})
		</script>
</body>
</html>
