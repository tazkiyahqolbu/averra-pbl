<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controller
{
    public function index()
    {
        // Data Layanan untuk Halaman Utama
        $services = [
            ['icon' => 'heart', 'title' => 'Paket Pernikahan', 'desc' => 'Rangkaian acara adat lengkap dari akad hingga resepsi dengan sentuhan Minangkabau.'],
            ['icon' => 'sparkles', 'title' => 'Hiburan / Acara', 'desc' => 'Konsep hiburan untuk syukuran, ulang tahun, dan perayaan keluarga.'],
            ['icon' => 'mic', 'title' => 'Master of Ceremony', 'desc' => 'MC dwibahasa berpengalaman, membawa acara dengan elegan dan berwibawa.'],
            ['icon' => 'guitar', 'title' => 'Band & Akustik', 'desc' => 'Iringan musik live, dari akustik intim hingga band full untuk panggung besar.'],
            ['icon' => 'music', 'title' => 'Pertunjukan Tari', 'desc' => 'Tari Piring, Pasambahan, Indang, dan repertoar khas ranah Minang.'],
            ['icon' => 'brush', 'title' => 'Makeup & Busana', 'desc' => 'Tata rias pengantin tradisional dan modern oleh perias profesional.'],
        ];

        // Data Kostum untuk Halaman Utama (Slider/Preview)
        $costumes = [
            ['img' => 'Resepsi.jpeg', 'name' => 'Resepsi', 'cat' => 'Wedding'],
            ['img' => 'MC.jpeg', 'name' => 'MC', 'cat' => 'Stage & MC'],
            ['img' => 'Busana tari.jpeg', 'name' => 'Busana Tari', 'cat' => 'Dance Attire'],
            ['img' => 'Baju adat.jpeg', 'name' => 'Busana Adat', 'cat' => 'Traditional Attire'],
        ];

        // Mengarah langsung ke file resources/views/home.blade.php Anda
        return view('home', compact('services', 'costumes'));
    }
}