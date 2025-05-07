<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <h1>List Transaksi Member</h1>
            <span>Informasi Transaksi Keluar</span>
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
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Transaksi Keluar</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-border table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th width="2%">#</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($transaksi as $t): ?>
                            <tr>
                              <td><?= $no++ ?></td>
                              <td><?= $t->nama_lengkap ?></td>
                              <td> 
                                <?php if ($t->tipe == 'masuk'): ?>
                                <span class="badge badge-primary">SALDO <?= ucfirst($t->tipe) ?></span>
                                <?php else: ?>
                                <span class="badge badge-danger">SALDO <?= ucfirst($t->tipe) ?></span>
                                <?php endif; ?> 
                              </td>
                              <td><?= format_rupiah($t->jumlah) ?></td>
                              <td><?= $t->keterangan ?></td>
                              <td><?= format_tanggal_indonesia($t->created_at) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>