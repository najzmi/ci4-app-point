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
    @page {
        size: A4;
        margin: 10mm 12mm;
    }

    @media print {
        body {
            margin: 0;
            /* font-family: Arial, sans-serif; */
            font-family: 'Poppins', sans-serif;
            color: #000;
        }

        h2, hr, .info {
            page-break-after: avoid;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            page-break-inside: auto; /* ubah dari avoid -> auto */
        }

        thead {
            display: table-header-group; /* supaya header muncul di tiap halaman */
        }

        tbody {
            display: table-row-group;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th, td {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            border: 1px solid #000;
            padding: 6px 8px;
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

    tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    table.ttd, 
    table.ttd td, 
    table.ttd th {
        border: none !important;
        border-collapse: collapse;
    }
</style>
    </head>
    <!-- <body onload="window.print()"> -->
    <body>
        <center>
        <h2 style="font-size: 32px;"><?= env('PDN_NAMA_SEKOLAH', 'Nama Sekolah Default');?></h2>
        <h3 style="font-size: 24px;">LAPORAN MURID DENGAN POINT DIATAS 25</h3>
        <br/>
        <hr>
        <br/>
        <br/>
        </center>
        <!-- ==== Tabel Pelanggaran ==== -->
        <table class="data">
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:18%; text-align:left;">NIS</th>
                    <th style="text-align:left;">Nama Murid</th>
                    <th style="text-align:left;">Kelas</th>
                    <th style="width:10%;">Point</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                if (is_array($dataMurid) || is_object($dataMurid)) {
                foreach ($dataMurid as $row){
                    $no ++;
                ?>
                    <tr>
                        <td style="text-align:center;" ><?=$no;?></td>
                        <td><?=$row['murid_nis'];?></td>
                        <td><?=$row['murid_nama'];?></td>
                        <td><?=$row['kelas_nama'];?> <?=$row['kelas_subnama'];?></td>
                        <td style="text-align:center;" ><?=$row['total_point'];?></td>
                    </tr>
                <?php } } ?>
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
