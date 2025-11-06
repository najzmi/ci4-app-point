
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <a href="/users" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-angle-left fa-sm text-white-50"></i> Kembali</a>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border shadow mb-4">
                        <div class="card-body">
                            <?php   echo form_open('/users/edit/'.$update_id, 'class="form" id="form"');
                                    echo csrf_field();
                                    echo form_input($id);
                            ?>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Nama Depan</label>
                                    <?= form_input($first_name); ?>
                                    <?php if(service('validation')->getError('first_name')){ ?>
                                        <div id="first_name" class="form-text"><?= service('validation')->getError('first_name') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Nama Belakang</label>
                                    <?= form_input($last_name); ?>
                                    <?php if(service('validation')->getError('last_name')){ ?>
                                        <div id="last_name" class="form-text"><?= service('validation')->getError('last_name') ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <?= form_input($email); ?>
                                    <?php if(service('validation')->getError('email')){ ?>
                                        <div id="email" class="form-text"><?= service('validation')->getError('email'); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="mb-3">
                                    <label for="users_level" class="form-label">Level</label>
                                    <?=$users_level;?>
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
