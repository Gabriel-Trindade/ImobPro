<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\CompanyComposer;
use App\Models\Company;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', CompanyComposer::class);

        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $companiesCount = Company::count();


            $event->menu->addAfter('cadastros_header',[
                'text'        => 'Empresas',
                'url'         => '/companies',
                'icon'        => 'fas fa-building',
                'label'       => $companiesCount,
                'label_color' => 'success',
            ]);
        });
    }
}
