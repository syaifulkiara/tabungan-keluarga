<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <h1>Halaman Transaksi</h1>
            <span>Info Saldo Tabungan Anda dan Tracking Transaksi</span>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 text-right">
            <div class="d-flex align-items-center justify-content-lg-end mt-4 mt-lg-0 flex-wrap vivify pullUp delay-550">
                <div class="border-right pr-2 mr-2 mb-2 mb-xl-0">
                    <p class="text-muted mb-1">Saldo Masuk</p>
                    <button class="btn btn-warning"><?= number_format($saldo_masuk, 0, ',', '.') ?></button>
                </div>
                <div class="border-right pr-2 mr-2 mb-2 mb-xl-0">
                    <p class="text-muted mb-1">Saldo keluar</p>
                    <button class="btn btn-warning"><?= number_format($saldo_keluar, 0, ',', '.') ?></button>
                </div>
                <div class="pr-2 mb-2 mb-xl-0">
                    <?php
                    $warna = ($total_saldo < 0) ? 'red' : 'white';
                    ?>
                    <p class="text-muted mb-1">Saldo Tabungan</p>
                    <button class="btn btn-primary" style="font-size: 15px; font-weight: bold; color: <?= $warna ?>;;"><?= number_format($total_saldo, 0, ',', '.') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="card">
        <div class="row clearfix">
            <div class="col-8">
                <div class="header">
                  <h2>Riwayat Transaksi</h2>
                </div>
            </div>
            <div class="col-4 text-right">
                <div class="d-flex align-items-center justify-content-end mt-2 mt-lg-0 flex-wrap vivify pullUp delay-550">
                    <div class="">
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
        <div class="body">
            <div class="table-responsive">
                <table class="table table-border table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($transaksi as $t): ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= format_tanggal_indonesia($t->created_at) ?></td>
                          <td><?= format_rupiah($t->jumlah) ?></td>
                          <td> 
                            <?php if ($t->tipe == 'masuk'): ?>
                            <span class="badge badge-primary">SALDO <?= ucfirst($t->tipe) ?></span>
                            <?php else: ?>
                            <span class="badge badge-danger">SALDO <?= ucfirst($t->tipe) ?></span>
                            <?php endif; ?> 
                          </td>
                          <td><?= $t->keterangan ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>