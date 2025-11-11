<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></title>
    <link rel="shortcut icon" href="<?=base_url('assets');?>/img/favicon.ico" type="image/x-icon" />
    <link href="<?=base_url('assets');?>/gudang/select2/select2.min.css" rel="stylesheet">
    <link href="<?=base_url('assets');?>/gudang/select2/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="<?=base_url('assets');?>/gudang/jquery/jquery-ui.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="<?=base_url('assets');?>/gudang/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('assets');?>/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?=base_url('assets');?>/gudang/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url('dashboard');?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">YPI Al Azhar</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo isset($menudashboard) ? $menudashboard : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('dashboard'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item <?php echo isset($menumapel) ? $menumapel : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('mapel'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Mapel</span></a>
            </li>
            <li class="nav-item <?php echo isset($menuguru) ? $menuguru : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('guru'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Guru</span></a>
            </li>
            <li class="nav-item <?php echo isset($menukelas) ? $menukelas : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('kelas'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Kelas</span></a>
            </li>
            <li class="nav-item <?php echo isset($menumurid) ? $menumurid : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('murid'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Murid</span></a>
            </li>
            <li class="nav-item <?php echo isset($menupelanggaran) ? $menupelanggaran : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('pelanggaran'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Pelanggaran</span></a>
            </li>
            <li class="nav-item <?php echo isset($menusanksi) ? $menusanksi : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('sanksi'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Sanksi</span></a>
            </li>
            <li class="nav-item <?php echo isset($menuremisi) ? $menuremisi : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url('remisi'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Remisi</span></a>
            </li>
            <li class="nav-item <?= isset($menu_data_laporan[0]) ? $menu_data_laporan[0]: ''; ?>">
                <a class="nav-link <?= isset($menu_data_laporan[0]) ? '': 'collapsed'; ?>" href="#" data-toggle="collapse" data-target="#menuDataLaporan" aria-expanded="true"
                    aria-controls="menuDataLaporan">
                    <i class="fas fa-fw fa-tag"></i>
                    <span>Laporan</span>
                </a>
                <div id="menuDataLaporan" class="collapse <?= isset($menu_data_laporan[1]) ? $menu_data_laporan[1]: ''; ?>" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Laporan :</h6>
                        <a class="collapse-item <?= isset($menulaporanmurid) ? $menulaporanmurid: ''; ?>" href="<?= base_url('laporanmurid'); ?>">Per Murid</a>
                        <a class="collapse-item <?= isset($menulaporankelas) ? $menulaporankelas: ''; ?>" href="<?= base_url('laporankelas'); ?>">Per Kelas</a>
                        <a class="collapse-item <?= isset($menupointlebih) ? $menupointlebih: ''; ?>" href="<?= base_url('pointlebih'); ?>">Point Tingi</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block mt-3">
            <li class="nav-item <?php echo isset($menuusers) ? $menuusers : ''; ?> ">
                <a class="nav-link pb-0" href="<?= base_url('users'); ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block mt-3">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=session()->get('pdn_nama')?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?=base_url('assets');?>/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- /.KONTEN -->
					<?= $this->renderSection('content') ?>
                    <!-- /.END KONTEN -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Page rendered in <strong>{elapsed_time}</strong> seconds, {memory_usage} MB of memory, <?= CodeIgniter\CodeIgniter::CI_VERSION ?> Copyright &copy; Pudin <?=date('Y');?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" jika anda ingin keluar dari aplikasi ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?=base_url('logout');?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url('assets');?>/gudang/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets');?>/gudang/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url('assets');?>/gudang/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url('assets');?>/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?=base_url('assets');?>/gudang/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets');?>/gudang/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url('assets');?>/js/demo/datatables-demo.js"></script>
    <!-- Notify-->
    <script src="<?=base_url('assets');?>/gudang/notify/notify.min.js"></script>
    <script type="text/javascript">
        const flasDatas = "<?= session()->getFlashdata('success');?>";
        if (flasDatas) {
            $.notify(flasDatas, "success");
        }

        const flasDatae = "<?= session()->getFlashdata('error');?>";
        if (flasDatae) {
            $.notify(flasDatae, "error");
        }
    </script>
    <!-- /.KONTEN -->
    <?= $this->renderSection('contentcode') ?>
    <!-- /.END KONTEN -->
</body>

</html>