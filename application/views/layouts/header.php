<!doctype html>
<html lang="en">

<head>
<title>Tabungan | Dashboard</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="author" content="">

<link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/animate-css/vivify.min.css') ?>">

<link rel="stylesheet" href="<?= base_url('assets/vendor/dropify/css/dropify.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css')?>">

<link rel="stylesheet" href="<?= base_url('assets/vendor/chartist/css/chartist.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/c3/c3.min.css')?>"/>
<!-- <link rel="stylesheet" href="<?= base_url('assets/vendor/toastr/toastr.min.css') ?>"> -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/jvectormap/jquery-jvectormap-2.0.3.min.css')?>"/>

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/mooli.min.css') ?>">

</head>
<body>
    
<div id="body" class="theme-green">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="mt-3"><img src="<?= base_url('assets/images/icon.svg') ?>" width="40" height="40" alt="Tabungan"></div>
            <p>Please wait...</p>        
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <div id="wrapper">

        <!-- Page top navbar -->
        <nav class="navbar navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-left">
                    <div class="navbar-btn">
                        <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-align-left"></i></button>
                    </div>
                </div>
                <div class="navbar-right">
                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">
                            <li class="hidden-xs"><a href="javascript:void(0);" id="btnFullscreen" class="icon-menu"><i class="fa fa-arrows-alt"></i></a></li>
                            <li><a href="<?= base_url('auth/logout') ?>" class="icon-menu"><i class="fa fa-power-off"></i></a></li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </nav>
        <!-- Main left sidebar menu -->
        <div id="left-sidebar" class="sidebar light_active">
            <a href="javascript:void(0);" class="menu_toggle"><i class="fa fa-angle-left"></i></a>
            <div class="navbar-brand">
                 <?php
                    
                    $roles = $this->session->userdata('role');
                    switch ($roles) {
                        case 'admin':
                            $link = 'dashboard';
                            break;
                        case 'member':
                            $link = 'member';
                            break;
                        default:
                            $link = '#'; 
                            break;  
                    }
                    ?>

                <a href="<?= base_url($link) ?>"><img src="<?= base_url('assets/images/icon.svg') ?>" alt="Tabungan Logo" class="img-fluid logo"><span>Tabungan</span></a>
                <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="fa fa-close"></i></button>
            </div>
            <div class="sidebar-scroll">
                <div class="user-account">
                    <div class="user_div">
                        <?php
                        $id = $this->session->userdata('id');
                        $user = $this->User_m->get_user($id);
                        $avatar_url = !empty($user->avatar) ? base_url('assets/avatar/' . $user->avatar) : base_url('assets/avatar/default.png');
                        ?>

                        <img src="<?= $avatar_url ?>" height="40px" class="user-photo" alt="User Profile Picture">
                    </div>
                    <div class="dropdown">
                        <span>Selamat Datang</span>
                        <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown">
                            <strong>
                                <?php
                                $id = $this->session->userdata('id');
                                $user = $this->User_m->get_user($id);
                                ?>
                               <?= ucwords($user->nama_lengkap); ?>  
                            </strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                            <li><a href="<?= base_url('user/my_profile') ?>"><i class="fa fa-user"></i>Profil Saya</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= base_url('auth/logout') ?>"><i class="fa fa-power-off"></i>Keluar</a></li>
                        </ul>
                    </div>
                </div>  
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu animation-li-delay">
                        <li class="header">MENU</li>

                        <?php
                        $role = $this->session->userdata('role');
                        ?>

                        <?php if ($role == 'admin'): ?>
                            <li class="<?php echo (current_url() == base_url('dashboard')) ? 'active' : ''; ?>"><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dasbor</span></a></li>
                            <li class="<?php echo (current_url() == base_url('transaksi') || current_url() == base_url('transaksi/masuk') || current_url() == base_url('transaksi/keluar')) ? 'active' : ''; ?>">
                                <a href="#" class="has-arrow"><i class="fa fa-th-list"></i><span>Transaksi</span></a>
                                <ul>
                                    <li class="<?php echo (current_url() == base_url('transaksi')) ? 'active' : ''; ?>"><a href="<?= base_url('transaksi') ?>">Semua</a></li>
                                    <li class="<?php echo (current_url() == base_url('transaksi/masuk')) ? 'active' : ''; ?>"><a href="<?= base_url('transaksi/masuk') ?>">Masuk</a></li>
                                    <li class="<?php echo (current_url() == base_url('transaksi/keluar')) ? 'active' : ''; ?>"><a href="<?= base_url('transaksi/keluar') ?>">Keluar</a></li>
                                </ul>
                            </li>
                            <li class="<?php echo (current_url() == base_url('saldo')) ? 'active' : ''; ?>"><a href="<?= base_url('saldo') ?>"><i class="fa fa-money"></i> <span>Saldo</span></a></li>
                            <li class="<?php echo (current_url() == base_url('user/teman')) ? 'active' : ''; ?>"><a href="<?= base_url('user/teman') ?>"><i class="fa fa-comment"></i> <span>Online</span></a></li>
                            <li class="<?php echo (current_url() == base_url('user')) ? 'active' : ''; ?>"><a href="<?= base_url('user') ?>"><i class="fa fa-users"></i> <span>Member</span></a></li>  
                        <?php endif; ?>

                        <?php if ($role == 'member'): ?>
                            <li class="<?php echo (current_url() == base_url('member')) ? 'active' : ''; ?>"><a href="<?= base_url('member') ?>"><i class="fa fa-dashboard"></i> <span>Dasbor</span></a></li>
                            <li class="<?php echo (current_url() == base_url('user/my_profile')) ? 'active' : ''; ?>"><a href="<?= base_url('user/my_profile') ?>"><i class="fa fa-user"></i> <span>Profil Saya</span></a></li>
                            <li class="<?php echo (current_url() == base_url('transaksi/riwayat')) ? 'active' : ''; ?>"><a href="<?= base_url('transaksi/riwayat') ?>"><i class="fa fa-exchange"></i> <span>Riwayat Transaksi</span></a></li>
                            <li class="<?php echo (current_url() == base_url('user/teman')) ? 'active' : ''; ?>"><a href="<?= base_url('user/teman') ?>"><i class="fa fa-comment"></i> <span>Online</span></a></li>
                            <li><a href="<?= base_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
                        <?php endif; ?>

                                              
                    </ul>
                </nav>     
            </div>
        </div>
        <!-- Main body part  -->
        <div id="main-content">
            <div class="container-fluid">