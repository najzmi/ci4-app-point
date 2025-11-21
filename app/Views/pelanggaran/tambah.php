
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <div class="d-none d-sm-inline-block">
                <a href="/<?=$pdn_url;?>" class=" btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-angle-left fa-sm text-white-50"></i> Kembali</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card border shadow mb-4">
                        <div class="card-body">
                            <?php   echo form_open($pdn_url.'/tambah', 'class="form" id="form"');
                                    echo csrf_field();
                            ?>
                                <div class="mb-3">
                                    <label for="pelanggaran_nama" class="form-label">Nama Pelanggaran *</label>
                                    <?= form_input($pelanggaran_nama); ?>
                                    <?php if(service('validation')->getError('pelanggaran_nama')){ ?>
                                        <div id="pelanggaran_nama" class="form-text"><?= service('validation')->getError('pelanggaran_nama') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="pelanggaran_point" class="form-label">Point *</label>
                                    <?= form_input($pelanggaran_point); ?>
                                    <?php if(service('validation')->getError('pelanggaran_point')){ ?>
                                        <div id="pelanggaran_point" class="form-text"><?= service('validation')->getError('pelanggaran_point') ?></div>
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
