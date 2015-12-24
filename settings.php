<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Remove Tap Highlight on Windows Phone IE -->
	<meta name="msapplication-tap-highlight" content="no"/>

	<link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

	<title>NeXt FaX - Dashboard</title>


	<!-- uikit -->
	<link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

	<!-- flag icons -->
	<link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

	<!-- altair admin -->
	<link rel="stylesheet" href="assets/css/main.min.css" media="all">

	<!-- matchMedia polyfill for testing media queries in JS -->
	<!--[if lte IE 9]>
		<script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
		<script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
	<![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
	 <!-- main header -->
	<?php include_once('includes/header.php')?>
	<!-- main header end -->
	<!-- main sidebar -->
	<?php include_once('includes/sidemenu.php')?>
	<!-- main sidebar end -->

<div id="page_content">
        <div id="page_content_inner">
<div class="uk-width-large-8-10 uk-container-center">
            <h4 class="heading_a uk-margin-bottom">Basic settings</h4>
            <form action="" class="uk-form-stacked" id="page_settings">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-large-1-3 uk-width-medium-1-1">
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-form-row">
                                    <label for="settings_site_name">Site Name</label>
                                    <input class="md-input" type="text" id="settings_site_name" name="settings_site_name" value="Altair Admin"/>
                                </div>
                                <div class="uk-form-row">
                                    <label for="settings_page_description">Page description</label>
                                    <textarea class="md-input" name="settings_page_description" id="settings_page_description" cols="30" rows="4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ad, alias aliquid assumenda dicta ducimus eos harum impedit modi obcaecati odit possimus quibusdam quidem rerum, tempora tenetur ullam ut voluptates?</textarea>
                                </div>
                                <div class="uk-form-row">
                                    <label for="settings_admin_email">Admin email</label>
                                    <input class="md-input" type="text" id="settings_admin_email" name="settings_admin_email" value="altair_admin@example.com"/>
                                </div>
                                <div class="uk-form-row">
                                    <div class="uk-grid uk-grid-width-1-1 uk-grid-width-medium-1-2" data-uk-grid-margin>
                                        <div>
                                            <label for="settings_time_format" class="uk-form-label">Time Format</label>
                                            <select id="settings_time_format" name="settings_time_format" data-md-selectize>
                                                <option value="">Select</option>
                                                <option value="H:i">08:25</option>
                                                <option value="H:i:s">08:25:16</option>
                                                <option value="g:i a">08:25 am</option>
                                                <option value="g:i A">08:25 AM</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="settings_date_format" class="uk-form-label">Date Format</label>
                                            <select id="settings_date_format" name="settings_date_format" data-md-selectize>
                                                <option value="">Select</option>
                                                <option value="j/n/Y">29/11/2013</option>
                                                <option value="j-n-Y">29-11-2013</option>
                                                <option value="j.n.Y">29.11.2013</option>
                                                <option value="n/j/Y">11/29/2013</option>
                                                <option value="d/m/Y">29/11/2013</option>
                                                <option value="d-m-Y">29-11-2013</option>
                                                <option value="d.m.Y">29.11.2013</option>
                                                <option value="m/d/Y">11/29/2013</option>
                                                <option value="m-d-Y">11-29-2013</option>
                                                <option value="m.d.Y">11.29.2013</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3 uk-width-medium-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <ul class="md-list">
                                    <li>
                                        <div class="md-list-content">
                                            <div class="uk-float-right">
                                                <input type="checkbox" data-switchery checked id="settings_site_online" name="settings_site_online" />
                                            </div>
                                            <span class="md-list-heading">Site Online</span>
                                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <div class="uk-float-right">
                                                <input type="checkbox" data-switchery id="settings_seo" name="settings_seo" />
                                            </div>
                                            <span class="md-list-heading">Search Engine Friendly URLs</span>
                                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <div class="uk-float-right">
                                                <input type="checkbox" data-switchery id="settings_url_rewrite" name="settings_url_rewrite" />
                                            </div>
                                            <span class="md-list-heading">Use URL rewriting</span>
                                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3 uk-width-medium-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <ul class="md-list">
                                    <li>
                                        <div class="md-list-content">
                                            <div class="uk-float-right">
                                                <input type="checkbox" data-switchery data-switchery-color="#7cb342" checked id="settings_top_bar" name="settings_top_bar" />
                                            </div>
                                            <span class="md-list-heading">Top Bar Enabled</span>
                                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <div class="uk-float-right">
                                                <input type="checkbox" data-switchery data-switchery-color="#7cb342" id="settings_api" name="settings_api" />
                                            </div>
                                            <span class="md-list-heading">Api Enabled</span>
                                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <div class="uk-float-right">
                                                <input type="checkbox" data-switchery data-switchery-color="#d32f2f" id="settings_minify_static" checked name="settings_minify_static" />
                                            </div>
                                            <span class="md-list-heading">Minify JS files automatically</span>
                                            <span class="uk-text-muted uk-text-small">Lorem ipsum dolor sit amet&hellip;</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="heading_a">Other settings</h3>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-form-row">
                                    <label for="settings_visitors_languages">Select the languages that are accessible for visitors</label>
                                    <select id="settings_visitors_languages" name="settings_visitors_languages" multiple>
                                        <option value="gb" selected>English</option>
                                        <option value="fr" selected>French</option>
                                    </select>
                                </div>
                                <div class="uk-form-row">
                                    <label for="settings_admin_email" class="uk-form-label">Cache type</label>
                                    <div>
                                        <span class="icheck-inline">
                                            <input type="radio" name="settings_cache_type" id="settings_cache_file" data-md-icheck checked />
                                            <label for="settings_cache_file" class="inline-label">File system</label>
                                        </span>
                                        <span class="icheck-inline">
                                            <input type="radio" name="settings_cache_type" id="settings_cache_mysql" data-md-icheck />
                                            <label for="settings_cache_mysql" class="inline-label">MySQL</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <ul class="uk-tab" data-uk-tab="{connect:'#settings_users', animation: 'slide-horizontal' }">
                                    <li class="uk-active"><a href="#">Admin</a></li>
                                    <li><a href="#">Editor</a></li>
                                    <li><a href="#">author</a></li>
                                </ul>
                                <ul id="settings_users" class="uk-switcher uk-margin">
                                    <li>
                                        <ul class="md-list">
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_admin_editor" checked id="settings_user_admin_editor" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Disable the visual editor when writing</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_admin_toolbar" id="settings_user_admin_toolbar" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Show Toolbar when viewing site</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_admin_sitemap" checked id="settings_user_admin_sitemap" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Exclude user from Author-sitemap</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="md-list">
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_editor_editor" checked id="settings_user_editor_editor" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Disable the visual editor when writing</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_editor_toolbar" checked id="settings_user_editor_toolbar" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Show Toolbar when viewing site</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_editor_sitemap" id="settings_user_editor_sitemap" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Exclude user from Author-sitemap</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="md-list">
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_author_editor" id="settings_user_author_editor" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Disable the visual editor when writing</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_author_toolbar" checked id="settings_user_author_toolbar" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Show Toolbar when viewing site</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="md-list-content">
                                                    <div class="uk-float-right">
                                                        <input type="checkbox" name="settings_user_author_sitemap" id="settings_user_author_sitemap" data-md-icheck />
                                                    </div>
                                                    <span class="md-list-heading">Exclude user from Author-sitemap</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md-fab-wrapper">
                    <button type="submit" class="md-fab md-fab-primary" href="#" id="page_settings_submit">
                        <i class="material-icons">&#xE161;</i>
                    </button>
                </div>

            </form>

        </div>
        
        </div>
    </div>
    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
    <!--  settings functions -->
    <script src="assets/js/pages/page_settings.min.js"></script>
    
    <script>
        $(function() {
            // enable hires images
            altair_helpers.retina_images();
            // fastClick (touch devices)
            if(Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
    </script>


    <div id="style_switcher">
        <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
        <div class="uk-margin-medium-bottom">
            <h4 class="heading_c uk-margin-bottom">Colors</h4>
            <ul class="switcher_app_themes" id="theme_switcher">
                <li class="app_style_default active_theme" data-app-theme="">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_a" data-app-theme="app_theme_a">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_b" data-app-theme="app_theme_b">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_c" data-app-theme="app_theme_c">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_d" data-app-theme="app_theme_d">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_e" data-app-theme="app_theme_e">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_f" data-app-theme="app_theme_f">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_g" data-app-theme="app_theme_g">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
            </ul>
        </div>
        <div class="uk-visible-large uk-margin-medium-bottom">
            <h4 class="heading_c">Sidebar</h4>
            <p>
                <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
                <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
            </p>
        </div>
        <div class="uk-visible-large">
            <h4 class="heading_c">Layout</h4>
            <p>
                <input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck />
                <label for="style_layout_boxed" class="inline-label">Boxed layout</label>
            </p>
        </div>
    </div>

    <script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $body = $('body');


            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $body
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g')
                    .addClass(this_theme);

                if(this_theme == '') {
                    localStorage.removeItem('altair_theme');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                }

            });

            // hide style switcher
            $document.on('click keyup', function(e) {
                if( $switcher.hasClass('switcher_active') ) {
                    if (
                        ( !$(e.target).closest($switcher).length )
                        || ( e.keyCode == 27 )
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            // get theme from local storage
            if(localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
            }


        // toggle mini sidebar

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            $mini_sidebar_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });


        // toggle boxed layout

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                $boxed_layout_toggle.iCheck('check');
                $body.addClass('boxed_layout');
                $(window).resize();
            }

            // toggle mini sidebar
            $boxed_layout_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_layout", 'boxed');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_layout');
                    location.reload(true);
                });


        });
    </script>
</body>
</html>