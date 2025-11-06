
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
                                    <label for="id_mapel" class="form-label">Mapel *</label>
                                    <?= $id_mapel; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="guru_nama" class="form-label">Nama Guru *</label>
                                    <?= form_input($guru_nama); ?>
                                    <?php if(service('validation')->getError('guru_nama')){ ?>
                                        <div id="guru_nama" class="form-text"><?= service('validation')->getError('guru_nama') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="guru_telpon" class="form-label">No Telpon</label>
                                    <?= form_input($guru_telpon); ?>
                                    <?php if(service('validation')->getError('guru_telpon')){ ?>
                                        <div id="guru_telpon" class="form-text"><?= service('validation')->getError('guru_telpon') ?></div>
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
