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
            <span>Halaman Dasbor</span>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 text-lg-right">
            <div class="d-flex align-items-center justify-content-lg-end mt-4 mt-lg-0 flex-wrap vivify pullUp delay-550">
                <div class="border-right pr-4 mr-4 mb-xl-0">
                   <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSaldo">Tabungan Masuk</button>
                </div>
                <div class="mb-xl-0">
                    <button class="btn btn-danger" data-toggle="modal" data-target="#modalKurangSaldo">Tabungan Keluar</button>
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
    <div class="col-12">
        <nav class="navbar navbar-expand-lg page_menu">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"><a class="nav-link" href="#">Data Terkini !</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="col-12">
        <div class="card theme-bg gradient">
            <div class="body">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="body">
                                <div>Total Saldo</div>
                                <div class="mt-3 h2"><?= format_rupiah($total_saldo) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="body">
                                <div>Total Masuk</div>
                                <div class="mt-3 h2"><?= format_rupiah($total_masuk) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="body">
                                <div>Total Keluar</div>
                                <div class="mt-3 h2"><?= format_rupiah($total_keluar) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="body">
                                <div>Member</div>
                                <div class="mt-3 h2"><?= $total_member ?></div>
                            </div>
                        </div>
                    </div>
                </div>         
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-12">
        <div class="section_title">
            <div class="mr-3">
                <h3>Transaksi Terakhir</h3>
                <small>Member, Nominal masuk, hari & Tanggal.</small>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-border table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th width="2%"><strong>#</strong></th>
                                <th><strong>Nama Member</strong></th>
                                <th><strong>Jumlah</strong></th>
                                <th><strong>Jenis</strong></th>
                                <th><strong>Keterangan</strong></th>
                                <th><strong>Tanggal</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($get_transaksi_terakhir as $val): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="media mb-0">
                                        <img src="<?= base_url('assets/avatar/' . $val->avatar)?>" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="rounded-circle w35" data-original-title="<?= $val->nama_lengkap ?>">
                                        <div class="media-body ml-3">
                                            <h6 class="m-0"><?= $val->nama_lengkap ?></h6>
                                            <span class="text-muted font-12"><?= $val->no_tlp ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?= format_rupiah($val->jumlah) ?></td>
                                <td>
                                    <?php if ($val->tipe == 'masuk'): ?>
                                    <span class="badge badge-primary">SALDO <?= ucfirst($val->tipe) ?></span>
                                    <?php else: ?>
                                    <span class="badge badge-danger">SALDO <?= ucfirst($val->tipe) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $val->keterangan ?></td>
                                <td><?= format_tanggal_indonesia($val->created_at) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    </div>
</div>

<!-- modal Tabungan Masuk -->
<div class="modal fade" id="modalTambahSaldo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('saldo/tambah') ?>">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #68b440; color: white;">
          <h5 class="modal-title h4">Tabungan Masuk</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Pilih Member</label>
            <select name="user_id" class="form-control show-tick" required>
              <option value="">-- Pilih Member --</option>
              <?php foreach ($members as $m): ?>
                <option value="<?= $m->id ?>"><?= $m->nama_lengkap ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="jumlah" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Catatan</label>
            <textarea rows="2" name="keterangan" class="form-control no-resize"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-round btn-primary">Simpan</button>
          <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- modal Tabungan Keluar -->
<div class="modal fade" id="modalKurangSaldo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('saldo/kurang') ?>">
            <div class="modal-content">
                <div class="modal-header" style="background-color: darkred; color: white;">
                    <h5 class="modal-title h4">Tabungan Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Member</label>
                        <select name="user_id" class="form-control show-tick" required>
                            <option value="">-- Pilih Member --</option>
                            <?php foreach ($members as $m): ?>
                                <option value="<?= $m->id ?>"><?= $m->nama_lengkap ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea rows="2" name="keterangan" class="form-control no-resize"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-primary">Simpan</button>
                    <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>