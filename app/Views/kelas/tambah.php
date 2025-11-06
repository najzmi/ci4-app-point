
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
                            <?php   echo form_open($pdn_url.'/tambah', 'class="form" id="form"');
                                    echo csrf_field();
                            ?>
                                <div class="mb-3">
                                    <label for="kelas_nama" class="form-label">Nama Kelas *</label>
                                    <?= $kelas_nama; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas_subnama" class="form-label">Sub Nama Kelas *</label>
                                    <?= form_input($kelas_subnama); ?>
                                    <?php if(service('validation')->getError('kelas_subnama')){ ?>
                                        <div id="kelas_subnama" class="form-text"><?= service('validation')->getError('kelas_subnama') ?></div>
                                    <?php } ?>
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
