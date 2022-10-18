<?php

namespace Modules\Core\Contracts;

interface ModuleUtilityContract
{
    public function getAllEntities($module = null);

    public function loadLivewireModals();

    public function modulesDropdown();
}
