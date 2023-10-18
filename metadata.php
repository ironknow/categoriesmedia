<?php
/**
 * Metadata file for module
 *
 * @file          metadata.php
 * @package       modules
 * @addtogroup    modules
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id' => 'categoriesmedia',
    'title' => 'Categories Media',
    'description' => [
        'de' => 'Allows to attach media to the categories in the same way like to the articles',
        'en' => 'Allows to attach media to the categories in the same way like to the articles',
    ],
    'thumbnail' => 'logo.png',
    'version' => '1.0.0',
    'author' => 'Ilyaz Khan Mohammed',
    'email' => 'ilyaskhan900@gmail.com',
    'blocks' => [
        [
            'template' => 'include/category_main_form.tpl',
            'block' => 'admin_category_main_form',
            'file' => '/Application/views/admin/blocks/admin_category_main_form.tpl',
        ],
    ],
    'extend' => [
        \OxidEsales\Eshop\Application\Controller\Admin\CategoryMain::class => \test\CategoriesMedia\Application\Controller\Admin\CategoryMain::class,
        \OxidEsales\Eshop\Application\Model\MediaUrl::class => \test\CategoriesMedia\Application\Model\MediaUrl::class,
        \OxidEsales\Eshop\Application\Model\Article::class => \test\CategoriesMedia\Application\Model\Article::class,
        \OxidEsales\Eshop\Application\Model\Category::class => \test\CategoriesMedia\Application\Model\Category::class
    ],
    'events'      => [
        'onActivate'   => '\test\CategoriesMedia\Core\Events::onActivate',
        'onDeactivate' => '\test\CategoriesMedia\Core\Events::onDeactivate',
    ]
];
