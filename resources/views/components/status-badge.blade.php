<?php
/**
 * Blade Component: Status Badge
 * 
 * Menampilkan badge status dengan warna yang konsisten
 * Untuk berita (draft/published) dan pengumuman (aktif/tidak_aktif)
 * 
 * @param string $status - Status value
 * @param string $type - berita|pengumuman
 */

$beritaColors = [
    'published' => 'bg-green-100 text-green-700',
    'draft' => 'bg-yellow-100 text-yellow-700',
];

$pengumumanColors = [
    'aktif' => 'bg-green-100 text-green-700',
    'tidak_aktif' => 'bg-gray-100 text-gray-600',
];

$beritaLabels = [
    'published' => 'Published',
    'draft' => 'Draft',
];

$pengumumanLabels = [
    'aktif' => 'Aktif',
    'tidak_aktif' => 'Tidak Aktif',
];

$type = $type ?? 'berita';
$colors = $type === 'pengumuman' ? $pengumumanColors : $beritaColors;
$labels = $type === 'pengumuman' ? $pengumumanLabels : $beritaLabels;

$colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-600';
$label = $labels[$status] ?? $status;
?>

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
    {{ $label }}
</span>
