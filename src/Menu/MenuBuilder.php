<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{

    public function __construct(private readonly FactoryInterface $factory)
    {
    }

    public function mainMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('link_list', [
            'route' => 'link_list',
        ]);
        $menu->addChild('checker_log', [
            'route' => 'checker_log_list',
        ]);

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    public function profileMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('profile', [
            'route' => 'profile_edit'
        ]);

        return $menu;
    }
}