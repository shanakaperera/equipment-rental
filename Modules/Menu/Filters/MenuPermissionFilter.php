<?php

namespace Modules\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Laratrust\Laratrust;

class MenuPermissionFilter implements FilterInterface
{
    /**
     * @var Laratrust
     */
    private $user;

    /**
     * MenuPermissionFilter constructor.
     * @param Laratrust $user
     */
    public function __construct(Laratrust $user)
    {
        $this->user = $user;
    }

    /**
     * Transforms a menu item in some way.
     *
     * @param array $item A menu item
     * @return array The transformed menu item
     */
    public function transform($item)
    {
        if (isset($item['permission']) && !$this->user->isAbleTo($item['permission'])) {
            $item['restricted'] = true;
        }

        return $item;
    }
}
