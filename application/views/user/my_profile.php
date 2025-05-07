 <div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <h1>Halaman Profil</h1>
            <span>Ubah nama, Alamat, Tlp dan Foto Profil</span>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 text-lg-right">
            <div class="d-flex align-items-center justify-content-lg-end mt-4 mt-lg-0 flex-wrap vivify pullUp delay-550">
                <div class="mb-3 mb-xl-0">
                    <?php if ($user->role == 'admin'): ?>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Kembali</a>
                    <?php elseif ($user->role == 'member'): ?>    
                    <a href="<?= base_url('member') ?>" class="btn btn-primary">Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

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

<div class="row clearfix">
    <div class="col-lg-4 col-md-12">
        <div class="card profile-header">
            <div class="body text-center">
                <img src="<?= base_url('assets/avatar/' . $user->avatar)?>" width="350px" class="" alt="">
                <div class="mt-3">
                    <h5 class="mb-0"><strong><?= $user->nama_lengkap ?></strong></h5>
                    <span><?= $user->no_tlp ?></span>
                </div>
                <div class="m-t-15">
                    <?php if ($user->role == 'admin'): ?>
                        <button class="btn btn-round btn-primary">Admin</button>
                    <?php elseif ($user->role == 'member'): ?>
                        <button class="btn btn-round btn-warning">Member</button>
                    <?php else: ?>
                        <button class="btn btn-round btn-secondary">Unknown Role</button>
                    <?php endif; ?>
                    <button class="btn btn-outline-secondary">Aktif</button>
                </div>                            
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="header">
            <ul class="nav nav-tabs3">
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#BioData">Bio</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Setting">Password</a></li>
            </ul>
        </div>
        <div class="tab-content mt-0">
            <div class="tab-pane show active" id="BioData">
                <div class="card">
                    <div class="body">
                        <form method="post" action="<?= base_url('user/update_profile') ?>" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" value="<?= $user->username ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_lengkap" value="<?= $user->nama_lengkap ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="alamat" value="<?= $user->alamat ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">No. Telpon</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="no_tlp" value="<?= $user->no_tlp ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Unggah Foto Profil</label>
                                <div class="col-sm-10">
                                    <input type="file" class="dropify" name="avatar" data-allowed-file-extensions="jpg jpeg png"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-md-6 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Perbaharui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="Setting">
                <div class="card">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <h6>Ubah Password</h6>
                                <form method="post" action="<?= base_url('user/ubah_password') ?>">
                                <div class="form-group c_form_group">
                                    <label>Password Baru</label>
                                    <input type="password" name="password_baru" class="form-control" placeholder="Enter here">
                                </div>
                                <div class="form-group c_form_group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="konfirmasi_password" class="form-control" placeholder="Enter here">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button> &nbsp;&nbsp;
                        <a href="<?= base_url('user/my_profile') ?>" class="btn btn-default">Batal</a>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.dropify').dropify({
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happened.'
        },
        error: {
            'fileSize': 'The file size is too big (5M max).'
        }
    });
</script>