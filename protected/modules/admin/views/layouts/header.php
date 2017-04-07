<header class="header dark-bg">
    <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
    </div>

    <!--logo start-->
    <a href="<?php echo Yii::app()->request->getBaseUrl(true); ?>" class="logo">GPC <span class="lite">Admin</span></a>
    <!--logo end-->

    <div class="top-nav notification-row">                
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="profile-ava">
                        <img alt="" src="<?= Yii::app()->theme->baseUrl; ?>/img/avatar1_small.jpg">
                    </span>
                    <span class="username"><?php echo isset(Yii::app()->user->id) ? Yii::app()->user->getUsername() : null ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li>
                        <a href="<?php echo url('user/updateProfile') ?>"><i class="icon_profile"></i> Update Profile</a>
                    </li>
                    <li>
                        <a href="<?php echo url('site/logout') ?>"><i class="icon_key_alt"></i> Log Out</a>
                    </li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
    </div>
</header>      
<!--header end-->