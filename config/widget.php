<?php

return [
    
    'numberchains' => [
        
        'layout' => [[
            'type' => 'box',
            'show' => 4,
            'width' => 'calc(25% - 1rem)',
        ], [
            'type' => 'chart',
            'show' => 1,
            'width' => '100%',
        ], [
            'type' => 'grid',
            'show' => 1,
            'width' => 'calc(65% - 1rem)',
        ], [
            'type' => 'grid',
            'show' => 1,
            'width' => 'calc(35% - 1rem)',
        ], [
            'type' => 'chart',
            'show' => 1,
            'width' => '100%',
        ], [
            'type' => 'grid',
            'show' => 1,
            'width' => 'calc(35% - 1rem)',
        ], [
            'type' => 'grid',
            'show' => 1,
            'width' => 'calc(65% - 1rem)',
        ]],
        
        'box' => [
            'indexed_through' => [
                'label' => 'Indexed Through',
                'priority' => 100,
                'style' => [
                    'color' => '#ff0000',
                    'icon' => 'fa fa-cube',
                ],
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'indexedThrough',
                ],
            ],
            'ends_with_1' => [
                'label' => 'Ends With 1',
                'priority' => 200,
                'style' => [
                    'color' => '#ff0000',
                    'icon' => 'fa fa-cube',
                ],
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'countByEndingNumber',
                    'params' => [1],
                ],
            ],
            'ends_with_89' => [
                'label' => 'Ends With 89',
                'priority' => 300,
                'style' => [
                    'color' => '#ff0000',
                    'icon' => 'fa fa-cube',
                ],
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'countByEndingNumber',
                    'params' => [89],
                ],
            ],
            'avg_link_count' => [
                'label' => 'Avg Link Count',
                'priority' => 400,
                'style' => [
                    'color' => '#ff0000',
                    'icon' => 'fa fa-cube',
                ],
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'averageLinkCount',
                ],
            ],
        ],
        
        'chart' => [
            'chainlink_frequency' => [
                'label' => 'Chainlink Frequency',
                'sublabel' => 'not including starting number',
                'view' => 'components.widget.chart.chainlinkFrequency',
                'priority' => 100,
                'style' => [
                    'color' => '#7cb5ec',
                ],
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'chainlinkFrequency',
                ],
            ],
            'chainlink_counts' => [
                'label' => 'Chainlink Counts',
                'view' => 'components.widget.chart.chainlinkCounts',
                'priority' => 200,
                'style' => [
                    'color' => '#7cb5ec',
                ],
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'chainlinkCounts',
                ],
            ],
        ],
        
        'grid' => [
            'longest_numberchains' => [
                'label' => 'Longest Numberchains',
                'view' => 'components.widget.grid.longestNumberchains', 
                'priority' => 100,
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'longestNumberchains',
                    'results_limit' => 15
                ],
            ],
            'most_frequent_chainlinks' => [
                'label' => 'Most Frequent Chainlinks',
                'view' => 'components.widget.grid.mostFrequentChainlinks',
                'priority' => 200,
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'mostFrequentChainlinks',
                    'results_limit' => 15
                ],
            ],
            'most_frequent_2nd_chainlink' => [
                'label' => 'Most Frequent 2nd Chainlink',
                'view' => 'components.widget.grid.mostFrequentChainlinks',
                'priority' => 300,
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'mostFrequentSecondChainlink',
                    'results_limit' => 15
                ],
            ],
            'longest_numberchains_one' => [
                'label' => 'Longest Numberchains Ending With 1',
                'view' => 'components.widget.grid.longestNumberchains',
                'priority' => 400,
                'data' => [
                    'service' => \Dalyio\Challenge\Services\NumberchainData::class,
                    'method' => 'longestNumberchainsByEndingNumber',
                    'params' => [1],
                    'results_limit' => 15
                ],
            ],
        ],
        
    ],
    
];
