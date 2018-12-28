<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('MAIN NAVIGATION');
            $event->menu->add([
                'text' => 'Ads',
                'url' => '#',
                'icon' => 'list',
                'submenu' => [
                    [
                        'text' => 'New Ads',
                        'url' => route('administrator.new.ads.list'),
                    ],
                    [
                        'text' => 'Published Ads',
                        'url' => route('administrator.published.ads.list'),
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'Categories',
                'url' => '#',
                'icon' => 'thumb-tack',
                'submenu' => [
                    [
                        'text' => 'Add New Category',
                        'url' => route('administrator.category.add.get'),
                    ],
                    [
                        'text' => 'All Categories',
                        'url' => route('administrator.category.list'),
                        'active' => ['administrator/categories/list','administrator/categories/list/*', 'administrator/categories/edit/*']
                    ],
                    [
                        'text' => 'Add New Sub Category',
                        'url' => route('administrator.sub-category.add.get'),
                        'active' => ['administrator/sub-categories/add', 'administrator/sub-categories/*/add']
                    ],
                    [
                        'text' => 'All Sub Categories',
                        'url' => route('administrator.sub-category.list'),
                        'active' => ['administrator/sub-categories/list','administrator/sub-categories/list/*', 'administrator/sub-categories/edit/*']
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'Brands',
                'url' => '#',
                'icon' => 'fire',
                'submenu' => [
                    [
                        'text' => 'Add New Brand',
                        'url' =>  route('administrator.brands.add.get'),
                    ],
                    [
                        'text' => 'All Brands',
                        'url' => route('administrator.brands.list'),
                        'active' => ['administrator/brands/list','administrator/brands/list/*', 'administrator/brands/edit/*']
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'Locations',
                'url' => '#',
                'icon' => 'map-marker',
                'submenu' => [
                    [
                        'text' => 'Add New Location',
                        'url' =>  route('administrator.location.add.get'),
                    ],
                    [
                        'text' => 'All Locations',
                        'url' => route('administrator.location.list'),
                        'active' => ['administrator/locations/list','administrator/locations/list/*', 'administrator/locations/edit/*']
                    ],
                    [
                        'text' => 'Add New Sub Location',
                        'url' => route('administrator.sub-location.add.get'),
                        'active' => ['administrator/sub-locations/add', 'administrator/sub-locations/*/add']
                    ],
                    [
                        'text' => 'All Sub Locations',
                        'url' => route('administrator.sub-location.list'),
                        'active' => ['administrator/sub-locations/list', 'administrator/sub-locations/edit/*']
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'Users',
                'url' => '#',
                'icon' => 'user',
                'submenu' => [
                    [
                    'text' => 'Add New User',
                    'url' => '#',
                    ],
                    [
                        'text' => 'All Users',
                        'url' => '#',
                    ]
                ]
            ]);
            $event->menu->add([
                'text' => 'Customers',
                'url' => '#',
                'icon' => 'user-o',
                'submenu' => [
                    [
                        'text' => 'Add New Customer',
                        'url' => '#',
                    ],
                    [
                        'text' => 'All Customers',
                        'url' => '#',
                    ]
                ]
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
