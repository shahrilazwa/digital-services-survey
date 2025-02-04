<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     */
    public static function menu(): array
    {
        return [
            'administration' => [
                'icon' => 'settings',
                'title' => 'Administration',
                'sub_menu' => [
                    'permission' => [
                        'icon' => 'key-round',
                        'route_name' => 'permissions.index',
                        'title' => 'Permission'
                    ],
                    'role' => [
                        'icon' => 'contact',
                        'route_name' => 'roles.index',
                        'title' => 'Roles'
                    ],
                    'user' => [
                        'icon' => 'Users',
                        'route_name' => 'users.index',
                        'title' => 'Users'
                    ],
                    'service-tags' => [
                        'icon' => 'tags',
                        'route_name' => 'tags.index',
                        'title' => 'Service Tags'
                    ],                                             
                    'organization' => [
                        'icon' => 'landmark',
                        'route_name' => 'organizations.index',
                        'title' => 'Organizations'
                    ], 
                    'agency' => [
                        'icon' => 'building-2',
                        'route_name' => 'agencies.index',
                        'title' => 'Agencies'
                    ],
                    'digital-platforms' => [
                        'icon' => 'tablet-smartphone',
                        'route_name' => 'digital-platforms.index',
                        'title' => 'Digital Platforms'
                    ],
                    'digital-services' => [
                        'icon' => 'hand',
                        'route_name' => 'digital-services.index',
                        'title' => 'Digital Services'
                    ]                                                                             
                ]                                
            ],
            'survey' => [
                'icon' => 'scroll-text',
                'title' => 'Survey',
                'sub_menu' => [
                    'create survey' => [
                        'icon' => 'hammer',
                        'route_name' => 'schemas.index',
                        'title' => 'Design Survey'
                    ],
                    'publish-surveys' => [
                        'icon' => 'send',
                        'route_name' => 'publish-surveys.index',
                        'title' => 'Publish Survey'
                    ]                    
                ]                
            ]            
        ];
    }
}
