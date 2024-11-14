INSERT INTO `roles` (
        `id`,
        `available_for`,
        `name`,
        `guard_name`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        'system_level',
        'Super Admin',
        'api',
        '2023-08-11 11:57:33',
        '2023-08-11 11:57:33'
    ),
    (
        2,
        'store_level',
        'Store Owner',
        'api',
        '2023-08-11 11:57:33',
        '2023-08-11 11:57:33'
    ),
    (
        3,
        'store_level',
        'Customer',
        'api',
        '2023-08-11 11:57:33',
        '2023-08-11 11:57:33'
    ),
    (
        4,
        'delivery_level',
        'Delivery Man',
        'api',
        '2023-08-11 11:57:33',
        '2023-08-11 11:57:33'
    ),
    (
        5,
        'fitting_level',
        'Fitter Man',
        'api',
        '2023-08-11 11:57:33',
        '2023-08-11 11:57:33'
    );