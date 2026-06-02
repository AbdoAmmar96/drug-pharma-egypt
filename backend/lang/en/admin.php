<?php

return [
    'brand_name' => 'Drug Pharma — Admin',

    'dashboard' => [
        'title' => 'Dashboard',
    ],

    'nav' => [
        'catalog'       => 'Catalog',
        'communication' => 'Communication',
    ],

    // Categories
    'category' => [
        'singular'       => 'Category',
        'plural'         => 'Categories',
        'fields' => [
            'name'        => 'Name',
            'slug'        => 'Slug',
            'description' => 'Description',
            'icon'        => 'Icon (emoji)',
            'sort_order'  => 'Sort Order',
            'is_active'   => 'Active',
            'created_at'  => 'Created',
        ],
    ],

    // Products
    'product' => [
        'singular' => 'Product',
        'plural'   => 'Products',
        'tabs' => [
            'basics'     => 'Basics',
            'details'    => 'Details',
            'image'      => 'Image',
            'visibility' => 'Visibility',
        ],
        'fields' => [
            'name'        => 'Name',
            'slug'        => 'Slug',
            'category'              => 'Primary Category',
            'category_help'         => 'The main category this product belongs to.',
            'extra_categories'      => 'Additional Categories',
            'extra_categories_help' => 'Optional — show this product in other categories as well.',
            'form'                  => 'Form (e.g., Tablet, Syrup)',
            'description' => 'Description',
            'composition' => 'Composition',
            'uses'        => 'Uses',
            'dose'        => 'Dose',
            'image'       => 'Product Image',
            'is_featured' => 'Featured',
            'is_active'   => 'Active',
            'sort_order'  => 'Sort Order',
        ],
    ],

    // Messages
    'message' => [
        'singular' => 'Message',
        'plural'   => 'Messages',
        'fields' => [
            'name'       => 'From',
            'email'      => 'Email',
            'phone'      => 'Phone',
            'topic'      => 'Topic',
            'message'    => 'Message',
            'status'     => 'Status',
            'created_at' => 'Received',
        ],
    ],

    // Widgets / dashboard
    'widget' => [
        'total_products'    => 'Total Products',
        'active_categories' => 'Active Categories',
        'unread_messages'   => 'Unread Messages',
        'featured_products' => 'Featured Products',
        'latest_messages'   => 'Latest Messages',
    ],
];
