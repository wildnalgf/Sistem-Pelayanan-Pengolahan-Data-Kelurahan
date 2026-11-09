<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/algorithms.php';

// Inisialisasi Data Contoh (Session)
if (!isset($_SESSION['penduduk'])) {
    $_SESSION['penduduk'] = [
        ['nik' => '33720188', 'nama' => 'Cahyo', 'rt_rw' => '01/02', 'umur' => 45, 'pendapatan' => 3500000],
        ['nik' => '33720112', 'nama' => 'Anisa', 'rt_rw' => '03/01', 'umur' => 22, 'pendapatan' => 2100000],
        ['nik' => '33720199', 'nama' => 'Dedi',  'rt_rw' => '02/02', 'umur' => 60, 'pendapatan' => 5000000],
        ['nik' => '33720105', 'nama' => 'Bagas', 'rt_rw' => '01/01', 'umur' => 30, 'pendapatan' => 4200000],
        ['nik' => '33720133', 'nama' => 'Eka',   'rt_rw' => '04/03', 'umur' => 19, 'pendapatan' => 1800000]
    ];
}

if (!isset($_SESSION['kpm_list'])) {
    $_SESSION['kpm_list'] = [
        ['nik' => '33720101', 'nama' => 'Bpk. Ahmad', 'skor_p' => 85, 'kuota_k' => 3000000],
        ['nik' => '33720102', 'nama' => 'Ibu Siti',   'skor_p' => 90, 'kuota_k' => 4500000],
        ['nik' => '33720103', 'nama' => 'Bpk. Budi',  'skor_p' => 60, 'kuota_k' => 2000000],
        ['nik' => '33720104', 'nama' => 'Ibu Ratna',  'skor_p' => 75, 'kuota_k' => 2500000],
        ['nik' => '33720105', 'nama' => 'Bpk. Eko',   'skor_p' => 95, 'kuota_k' => 5000000]
    ];
}

if (!isset($_SESSION['anggaran_B'])) {
    $_SESSION['anggaran_B'] = 8000000;
}

// Aksi Admin
if ($role === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_warga'])) {
        $_SESSION['penduduk'][] = [
            'nik' => $_POST['nik'],
            'nama' => $_POST['nama'],
            'rt_rw' => $_POST['rt_rw'],
            'umur' => (int)$_POST['umur'],
            'pendapatan' => (int)$_POST['pendapatan']
        ];
    } elseif (isset($_POST['delete_warga'])) {
        array_splice($_SESSION['penduduk'], $_POST['index'], 1);
    } elseif (isset($_POST['update_anggaran'])) {
        $_SESSION['anggaran_B'] = (int)$_POST['anggaran_B'];
    }
}

// Eksekusi Algoritma
$key_sort = $_GET['sort_by'] ?? 'nik';
$data_dpt_terurut = mergeSort($_SESSION['penduduk'], $key_sort);
$hasil_greedy = hitungGreedyBansos($_SESSION['kpm_list'], $_SESSION['anggaran_B']);

require_once __DIR__ . '/includes/header.php';
?>

<div class="container">

    <!-- Card Ringkasan Statistik -->
    <div class="metrics-grid">
        <div class="metric-card">
            <span class="metric-title">Total Anggaran Bansos</span>
            <span class="metric-value">Rp <?= number_format($_SESSION['anggaran_B'], 0, ',', '.') ?></span>
        </div>
        <div class="metric-card gold">
            <span class="metric-title">Sisa Anggaran</span>
            <span class="metric-value">Rp <?= number_format($hasil_greedy['sisa_anggaran'], 0, ',', '.') ?></span>
        </div>
        <div class="metric-card">
            <span class="metric-title">Total Tercover</span>
            <span class="metric-value"><?= count($hasil_greedy['terpilih']) ?> KPM</span>
        </div>
        <div class="metric-card gold">
            <span class="metric-title">Total DPT Terdata</span>
            <span class="metric-value"><?= count($_SESSION['penduduk']) ?> Warga</span>
        </div>
    </div>

    <!-- Kasus 1: Greedy Bansos -->
    <div class="card">
        <div class="card-header">
            <h3>📊 Kasus 1: Optimasi Alokasi Dana Bansos (Algoritma Greedy)</h3>
        </div>

        <?php if ($role === 'admin'): ?>
            <form method="POST" class="form-inline">
                <strong>Atur Anggaran:</strong>
                <input type="number" name="anggaran_B" value="<?= $_SESSION['anggaran_B'] ?>" required>
                <button type="submit" name="update_anggaran" class="btn btn-primary">Simpan Anggaran</button>
            </form>
        <?php endif; ?>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Penerima (KPM)</th>
                        <th>Kuota Bantuan (K)</th>
                        <th>Skor Kemiskinan (P)</th>
                        <th>Status Alokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hasil_greedy['terpilih'] as $kpm): ?>
                    <tr>
                        <td><strong><?= $kpm['nik'] ?></strong></td>
                        <td><?= $kpm['nama'] ?></td>
                        <td>Rp <?= number_format($kpm['kuota_k'], 0, ',', '.') ?></td>
                        <td><span class="badge badge-gold">Skor <?= $kpm['skor_p'] ?></span></td>
                        <td><span class="badge badge-teal">Terpilih (Greedy)</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kasus 2: Merge Sort DPT -->
    <div class="card">
        <div class="card-header">
            <h3>🗂️ Kasus 2: Verifikasi & Pengurutan Data DPT (Merge Sort)</h3>
        </div>
        
        <form method="GET" class="form-inline">
            <strong>Urutkan Berdasarkan:</strong>
            <select name="sort_by" onchange="this.form.submit()">
                <option value="nik" <?= $key_sort == 'nik' ? 'selected' : '' ?>>NIK (Default)</option>
                <option value="umur" <?= $key_sort == 'umur' ? 'selected' : '' ?>>Umur</option>
                <option value="pendapatan" <?= $key_sort == 'pendapatan' ? 'selected' : '' ?>>Pendapatan</option>
            </select>
        </form>

        <?php if ($role === 'admin'): ?>
            <div class="form-inline" style="background: #eef7f8;">
                <strong style="width: 100%; color: var(--tsu-teal);">Tambah Data Warga Baru (Admin Access):</strong>
                <form method="POST" style="display:flex; gap:10px; flex-wrap:wrap; width:100%;">
                    <input type="text" name="nik" placeholder="NIK" required>
                    <input type="text" name="nama" placeholder="Nama Lengkap" required>
                    <input type="text" name="rt_rw" placeholder="RT/RW" required style="width: 100px;">
                    <input type="number" name="umur" placeholder="Umur" required style="width: 90px;">
                    <input type="number" name="pendapatan" placeholder="Pendapatan (Rp)" required>
                    <button type="submit" name="add_warga" class="btn btn-primary">+ Tambah Data</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Warga</th>
                        <th>RT / RW</th>
                        <th>Umur</th>
                        <th>Pendapatan / Bulan</th>
                        <?php if ($role === 'admin'): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_dpt_terurut as $idx => $row): ?>
                    <tr>
                        <td><?= $idx + 1 ?></td>
                        <td><strong><?= $row['nik'] ?></strong></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['rt_rw'] ?></td>
                        <td><?= $row['umur'] ?> Tahun</td>
                        <td>Rp <?= number_format($row['pendapatan'], 0, ',', '.') ?></td>
                        <?php if ($role === 'admin'): ?>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="index" value="<?= $idx ?>">
                                <button type="submit" name="delete_warga" class="btn btn-danger" onclick="return confirm('Hapus data warga ini?')">Hapus</button>
                            </form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?> 