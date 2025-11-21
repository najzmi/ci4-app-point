
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <!-- <a href="<?=$pdn_url;?>/tambah" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-square fa-sm text-white-50"></i> Tambah Data</a> -->
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border shadow mb-4">
                        <div class="card-body">
                            <p>Hallo World</p>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>

        <?= $this->section('contentcode') ?>
        <?= $this->endSection();?>
