
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
                            <div class="row">
                                <div class="col">
                                    <?php if ($dataBerkas['file_foto'] == ''){ ?>
                                    <div class="col d-flex align-items-center justify-content-center">
                                        <p class="text-center">Tidak Ada Berkas</p>
                                    </div>
                                    <?php }else{ ?>
                                        <p>Berkas Bukti :</p>
                                        <img src="<?php echo base_url('uploads/bukti/'.$dataBerkas['file_foto']);?>" alt="Berkas Foto" class="img-thumbnail rounded mx-auto d-block">
                                    <?php } ?>
                                </div>
                                <div class="col">
                                    <h2>Data Detail</h2>
                                    <div class="border shadow p-4">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td width="30%">Tanggal</td><td>: <?= date('d-m-Y', strtotime($dataBerkas['tanggal'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td>NIS</td><td>: <?= $dataBerkas['murid_nis'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td><td>: <?= $dataBerkas['murid_nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Kelas</td><td>: <?= $dataBerkas['kelas_nama'] ?> <?= $dataBerkas['kelas_subnama'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nama Pelanggaran</td><td>: <?= $dataBerkas['pelanggaran_nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Point</td><td>: <?= $dataBerkas['pelanggaran_point'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>
