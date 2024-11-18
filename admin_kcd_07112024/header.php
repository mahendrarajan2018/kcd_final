<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="sm" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8">
    <title><?php if(!empty($page_title)) { echo $page_title; } ?> | <?php if(!empty($project_title)) { echo $project_title; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="js/fonticons.js"></script>
    <script src="js/layout.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="include/select2/css/select2.min.css">
    <link rel="stylesheet" href="include/select2/css/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="include/css/modify.css">
    <link rel="stylesheet" href="css/app.min.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/style.css">

    <link href="include/select2/css/select2.min.css" rel="stylesheet" />
    <link href="include/select2/css/select2-bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="include/css/modify.css">
    <script type="text/javascript" src="include/js/common.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
</head>
<body>
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="images/logo-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="images/logo-dark.png" alt="" height="70">
                            </span>
                        </a>
                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="images/logo-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="images/logo-light.png" alt="" height="70">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <div class="h6 align-self-center mb-0"> <?php if(!empty($page_title )) { echo $page_title ; } ?> </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                        <div class="d-flex align-items-center">
                            <div class="px-2">Bill Year : </div>
                            <div>
                                <select name="billing_year" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:ChangeBillingYear(this.value);">
                                    <option value="">Select</option>
                                    <?php
                                        if(!empty($year_list)) {
                                            foreach($year_list as $year) {
                                                if(!empty($year)) {
                                    ?>
                                                    <option value="<?php echo $year; ?>" <?php if(!empty($billing_year) && $year == $billing_year) { ?>selected="selected"<?php } ?> ><?php echo $year." - ".($year + 1); ?></option>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                                <script>                                    
                                    function ChangeBillingYear(billing_year) {
                                        var check_login_session = 1;
                                        var post_url = "dashboard_changes.php?check_login_session=1";
                                        jQuery.ajax({url: post_url, success: function (check_login_session) {
                                            if (check_login_session == 1) {
                                                var numbers_regex = /^\d+$/;

                                                if(jQuery('select[name="billing_year"]').parent().find('.alert').length > 0) {
                                                    jQuery('select[name="billing_year"]').parent().find('.alert').remove();
                                                }

                                                var check_login_session = 1;
                                                var post_url = "dashboard_changes.php?update_billing_year="+billing_year;
                                                jQuery.ajax({url: post_url, success: function (result) {
                                                    result = jQuery.trim(result);
                                                    if (numbers_regex.test(result) == true) {
                                                        jQuery('select[name="billing_year"]').before('<div class="alert alert-success">Updated Successfully</div>');
                                                        setTimeout(function () { window.location.reload(); }, 1000);
                                                    }
                                                }});
                                                
                                            }
                                            else {
                                                window.location.reload();
                                            }
                                        }});
                                    }
                                </script>
                            </div>
                        </div>
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class='bi bi-bell-fill fs-18'></i>
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                        </div>
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge bg-light-subtle text-body fs-13"> 4 New</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                                All (4)
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false">
                                                Messages
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                                                Alerts
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content position-relative" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                        <i class="bi bi-patch-check-fill"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author Graphic
                                                            Optimization <span class="text-secondary">reward</span> is
                                                            ready!
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="bi bi-clock"></i> Just 30 sec ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check01">
                                                        <label class="form-check-label" for="all-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <img src="images/avatar-1.jpg" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Answered to your comment on the cash flow forecast's
                                                            graph</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="bi bi-clock"></i> 48 min ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check02">
                                                        <label class="form-check-label" for="all-notification-check02"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="images/avatar-1.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="bi bi-clock"></i> 30 min ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="messages-notification-check01">
                                                        <label class="form-check-label" for="messages-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-actions" id="notification-actions">
                                    <div class="d-flex text-muted justify-content-center">
                                        Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <?php
                            $login_user_name = ""; $login_user_type = "";
                            if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
                                $login_user_name = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'name');
                                if(!empty($login_user_name)) {
                                    $login_user_name = $obj->encode_decode('decrypt', $login_user_name);
                                }
                            }
                            if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
                                $login_user_type = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'];
                            }
                        ?>
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" src="images/logo-sm.png" alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php if(!empty($login_user_name)) { echo $login_user_name; } ?></span>
                                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php if(!empty($login_user_type)) { echo $login_user_type; } ?></span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!--<a class="dropdown-item" href="Javascript:getBackup();"><i class="fa fa-file"></i> &ensp; Backup</a>-->
                            <a class="dropdown-item" href="logout.php">
                                <i class="bi bi-box-arrow-right text-muted fs-14 align-middle me-1"></i> 
                                <span class="align-middle" data-key="t-logout">Logout</span>
                            </a>
                        </div>
                        <script type="text/javascript">
                            function getBackup() {
                                var check_login_session = 1;
                                var post_url = "dashboard_changes.php?check_login_session=1";	
                                jQuery.ajax({url: post_url, success: function(check_login_session){
                                    if(check_login_session == 1) {
                                        var post_url = "dashboard_changes.php?get_backup=1";
                                        jQuery.ajax({url: post_url, success: function(result){
                                            window.location.href = result;
                                        }});
                                    }
                                    else {
                                        window.location.reload();
                                    }
                                }});
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </header>
<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <i class="bi bi-trash h1"></i>
                    <div class="pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="images/logo-sm.png" alt="Logo" height="50">
            </span>
            <span class="logo-lg">
                <img src="images/logo-light.png" alt="Logo" height="70">
            </span>
        </a>
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="images/logo-sm.png" alt="Logo" height="50">
            </span>
            <span class="logo-lg">
                <img src="images/logo-light.png" alt="Logo" height="70">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="bi bi-arrow-right-circle"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menu</span></li>
                <li class="nav-item" id="dashboard">
                    <a class="nav-link menu-link" href="dashboard.php">
                        <i class="bi bi-speedometer"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#company" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="company">
                        <i class="bi bi-buildings"></i> <span>Primary Company</span>
                    </a>
                    <div class="collapse menu-dropdown" id="company">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item" id="organization">
                                <a href="organization.php" class="nav-link"><i class="bi bi-building"></i> <span>Organization</span></a>
                            </li>
                            <li class="nav-item" id="godown">
                                <a href="godown.php" class="nav-link"><i class="bi bi-house-door"></i><span>Godown</span></a>
                            </li>
                            <li class="nav-item" id="branch">
                                <a href="branch.php" class="nav-link"><i class="bi bi-building-add"></i><span>Branch</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#creation" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="creation">
                        <i class="bi bi-plus-square"></i> <span>Creation</span>
                    </a>
                    <div class="collapse menu-dropdown" id="creation">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item" id="roles">
                                <a href="roles.php" class="nav-link"><i class="bi bi-person-fill-add"></i> <span>Roles</span></a>
                            </li>
                            <li class="nav-item" id="user">
                                <a href="user.php" class="nav-link"><i class="bi bi-people-fill"></i> <span>User</span></a>
                            </li>
                            <li class="nav-item" id="vehicle">
                                <a href="vehicle.php" class="nav-link"><i class="bi bi-truck"></i><span>Vehicle</span></a>
                            </li>
                            <li class="nav-item" id="unit">
                                <a href="unit.php" class="nav-link"><i class="fa fa-balance-scale"></i><span>Unit</span></a>
                            </li>
                            <li class="nav-item" id="consignor">
                                <a href="consignor.php" class="nav-link"><i class="bi bi-person-add"></i><span>Consignor</span></a>
                            </li>
                            <li class="nav-item" id="consignee">
                                <a href="consignee.php" class="nav-link"><i class="bi bi-person-fill-dash"></i><span>Consignee</span></a>
                            </li>
                            <li class="nav-item" id="account_party">
                                <a href="account_party.php" class="nav-link"><i class="bi bi-person-check"></i><span>Account Party</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item" id="lr">
                    <a class="nav-link menu-link" href="lr.php">
                        <i class="fa fa-files-o"></i><span>LR</span>
                    </a>
                </li>
                <li class="nav-item" id="luggage_sheet">
                    <a class="nav-link menu-link" href="luggage_sheet.php">
                        <i class="fa fa-pencil-square-o"></i></i><span>Luggage Sheet</span>
                    </a>
                </li>
                <li class="nav-item" id="trip_sheet">
                    <a class="nav-link menu-link" href="tripsheet.php">
                        <i class="bi bi-map"></i><span>Trip Sheet</span>
                    </a>
                </li>
                <li class="nav-item" id="invoice_acknowledgement">
                    <a class="nav-link menu-link" href="invoice_acknowledgement.php">
                        <i class="bi bi-hand-thumbs-up"></i><span>Tripsheet Approval</span>
                    </a>
                </li>
                <li class="nav-item" id="unclearance_entry">
                    <a class="nav-link menu-link" href="unclearance_entry.php">
                        <i class="bi bi-file-earmark-code"></i><span>Unclearance Entry</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#report" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="report">
                        <i class="nav-icon fa fa-database"></i> <span>Reports</span>
                    </a>
                    <div class="collapse menu-dropdown" id="report">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item" id="acknowledgement_invoice_report">
                                <a href="acknowledgement_invoice_report.php" class="nav-link"> Acknowledged Invoice Report </a>
                            </li>
                            <li class="nav-item" id="cleared_lr_list">
                                <a href="cleared_lr_list.php" class="nav-link"> Cleared LR List </a>
                            </li>
                            <li class="nav-item" id="uncleared_lr_list">
                                <a href="uncleared_lr_list.php" class="nav-link"> Uncleared LR List </a>
                            </li>
                            <li class="nav-item" id="pending_payment_details">
                                <a href="pending_payment_details.php" class="nav-link"> Pending Payment Details </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>