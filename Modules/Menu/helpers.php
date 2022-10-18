<?php

if (!function_exists('sort_menu')) {

    /**
     * @param $menuItems
     * @return mixed
     */
    function sort_menu(&$menuItems)
    {
        usort($menuItems, function ($item1, $item2) {
            return $item1['order'] <=> $item2['order'];
        });

        return $menuItems;
    }
}
