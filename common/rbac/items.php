<?php
return [
    'seeContragentPage' => [
        'type' => 2,
        'description' => 'See contragent page',
    ],
    'seeAdminPage' => [
        'type' => 2,
        'description' => 'See admin page',
    ],
    'contragent' => [
        'type' => 1,
        'children' => [
            'seeContragentPage',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'seeAdminPage',
        ],
    ],
];
