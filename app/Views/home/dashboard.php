
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo isset($pdn_title) ? $pdn_title	: 'Administrator | Pudin Project'; ?></h1>
                <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
            </div>
            <!-- Content Row -->
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Jumlah Murid</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pdn_jml_murid ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Kelas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pdn_jml_kelas;?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-home fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pending Requests Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Jumlah Pelanggaran</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pdn_jml_pelanggaran; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Row -->
            <div class="row mb-4">
                <div class="col">
                    <div class="card border border-secondary-subtle">
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="grafikKelas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>
        <?= $this->section('contentcode') ?>
            <script src="<?=base_url('assets');?>/gudang/chart.js/Chart.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('grafikKelas').getContext('2d');
                    let grafikKelasChart;

                    async function getPudinSatu() {
                        try {
                            const response = await fetch("<?= base_url($pdn_url . '/grafik_kelas') ?>", {
                                method: "POST"
                            });
                            const data = await response.json();

                            const labels = data.map(item => item.nama);
                            const values = data.map(item => item.jmlpoint);

                            if (!grafikKelasChart) {
                                // Buat chart pertama kali
                                grafikKelasChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Total Point Kelas',
                                            data: values,
                                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            },
                                            x: {
                                                ticks: {
                                                    autoSkip: false,
                                                    maxRotation: 45,
                                                    minRotation: 45
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                position: 'top'
                                            },
                                            title: {
                                                display: true,
                                                text: 'Total Point per Kelas'
                                            }
                                        }
                                    }
                                });
                            } else {
                                // Update chart tanpa re-inisialisasi
                                grafikKelasChart.data.labels = labels;
                                grafikKelasChart.data.datasets[0].data = values;
                                grafikKelasChart.update();
                            }
                        } catch (err) {
                            console.error("Gagal ambil data grafik kelas:", err);
                        }
                    }

                    // Load pertama kali
                    getPudinSatu();

                    // Auto-refresh setiap 6 menit (360000 ms)
                    setInterval(getPudinSatu, 360000);
                });
                </script>
        <?= $this->endSection();?>
