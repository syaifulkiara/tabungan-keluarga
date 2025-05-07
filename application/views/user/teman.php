 <div class="block-header">
    <div class="row clearfix">
        <div class="col-8">
            <h1><?= $title ?></h1>
            <span>List Member Status</span>
        </div>
        <div class="col-4 text-right">
            <div class="d-flex align-items-center justify-content-end mt-2 mt-lg-0 flex-wrap vivify pullUp delay-550">
                <div class="mb-3 mb-xl-0">
                    <?php $role = $this->session->userdata('role'); ?>
                    <?php if ($role == 'admin'): ?>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Kembali</a>
                    <?php endif; ?>

                    <?php if ($role == 'member'): ?>  
                    <a href="<?= base_url('member') ?>" class="btn btn-primary">Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="list-group">
  <?php foreach ($members as $m): ?>
    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <?php
        $avatar_url = !empty($m->avatar) ? base_url('assets/avatar/' . $m->avatar) : base_url('assets/avatar/default.jpg');
        ?>
        <img src="<?= $avatar_url ?>" class="rounded-circle mr-2" width="40" height="40">
        <div>
          <div><strong><?= $m->nama_lengkap ?></strong></div>
          <small>@<?= $m->username ?></small>
        </div>
      </div>
      <button id="status-user-<?= $m->id ?>" class="btn btn-round">Checking...</button>
    </a>
  <?php endforeach; ?>
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
                    btn.removeClass('btn-success btn-sm btn-danger btn-sm')
                       .addClass(user.online ? 'btn-success' : 'btn-danger')
                       .text(user.online ? 'Online' : 'Offline');
                }
            });
        }
    });
}

// Refresh tiap 5 detik
setInterval(updateUserStatusRealtime, 2000);
updateUserStatusRealtime(); // panggil langsung saat halaman dimuat
</script>