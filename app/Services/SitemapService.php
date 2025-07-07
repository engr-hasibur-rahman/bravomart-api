<?php

namespace App\Services;

use Spatie\Sitemap\Sitemap;
use App\Models\Sitemap as SitemapModel;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;


class SitemapService
{
    public function generate(): SitemapModel
    {
        $sitemap = Sitemap::create();
        $baseUrl = config('app.frontend_url'); // We’ll load this from config
        $baseUrlAdmin = config('app.admin_url'); // We’ll load this from config

        $sitemap->add(Url::create($baseUrl . '/')
            ->setLastModificationDate(now())
            ->setPriority(1.0));

        $sitemap->add(Url::create($baseUrl . '/product')
            ->setLastModificationDate(now())
            ->setPriority(0.9));

        $sitemap->add(Url::create($baseUrl . 'store/list')
            ->setLastModificationDate(now())
            ->setPriority(0.8));

        $sitemap->add(Url::create($baseUrlAdmin . '/become-a-seller')
            ->setLastModificationDate(now())
            ->setPriority(0.7));


        $sitemap->add(Url::create($baseUrl . '/product-category/list')
            ->setLastModificationDate(now()));

        $staticPages = [
            'coupon',
            'about-us',
            'contact-us',
            'privacy-policy',
            'terms-conditions',
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(Url::create($baseUrl . "/{$page}")
                ->setLastModificationDate(now()));
        }

        foreach (\App\Models\Product::where('status', 1)->get() as $product) {
            $sitemap->add(Url::create($baseUrl . "/productDetails/{$product->slug}")
                ->setLastModificationDate($product->updated_at));
        }

        foreach (\App\Models\Store::where('status', 1)->get() as $seller) {
            $sitemap->add(Url::create($baseUrl . "/store/details/{$seller->slug}")
                ->setLastModificationDate($seller->updated_at));
        }

        foreach (\App\Models\Blog::all() as $blog) {
            $sitemap->add(Url::create($baseUrl . "/blog/{$blog->slug}")
                ->setLastModificationDate($blog->updated_at));
        }

        // Generate unique filename
        $timestamp = now()->timestamp;
        $filename = "sitemap-{$timestamp}.xml";
        $path = public_path($filename);

        $sitemap->writeToFile($path);

        // Save metadata
        $sizeKb = round(filesize($path) / 1024, 2);

        return SitemapModel::create([
            'filename' => $filename,
            'generated_at' => now(),
            'size_kb' => $sizeKb,
        ]);
    }
}
