<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    /**
     * Pages statiques : [suffixe de chemin, fréquence de mise à jour, priorité]
     */
    private const STATIC_PAGES = [
        [
            'path'       => '',
            'changefreq' => Url::CHANGE_FREQUENCY_DAILY,
            'priority'   => 1.0,
            'label'      => 'Accueil',
        ],
        [
            'path'       => '/contact',
            'changefreq' => Url::CHANGE_FREQUENCY_MONTHLY,
            'priority'   => 0.6,
            'label'      => 'Contact',
        ],
        [
            'path'       => '/privacy',
            'changefreq' => Url::CHANGE_FREQUENCY_YEARLY,
            'priority'   => 0.3,
            'label'      => 'Politique de confidentialité',
        ],
        [
            'path'       => '/payment-info',
            'changefreq' => Url::CHANGE_FREQUENCY_YEARLY,
            'priority'   => 0.3,
            'label'      => 'Informations de paiement',
        ],
        [
            'path'       => '/products',
            'changefreq' => Url::CHANGE_FREQUENCY_DAILY,
            'priority'   => 0.8,
            'label'      => 'Catalogue produits',
        ],
    ];

    public function index(): Response
    {
        $locales = config('app.available_locales', ['en', 'fr']);
        $baseUrl = rtrim(config('app.url'), '/');

        $sitemap = Sitemap::create();

        foreach (self::STATIC_PAGES as $page) {
            foreach ($locales as $locale) {
                $url = Url::create($baseUrl . '/' . $locale . $page['path'])
                    ->setLastModificationDate(Carbon::now())
                    ->setChangeFrequency($page['changefreq'])
                    ->setPriority($page['priority']);

                // Balises hreflang pour chaque locale disponible
                foreach ($locales as $altLocale) {
                    $url->addAlternate(
                        $baseUrl . '/' . $altLocale . $page['path'],
                        $altLocale
                    );
                }

                $sitemap->add($url);
            }
        }

        return $sitemap->toResponse(request());
    }
}
