

INSERT INTO `users` (
        `id`,
        `name`,
        `email`,
        `activity_scope`,
        `email_verified_at`,
        `password`,
        `remember_token`,
        `created_at`,
        `updated_at`,
        `is_active`
    )
VALUES (
        1,
        'Store Owner',
        'vendor@demo.com',
        'SHOP_AREA',
        NULL,
        '$2y$10$UVs.WftC2iIdLQsHz9Tbdu7OmUXG3P7wyjHvJqCunyJ7JE8ekyXr.',
        NULL,
        '2021-06-27 04:13:00',
        '2023-10-02 06:53:37',
        1
    ),
    (
        2,
        'Kitchen X',
        'kitchenx@demo.com',
        'KITCHEN_AREA',
        NULL,
        '$2y$10$UVs.WftC2iIdLQsHz9Tbdu7OmUXG3P7wyjHvJqCunyJ7JE8ekyXr.',
        NULL,
        '2021-08-18 10:30:29',
        '2021-08-18 13:17:53',
        1
    ),
    (
        4,
        'Kitchen',
        'kitchen@demo.com',
        'KITCHEN_AREA',
        NULL,
        '$2y$10$UVs.WftC2iIdLQsHz9Tbdu7OmUXG3P7wyjHvJqCunyJ7JE8ekyXr.',
        NULL,
        '2021-08-18 10:30:29',
        '2021-08-18 13:17:53',
        1
    ),
    (
        5,
        'Kitchen 2',
        'kitchen2@demo.com',
        'KITCHEN_AREA',
        NULL,
        '$2y$10$UVs.WftC2iIdLQsHz9Tbdu7OmUXG3P7wyjHvJqCunyJ7JE8ekyXr.',
        NULL,
        '2022-03-17 14:15:08',
        '2022-03-17 14:15:08',
        1
    ),
    (
        6,
        'Delivery Man',
        'deliveryman@demo.com',
        'FIELD_AREA',
        NULL,
        '$2y$10$UVs.WftC2iIdLQsHz9Tbdu7OmUXG3P7wyjHvJqCunyJ7JE8ekyXr.',
        NULL,
        '2022-03-17 16:25:39',
        '2022-03-17 16:25:39',
        1
    ),
    (
        7,
        'fitter Man',
        'fitterman@demo.com',
        'FIELD_AREA',
        NULL,
        '$2y$10$UVs.WftC2iIdLQsHz9Tbdu7OmUXG3P7wyjHvJqCunyJ7JE8ekyXr.',
        NULL,
        '2022-03-17 16:25:39',
        '2022-03-17 16:25:39',
        1
    );