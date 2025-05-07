<!doctype html>
<html lang="en">

<head>
<title>Tabungan | Masuk</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="author" content="GetBootstrap, design by: puffintheme.com">
<link rel="icon" href="<?= base_url('assets/images/favicon.ico')?>" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css')?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/animate-css/vivify.min.css')?>">
<!-- MAIN CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/mooli.min.css')?>">
</head>
<body>
<div id="body" class="theme-cyan">
    <div class="auth-main">
        <div class="auth_div vivify fadeIn">
            <div class="auth_brand">
                <a class="navbar-brand" href="<?= base_url('auth') ?>">
                    <img src="<?= base_url('assets/images/icon.svg') ?>" width="50" class="d-inline-block align-top mr-2" alt="">Tabungan
                </a>  
                <p>BabaFamily.my.id</p>                                              
            </div>
            <div class="card">
                <div class="body">
                     <?php 
                        if($this->session->flashdata('success')){
                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php } ?>
                        <?php 
                        if($this->session->flashdata('warning')){
                        ?>
                            <div class="alert alert-danger alert-dismissible">
                                <?php echo $this->session->flashdata('warning'); ?>
                            </div>
                        <?php } ?>

                        <?php 
                        echo validation_errors('<div class="alert alert-danger alert-dismissible">','</div>');

                        // Add 'class' attribute within an array
                        echo form_open(base_url('auth'), ['class' => 'form-auth-small']);
                        ?>
                            <div class="form-group c_form_group">
                                <label>Nama Anda</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukan Nama">
                            </div>
                            <div class="form-group c_form_group">
                                <label>Kata Sandi</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukan kata sandi">
                            </div>
                            <button type="submit" class="btn btn-dark btn-lg btn-block">MASUK</button>
                            <div class="bottom">
                                 <span>Belum punya akun? <a href="<?= base_url('auth/register') ?>">Daftar</a></span>
                            </div>
                        <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="animate_lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>

</div>
    
<script src="<?= base_url('assets/bundles/libscripts.bundle.js') ?>"></script>    
<script src="<?= base_url('assets/bundles/vendorscripts.bundle.js') ?>"></script>
</body>
</html>