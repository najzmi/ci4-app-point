
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
                            <?php   echo form_open_multipart($pdn_url.'/import_xlsx', 'class="form" id="form"');
                                    echo csrf_field();
                            ?>
                                <div class="mb-3">
                                    <label for="berkas" class="form-label">Import File Excel *</label>
                                    <?= form_input($berkas); ?>
                                    <?php if(service('validation')->getError('berkas')){ ?>
                                        <div id="berkas" class="form-text"><?= service('validation')->getError('berkas') ?></div>
                                    <?php } ?>
                                </div>
                                
                                <div class="text-right mt-5">
                                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </div>
                            <?= form_close();?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border shadow mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <ul>
                                    <li>Silahkan download dan isi terlebih dahulu template excel yang disediakan.</li>
                                    <li>Pastikan pengisian data sesuai dengan aturan yang sudah dicontohkan.</li>
                                </ul>
                                <a href="<?= base_url('uploads/template/template_import_murid.xlsx') ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" target="_blank"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Template</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>
