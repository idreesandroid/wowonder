<?php
$page  = 'dashboard';

$pages = array(
    'general-settings',
    'dashboard',
    'site-settings',
    'dashboard',
    'site-features',
    'amazon-settings',
    'email-settings',
    'social-login',
    'video-settings',
    'manage-languages',
    'add-language',
    'edit-lang',
    'manage-users',
    'manage-stories',
    'manage-profile-fields',
    'add-new-profile-field',
    'edit-profile-field',
    'manage-verification-reqeusts',
    'payment-reqeuests',
    'affiliates-settings',
    'referrals-list',
    'pro-memebers',
    'pro-settings',
    'pro-payments',
    'payment-settings',
    'manage-pages',
    'manage-groups',
    'manage-posts',
    'manage-articles',
    'manage-events',
    'manage-forum-sections',
    'manage-forum-forums',
    'manage-forum-threads',
    'manage-forum-messages',
    'create-new-section',
    'create-new-forum',
    'manage-movies',
    'add-new-movies',
    'manage-games',
    'add-new-game',
    'ads-settings',
    'manage-site-ads',
    'manage-user-ads',
    'manage-themes',
    'manage-site-design',
    'manage-announcements',
    'mailing-list',
    'mass-notifications',
    'ban-users',
    'generate-sitemap',
    'manage-invitation-keys',
    'backups',
    'manage-custom-pages',
    'add-new-custom-page',
    'edit-custom-page',
    'edit-terms-pages',
    'manage-reports',
    'push-notifications-system',
    'manage-api-access-keys',
    'verfiy-applications',
    'manage-updates',
    'changelog',
    'online-users',
    'custom-code',
    'manage-third-psites',
    'edit-movie',
    'auto-delete',
    'manage-gifts',
    'add-new-gift',
    'post-settings',
    'manage-stickers',
    'add-new-sticker',
    'manage-apps',
    'auto-friend',
    'fake-users',
    'manage-genders',
    'pages-categories',
    'groups-categories',
    'blogs-categories',
    'products-categories',
    'bank-receipts',
    'manage-currencies',
    'manage-colored-posts',
    'job-categories',
    'manage-fund',
    'manage-jobs',
    'auto-like',
    'auto-join',
    'manage-reactions',
    'pages-sub-categories',
    'groups-sub-categories',
    'products-sub-categories',
    'pages-fields',
    'groups-fields',
    'products-fields',
    'pro-features',
    'pro-refund',
    'manage-offers',
    'manage-invitation',
    'send_email',
    'live',
    'node',
);
$mod_pages = array('dashboard', 'post-settings', 'manage-stickers', 'manage-gifts', 'manage-users', 'online-users', 'manage-stories', 'manage-pages', 'manage-groups', 'manage-posts', 'manage-articles', 'manage-events', 'manage-forum-threads', 'manage-forum-messages', 'manage-movies', 'manage-games', 'add-new-game', 'manage-user-ads', 'manage-reports', 'manage-third-psites', 'edit-movie','bank-receipts','job-categories','manage-jobs');


if (!empty($_GET['page'])) {
    $page = Wo_Secure($_GET['page'], 0);
}
if ($page == 'dashboard') {
   Wo_GetOfflineTyping();
   //Wo_DelexpiredEnvents();
}
$wo['decode_android_v']  = $wo['config']['footer_background'];
$wo['decode_android_value']  = base64_decode('I2FhYQ==');

$wo['decode_android_n_v']  = $wo['config']['footer_background_n'];
$wo['decode_android_n_value']  = base64_decode('I2FhYQ==');

$wo['decode_ios_v']  = $wo['config']['footer_background_2'];
$wo['decode_ios_value']  = base64_decode('I2FhYQ==');

$wo['decode_windwos_v']  = $wo['config']['footer_text_color'];
$wo['decode_windwos_value']  = base64_decode('I2RkZA==');

