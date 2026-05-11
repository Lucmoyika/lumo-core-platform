<?php

namespace App\Support\Modules;

use Illuminate\Support\Arr;
use InvalidArgumentException;

class ModuleRegistry
{
    protected const MODULES = [
        [
            'label' => 'Core',
            'key' => 'core',
            'route_prefix' => 'core',
            'icon' => '⚡',
            'accent' => '#4f46e5',
            'summary' => 'Socle SaaS modulaire avec vitrine, portail et ERP transverse.',
            'audience' => 'Directions, super admins et équipes produit',
            'api_path' => '/api/v1/cores',
            'portal_route' => 'core.portal',
            'erp_route' => 'core.erp',
            'roles' => ['super-admin', 'admin', 'manager'],
            'features' => ['Catalogue modules', 'Navigation centralisée', 'Observabilité transverse'],
            'model' => 'Modules\\Core\\Models\\CoreFeature',
            'policy' => 'Modules\\Core\\Policies\\CoreFeaturePolicy',
        ],
        [
            'label' => 'Analytics',
            'key' => 'analytics',
            'route_prefix' => 'analytics',
            'icon' => '📊',
            'accent' => '#06b6d4',
            'summary' => 'Dashboards, rapports et exports pilotés par des indicateurs temps réel.',
            'audience' => 'Admin, managers et directions métier',
            'api_path' => '/api/v1/analytics',
            'portal_route' => 'analytics.portal',
            'erp_route' => 'analytics.erp',
            'roles' => ['super-admin', 'admin', 'manager'],
            'features' => ['KPIs consolidés', 'Exports PDF / Excel', 'Suivi temps réel'],
            'model' => 'Modules\\Analytics\\Models\\InsightReport',
            'policy' => 'Modules\\Analytics\\Policies\\InsightReportPolicy',
        ],
        [
            'label' => 'Communication',
            'key' => 'communication',
            'route_prefix' => 'communication',
            'icon' => '💬',
            'accent' => '#14b8a6',
            'summary' => 'Messagerie, notifications et salons temps réel pour tous les rôles.',
            'audience' => 'Utilisateurs, support et équipes de coordination',
            'api_path' => '/api/v1/communications',
            'portal_route' => 'communication.portal',
            'erp_route' => 'communication.erp',
            'roles' => ['super-admin', 'admin', 'manager'],
            'features' => ['Canaux privés/publics', 'Alertes instantanées', 'Journal conversationnel'],
            'model' => 'Modules\\Communication\\Models\\CommunicationChannel',
            'policy' => 'Modules\\Communication\\Policies\\CommunicationChannelPolicy',
        ],
        [
            'label' => 'Companies',
            'key' => 'companies',
            'route_prefix' => 'companies',
            'icon' => '🏢',
            'accent' => '#10b981',
            'summary' => 'Référentiel entreprises, RH et stages partenaires dans un ERP unifié.',
            'audience' => 'Administrateurs RH, recruteurs et managers',
            'api_path' => '/api/v1/companies',
            'portal_route' => 'companies.portal',
            'erp_route' => 'companies.erp',
            'roles' => ['super-admin', 'admin', 'manager'],
            'features' => ['Annuaire partenaires', 'Départements et postes', 'Suivi stages'],
            'model' => 'Modules\\Companies\\Models\\CompanyProfile',
            'policy' => 'Modules\\Companies\\Policies\\CompanyProfilePolicy',
        ],
        [
            'label' => 'Ecommerce',
            'key' => 'ecommerce',
            'route_prefix' => 'ecommerce',
            'icon' => '🛒',
            'accent' => '#f43f5e',
            'summary' => 'Catalogue multi-vendeur, commandes et expérience achat mobile-first.',
            'audience' => 'Clients, vendeurs et équipe opérations',
            'api_path' => '/api/v1/ecommerce-products',
            'portal_route' => 'ecommerce.portal',
            'erp_route' => 'ecommerce.erp',
            'roles' => ['super-admin', 'admin', 'manager', 'vendor'],
            'features' => ['Catalogue vendeur', 'Commandes et wishlist', 'Coupons promotionnels'],
            'model' => 'Modules\\Ecommerce\\Models\\CatalogProduct',
            'policy' => 'Modules\\Ecommerce\\Policies\\CatalogProductPolicy',
        ],
        [
            'label' => 'Jobs',
            'key' => 'jobs',
            'route_prefix' => 'jobs',
            'icon' => '💼',
            'accent' => '#f59e0b',
            'summary' => 'Offres d’emploi, matching et suivi recrutement dans un portail unique.',
            'audience' => 'Recruteurs, candidats et HRBP',
            'api_path' => '/api/v1/jobs',
            'portal_route' => 'jobs.portal',
            'erp_route' => 'jobs.erp',
            'roles' => ['super-admin', 'admin', 'manager', 'recruiter'],
            'features' => ['Pipeline candidatures', 'Matching compétences', 'Suivi embauche'],
            'model' => 'Modules\\Jobs\\Models\\JobListing',
            'policy' => 'Modules\\Jobs\\Policies\\JobListingPolicy',
        ],
        [
            'label' => 'Logistics',
            'key' => 'logistics',
            'route_prefix' => 'logistics',
            'icon' => '🚚',
            'accent' => '#f97316',
            'summary' => 'Tracking, affectation chauffeurs et exécution des livraisons.',
            'audience' => 'Clients, dispatchers et chauffeurs',
            'api_path' => '/api/v1/shipments',
            'portal_route' => 'logistics.portal',
            'erp_route' => 'logistics.erp',
            'roles' => ['super-admin', 'admin', 'manager'],
            'features' => ['Tracking colis', 'Gestion tournées', 'Cartographie opérations'],
            'model' => 'Modules\\Logistics\\Models\\DeliveryShipment',
            'policy' => 'Modules\\Logistics\\Policies\\DeliveryShipmentPolicy',
        ],
        [
            'label' => 'Payment',
            'key' => 'payment',
            'route_prefix' => 'payment',
            'icon' => '💳',
            'accent' => '#8b5cf6',
            'summary' => 'Wallet, paiements scolaires, ecommerce et contrôle anti-fraude.',
            'audience' => 'Comptables, clients et administrateurs financiers',
            'api_path' => '/api/v1/payments',
            'portal_route' => 'payment.portal',
            'erp_route' => 'payment.erp',
            'roles' => ['super-admin', 'admin', 'manager', 'accountant'],
            'features' => ['Wallet omnicanal', 'Mobile money', 'Journal anti-fraude'],
            'model' => 'Modules\\Payment\\Models\\WalletTransaction',
            'policy' => 'Modules\\Payment\\Policies\\WalletTransactionPolicy',
        ],
        [
            'label' => 'School',
            'key' => 'school',
            'route_prefix' => 'school',
            'icon' => '🎓',
            'accent' => '#6366f1',
            'summary' => 'Smart School ERP: admissions, classes, évaluations et communication.',
            'audience' => 'Admins école, enseignants, parents et élèves',
            'api_path' => '/api/v1/schools',
            'portal_route' => 'school.portal',
            'erp_route' => 'school.erp',
            'roles' => ['super-admin', 'admin', 'manager', 'teacher'],
            'features' => ['Admissions en ligne', 'Structure académique', 'Bulletins & finances'],
            'model' => 'Modules\\School\\Models\\AcademicProgram',
            'policy' => 'Modules\\School\\Policies\\AcademicProgramPolicy',
        ],
        [
            'label' => 'University',
            'key' => 'university',
            'route_prefix' => 'university',
            'icon' => '🏛️',
            'accent' => '#3b82f6',
            'summary' => 'Admissions, parcours licence-master-doctorat et recherche académique.',
            'audience' => 'Étudiants, enseignants et administration universitaire',
            'api_path' => '/api/v1/universities',
            'portal_route' => 'university.portal',
            'erp_route' => 'university.erp',
            'roles' => ['super-admin', 'admin', 'manager', 'teacher'],
            'features' => ['Parcours LMD', 'Calendrier académique', 'Recherche & thèses'],
            'model' => 'Modules\\University\\Models\\UniversityProgram',
            'policy' => 'Modules\\University\\Policies\\UniversityProgramPolicy',
        ],
    ];

    public static function all(): array
    {
        return self::MODULES;
    }

    public static function find(string $key): array
    {
        $module = Arr::first(self::MODULES, fn (array $module): bool => $module['key'] === $key);

        if (! $module) {
            throw new InvalidArgumentException(sprintf('Unknown module [%s].', $key));
        }

        return $module;
    }

    public static function navigation(): array
    {
        return array_map(fn (array $module): array => [
            'label' => $module['label'],
            'route' => $module['route_prefix'].'.home',
            'icon' => $module['icon'],
            'accent' => $module['accent'],
        ], self::MODULES);
    }
}
