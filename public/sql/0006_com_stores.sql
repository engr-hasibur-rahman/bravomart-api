INSERT INTO `com_merchant_stores` (
    `id`, `area_id`, `merchant_id`, `store_type`, `name`, `phone`, `email`, `logo`, `banner`, `address`,
    `latitude`, `longitude`, `slug`, `vat_tax_number`, `is_featured`, `opening_time`, `closing_time`,
    `subscription_type`, `admin_commission_type`, `admin_commission_amount`, `delivery_charge`, `delivery_time`,
    `delivery_self_system`, `delivery_take_away`, `order_minimum`, `veg_status`, `off_day`, `enable_saling`,
    `meta_title`, `meta_description`, `meta_image`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`
) VALUES
      (1, 1, 1, 'furniture', 'Ballard Furnishers', '+516-874-0000', 'hatil@store.com', NULL, NULL,
       '1900 Northern Blvd Unit C2 Manhasset, NY 11030', '40.7564819', '-73.9683690', 'ballard-furnishers', 'TN-005',
       NULL, NULL, NULL, 'commission', 'percent', 10.00, 0.00, NULL, 0, 0, 100, NULL, NULL, 1,
       'Best Furniture Brand',
       'Discover timeless elegance and unmatched quality with HATIL, the best furniture brand offering innovative designs, superior craftsmanship, and comfort for your home or office.',
       NULL, 1, NULL, NULL, NOW(), NOW()),

      (2, 1, 1, 'bakery', 'Demo Mexican Grill', '+1785-587-0000', 'demo@grill.com', NULL, NULL,
       '606 N Manhattan Ave, Manhattan, KS 66502, United States', '40.7564819', '-73.9683690', 'demo-mexican-grill', 'TN-006',
       NULL, NULL, NULL, 'commission', 'amount', 500.00, 0.00, NULL, 0, 0, 100, NULL, NULL, 1,
       'Best Furniture Brand',
       'Discover timeless elegance and unmatched quality with HATIL, the best furniture brand offering innovative designs, superior craftsmanship, and comfort for your home or office.',
       NULL, 1, NULL, NULL, NOW(), NOW()),

      (3, 1, 1, 'grocery', 'Demo Grocery Store', '+1 212-253-0000', 'demo@grocery.com', NULL, NULL,
       '606 N Manhattan Ave, Manhattan, KS 66502, United States', '40.7564819', '-73.9683690', 'demo-grocery-store', 'TN-007',
       NULL, NULL, NULL, 'subscription', NULL, NULL, 0.00, NULL, 0, 0, 100, NULL, NULL, 1,
       'Best Furniture Brand',
       'Discover timeless elegance and unmatched quality with HATIL, the best furniture brand offering innovative designs, superior craftsmanship, and comfort for your home or office.',
       NULL, 1, NULL, NULL, NOW(), NOW()),

      (4, 1, 1, 'books', 'Demo Book Store', '(516) 874-5235', 'demo@books.com', NULL, NULL,
       '1900 Northern Blvd Unit C2 Manhasset, NY 11030', '40.7564819', '-73.9683690', 'demo-book-store', 'TN-007',
       NULL, NULL, NULL, 'subscription', NULL, NULL, 0.00, NULL, 0, 0, 100, NULL, NULL, 1,
       'Best Furniture Brand',
       'Discover timeless elegance and unmatched quality with HATIL, the best furniture brand offering innovative designs, superior craftsmanship, and comfort for your home or office.',
       NULL, 1, NULL, NULL, NOW(), NOW());
