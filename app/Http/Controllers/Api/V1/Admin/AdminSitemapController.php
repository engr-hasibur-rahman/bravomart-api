<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Sitemap;
use App\Services\SitemapService;
use Illuminate\Http\Request;

class AdminSitemapController
{
    public function generate(SitemapService $sitemapService)
    {
        $sitemap = $sitemapService->generate();

        return response()->json([
            'message' => 'Sitemap generated successfully',
            'sitemap' => $sitemap
        ]);
    }

    public function list()
    {
        return Sitemap::orderBy('generated_at', 'desc')->get()->map(function ($sitemap) {
            return [
                'name' => $sitemap->filename,
                'date' => $sitemap->generated_at->format('d F Y - H:i:s'),
                'size' => $sitemap->size_kb . ' KB',
                'url'  => url($sitemap->filename),
            ];
        });
    }

    public function download($filename)
    {
        $path = public_path($filename);

        if (!file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return response()->download($path);
    }
}
