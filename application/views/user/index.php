<div class="block-header">
    <div class="row clearfix">
        <div class="col-md-4 col-sm-12">
            <h1>Pengaturan Member</h1>
            <span>Tambah, Ubah dan Hapus Member</span>
        </div> 
        <div class="col-lg-8 col-md-12 col-sm-12 text-lg-right">
            <div class="d-flex align-items-center justify-content-lg-end mt-4 mt-lg-0 flex-wrap vivify pullUp delay-550">
                <div class="mb-3 mb-xl-0">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>         
    </div>
</div>


<div class="row clearfix">
    <div class="col-12">
        <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success alert-dismissible">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('warning')){ ?>
            <div class="alert alert-danger alert-dismissible">
                <?php echo $this->session->flashdata('warning'); ?>
            </div>
        <?php } ?>
        <div class="card bg-clear">
            <div class="d-flex align-items-center flex-wrap vivify pullUp delay-50">
                <div class="">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Tambah Member</button>
                </div>
            </div>
            <div class="header">
                <ul class="nav nav-tabs3">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#All-Contacts">All</a></li>
                </ul>
            </div>
            <div class="body">
                <div class="tab-content mt-0">
                    <div class="tab-pane show active" id="All-Contacts">
                        <div class="row clearfix">
                            <?php foreach($users as $val): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card contact_card">
                                        <div class="body text-center">
                                            <div class="circle">
                                                <?php
                                                $avatar_url = !empty($val->avatar) ? base_url('assets/avatar/' . $val->avatar) : base_url('assets/avatar/default.jpg');
                                                ?>
                                                <img class="rounded-circle" src="<?= $avatar_url ?>" width="120px" height="120px" alt="">
                                            </div>
                                            <h6 class="mt-3 mb-0"><?= !empty($val->nama_lengkap) ? $val->nama_lengkap : $val->username ?></h6>
                                            <span><?= !empty($val->no_tlp) ? $val->no_tlp : 'NULL' ?></span>
                                            <ul class="mt-3 list-unstyled d-flex justify-content-center">
                                                <li><span><?= !empty($val->alamat) ? $val->alamat : 'NULL' ?></span></li>
                                            </ul>
                                            
                                            <?php if ($val->role == 'admin'): ?>
                                                <button class="btn btn-round btn-primary">Admin</button>
                                            <?php elseif ($val->role == 'member'): ?>
                                                <button class="btn btn-round btn-warning">Member</button>
                                            <?php else: ?>
                                                <button class="btn btn-round btn-secondary">Unknown Role</button>
                                            <?php endif; ?>

                                            <a href="<?= site_url('user/edit/'.$val->id) ?>" type="button" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <button id="status-user-<?= $val->id ?>" class="btn btn-round">Checking...</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <h5 class="modal-title" id="exampleModalLabel">Tmbah Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('user/saveUser') ?>" method="POST">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group c_form_group">
                                <label>Nama User <span class="text-danger">*</span></label>
                                <input class="form-control" name="username" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group c_form_group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input class="form-control" name="nama_lengkap" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group c_form_group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input class="form-control" name="password" type="password">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-round btn-primary">Simpan</button>
                            <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateUserStatusRealtime() {
    $.ajax({
        url: '<?= base_url("user/check_online_status") ?>',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(user => {
                const btn = $('#status-user-' + user.id);
                if (btn.length) {
                    btn.removeClass('btn-success btn-danger')
                       .addClass(user.online ? 'btn-success' : 'btn-danger')
                       .text(user.online ? 'On' : 'Off');
                }
            });
        }
    });
}

// Refresh tiap 5 detik
setInterval(updateUserStatusRealtime, 5000);
updateUserStatusRealtime();
</script>

