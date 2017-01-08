<?php

namespace frontend\services\implementations;


use common\models\Menu;
use common\models\MenuItem;
use common\models\MenuType;
use frontend\services\interfaces\IMenuItemService;

class MenuItemService extends \common\services\implementations\MenuItemService implements IMenuItemService
{

    public function getItems(string $menuType) : array
    {
        $menuQuery = MenuType::find()
            ->joinWith("menus")
            ->joinWith("menus.menuItems")
            ->where(['menu_type.code'=>$menuType])
            ->andWhere(['menu_item.parent_id'=>null])
            ->all();

        $menuResult = [];

        /** @var MenuItem $menuItem */
        foreach ($menuQuery as $menuItem){
            foreach ($menuItem->menus as $menu) {
                foreach ($menu->menuItems as $menuItem){
                    $menuItem = $this->createMenuItem($menuItem);
                    array_push($menuResult, $menuItem);
                }
            }
        }

        return $menuResult;
    }

    /**
     * @param MenuItem $menu
     * @return array
     */
    private function createMenuItem(MenuItem $menu): array{
        return [
            'label' => $menu->title,
//            'url' => ['/'.$menu->page->url], TODO: Add link to page
            'items' => $this->getChildren($menu)
        ];
    }

    /**
     * @param MenuItem $menu
     * @return array|null
     */
    private function getChildren(MenuItem $menu)
    {
        if (count($menu->children) === 0){
            return null;
        }

        $menuItems = [];
        foreach ($menu->children as $menuItem){
            array_push($menuItems, $this->createMenuItem($menuItem));
        }

        return $menuItems;
    }
}