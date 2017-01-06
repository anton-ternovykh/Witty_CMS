<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

\Yii::$container->set('common\services\interfaces\IBlogService', 'common\services\implementations\BlogService');
\Yii::$container->set('common\services\interfaces\IPageService', 'common\services\implementations\PageService');