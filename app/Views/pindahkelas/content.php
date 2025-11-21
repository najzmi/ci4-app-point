
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
                            <form action="<?= base_url($pdn_url.'/proses_pindah'); ?>" method="post">
                                <div class="row">
                                    <?php foreach ($kelas as $index => $k): ?>

                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header text-center">
                                                    <strong><?= $k->kelas_nama . ' - ' . $k->kelas_subnama ?></strong>
                                                </div>

                                                <div class="card-body">

                                                    <?php if (empty($k->murid)): ?>
                                                        <p class="text-muted">Tidak ada murid.</p>

                                                    <?php else: ?>

                                                        <table class="table table-bordered table-sm">
                                                            <tbody>

                                                                <?php foreach ($k->murid as $m): ?>
                                                                    <tr>
                                                                        <td width="10">
                                                                            <input type="checkbox"
                                                                                name="murid_id[]"
                                                                                value="<?= $m->id ?>" class="form-control">
                                                                        </td>
                                                                        <td><?= $m->murid_nis ?></td>
                                                                        <td><?= $m->murid_nama ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>

                                                            </tbody>
                                                        </table>

                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>

                                        <?php if (($index + 1) % 3 == 0): ?>
                                            </div><div class="row">
                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </div>

                                <hr>

                                <!-- Dropdown Kelas Tujuan -->
                                <div class="mb-3">
                                    <label><strong>Pilih Kelas Tujuan:</strong></label>
                                    <select class="form-control" name="kelas_tujuan" required>
                                        <option value="">-- Pilih Kelas --</option>

                                        <?php foreach ($kelas as $k): ?>
                                            <option value="<?= $k->id ?>">
                                                <?= $k->kelas_nama . ' - ' . $k->kelas_subnama ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <div class="mt-2 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        Pindahkan Murid
                                    </button>
                                </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>

        <?= $this->section('contentcode') ?>
        <?= $this->endSection();?>
