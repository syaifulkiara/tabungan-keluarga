<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka) {
        $angka = (float) $angka; // pastikan float agar bisa dicek

        // Cek apakah ada desimal lebih dari 0
        if (floor($angka) != $angka) {
            return 'Rp ' . number_format($angka, 2, ',', '.');
        } else {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }
    }

}
