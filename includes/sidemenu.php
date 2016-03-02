<?php 
$cUrl = basename($_SERVER['REQUEST_URI']);
?>
<aside id="sidebar_main">        
    <!--<div class="sidebar_main_header">
        <div class="sidebar_logo">
            <a href="index.php" class="sSidebar_hide"><img src="assets/img/logo_main.png" alt="" height="15" width="71"/></a>
            <a href="index.php" class="sSidebar_show"><img src="assets/img/logo_main_small.png" alt="" height="32" width="32"/></a>
        </div>
        <div class="sidebar_actions">
            <select id="lang_switcher" name="lang_switcher">
                <option value="gb" selected>English</option>
            </select>

        </div>
    </div>-->
    
    <div class="menu_section">
        <ul>
            <li title="Dashboard">
                <a href="index.php" <?php if($cUrl == "index.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE871;</i> -->
                    <i class="fa fa-dashboard fa-2x" style="color:#0f9d58;"></i>
                    </span>
                    <span class="menu_title">Dashboard</span>
                </a>
            </li>
            <li title="Inbox">
                <a href="inbox.php" <?php if($cUrl == "inbox.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-inbox fa-2x" style="color:#1976d2;"></i>
                    </span>
                    <span class="menu_title">Inbox</span>
                </a>
            </li>
            <li title="Outbox">
                <a href="outbox.php" <?php if($cUrl == "outbox.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                    <i class="fa fa-envelope-o fa-2x" style="color:#ef7919;"></i>
                    </span>
                    <span class="menu_title">Outbox</span>
                </a>
            </li>
            
            <hr style="width:86%;margin:0 0 0 16px;">
            <li title="Favourite">
                <a href="favourite.php" <?php if($cUrl == "favourite.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-star fa-2x" style="color:#9c27b0;"></i>
                    </span>
                    <span class="menu_title">Favourite</span>
                </a>
            </li>
            <li title="Groups">
                <a href="groups.php" <?php if($cUrl == "groups.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-group fa-2x" style="color:#275DB0;"></i>
                    </span>
                    <span class="menu_title">Groups</span>
                </a>
            </li>
            <li title="Tags">
                <a href="tag.php" <?php if($cUrl == "tag.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-tags fa-2x" style="color:#db4437;"></i>
                    </span>
                    <span class="menu_title">Tags</span>
                </a>
            </li>
            <?php /*<li title="Notes">
                <a href="note.php" <?php if($cUrl == "note.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-clipboard fa-2x" style="color:#3f51b5;"></i>
                    </span>
                    <span class="menu_title">Notes</span>
                </a>
            </li>
            <?php */
			 if($_SESSION['userType'] == 'AU'){
			?>
            <li title="User Management">
                <a href="usermanagement.php" <?php if($cUrl == "usermanagement.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-user-plus fa-2x"></i>
                    </span>
                    <span class="menu_title">User Management </span>
                </a>
            </li>
			 <?php } ?>
            <li title="Contact Lists">
                <a href="contact.php" <?php if($cUrl == "contact.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-users fa-2x" style="color:#ff6839;"></i>
                    </span>
                    <span class="menu_title">Contacts Lists</span>
                </a>
            </li>
            <li title="Chat">
                <a href="chat.php" <?php if($cUrl == "chat.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="fa fa-commenting-o material-icons">&#xE158;</i> -->
                    <i class="fa fa-commenting-o fa-2x" style="color:#20bfd3;"></i>
                    </span>
                    <span class="menu_title">SMS</span>
                </a>
            </li>
            <li title="Scrum Board">
                <a href="scrum.php" <?php if($cUrl == "scrum.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-bar-chart-o fa-2x" style="color:#a1887f;"></i>
                    </span>
                    <span class="menu_title">Work Flow</span>
                </a>
            </li>
            <li title="Report">
                <a href="report.php" <?php if($cUrl == "report.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-exclamation-triangle fa-2x" style="color:#0177b5;"></i>
                    </span>
                    <span class="menu_title">Report</span>
                </a>
            </li>
            <li title="Help">
                <a href="help.php" <?php if($cUrl == "help.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-exclamation fa-2x" style="color:#be6414;"></i>
                    </span>
                    <span class="menu_title">Help</span>
                </a>
            </li>
            <li title="FAQ's">
                <a href="faq.php" <?php if($cUrl == "faq.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-question fa-2x" style="color:#ec1f97;"></i>
                    </span>
                    <span class="menu_title">FAQ's</span>
                </a>
            </li>
            <li title="Settings">
                <a href="settings.php" <?php if($cUrl == "settings.php"){ ?> class="active"<?php } ?>>
                    <span class="menu_icon"><!-- <i class="material-icons">&#xE158;</i> -->
                        <i class="fa fa-cogs fa-2x" style="color:#81cb00;"></i>
                    </span>
                    <span class="menu_title">Settings</span>
                </a>
            </li>

        </ul>
    </div>
</aside>