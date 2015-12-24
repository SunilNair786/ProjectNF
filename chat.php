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

            <div class="uk-width-medium-8-10 uk-container-center">
                <div class="uk-grid uk-grid-collapse" data-uk-grid-margin>
                    <div class="uk-width-large-7-10">
                        <div class="md-card md-card-single">
                            <div class="md-card-toolbar">
                                <div class="md-card-toolbar-actions hidden-print">
                                    <div class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                        <i class="md-icon material-icons">&#xE3B7;</i>
                                        <div class="uk-dropdown">
                                            <ul class="uk-nav" id="chat_colors">
                                                <li class="uk-nav-header">Message Colors</li>
                                                <li class="uk-active"><a href="#" data-chat-color="chat_box_colors_a">Grey/Green</a></li>
                                                <li><a href="#" data-chat-color="chat_box_colors_b">Blue/Dark Blue</a></li>
                                                <li><a href="#" data-chat-color="chat_box_colors_c">Orange/Light Gray</a></li>
                                                <li><a href="#" data-chat-color="chat_box_colors_d">Deep Purple/Light Grey</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <i class="md-icon  material-icons">&#xE5CD;</i>
                                </div>
                                <h3 class="md-card-toolbar-heading-text large">
                                    <span class="uk-text-muted"> Chat with</span> <a href="#">Daryl Mayert</a>
                                </h3>
                            </div>
                            <div class="md-card-content padding-reset">
                                <div class="chat_box_wrapper">
                                    <div class="chat_box touchscroll chat_box_colors_a" id="chat">
                                        <div class="chat_message_wrapper">
                                            <div class="chat_user_avatar">
                                                <img class="md-user-image" src="assets/img/avatars/avatar_11_tn.png" alt=""/>
                                            </div>
                                            <ul class="chat_message">
                                                <li>
                                                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, eum? </p>
                                                </li>
                                                <li>
                                                    <p> Lorem ipsum dolor sit amet.<span class="chat_message_time">13:38</span> </p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="chat_message_wrapper chat_message_right">
                                            <div class="chat_user_avatar">
                                                <img class="md-user-image" src="assets/img/avatars/avatar_03_tn.png" alt=""/>
                                            </div>
                                            <ul class="chat_message">
                                                <li>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus distinctio dolor earum est hic id impedit ipsum minima mollitia natus nulla perspiciatis quae quasi, quis recusandae, saepe, sunt totam.
                                                        <span class="chat_message_time">13:34</span>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="chat_message_wrapper">
                                            <div class="chat_user_avatar">
                                                <img class="md-user-image" src="assets/img/avatars/avatar_11_tn.png" alt=""/>
                                            </div>
                                            <ul class="chat_message">
                                                <li>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque ea mollitia pariatur porro quae sed sequi sint tenetur ut veritatis.
                                                        <span class="chat_message_time">23 Jun 1:10am</span>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="chat_message_wrapper chat_message_right">
                                            <div class="chat_user_avatar">
                                                <img class="md-user-image" src="assets/img/avatars/avatar_03_tn.png" alt=""/>
                                            </div>
                                            <ul class="chat_message">
                                                <li>
                                                    <p> Lorem ipsum dolor sit amet, consectetur. </p>
                                                </li>
                                                <li>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        <span class="chat_message_time">Friday 13:34</span>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="chat_submit_box" id="chat_submit_box">
                                        <div class="uk-input-group">
                                            <input type="text" class="md-input" name="submit_message" id="submit_message" placeholder="Send message">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons md-24">&#xE163;</i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-3-10 uk-visible-large">
                        <div class="md-list-outside-wrapper">
                            <ul class="md-list md-list-addon md-list-outside" id="chat_user_list">
                                <li>
                                    <div class="md-card-dropdown md-list-action-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                        <i class="md-icon material-icons">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small">
                                            <ul class="uk-nav">
                                                <li><a href="#">Add to chat</a></li>
                                                <li><a href="#" class="uk-text-danger">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="md-list-addon-element">
                                        <span class="element-status element-status-danger"></span>
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <div class="md-list-action-placeholder"></div>
                                        <span class="md-list-heading">Abbigail Howell</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Temporibus aut iste eos enim.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-card-dropdown md-list-action-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                        <i class="md-icon material-icons">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small">
                                            <ul class="uk-nav">
                                                <li><a href="#">Add to chat</a></li>
                                                <li><a href="#" class="uk-text-danger">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="md-list-addon-element">
                                        <span class="element-status element-status-success"></span>
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <div class="md-list-action-placeholder"></div>
                                        <span class="md-list-heading">Adrain Beier</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">At non similique officiis ex tempore.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-card-dropdown md-list-action-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                        <i class="md-icon material-icons">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small">
                                            <ul class="uk-nav">
                                                <li><a href="#">Add to chat</a></li>
                                                <li><a href="#" class="uk-text-danger">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="md-list-addon-element">
                                        <span class="element-status element-status-success"></span>
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_06_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <div class="md-list-action-placeholder"></div>
                                        <span class="md-list-heading">Rafaela Swaniawski</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Nam fugiat facilis ut magni.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-card-dropdown md-list-action-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                        <i class="md-icon material-icons">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small">
                                            <ul class="uk-nav">
                                                <li><a href="#">Add to chat</a></li>
                                                <li><a href="#" class="uk-text-danger">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="md-list-addon-element">
                                        <span class="element-status element-status-danger"></span>
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_01_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <div class="md-list-action-placeholder"></div>
                                        <span class="md-list-heading">Gia Rogahn</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Incidunt distinctio facere consequatur dolorem eos.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-card-dropdown md-list-action-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                        <i class="md-icon material-icons">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small">
                                            <ul class="uk-nav">
                                                <li><a href="#">Add to chat</a></li>
                                                <li><a href="#" class="uk-text-danger">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="md-list-addon-element">
                                        <span class="element-status element-status-warning"></span>
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_08_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <div class="md-list-action-placeholder"></div>
                                        <span class="md-list-heading">Retha Friesen</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Voluptates inventore facilis asperiores explicabo.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-card-dropdown md-list-action-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                                        <i class="md-icon material-icons">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small">
                                            <ul class="uk-nav">
                                                <li><a href="#">Add to chat</a></li>
                                                <li><a href="#" class="uk-text-danger">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="md-list-addon-element">
                                        <span class="element-status element-status-success"></span>
                                        <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_04_tn.png" alt=""/>
                                    </div>
                                    <div class="md-list-content">
                                        <div class="md-list-action-placeholder"></div>
                                        <span class="md-list-heading">Ella Welch</span>
                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Nulla molestiae eos.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="sidebar_secondary">
        <div class="sidebar_secondary_wrapper uk-margin-remove"></div>
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

    <!--  chat functions -->
    <script src="assets/js/pages/page_chat.min.js"></script>
    
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