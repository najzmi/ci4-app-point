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



-- DATABASE

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

CREATE TABLE `pelanggaran` (
  `id` int(11) UNSIGNED NOT NULL,
  `pelanggaran_nama` varchar(254) NOT NULL,
  `pelanggaran_point` int(11) UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- By Pudin Saepudin