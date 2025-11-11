
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
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
                                            <th class="text-center">Nama Kelas</th>
                                            <th width="12%">Jml Point</th>
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
                            "targets": [0],
                            "sClass": "text-center",
                            "orderable": false,
                        },
                        {
                            "targets": [4],
                            "sClass": "text-center"
                        }
                    ],
                });

                function reloadTable(){
                    $('#dataTable').DataTable().ajax.reload();
                }
            </script>
        <?= $this->endSection();?>
