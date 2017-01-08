<?php

namespace common\models;

use yii;

/**
 * This is the model class for table "{{%menu_item}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $subtitle
 * @property integer $menu_id
 * @property integer $parent_id
 * @property integer $is_visible
 * @property integer $item_order
 *
 * @property Menu $menu
 * @property MenuItem $parent
 * @property MenuItem[] $menuItems
 */
class MenuItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'menu_id'], 'required'],
            [['menu_id', 'parent_id', 'is_visible', 'item_order'], 'integer'],
            [['title', 'subtitle'], 'string', 'max' => 100],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'menu_id' => 'Menu ID',
            'parent_id' => 'Parent ID',
            'is_visible' => 'Is Visible',
            'item_order' => 'Item Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'id']);
    }
}
