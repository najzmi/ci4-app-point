
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <a href="/<?=$pdn_url;?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-angle-left fa-sm text-white-50"></i> Kembali</a>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border shadow mb-4">
                        <div class="card-body">
                            <?php   echo form_open($pdn_url.'/edit/'.$update_id, 'class="form" id="form"');
                                    echo csrf_field();
                                    echo form_input($id);
                            ?>
                                <div class="mb-3">
                                    <label for="id_mapel" class="form-label">Kelas *</label>
                                    <?= $id_kelas; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="murid_nis" class="form-label">NIS Murid *</label>
                                    <?= form_input($murid_nis); ?>
                                    <?php if(service('validation')->getError('murid_nis')){ ?>
                                        <div id="murid_nis" class="form-text"><?= service('validation')->getError('murid_nis') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="murid_nama" class="form-label">Nama Murid *</label>
                                    <?= form_input($murid_nama); ?>
                                    <?php if(service('validation')->getError('murid_nama')){ ?>
                                        <div id="murid_nama" class="form-text"><?= service('validation')->getError('murid_nama') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="murid_telpon" class="form-label">No Telpon</label>
                                    <?= form_input($murid_telpon); ?>
                                    <?php if(service('validation')->getError('murid_telpon')){ ?>
                                        <div id="murid_telpon" class="form-text"><?= service('validation')->getError('murid_telpon') ?></div>
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
