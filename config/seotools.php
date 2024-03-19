<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "خرید آنلاین و حضوری پوشاک زنانه", // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'فروشگاه اینترنتی پوشاک زنانه صوفیا,خرید آنلاین انواع شومیز ها و ست ها مناسب تمامی فصول از تابستان گرفته تا زمستان در تمامی سایز ها با قیمت مناسب ',
            'separator'    => ' | ',
            'keywords'     => ['پوشاک زنانه صوفیا','شومیز', 'شلوار', 'مانتو','شال','لباس زنانه','فروشگاه','فروشگاه لباس زنانه','صوفیا','پوشاک','پوشاک صوفیا','خرید آنلاین','shop','sofia','آنلاین شاپ','آنلاین','online'],
            'canonical'    => false, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => false, // set false to total remove
            'description' => 'فروشگاه اینترنتی پوشاک زنانه صوفیا,خرید آنلاین انواع شومیز ها و ست ها مناسب تمامی فصول از تابستان گرفته تا زمستان در تمامی سایز ها با قیمت مناسب ', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => 'فروشگاه اینترنتی صوفیا',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary',
             'site'        => '@sofiawomanwear',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => False,
            'description' => False,
            'url'         => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
