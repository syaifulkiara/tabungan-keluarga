<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <h1>Saldo Tabungan</h1>
            <span>Total Tabungan Terkumpul, Total Saldo Member</span>
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
                <h2>Saldo Member</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-border table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th width="2%">#</th>
                                <th>Nama</th>
                                <th>Total Masuk</th>
                                <th>Total Keluar</th>
                                <th>Saldo Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($saldo as $s): ?>
                            <tr>
                              <td><?= $no++ ?></td>
                              <td><?= $s->nama_lengkap ?></td>
                              <td><?= format_rupiah($s->total_masuk) ?></td>
                              <td><?= format_rupiah($s->total_keluar) ?></td>
                               <?php
                                $warna = ($s->saldo < 0) ? 'red' : 'green';
                                ?>
                              <td style="font-size: 15px; font-weight: bold; color: <?= $warna ?>;">
                                    <?= format_rupiah($s->saldo) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="body theme-bg gradient">
            <h2 style="font-size: 20px; font-weight: bold; color: white;">Total Saldo Semua</h2>
            <p style="font-size: 25px; font-weight: bold; color: gold;"><?= format_rupiah($total->total_saldo) ?></p>
             </div>
        </div>
    </div>

 
</div>