
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <div class="d-none d-sm-inline-block">
                    <a href="<?=$pdn_url;?>/import_xlsx" class="btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-plus-square fa-sm text-white-50"></i> Import</a>
                    <a href="<?=$pdn_url;?>/tambah" class="btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus-square fa-sm text-white-50"></i> Tambah Data</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th class="text-center">NIS</th>
                                            <th class="text-center">Nama Murid</th>
                                            <th class="text-center">Telpon</th>
                                            <th class="text-center">Kelas</th>
                                            <th width="12%">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>

        <?= $this->section('contentcode') ?>
            <script>
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax:{
                        url: '<?=$pdn_url.'/data_json'?>',
                        type: 'POST',
                        error: function(xhr, error, thrown) {
                            console.log("Error DataTables:", xhr.responseText);
                        }
                    },
                    columnDefs: [
                        {
                            "targets": [0,5],
                            "sClass": "text-center",
                            "orderable": false,
                        },
                    ],
                });

                function reloadTable(){
                    $('#dataTable').DataTable().ajax.reload();
                }
            </script>
        <?= $this->endSection();?>
