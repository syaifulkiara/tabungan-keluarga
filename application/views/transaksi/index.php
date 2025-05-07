<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <h1>List Transaksi Member</h1>
            <span>Informasi Transaksi</span>
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
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Semua Transaksi</h2>
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
                                <th>Aksi</th>
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
                              <td><?= format_tanggal_indonesia($t->tanggal) ?></td>
                              <td>
                                  <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit<?= $t->id ?>"><i class="fa fa-edit"></i> Edit</button>
                                  <a href="<?= base_url('transaksi/hapus/' . $t->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="fa fa-trash"></i> Hapus</a>
                              </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php foreach ($transaksi as $t): ?>
<div class="modal fade" id="modalEdit<?= $t->id ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?= $t->id ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('transaksi/edit/' . $t->id) ?>">
      <div class="modal-content">
        <div class="modal-header" style="background-color: orange; color: white;">
          <h5 class="modal-title">Edit Transaksi</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="<?= $t->jumlah ?>" required>
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $t->tanggal ?>" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" required><?= $t->keterangan ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>
