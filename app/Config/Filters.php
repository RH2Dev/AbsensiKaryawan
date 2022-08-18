<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\Login;
use App\Filters\CEO;
use App\Filters\HRCEO;
use App\Filters\LogedIn;

use function PHPSTORM_META\map;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'Login' => Login::class,
        'LogedIn' => LogedIn::class,
        'CEO' => CEO::class,
        'HRCEO' => HRCEO::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [

        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
        'Login' => ['before' =>  
            [
                'Admin',
                'Admin/User',
                'Admin/Absen',
                'Admin/Admin',
                'Admin/Izin',
                'Admin/User/*',
                'Admin/Absen/*',
                'Admin/Admin/*',
                'Admin/Izin/*'
            ]
        ],
        'LogedIn' => ['before' => 
            [
                'Admin/Login',
                'Admin/Check'
            ]
        ],
        'CEO' => ['before' => 
            [
                'Admin/Admin',
                'Admin/Admin/*'
            ]
        ],
        'HRCEO' => ['before' => 
            [
                'Admin/User/*'
            ]
        ]
    ];
}
