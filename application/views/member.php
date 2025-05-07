<!-- Page header section  -->
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <h1>Selamat Datang, 
                <?php
                $id = $this->session->userdata('id');
                $user = $this->User_m->get_user($id);
                ?>
               <?= ucwords($user->nama_lengkap); ?>  !</h1>
            <span>Halaman Dasbor,</span>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-12">
        <div class="card">
            <div class="body">
                <div class="file_folder">
                    <a href="<?= base_url('user/my_profile') ?>">
                        <div class="icon">
                            <i class="fa fa-user text-info"></i>
                        </div>
                        <div class="file-name">
                            <p class="mb-0 text-muted">Profil Saya</p>
                        </div>
                    </a>
                    <a href="<?= base_url('transaksi/riwayat') ?>">
                        <div class="icon">
                            <i class="fa fa-folder text-info"></i>
                        </div>
                        <div class="file-name">
                            <p class="mb-0 text-muted">Transaksi</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>