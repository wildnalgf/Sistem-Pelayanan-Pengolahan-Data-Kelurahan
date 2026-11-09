<?php
// --- ALGORITMA MERGE SORT (Divide & Conquer) ---
function mergeSort($arr, $key) {
    if (count($arr) <= 1) {
        return $arr;
    }
    $mid   = floor(count($arr) / 2);
    $left  = mergeSort(array_slice($arr, 0, $mid), $key);
    $right = mergeSort(array_slice($arr, $mid), $key);

    return merge($left, $right, $key);
}

function merge($left, $right, $key) {
    $result = [];
    $i = 0; $j = 0;
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i][$key] <= $right[$j][$key]) {
            $result[] = $left[$i]; $i++;
        } else {
            $result[] = $right[$j]; $j++;
        }
    }
    while ($i < count($left)) { $result[] = $left[$i]; $i++; }
    while ($j < count($right)) { $result[] = $right[$j]; $j++; }
    return $result;
}

// --- ALGORITMA GREEDY (Bansos) ---
function hitungGreedyBansos($kpm_list, $anggaran_B) {
    foreach ($kpm_list as $k => $item) {
        $kpm_list[$k]['rasio'] = $item['skor_p'] / $item['kuota_k'];
    }
    
    // Sort descending berdasarkan rasio P/K
    usort($kpm_list, function($a, $b) {
        return $b['rasio'] <=> $a['rasio'];
    });

    $terpilih = [];
    $sisa = $anggaran_B;
    $total_skor = 0;

    foreach ($kpm_list as $item) {
        if ($item['kuota_k'] <= $sisa) {
            $terpilih[] = $item;
            $sisa -= $item['kuota_k'];
            $total_skor += $item['skor_p'];
        }
    }

    return [
        'terpilih' => $terpilih,
        'sisa_anggaran' => $sisa,
        'total_skor' => $total_skor
    ];
}
?>