<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $disk = Storage::disk('public');
        $rawFiles = $disk->allFiles();

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
        $files = [];

        foreach ($rawFiles as $path) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExtensions)) {
                continue;
            }

            $size = $disk->size($path);
            $lastModified = $disk->lastModified($path);

            $files[] = [
                'path'          => $path,
                'name'          => basename($path),
                'url'           => Storage::url($path),
                'size_formatted'=> $this->formatBytes($size),
                'size_raw'      => $size,
                'last_modified' => date('d/m/Y H:i', $lastModified),
                'folder'        => dirname($path),
            ];
        }

        // Sort latest first
        usort($files, fn($a, $b) => strcmp($b['path'], $a['path']));

        // Search filter if provided
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $files = array_filter($files, function ($f) use ($search) {
                return str_contains(strtolower($f['name']), $search) || str_contains(strtolower($f['folder']), $search);
            });
        }

        return view('admin.media.index', compact('files'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->path;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return back()->with('success', 'Ficheiro de imagem eliminado com sucesso!');
        }

        return back()->with('error', 'Ficheiro não encontrado.');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
