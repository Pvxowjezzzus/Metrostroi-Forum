<?php

return [
    'main' => [
        'controller' => 'main',
        'action' => 'main'
    ],
    'discussions'=>[
        'controller' => 'forum',
        'action' => 'discussions',
        ],
    'profile'=>[
        'controller' => 'main',
        'action' => 'selfprofile',
    ],
    'profile/{user:\w+}'=>[
        'controller' => 'main',
        'action' => 'profile',
    ],
    'chat'=>[
        'controller' => 'main',
        'action' => 'chat',
    ],
    'discussions/section/{id:\d+}'=>[
        'controller' => 'forum',
        'action' => 'section',
    ],
    'discussions/thread/{id:\d+}'=>[
        'controller' => 'forum',
        'action' => 'thread',
    ],
    'discussions/thread/{id:\d+}/page/{page:\d+}'=>[
        'controller' => 'forum',
        'action' => 'thread',
    ],
    ];


?>