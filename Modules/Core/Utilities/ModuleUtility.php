<?php

namespace Modules\Core\Utilities;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\Core\Contracts\ModuleUtilityContract;
use Nwidart\Modules\Contracts\RepositoryInterface;

class ModuleUtility implements ModuleUtilityContract
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    protected $entity_path = 'Entities';

    protected $modals_path = 'Http/Livewire/Modals';

    /**
     * ModuleUtility constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllEntities($module = null)
    {
        $entities = [];

        if ($module) {

            $module = $this->repository->find($module);

            $moduleEntities = File::glob($module->getExtraPath($this->entity_path) . '/*.php');

            foreach ($moduleEntities as $entity) {

                $entities[] = str_replace([base_path(''), '/', '.php'], ['', '\\', ''], $entity);
            }

        } else {

            $modules = $this->repository->all();

            foreach ($modules as $module) {

                $moduleEntities = File::glob($module->getExtraPath($this->entity_path) . '/*.php');

                foreach ($moduleEntities as $entity) {

                    $entities[] = str_replace([base_path(''), '/', '.php'], ['', '\\', ''], $entity);
                }

            }

        }

        return $entities;
    }

    public function loadLivewireModals()
    {
        $modals = [];

        $modules = $this->repository->all();

        foreach ($modules as $module) {

            $moduleModals = File::glob($module->getExtraPath($this->modals_path) . '/*.php');

            foreach ($moduleModals as $modal) {

                $modals[] = str_replace([base_path(''), '/', '.php'], ['', '\\', ''], $modal);
            }

        }

        return $modals;
    }

    public function modulesDropdown()
    {
        $modules = [];

        foreach ($this->repository->all() as $module) {
            $modules = Arr::add($modules,
                $module->getName(),
                $module->getLowerName()
            );
        }

        return $modules;
    }
}
