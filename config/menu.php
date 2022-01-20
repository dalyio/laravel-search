<?php

return [
    
    'challenge' => [
        'number_chain' => [
            'label' => 'IEL-SE-1',
            'priority' => 200,
            'icon' => 'fa fa-laptop',
            'submenu' => [
                'solution' => [
                    'label' => 'Solution',
                    'url' => '/numberchain/solution'
                ],
                'data' => [
                    'label' => 'Data',
                    'url' => '/numberchain/data'
                ],
            ],
        ],
        'zipcodes' => [
            'label' => 'IEL-SE-2',
            'priority' => 300,
            'icon' => 'fa fa-laptop',
            'submenu' => [
                'solution' => [
                    'label' => 'Solution',
                    'url' => '/zipcodes/solution'
                ],
                /*
                'documentation' => [
                    'label' => 'Documentation',
                    'url' => '/zipcodes/documentation'
                ],
                 * 
                 */
            ],
        ],
    ],
    
];
