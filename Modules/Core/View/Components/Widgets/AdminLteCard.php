<?php

namespace Modules\Core\View\Components\Widgets;

use JeroenNoten\LaravelAdminLte\View\Components\Widget\Card;

class AdminLteCard extends Card
{
    /**
     * The loading spinner for card.
     *
     * @var string
     */
    public $loading;

    public function __construct(
        $title = null, $icon = null, $theme = null, $themeMode = null,
        $headerClass = null, $bodyClass = null, $footerClass = null,
        $disabled = null, $collapsible = null, $removable = null,
        $maximizable = null, $loading = null)
    {
        $this->loading = $loading;
        parent::__construct($title, $icon, $theme, $themeMode, $headerClass, $bodyClass, $footerClass, $disabled,
            $collapsible, $removable, $maximizable);
    }

}
