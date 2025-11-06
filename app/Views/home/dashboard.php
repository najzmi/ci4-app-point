
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border border-secondary-subtle">
                        <div class="card-body">
                            <h1>Home</h1>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>
