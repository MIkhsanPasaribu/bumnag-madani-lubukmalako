<?php
/**
 * Blade Component: Prioritas Badge
 * 
 * Menampilkan badge prioritas dengan warna yang konsisten
 * Menghilangkan duplikasi kode badge di views
 * 
 * @param string $prioritas - rendah|sedang|tinggi
 * @param string $size - sm|md|lg
 * @param bool $showLabel - Tampilkan teks "Prioritas" atau tidak
 */

$colors = [
    'tinggi' => 'bg-red-100 text-red-700',
    'sedang' => 'bg-yellow-100 text-yellow-700',
    'rendah' => 'bg-green-100 text-green-700',
];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-xs',
    'lg' => 'px-3 py-1.5 text-sm',
];

$colorClass = $colors[$prioritas] ?? 'bg-gray-100 text-gray-700';
$sizeClass = $sizes[$size ?? 'md'];
$label = $showLabel ?? false ? 'Prioritas ' : '';
?>

<span class="inline-flex items-center rounded-full font-semibold {{ $colorClass }} {{ $sizeClass }}">
    {{ $label }}{{ ucfirst($prioritas) }}
</span>
