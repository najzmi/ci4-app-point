<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?=base_url('assets/');?>img/favicon.ico" type="image/x-icon"/>
        <title>PRINT LAPORAN PER MURID</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
            *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            }
        </style>
        <style>
            /* ==== Aturan Cetak A4 ==== */
            @page {
                size: A4;
                margin: 15mm;
            }

            @media print {
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                    color: #000;
                }
                table {
                    page-break-inside: avoid;
                }
                thead {
                    display: table-header-group;
                }
            }

            body {
                background: #fff;
                font-size: 14px;
                color: #000;
            }

            h2 {
                text-align: center;
                margin-bottom: 5px;
            }

            hr {
                border: 1px solid #000;
                margin: 5px 0 10px 0;
            }

            /* ==== Header Identitas ==== */
            .info {
                width: 100%;
                margin-bottom: 25px;
                font-size: 13px;
            }

            .info td {
                padding: 3px 5px;
            }

            .info td.label {
                width: 18%;
                font-weight: 600;
            }

            /* ==== Tabel ==== */
            table.data {
                margin-top:20px;
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            thead {
                font-size: 14px;
                background-color: rgba(0,0,0,0.1);
            }

            thead tr {
                background-color: #F1F1F1;
            }

            th, td {
                border: 1px solid #000;
                padding: 6px 8px;
            }

            th {
                font-weight: 600;
                text-align: center;
            }

            td {
                font-weight: 400;
            }

            tbody tr:nth-child(even) {
                background-color: #fafafa;
            }

            table.ttd, 
            table.ttd td, 
            table.ttd th {
                border: none !important;
                border-collapse: collapse;
            }

            /* ==== Print Presisi ==== */
            @media print {
                th, td {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            }
        </style>
    </head>
    <body onload="window.print()">
    <!-- <body> -->
        <h2 style="font-size: 32px;">LAPORAN POINT PELANGGARAN MURID</h2>
        <hr>

        <!-- ==== Identitas Siswa ==== -->
        <table class="info">
            <tr>
                <td class="label">Nama Sekolah</td>
                <td>: <?= env('PDN_NAMA_SEKOLAH', 'Nama Sekolah Default');?></td>
            </tr>
            <tr>
                <td class="label">NIS</td>
                <td>: <?=$pdn_rowMurid->murid_nis;?></td>
            </tr>
            <tr>
                <td class="label">Nama Murid</td>
                <td>: <?=$pdn_rowMurid->murid_nama;?></td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>: <?=$pdn_rowMurid->kelas_nama;?> <?=$pdn_rowMurid->kelas_subnama;?></td>
            </tr>
        </table>

        <!-- ==== Tabel Pelanggaran ==== -->
        <table class="data">
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:18%; text-align:left;">Tanggal</th>
                    <th style="text-align:left;">Keterangan</th>
                    <th style="width:10%;">Point</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" style="text-align:left;">Point Pelanggaran</td>
                </tr>
                <!-- ==== PHP Loop Data ==== -->
                <?php
                $no = 0;
                if (is_array($pdn_dataSanksi) || is_object($pdn_dataSanksi)) {
                foreach($pdn_dataSanksi as $row) {
                    $no++;
                ?>
                    <tr>
                        <td style="text-align:center;"><?= $no; ?></td>
                        <td><?= pdn_tgl_default($row->tanggal); ?></td>
                        <td><?= $row->pelanggaran_nama; ?></td>
                        <td style="text-align:center;"><?= $row->pelanggaran_point; ?></td>
                    </tr>
                <?php } } ?>
                <!-- ==== JUMLAH POINT ==== -->
                 <tr>
                    <td colspan="3" style="text-align:right;">Jumlah Point :</td>
                    <td style="text-align:center;"><?=$pdn_jmlPoint;?></td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align:left;">Point Remisi</td>
                </tr>
                <!-- ==== PHP Loop Data ==== -->
                <?php
                $no = 0;
                if (is_array($pdn_dataRemisi) || is_object($pdn_dataRemisi)) {
                foreach($pdn_dataRemisi as $row) {
                    $no++;
                ?>
                    <tr>
                        <td style="text-align:center;"><?= $no; ?></td>
                        <td><?= pdn_tgl_default($row->tanggal); ?></td>
                        <td><?= $row->keterangan; ?></td>
                        <td style="text-align:center;">- <?= $row->jml_remisi; ?></td>
                    </tr>
                <?php } } ?>
                <!-- ==== JUMLAH REMISI ==== -->
                <tr>
                    <td colspan="3" style="text-align:right;">Jumlah Remisi :</td>
                    <td style="text-align:center;">- <?=$pdn_jmlRemisi;?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Total Point :</td>
                    <td style="text-align:center;"><?=$pdn_totalPoint;?></td>
                </tr>
            </tbody>
        </table>
        <table class="ttd" width="100%" style="width:100%; margin-top: 60px;">
            <tbody>
                <tr>
                    <td width="75%" style="width:75%">&nbsp;</td>
                    <td>
                        <b>Jakarta, <?=date('d-m-Y');?></b><br/>
                        Mengetahui,<br/>
                        Koordinator Tanse<br/>
                        <br/>
                        <br/>
                        <br/>
                        <?= env('PDN_KOORDINATOR_TANSE', 'Koordinator Default');?>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
