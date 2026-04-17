import * as CookieConsent from 'vanilla-cookieconsent'
import 'vanilla-cookieconsent/dist/cookieconsent.css'

export function useCookieConsent() {
    function init() {
        CookieConsent.run({
            // Délai avant affichage (ms)
            autoShow: true,

            // Catégories de cookies
            categories: {
                necessary: {
                    enabled: true,
                    readOnly: true,    // Non désactivable — obligatoire RGPD
                },
                analytics: {
                    enabled: false,    // Refusé par défaut — opt-in RGPD
                    autoClear: {
                        cookies: [
                            { name: /^_ga/ },
                            { name: '_gid' },
                        ],
                    },
                },
                marketing: {
                    enabled: false,    // Refusé par défaut — opt-in RGPD
                    autoClear: {
                        cookies: [
                            { name: /^_fbp/ },
                            { name: /^_fbc/ },
                        ],
                    },
                },
            },

            language: {
                default: 'fr',
                translations: {
                    fr: {
                        consentModal: {
                            title: 'Nous respectons votre vie privée',
                            description:
                                'Nous utilisons des cookies pour assurer le bon fonctionnement du site, mesurer notre audience et, avec votre accord, vous proposer des contenus personnalisés. Vous pouvez accepter, refuser ou personnaliser vos choix à tout moment.',
                            acceptAllBtn: 'Tout accepter',
                            acceptNecessaryBtn: 'Tout refuser',
                            showPreferencesBtn: 'Gérer mes préférences',
                            footer: `
                                <a href="/privacy" target="_blank">Politique de confidentialité</a>
                            `,
                        },
                        preferencesModal: {
                            title: 'Préférences de confidentialité',
                            acceptAllBtn: 'Tout accepter',
                            acceptNecessaryBtn: 'Tout refuser',
                            savePreferencesBtn: 'Enregistrer mes choix',
                            closeIconLabel: 'Fermer',
                            serviceCounterLabel: 'Service|Services',
                            sections: [
                                {
                                    title: 'Vos choix en matière de confidentialité',
                                    description:
                                        'Vous pouvez choisir librement d\'activer ou de désactiver chaque catégorie de cookies. Les cookies nécessaires ne peuvent pas être désactivés car ils garantissent le fonctionnement essentiel du site.',
                                },
                                {
                                    title: 'Cookies nécessaires <span class="pm__badge">Toujours actifs</span>',
                                    description:
                                        'Ces cookies sont indispensables au bon fonctionnement du site : gestion du panier, authentification, sécurité de la session. Ils ne peuvent pas être désactivés.',
                                    linkedCategory: 'necessary',
                                    cookieTable: {
                                        headers: {
                                            name: 'Cookie',
                                            domain: 'Domaine',
                                            expiration: 'Durée',
                                            description: 'Description',
                                        },
                                        body: [
                                            {
                                                name: 'jewellerystore_session',
                                                domain: window.location.hostname,
                                                expiration: '2 heures',
                                                description: 'Cookie de session Laravel (panier, authentification)',
                                            },
                                            {
                                                name: 'XSRF-TOKEN',
                                                domain: window.location.hostname,
                                                expiration: 'Session',
                                                description: 'Protection contre les attaques CSRF',
                                            },
                                        ],
                                    },
                                },
                                {
                                    title: 'Cookies analytiques',
                                    description:
                                        'Ces cookies nous permettent de mesurer l\'audience du site et d\'améliorer nos services en analysant comment vous utilisez le site. Toutes les données sont anonymisées.',
                                    linkedCategory: 'analytics',
                                    cookieTable: {
                                        headers: {
                                            name: 'Cookie',
                                            domain: 'Domaine',
                                            expiration: 'Durée',
                                            description: 'Description',
                                        },
                                        body: [
                                            {
                                                name: '_ga',
                                                domain: 'google.com',
                                                expiration: '2 ans',
                                                description: 'Google Analytics — identifiant de visiteur unique',
                                            },
                                            {
                                                name: '_gid',
                                                domain: 'google.com',
                                                expiration: '24 heures',
                                                description: 'Google Analytics — session de visite',
                                            },
                                        ],
                                    },
                                },
                                {
                                    title: 'Cookies marketing',
                                    description:
                                        'Ces cookies permettent d\'afficher des publicités personnalisées sur d\'autres sites et de mesurer l\'efficacité de nos campagnes. Ils sont déposés par des partenaires tiers.',
                                    linkedCategory: 'marketing',
                                    cookieTable: {
                                        headers: {
                                            name: 'Cookie',
                                            domain: 'Domaine',
                                            expiration: 'Durée',
                                            description: 'Description',
                                        },
                                        body: [
                                            {
                                                name: '_fbp',
                                                domain: 'facebook.com',
                                                expiration: '3 mois',
                                                description: 'Facebook Pixel — suivi des conversions',
                                            },
                                        ],
                                    },
                                },
                                {
                                    title: 'En savoir plus',
                                    description:
                                        'Pour toute question concernant notre politique d\'utilisation des cookies, consultez notre <a href="/privacy" class="cc__link">politique de confidentialité</a> ou <a href="/contact" class="cc__link">contactez-nous</a>.',
                                },
                            ],
                        },
                    },
                },
            },
        })
    }

    return { init }
}