if ($is_moderoter == true && $is_admin == false) {
    if (!in_array($page, $mod_pages)) {
        header("Location: " . Wo_SeoLink('index.php?link1=admin-cp'));
        exit();
    }
}
if (in_array($page, $pages)) {
   $page_loaded = Wo_LoadAdminPage("$page/content");
}
if (empty($page_loaded)) {
    header("Location: " . Wo_SeoLink('index.php?link1=admin-cp'));
    exit();
}
if ($wo['config']['live_video'] == 1) {

    if ($wo['config']['live_video_save'] == 0) {
        try {
            $posts = $db->where('live_time','0','!=')->where('live_time',time() - 11,'<=')->get(T_POSTS);
            foreach ($posts as $key => $post) {
                if ($wo['config']['agora_live_video'] == 1 && !empty($wo['config']['agora_app_id']) && !empty($wo['config']['agora_customer_id']) && !empty($wo['config']['agora_customer_certificate']) && $wo['config']['live_video_save'] == 1) {
                    StopCloudRecording(array('resourceId' => $post->agora_resource_id,
                                             'sid' => $post->agora_sid,
                                             'cname' => $post->stream_name,
                                             'post_id' => $post->post_id,
                                             'uid' => explode('_', $post->stream_name)[2]));
                }
                Wo_DeletePost(Wo_Secure($post->id));
                // $db->where('post_id',$post->id)->delete(T_POSTS);
                // $db->where('parent_id',$post->id)->delete(T_POSTS);
            }
        } catch (Exception $e) {
            
        }
        
    }
    else{
        if ($wo['config']['agora_live_video'] == 1 && $wo['config']['amazone_s3_2'] != 1) {
            try {
            $posts = $db->where('live_time','0','!=')->where('live_time',time() - 11,'<=')->get(T_POSTS);
            foreach ($posts as $key => $post) {
                Wo_DeletePost(Wo_Secure($post->id));
                // $db->where('post_id',$post->id)->delete(T_POSTS);
                // $db->where('parent_id',$post->id)->delete(T_POSTS);
            }
        } catch (Exception $e) {
            
        }
        }
    }
}
$notify_count = $db->where('recipient_id',0)->where('admin',1)->where('seen',0)->getValue(T_NOTIFICATION,'COUNT(*)');
$notifications = $db->where('recipient_id',0)->where('admin',1)->where('seen',0)->orderBy('id','DESC')->get(T_NOTIFICATION);
$old_notifications = $db->where('recipient_id',0)->where('admin',1)->where('seen',0,'!=')->orderBy('id','DESC')->get(T_NOTIFICATION,5);
$mode = 'day';
if (!empty($_COOKIE['mode']) && $_COOKIE['mode'] == 'night') {
    $mode = 'night';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel | <?php echo $wo['config']['siteTitle']; ?></title>
    <link rel="icon" href="<?php echo $wo['config']['theme_url']; ?>/img/icon.png" type="image/png">


    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo(Wo_LoadAdminLink('vendors/bundle.css')) ?>" type="text/css">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Daterangepicker -->
    <link rel="stylesheet" href="<?php echo(Wo_LoadAdminLink('vendors/datepicker/daterangepicker.css')) ?>" type="text/css">

    <!-- DataTable -->
    <link rel="stylesheet" href="<?php echo(Wo_LoadAdminLink('vendors/dataTable/datatables.min.css')) ?>" type="text/css">

<!-- App css -->
    <link rel="stylesheet" href="<?php echo(Wo_LoadAdminLink('assets/css/app.css')) ?>" type="text/css">
    <!-- Main scripts -->
<script src="<?php echo(Wo_LoadAdminLink('vendors/bundle.js')) ?>"></script>

    <!-- Apex chart -->
    <script src="<?php echo(Wo_LoadAdminLink('vendors/charts/apex/apexcharts.min.js')) ?>"></script>

    <!-- Daterangepicker -->
    <script src="<?php echo(Wo_LoadAdminLink('vendors/datepicker/daterangepicker.js')) ?>"></script>

    <!-- DataTable -->
    <script src="<?php echo(Wo_LoadAdminLink('vendors/dataTable/datatables.min.js')) ?>"></script>

    <!-- Dashboard scripts -->
    <script src="<?php echo(Wo_LoadAdminLink('assets/js/examples/pages/dashboard.js')) ?>"></script>
    <script src="<?php echo Wo_LoadAdminLink('vendors/charts/chartjs/chart.min.js'); ?>"></script>

<!-- App scripts -->

<script type="text/javascript" src="<?php echo $pt->config->theme_url; ?>/js/jquery.form.min.js"></script>
<link href="<?php echo Wo_LoadAdminLink('vendors/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />
<script src="<?php echo Wo_LoadAdminLink('assets/js/admin.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo(Wo_LoadAdminLink('vendors/select2/css/select2.min.css')) ?>" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<?php if ($page == 'create-article' || $page == 'edit-article' || $page == 'manage-announcements' || $page == 'newsletters') { ?>
<script src="<?php echo Wo_LoadAdminLink('vendors/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?php echo Wo_LoadAdminLink('vendors/bootstrap-tagsinput/src/bootstrap-tagsinput.js'); ?>"></script>
<link href="<?php echo Wo_LoadAdminLink('vendors/bootstrap-tagsinput/src/bootstrap-tagsinput.css'); ?>" rel="stylesheet" />
<?php } ?>
<?php if ($page == 'custom-code') { ?>
<script src="<?php echo Wo_LoadAdminLink('vendors/codemirror-5.30.0/lib/codemirror.js'); ?>"></script>
<script src="<?php echo Wo_LoadAdminLink('vendors/codemirror-5.30.0/mode/css/css.js'); ?>"></script>
<script src="<?php echo Wo_LoadAdminLink('vendors/codemirror-5.30.0/mode/javascript/javascript.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo Wo_LoadAdminLink('vendors/codemirror-5.30.0/lib/codemirror.css'); ?>">
<?php } ?>


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if ($page == 'bank-receipts' || $page == 'manage-verification-reqeusts' || $page == 'monetization-requests' || $page == 'manage-user-ads') { ?>
        <!-- Css -->
        <link rel="stylesheet" href="<?php echo(Wo_LoadAdminLink('vendors/lightbox/magnific-popup.css')) ?>" type="text/css">

        <!-- Javascript -->
        <script src="<?php echo(Wo_LoadAdminLink('vendors/lightbox/jquery.magnific-popup.min.js')) ?>"></script>
        <script src="<?php echo(Wo_LoadAdminLink('vendors/charts/justgage/raphael-2.1.4.min.js')) ?>"></script>
        <script src="<?php echo(Wo_LoadAdminLink('vendors/charts/justgage/justgage.js')) ?>"></script>
    <?php } ?>
    <script src="<?php echo Wo_LoadAdminLink('assets/js/jquery.form.min.js'); ?>"></script>
    <script>
        function Wo_Ajax_Requests_File(){
            return "<?php echo $wo['config']['site_url'].'/requests.php';?>"
        }
    </script>
    <style>
        body {background-color: <?php echo $wo['config']['btn_background_color'];?>;}
        .btn.btn-primary, a.btn[href="#next"], a.btn[href="#previous"] {color: <?php echo $wo['config']['btn_color'];?> !important;background: <?php echo $wo['config']['btn_background_color'];?>;border-color: <?php echo $wo['config']['btn_background_color'];?>;}
        .btn.btn-primary:not(:disabled):not(.disabled):hover, a.btn[href="#next"]:not(:disabled):not(.disabled):hover, a.btn[href="#previous"]:not(:disabled):not(.disabled):hover, .btn.btn-primary:not(:disabled):not(.disabled):focus, a.btn[href="#next"]:not(:disabled):not(.disabled):focus, a.btn[href="#previous"]:not(:disabled):not(.disabled):focus, .btn.btn-primary:not(:disabled):not(.disabled):active, a.btn[href="#next"]:not(:disabled):not(.disabled):active, a.btn[href="#previous"]:not(:disabled):not(.disabled):active, .btn.btn-primary:not(:disabled):not(.disabled).active, a.btn[href="#next"]:not(:disabled):not(.disabled).active, a.btn[href="#previous"]:not(:disabled):not(.disabled).active {background: <?php echo $wo['config']['btn_hover_background_color'];?>;border-color: <?php echo $wo['config']['btn_hover_background_color'];?>;}
        body.dark .navigation .navigation-menu-body ul li a.active, .breadcrumb .breadcrumb-item.active, body.dark .breadcrumb li.breadcrumb-item.active, body.dark .navigation .navigation-menu-body ul li a.active .nav-link-icon {color: <?php echo $wo['config']['btn_background_color'];?> !important;}
        .card form .form-check-inline input:checked {background-color: <?php echo $wo['config']['btn_background_color'];?>;}
        .card form .form-check-inline input:checked + label::before, .card form .form-check-inline input:active + label::before {border-color: <?php echo $wo['config']['btn_background_color'];?>;}
        .card form .form-check-inline label::after {background-color: <?php echo $wo['config']['btn_background_color'];?>;}
        .select2-container--default.select2-container--focus .select2-selection--multiple {border: 2px solid <?php echo $wo['config']['btn_background_color'];?> !important;}
    </style>
</head>
<body <?php echo ($mode == 'night' ? 'class="dark"' : ''); ?>>
    <input type="hidden" class="main_session" value="<?php echo Wo_CreateMainSession();?>">
    <div class="colors"> <!-- To use theme colors with Javascript -->
        <div class="bg-primary"></div>
        <div class="bg-primary-bright"></div>
        <div class="bg-secondary"></div>
        <div class="bg-secondary-bright"></div>
        <div class="bg-info"></div>
        <div class="bg-info-bright"></div>
        <div class="bg-success"></div>
        <div class="bg-success-bright"></div>
        <div class="bg-danger"></div>
        <div class="bg-danger-bright"></div>
        <div class="bg-warning"></div>
        <div class="bg-warning-bright"></div>
    </div>
<!-- Preloader -->
<div class="preloader">
    <div class="preloader-icon"></div>
    <span>Loading...</span>
</div>
<!-- ./ Preloader -->

<!-- Sidebar group -->
<div class="sidebar-group">

</div>
<!-- ./ Sidebar group -->

<!-- Layout wrapper -->
<div class="layout-wrapper">

    <!-- Header -->
    <div class="header d-print-none">
        <div class="header-container">
            <div class="header-left">
                <div class="navigation-toggler">
                    <a href="#" data-action="navigation-toggler">
                        <i data-feather="menu"></i>
                    </a>
                </div>

                <div class="header-logo">
                    <a href="<?php echo $wo['config']['site_url'] ?>">
                        <img class="logo" src="<?php echo $wo['config']['theme_url'];?>/img/logo.<?php echo $wo['config']['logo_extension'];?>" alt="logo">
                    </a>
                </div>
            </div>

            <div class="header-body">
                <div class="header-body-left">
                    <ul class="navbar-nav">
                        <li class="nav-item mr-3">
                            <div class="header-search-form">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn">
                                            <i data-feather="search"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search"  onkeyup="searchInFiles($(this).val())">
                                    <div class="pt_admin_hdr_srch_reslts" id="search_for_bar"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="header-body-right">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link <?php if ($notify_count > 0) { ?> nav-link-notify<?php } ?>" title="Notifications" data-toggle="dropdown">
                                <i data-feather="bell"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                                <div
                                    class="border-bottom px-4 py-3 text-center d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Notifications</h5>
                                    <?php if ($notify_count > 0) { ?>
                                    <small class="opacity-7"><?php echo $notify_count; ?>   unread notifications</small>
                                    <?php } ?>
                                </div>
                                <div class="dropdown-scroll">
                                    <ul class="list-group list-group-flush">
                                        <?php if ($notify_count > 0) { ?>
                                            <li class="px-4 py-2 text-center small text-muted bg-light">Unread Notifications</li>
                                            <?php if (!empty($notifications)) { 
                                                    foreach ($notifications as $key => $notify) {
                                                        $page_ = '';
                                                        $text = '';
                                                        if ($notify->type == 'bank') {
                                                            $page_ = 'bank-receipts';
                                                            $text = 'You have a new bank payment awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'verify') {
                                                            $page_ = 'manage-verification-reqeusts';
                                                            $text = 'You have a new verification requests awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'refund') {
                                                            $page_ = 'pro-refund';
                                                            $text = 'You have a new refund requests awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'with') {
                                                            $page_ = 'payment-reqeuests';
                                                            $text = 'You have a new withdrawal requests awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'report') {
                                                            $page_ = 'manage-reports';
                                                            $text = 'You have a new reports awaiting your approval';
                                                        }
                                                ?>
                                            <li class="px-4 py-3 list-group-item">
                                                <a href="<?php echo Wo_LoadAdminLinkSettings($page_); ?>" class="d-flex align-items-center hide-show-toggler">
                                                    <div class="flex-shrink-0">
                                                        <figure class="avatar mr-3">
                                                            <span
                                                                class="avatar-title bg-info-bright text-info rounded-circle">
                                                                <?php if ($notify->type == 'bank') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                                                <?php }elseif ($notify->type == 'verify') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#2196f3" d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"></path></svg>
                                                                <?php }elseif ($notify->type == 'refund') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                                                <?php }elseif ($notify->type == 'with') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                                                <?php }elseif ($notify->type == 'report') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-flag"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                                                                <?php } ?>
                                                                
                                                            </span>
                                                        </figure>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0 line-height-20 d-flex justify-content-between">
                                                            <?php echo $text; ?>
                                                        </p>
                                                        <span class="text-muted small"><?php echo Wo_Time_Elapsed_String($notify->time); ?></span>
                                                    </div>
                                                </a>
                                            </li>
                                            <?php } } ?>
                                        <?php } ?>
                                        <?php if ($notify_count == 0 && !empty($old_notifications)) { ?>
                                            <li class="px-4 py-2 text-center small text-muted bg-light">Old Notifications</li>
                                            <?php
                                                    foreach ($old_notifications as $key => $notify) {
                                                        $page_ = '';
                                                        $text = '';
                                                        if ($notify->type == 'bank') {
                                                            $page_ = 'bank-receipts';
                                                            $text = 'You have a new bank payment awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'verify') {
                                                            $page_ = 'verification-requests';
                                                            $text = 'You have a new verification requests awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'refund') {
                                                            $page_ = 'pro-refund';
                                                            $text = 'You have a new refund requests awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'with') {
                                                            $page_ = 'payment-requests';
                                                            $text = 'You have a new withdrawal requests awaiting your approval';
                                                        }
                                                        elseif ($notify->type == 'report') {
                                                            $page_ = 'manage-reports';
                                                            $text = 'You have a new reports awaiting your approval';
                                                        }
                                                ?>
                                            <li class="px-4 py-3 list-group-item">
                                                <a href="<?php echo Wo_LoadAdminLinkSettings($page_); ?>" class="d-flex align-items-center hide-show-toggler">
                                                    <div class="flex-shrink-0">
                                                        <figure class="avatar mr-3">
                                                            <span class="avatar-title bg-secondary-bright text-secondary rounded-circle">
                                                                <?php if ($notify->type == 'bank') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                                                <?php }elseif ($notify->type == 'verify') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#2196f3" d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"></path></svg>
                                                                <?php }elseif ($notify->type == 'refund') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                                                <?php }elseif ($notify->type == 'with') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                                                <?php }elseif ($notify->type == 'report') { ?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-flag"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                                                                <?php } ?>
                                                            </span>
                                                        </figure>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0 line-height-20 d-flex justify-content-between">
                                                            <?php echo $text; ?>
                                                        </p>
                                                        <span class="text-muted small"><?php echo Wo_Time_Elapsed_String($notify->time); ?></span>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } } ?>
                                    </ul>
                                </div>
                                <?php if ($notify_count > 0) { ?>
                                <div class="px-4 py-3 text-right border-top">
                                    <ul class="list-inline small">
                                        <li class="list-inline-item mb-0">
                                            <a href="javascript:void(0)" onclick="ReadNotify()">Mark All Read</a>
                                        </li>
                                    </ul>
                                </div>
                                <?php } ?>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" title="User menu" data-toggle="dropdown">
                                <figure class="avatar avatar-sm">
                                    <img src="<?php echo $wo['user']['avatar']; ?>"
                                         class="rounded-circle"
                                         alt="avatar">
                                </figure>
                                <span class="ml-2 d-sm-inline d-none"><?php echo $wo['user']['name']; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                                <div class="text-center py-4">
                                    <figure class="avatar avatar-lg mb-3 border-0">
                                        <img src="<?php echo $wo['user']['avatar']; ?>"
                                             class="rounded-circle" alt="image">
                                    </figure>
                                    <h5 class="text-center"><?php echo $wo['user']['name']; ?></h5>
                                    <div class="mb-3 small text-center text-muted"><?php echo $wo['user']['email']; ?></div>
                                    <a href="<?php echo $wo['user']['url']; ?>" class="btn btn-outline-light btn-rounded">View Profile</a>
                                </div>
                                <div class="list-group">
                                    <a href="<?php echo(Wo_Link('logout')) ?>" class="list-group-item text-danger">Sign Out!</a>
                                    <?php if ($mode == 'night') { ?>
                                        <a href="javascript:void(0)" class="list-group-item admin_mode" onclick="ChangeMode('day')">
                                            <span id="night-mode-text">Day mode</span>
                                            <svg class="feather feather-moon float-right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="javascript:void(0)" class="list-group-item admin_mode" onclick="ChangeMode('night')">
                                            <span id="night-mode-text">Night mode</span>
                                            <svg class="feather feather-moon float-right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                                        </a>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item header-toggler">
                    <a href="#" class="nav-link">
                        <i data-feather="arrow-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- ./ Header -->

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- begin::navigation -->
        <div class="navigation">
            <div class="navigation-header">
                <span>Navigation</span>
                <a href="#">
                    <i class="ti-close"></i>
                </a>
            </div>
            <div class="navigation-menu-body">
                <ul>
                    <li>
                        <a <?php echo ($page == 'dashboard') ? 'class="active"' : ''; ?>  href="<?php echo Wo_LoadAdminLinkSettings(''); ?>">
                            <span class="nav-link-icon">
                                <i class="material-icons">dashboard</i>
                            </span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php if ($is_admin == true) { ?>
                    <li <?php echo ($page == 'general-settings' || $page == 'post-settings' || $page == 'site-settings' || $page == 'email-settings' || $page == 'social-login' || $page == 'site-features' || $page == 'amazon-settings' ||  $page == 'video-settings' || $page == 'payment-settings' || $page == 'manage-currencies' || $page == 'manage-colored-posts' || $page == 'live' || $page == 'node' || $page == 'manage-reactions') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">settings</i>
                            </span>
                            <span>Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'general-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('general-settings'); ?>">General Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'site-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('site-settings'); ?>">Site Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'site-features') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('site-features'); ?>">Manage Site Features</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'email-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('email-settings'); ?>">E-mail & SMS Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'video-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('video-settings'); ?>">Video & Audio Chat Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'social-login') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('social-login'); ?>">Social Login Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'payment-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('payment-settings'); ?>">Payment System Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-currencies') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-currencies'); ?>">Manage Currencies</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'amazon-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('amazon-settings'); ?>">Storage Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'live') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('live'); ?>">Live Stream Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'node') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('node'); ?>">NodeJs</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'post-settings' || $page == 'manage-colored-posts' || $page == 'manage-reactions') ? 'class="open"' : ''; ?> href="javascript:void(0);">Posts</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'post-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('post-settings'); ?>">
                                            <span>Post Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'manage-colored-posts') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-colored-posts'); ?>">
                                            <span>Manage Colored Posts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'manage-reactions') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-reactions'); ?>">
                                            <span>Post Reactions</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-languages' || $page == 'add-language' || $page == 'edit-lang') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">language</i>
                            </span>
                            <span>Languages</span>
                        </a>
                        <ul <?php echo ($page == 'manage-languages' || $page == 'add-language' || $page == 'edit-lang') ? 'style="display: block;"' : ''; ?>>
                            <li>
                                <a <?php echo ($page == 'add-language') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('add-language'); ?>">Add New Language & Keys</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-languages' || $page == 'edit-lang') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-languages'); ?>">Manage Languages</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li  <?php echo ($page == 'manage-users' || $page == 'manage-stories' || $page == 'manage-profile-fields' || $page == 'add-new-profile-field' || $page == 'edit-profile-field' || $page == 'manage-verification-reqeusts' || $page == 'affiliates-settings' || $page == 'payment-reqeuests' || $page == 'referrals-list' || $page == 'online-users' || $page == 'manage-genders') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">account_circle</i>
                            </span>
                            <span>Users</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-users') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-users'); ?>">Manage Users</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'online-users') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('online-users'); ?>">Online Users</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-stories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-stories'); ?>">Manage User Stories / Status</a>
                            </li>
                            <?php if ($is_admin == true) { ?>
                            <li>
                                <a <?php echo ($page == 'manage-profile-fields') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-profile-fields'); ?>">Manage Custom Profile Fields</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true) { ?>
                            <li>
                                <a <?php echo ($page == 'manage-verification-reqeusts') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-verification-reqeusts'); ?>">Manage Verification Requests</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true) { ?>
                            <li>
                                <a <?php echo ($page == 'affiliates-settings' || $page == 'payment-reqeuests' || $page == 'referrals-list') ? 'class="active"' : ''; ?> href="javascript:void(0);">Affiliates System</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'affiliates-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('affiliates-settings'); ?>">
                                            <span>Affiliates Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'payment-reqeuests') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('payment-reqeuests'); ?>">
                                            <span>Payment Requests</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true) { ?>
                            <li>
                                <a <?php echo ($page == 'manage-genders') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-genders'); ?>">Manage genders</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php if ($is_admin == true) { ?>
                        <li <?php echo ($page == 'pro-settings' || $page == 'pro-memebers' || $page == 'pro-payments' || $page == 'pro-features' || $page == 'pro-refund') ? 'class="open"' : ''; ?>>
                            <a href="#">
                                <span class="nav-link-icon">
                                    <i class="material-icons">stars</i>
                                </span>
                                <span>Pro System</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a <?php echo ($page == 'pro-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pro-settings'); ?>">Pro System Settings</a>
                                </li>
                                <li>
                                    <a <?php echo ($page == 'pro-features') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pro-features'); ?>">Pro Features</a>
                                </li>
                                <li>
                                    <a <?php echo ($page == 'pro-payments') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pro-payments'); ?>">Manage Payments</a>
                                </li>
                                <li>
                                    <a <?php echo ($page == 'pro-memebers') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pro-memebers'); ?>">Manage Pro Members</a>
                                </li>
                                <li>
                                    <a <?php echo ($page == 'pro-refund') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pro-refund'); ?>">Manage Pro Refund</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li <?php echo ($page == 'manage-apps' || $page == 'manage-pages' || $page == 'manage-stickers' || $page == 'add-new-sticker' || $page == 'manage-gifts' || $page == 'add-new-gift' || $page == 'manage-groups' || $page == 'manage-posts' || $page == 'manage-articles' || $page == 'manage-events'||  $page == 'manage-forum-sections' || $page == 'manage-forum-forums' || $page == 'manage-forum-threads' || $page == 'manage-forum-messages' || $page == 'create-new-forum' || $page == 'create-new-section' || $page == 'manage-movies' || $page == 'add-new-movies' || $page == 'manage-games' || $page == 'add-new-game' || $page == 'edit-movie' || $page == 'pages-categories' || $page == 'pages-sub-categories' || $page == 'groups-sub-categories' || $page == 'products-sub-categories' || $page == 'groups-categories' || $page == 'blogs-categories' || $page == 'products-categories' || $page == 'manage-fund' || $page == 'manage-jobs' || $page == 'manage-offers' || $page == 'pages-fields' || $page == 'groups-fields' || $page == 'products-fields') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">view_agenda</i>
                            </span>
                            <span>Manage Features</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-apps') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-apps'); ?>">Apps</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-pages') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-pages'); ?>">Pages</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-groups') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-groups'); ?>">Groups</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-posts') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-posts'); ?>">Posts</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-fund') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-fund'); ?>">Fundings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-jobs') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-jobs'); ?>">Jobs</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-offers') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-offers'); ?>">Offers</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-articles') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-articles'); ?>">Articles (Blog)</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-events') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-events'); ?>">Events</a>
                            </li>
                            <li <?php echo ($page == 'manage-forum-sections' || $page == 'manage-forum-forums' || $page == 'manage-forum-threads' || $page == 'manage-forum-messages' || $page == 'create-new-forum' || $page == 'create-new-section') ? 'class="open"' : ''; ?>>
                                <a href="javascript:void(0);">Forums</a>
                                <ul class="ml-menu">
                                    <?php if ($is_admin == true) { ?>
                                    <li>
                                        <a <?php echo ($page == 'manage-forum-sections') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-forum-sections'); ?>">
                                            <span>Manage Forums Sections</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($is_admin == true) { ?>
                                    <li>
                                        <a <?php echo ($page == 'manage-forum-forums') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-forum-forums'); ?>">
                                            <span>Manage Forums</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <a <?php echo ($page == 'manage-forum-threads') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-forum-threads'); ?>">
                                            <span>Manage Threads</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'manage-forum-messages') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-forum-messages'); ?>">
                                            <span>Manage Replies</span>
                                        </a>
                                    </li>
                                    <?php if ($is_admin == true) { ?>
                                    <li>
                                        <a <?php echo ($page == 'create-new-section') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('create-new-section'); ?>">
                                            <span>Create New Section</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($is_admin == true) { ?>
                                    <li>
                                        <a <?php echo ($page == 'create-new-forum') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('create-new-forum'); ?>">
                                            <span>Create New Forum</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li <?php echo ($page == 'manage-movies' || $page == 'add-new-movies') ? 'class="open"' : ''; ?>>
                                <a href="javascript:void(0);">Movies</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'manage-movies') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-movies'); ?>">
                                            <span>Manage Movies</span>
                                        </a>
                                    </li>
                                    <?php if ($is_admin == true) { ?>
                                    <li>
                                        <a <?php echo ($page == 'add-new-movies') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('add-new-movies'); ?>">
                                            <span>Add New Movie</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>

                            <li <?php echo ($page == 'manage-games' || $page == 'add-new-game') ? 'class="open"' : ''; ?>>
                                <a href="javascript:void(0);">Games</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'manage-games') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-games'); ?>">
                                            <span>Manage Games</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'add-new-game') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('add-new-game'); ?>">
                                            <span>Add New Game</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li <?php echo ($page == 'pages-categories' || $page == 'pages-sub-categories' || $page == 'groups-sub-categories' || $page == 'products-sub-categories' || $page == 'groups-categories' || $page == 'blogs-categories' || $page == 'products-categories') ? 'class="open"' : ''; ?>>
                                <a href="javascript:void(0);">Categories</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'pages-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pages-categories'); ?>">
                                            <span>Pages Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'pages-sub-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pages-sub-categories'); ?>">
                                            <span>Pages Sub Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'groups-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('groups-categories'); ?>">
                                            <span>Groups Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'groups-sub-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('groups-sub-categories'); ?>">
                                            <span>Groups Sub Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'blogs-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('blogs-categories'); ?>">
                                            <span>Blogs Categories</span>
                                        </a>
                                    </li> 
                                    <li>
                                        <a <?php echo ($page == 'products-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('products-categories'); ?>">
                                            <span>Products Categories</span>
                                        </a>
                                    </li> 
                                    <li>
                                        <a <?php echo ($page == 'products-sub-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('products-sub-categories'); ?>">
                                            <span>Products Sub Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'job-categories') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('job-categories'); ?>">
                                            <span>Job Categories</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li <?php echo ($page == 'pages-fields' || $page == 'groups-fields' || $page == 'products-fields') ? 'class="open"' : ''; ?>>
                                <a href="javascript:void(0);">Custom Fields</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'pages-fields') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('pages-fields'); ?>">
                                            <span>Pages Fields</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'groups-fields') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('groups-fields'); ?>">
                                            <span>Groups Fields</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'products-fields') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('products-fields'); ?>">
                                            <span>Products Fields</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <?php if ($wo['config']['gift_system'] == 1){?>
                            <li <?php echo ($page == 'manage-gifts' || $page == 'add-new-gift') ? 'class="open"' : ''; ?>>
                                <a href="javascript:void(0);">Gifts</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'manage-gifts') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-gifts'); ?>">
                                            <span>Manage Gifts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'add-new-gift') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('add-new-gift'); ?>">
                                            <span>Add New Gift</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($wo['config']['stickers_system'] == 1){?>
                            <li <?php echo ($page == 'manage-stickers' || $page == 'add-new-sticker') ? 'class="open"' : ''; ?>>
                                <a href="javascript:void(0);">Chat Stickers</a>
                                <ul class="ml-menu">
                                    <li>
                                        <a <?php echo ($page == 'manage-stickers') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-stickers'); ?>">
                                            <span>Manage Stickers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a <?php echo ($page == 'add-new-sticker') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('add-new-sticker'); ?>">
                                            <span>Add New sticker</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li>
                        <a <?php echo ($page == 'bank-receipts') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('bank-receipts'); ?>">
                            <span class="nav-link-icon">
                                <i class="material-icons">credit_card</i>
                            </span>
                            <span>Manage Bank Receipts</span>
                        </a>
                    </li>
                    <li <?php echo ($page == 'ads-settings' || $page == 'manage-site-ads' || $page == 'manage-user-ads') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">attach_money</i>
                            </span>
                            <span>Advertisement</span>
                        </a>
                        <ul class="ml-menu">
                            <?php if ($is_admin == true) { ?>
                            <li>
                                <a <?php echo ($page == 'ads-settings') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('ads-settings'); ?>">Advertisement System Settings</a>
                            </li>
                            <?php } ?>
                            <?php if ($is_admin == true) { ?>
                            <li>
                                <a <?php echo ($page == 'manage-site-ads') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-site-ads'); ?>">Manage Site Advertisements</a>
                            </li>
                            <?php } ?>
                            <li>
                                <a <?php echo ($page == 'manage-user-ads') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-user-ads'); ?>">Manage User Advertisements</a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($is_admin == true) { ?>
                    <li <?php echo ($page == 'manage-themes' || $page == 'manage-site-design' || $page == 'custom-code') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">color_lens</i>
                            </span>
                            <span>Design</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-themes') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-themes'); ?>">Themes</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-site-design') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-site-design'); ?>">Change Site Design</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'custom-code') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('custom-code'); ?>">Custom JS / CSS</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true) { ?>
                    <li <?php echo ($page == 'manage-announcements' || $page == 'mailing-list' || $page == 'mass-notifications' || $page == 'ban-users' || $page == 'generate-sitemap' || $page == 'manage-invitation-keys' || $page == 'backups' || $page == 'auto-delete' || $page == 'auto-friend' || $page == 'fake-users' || $page == 'auto-like' || $page == 'auto-join' || $page == 'send_email' || $page == 'manage-invitation') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">build</i>
                            </span>
                            <span>Tools</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-invitation') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-invitation'); ?>">Users Invitation</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'send_email') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('send_email'); ?>">Send E-mail</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-announcements') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-announcements'); ?>">Announcements</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'auto-delete') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('auto-delete'); ?>">Auto Delete Data</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'auto-friend') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('auto-friend'); ?>">Auto Friend</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'auto-like') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('auto-like'); ?>">Auto Page Like</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'auto-join') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('auto-join'); ?>">Auto Group Join</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'fake-users') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('fake-users'); ?>">Fake User Generator</a>
                            </li>
                            
                            <li>
                                <a <?php echo ($page == 'mailing-list') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('mailing-list'); ?>">Maling List</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'mass-notifications') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('mass-notifications'); ?>">Mass Notifications</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'ban-users') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('ban-users'); ?>">BlackList</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'generate-sitemap') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('generate-sitemap'); ?>">Generate SiteMap</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-invitation-keys') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-invitation-keys'); ?>">Invitation Codes</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'backups') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('backups'); ?>">Backup SQL & Files</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true) { ?>
                    <li <?php echo ($page == 'edit-terms-pages' || $page == 'manage-custom-pages' || $page == 'add-new-custom-page' || $page == 'edit-custom-page') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">description</i>
                            </span>
                            <span>Pages</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-custom-pages') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-custom-pages'); ?>">Manage Custom Pages</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'edit-terms-pages') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('edit-terms-pages'); ?>">Edit Terms Pages</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                     <li <?php echo ($page == 'manage-reports') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">warning</i>
                            </span>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-reports') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-reports'); ?>">Manage Reports</a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($is_admin == true) { ?>
                    <li <?php echo ($page == 'verfiy-applications' || $page == 'push-notifications-system' || $page == 'manage-api-access-keys' || $page == 'manage-third-psites') ? 'class="open"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">compare_arrows</i>
                            </span>
                            <span>API Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-api-access-keys') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-api-access-keys'); ?>">Manage API Server Key</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'push-notifications-system') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('push-notifications-system'); ?>">Push Notifications Settings</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'verfiy-applications') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('verfiy-applications'); ?>">Verify Applications</a>
                            </li>
                            <li>
                                <a <?php echo ($page == 'manage-third-psites') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-third-psites'); ?>">3rd Party Scripts</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true) { ?>
                    <li <?php echo ($page == 'manage-updates') ? 'class="active"' : ''; ?>>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i class="material-icons">cloud_download</i>
                            </span>
                            <span>Updates</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a <?php echo ($page == 'manage-updates') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('manage-updates'); ?>">Updates & Bug Fixes</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true) { ?>
                    <li>
                        <a <?php echo ($page == 'changelog') ? 'class="active"' : ''; ?> href="<?php echo Wo_LoadAdminLinkSettings('changelog'); ?>">
                            <span class="nav-link-icon">
                                <i class="material-icons">update</i>
                            </span>
                            <span>Changelogs</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($is_admin == true) { ?>
                    <li>
                        <a href="http://docs.wowonder.com/#faq" target="_blank">
                            <span class="nav-link-icon">
                                <i class="material-icons">more_vert</i>
                            </span>
                            <span>FAQs</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- end::navigation -->

        <!-- Content body -->
        <div class="content-body">
            <!-- Content -->
            <div class="content ">
                <?php echo $page_loaded; ?>
            </div>
            <!-- ./ Content -->

        </div>
        <!-- ./ Content body -->
    </div>
    <!-- ./ Content wrapper -->
</div>
<!-- ./ Layout wrapper -->

<script src="<?php echo Wo_LoadAdminLink('vendors/sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?php echo(Wo_LoadAdminLink('vendors/select2/js/select2.min.js')) ?>"></script>
    <script src="<?php echo(Wo_LoadAdminLink('assets/js/examples/select2.js')) ?>"></script>
    <script src="<?php echo(Wo_LoadAdminLink('assets/js/app.min.js')) ?>"></script>
    <script type="text/javascript">
        function ChangeMode(mode) {
            if (mode == 'day') {
                $('body').removeClass('dark');
                $('.admin_mode').html('<span id="night-mode-text">Night mode</span><svg class="feather feather-moon float-right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>');
                $('.admin_mode').attr('onclick', "ChangeMode('night')");
            }
            else{
                $('body').addClass('dark');
                $('.admin_mode').html('<span id="night-mode-text">Day mode</span><svg class="feather feather-moon float-right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>');
                $('.admin_mode').attr('onclick', "ChangeMode('day')");
            }
            hash_id = $('#hash_id').val();
            $.get(Wo_Ajax_Requests_File(),{f:'admin_setting', s:'change_mode', hash_id: hash_id}, function(data) {});
        }
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
            var hash = $('.main_session').val();
              $.ajaxSetup({ 
                data: {
                    hash: hash
                },
                cache: false 
              });
        });
        $('body').on('click', function (e) {
            $('.dropdown-animating').removeClass('show');
            $('.dropdown-menu').removeClass('show');
        });
        function searchInFiles(keyword) {
            if (keyword.length > 2) {
                $.post(Wo_Ajax_Requests_File() + '?f=admin_setting&s=search_in_pages', {keyword: keyword}, function(data, textStatus, xhr) {
                    if (data.html != '') {
                        $('#search_for_bar').html(data.html)
                    }
                    else{
                        $('#search_for_bar').html('')
                    }
                });
            }
            else{
                $('#search_for_bar').html('')
            }
        }
        jQuery(document).ready(function($) {
            jQuery.fn.highlight = function (str, className) {
                if (str != '') {
                    var aTags = document.getElementsByTagName("h2");
                    var bTags = document.getElementsByTagName("label");
                    var cTags = document.getElementsByTagName("h3");
                    var dTags = document.getElementsByTagName("h6");
                    var searchText = str.toLowerCase();

                    if (aTags.length > 0) {
                        for (var i = 0; i < aTags.length; i++) {
                            var tag_text = aTags[i].textContent.toLowerCase();
                            if (tag_text.indexOf(searchText) != -1) {
                                $(aTags[i]).addClass(className)
                            }
                        }
                    }

                    if (bTags.length > 0) {
                        for (var i = 0; i < bTags.length; i++) {
                            var tag_text = bTags[i].textContent.toLowerCase();
                            if (tag_text.indexOf(searchText) != -1) {
                                $(bTags[i]).addClass(className)
                            }
                        }
                    }

                    if (cTags.length > 0) {
                        for (var i = 0; i < cTags.length; i++) {
                            var tag_text = cTags[i].textContent.toLowerCase();
                            if (tag_text.indexOf(searchText) != -1) {
                                $(cTags[i]).addClass(className)
                            }
                        }
                    }

                    if (dTags.length > 0) {
                        for (var i = 0; i < dTags.length; i++) {
                            var tag_text = dTags[i].textContent.toLowerCase();
                            if (tag_text.indexOf(searchText) != -1) {
                                $(dTags[i]).addClass(className)
                            }
                        }
                    }
                }
            };
            jQuery.fn.highlight("<?php echo (!empty($_GET['highlight']) ? $_GET['highlight'] : '') ?>",'highlight_text');
        });
        $(document).on('click', '#search_for_bar a', function(event) {
            event.preventDefault();
            location.href = $(this).attr('href');
        });
        function ReadNotify() {
            hash_id = $('#hash_id').val();
            $.get(Wo_Ajax_Requests_File(),{f:'admin_setting', s:'ReadNotify', hash_id: hash_id});
            location.reload();
        }
    </script>

</body>
</html>
