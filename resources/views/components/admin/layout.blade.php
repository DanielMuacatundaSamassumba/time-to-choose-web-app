@props(['title' => 'Admin', 'breadcrumb' => null, 'styles' => ''])

@php
    // Reuse admin/layout.blade.php as a named component
@endphp

@include('admin.layout', [
    'title'      => $title,
    'breadcrumb' => $breadcrumb,
    'slot'       => $slot,
    'styles'     => $styles,
])
