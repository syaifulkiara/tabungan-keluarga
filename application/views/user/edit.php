 <div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <h1>Halaman Profil</h1>
            <span>Ubah nama, Alamat, Tlp dan Foto Profil</span>
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
                <?php
                $avatar_url = !empty($user->avatar) ? base_url('assets/avatar/' . $user->avatar) : base_url('assets/avatar/default.jpg');
                ?>
                <img src="<?= $avatar_url?>" width="350px" class="" alt="">
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
                    <a href="<?php echo base_url('user/hapus/'.$user->id) ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus MEMBER ini?')">Hapus Member</a>
                </div>                            
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="body">
                <form method="post" action="<?= base_url('user/update_myprofile') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" value="<?= $user->username ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select name="role" class="form-control show-tick">
                                <option value="">- Pilih Akses -</option>
                                <option value="admin" <?php if ($user->role == 'admin') {echo 'selected';}  ?>>Admin</option>
                                <option value="member" <?php if ($user->role == 'member') {echo 'selected';}  ?>>Member</option>
                            </select>
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
                            <input type="file" class="dropify" name="avatar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-md-6 col-sm-10">
                            <button type="submit" class="btn btn-primary">Perbaharui</button>
                            <a href="<?= base_url('user') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>