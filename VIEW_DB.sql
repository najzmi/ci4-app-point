-- TB GURU
CREATE OR REPLACE VIEW v_guru AS
SELECT
    tb1.id,
    tb1.guru_nama,
    tb1.guru_telpon,
    tb2.mapel_nama,
    tb2.keterangan
FROM guru tb1
LEFT JOIN mapel tb2 ON tb1.id_mapel = tb2.id;

-- TB MURID
CREATE OR REPLACE VIEW v_murid AS
SELECT
    tb1.id,
    tb1.id_kelas,
    tb1.murid_nama,
    tb1.murid_nis,
    tb1.murid_telpon,
    tb2.kelas_nama,
    tb2.kelas_subnama
FROM murid tb1
LEFT JOIN kelas tb2 ON tb1.id_kelas = tb2.id;

-- TB SANKSI
CREATE OR REPLACE VIEW v_sanksi AS
SELECT
    tb1.id,
    tb1.id_murid,
    tb1.tanggal,
    tb1.nama_pelapor,
    tb1.catatan,
    tb2.murid_nis,
    tb2.murid_nama,
    tb3.pelanggaran_nama,
    tb3.pelanggaran_point,
    tb4.kelas_nama,
    tb4.kelas_subnama
FROM sanksi tb1
LEFT JOIN murid tb2 ON tb1.id_murid = tb2.id
LEFT JOIN pelanggaran tb3 ON tb1.id_pelanggaran = tb3.id
LEFT JOIN kelas tb4 ON tb2.id_kelas = tb4.id;
-- POINT SAJA
CREATE OR REPLACE VIEW v_sanksi_point AS
SELECT
    tb1.id_murid,
    tb2.murid_nis,
    tb2.murid_nama,
    SUM(tb3.pelanggaran_point) as jml_point,
    tb4.kelas_nama,
    tb4.kelas_subnama
FROM sanksi tb1
LEFT JOIN murid tb2 ON tb1.id_murid = tb2.id
LEFT JOIN pelanggaran tb3 ON tb1.id_pelanggaran = tb3.id
LEFT JOIN kelas tb4 ON tb2.id_kelas = tb4.id
GROUP BY tb1.id_murid;

-- TB REMISI
CREATE OR REPLACE VIEW v_remisi AS
SELECT
    tb1.id,
    tb1.id_murid,
    tb1.tanggal,
    tb1.jml_remisi,
    tb1.keterangan,
    tb2.murid_nama,
    tb2.murid_nis,
    tb3.kelas_nama,
    tb3.kelas_subnama
FROM remisi tb1
LEFT JOIN murid tb2 ON tb1.id_murid = tb2.id
LEFT JOIN kelas tb3 ON tb2.id_kelas = tb3.id;
-- POINT REMISI
CREATE OR REPLACE VIEW v_remisi_point AS
SELECT
    tb1.id_murid,
    SUM(tb1.jml_remisi) jml_remisi,
    tb2.murid_nama,
    tb2.murid_nis,
    tb3.kelas_nama,
    tb3.kelas_subnama
FROM remisi tb1
LEFT JOIN murid tb2 ON tb1.id_murid = tb2.id
LEFT JOIN kelas tb3 ON tb2.id_kelas = tb3.id
GROUP BY tb1.id_murid;

-- TOTAL POINT
CREATE OR REPLACE VIEW v_total_point AS
SELECT
    sp.id_murid as id,
    sp.murid_nis,
    sp.murid_nama,
    sp.kelas_nama,
    sp.kelas_subnama,
    sp.jml_point,
    IFNULL(rp.jml_remisi, 0) AS jml_remisi,
    (sp.jml_point - IFNULL(rp.jml_remisi, 0)) AS total_point
FROM v_sanksi_point sp
LEFT JOIN v_remisi_point rp ON sp.id_murid = rp.id_murid
WHERE sp.jml_point > IFNULL(rp.jml_remisi, 0);

-- TAMPILKAN POINT DIATAS 25
CREATE OR REPLACE VIEW v_pointlebih AS
SELECT
  id,
  murid_nis,
  murid_nama,
  kelas_nama,
  kelas_subnama,
  total_point
FROM v_total_point
WHERE total_point >= 25;

-- DATABASE
CREATE TABLE `kelas` (
  `id` int(11) UNSIGNED NOT NULL,
  `kelas_nama` enum('Kelas 7','Kelas 8','Kelas 9','Kelas 10','Kelas 11','Kelas 12') NOT NULL,
  `kelas_subnama` varchar(254) NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `murid` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `murid_nis` varchar(32) NOT NULL,
  `murid_nama` varchar(254) NOT NULL,
  `murid_telpon` varchar(32) NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sanksi` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_murid` int(11) UNSIGNED NOT NULL,
  `id_pelanggaran` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `nama_pelapor` varchar(254) NOT NULL,
  `file_foto` varchar(254) NOT NULL,
  `catatan` varchar(254) NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pelanggaran` (
  `id` int(11) UNSIGNED NOT NULL,
  `pelanggaran_nama` varchar(254) NOT NULL,
  `pelanggaran_point` int(11) UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- By Pudin Saepudin