<?php

return [
    'content' => [
        'positions' => [
            'name' => 'Vị trí đi đường'
        ],
        'supports' => [
            'name' => 'Các phép bổ trợ'
        ],
        'supplements' => [
            'name' => 'Ngọc bổ trợ'
        ],
        'equipments' => [
            'name' => 'Trang bị'
        ],
        'skills' => [
            'name' => 'Kỹ năng tướng'
        ],
        'characters' => [
            'name' => 'Tướng'
        ],
        'contents' => [
            'name' => 'Guide',
            'modules' => [
                'hot_guide' => 'Hot Guide'
            ]
        ],
    ],
    'users' => [
        'manhquan.do@ved.com.vn' => 'admin',
        'test@example.com' => 'editor'
    ],
    'permission' => [
        'admin' => 'all',
        'editor' => 'positions'
    ],
    'item_per_page' => 10
];