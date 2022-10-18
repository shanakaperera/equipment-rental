<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Livewire\Livewire;
use Modules\Core\Console\SeedFreshSettings;
use Modules\Core\Contracts\ModuleUtilityContract;
use Modules\Core\Utilities\ModuleUtility;
use Modules\Core\View\Components\Widgets\AdminLteCard;
use Modules\Core\View\Components\Widgets\ContentHeader;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

    /**
     * Array with the available form components.
     *
     * @var array
     */
    protected $formComponents = [
        //

    ];

    /**
     * Array with the available tool components.
     *
     * @var array
     */
    protected $toolComponents = [
        // 'modal' => Tool\Modal::class,
    ];

    /**
     * Array with the available widget components.
     *
     * @var array
     */
    protected $widgetComponents = [
        'content-header' => ContentHeader::class,
        'card'           => AdminLteCard::class,

    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->loadComponents();
        $this->loadLivewireModals();
        $this->commands([
            SeedFreshSettings::class
        ]);
        $this->buildSidebarMenu();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        // register utilities
        $this->app->singleton(ModuleUtilityContract::class, ModuleUtility::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    private function loadComponents()
    {
        // Support of x-components is only available for Laravel >= 7.x
        // versions. So, we check if we can load components.

        $canLoadComponents = method_exists(
            'Illuminate\Support\ServiceProvider',
            'loadViewComponentsAs'
        );

        if (!$canLoadComponents) {
            return;
        }

        // Load all the blade-x components.

        $components = array_merge(
            $this->formComponents,
            $this->toolComponents,
            $this->widgetComponents
        );

        $this->loadViewComponentsAs($this->moduleNameLower, $components);
    }

    private function loadLivewireModals()
    {
        $components = $this->app->make(ModuleUtilityContract::class)->loadLivewireModals();

        foreach ($components as $component) {
            Livewire::component($component::getName(), $component);
        }
    }

    private function buildSidebarMenu()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            $event->menu->add([
                'key'        => 'settings',
                'order'      => '4',
                'text'       => 'Settings',
                'icon'       => 'fa fa-screwdriver-wrench',
                'permission' => 'view-system-variable'
            ]);

            $event->menu->addIn('settings',
                [
                    'key'        => 'system-variables',
                    'text'       => 'System Variables',
                    'icon'       => 'fa fa-cogs',
                    'url'        => 'admin/settings',
                    'active'     => ['admin/settings*'],
                    'permission' => 'view-system-variable'
                ]);

        });
    }
}
