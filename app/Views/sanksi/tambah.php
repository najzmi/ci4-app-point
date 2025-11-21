
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <a href="/<?=$pdn_url;?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-angle-left fa-sm text-white-50"></i> Kembali</a>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card border shadow mb-4">
                        <div class="card-body">
                            <?php   echo form_open_multipart($pdn_url.'/tambah', 'class="form" id="form"');
                                    echo csrf_field();
                            ?>
                                <div class="mb-3">
                                    <label for="id_murid" class="form-label">Nama Murid *</label>
                                    <?= $id_murid; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="id_pelanggaran" class="form-label">Pelanggaran *</label>
                                    <?= $id_pelanggaran; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal *</label>
                                    <?= form_input($tanggal); ?>
                                    <?php if(service('validation')->getError('tanggal')){ ?>
                                        <div id="tanggal" class="form-text"><?= service('validation')->getError('tanggal') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="berkas" class="form-label">Berkas</label>
                                    <?= form_input($berkas); ?>
                                    <?php if(service('validation')->getError('berkas')){ ?>
                                        <div id="berkas" class="form-text"><?= service('validation')->getError('berkas') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_pelapor" class="form-label">Pelapor</label>
                                    <?= form_input($nama_pelapor); ?>
                                    <?php if(service('validation')->getError('nama_pelapor')){ ?>
                                        <div id="nama_pelapor" class="form-text"><?= service('validation')->getError('nama_pelapor') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="murid_telpon" class="form-label">Catatan</label>
                                    <?= $catatan; ?>
                                </div>
                                <div class="text-right mt-5">
                                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </div>
                            <?= form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>
        <?= $this->section('contentcode') ?>
        <script type="text/javascript" src="<?= base_url('assets/gudang/select2/select2.min.js'); ?>"></script>
        <script type="text/javascript">
            /*-- Select 2 --*/
            $('#select1').select2({
                    theme: 'bootstrap4',
            });
            $('#select2').select2({
                    theme: 'bootstrap4',
            });
        </script>
        <?= $this->endSection();?>
