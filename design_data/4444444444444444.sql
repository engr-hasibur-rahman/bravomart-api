select * from wc_woocommerce_order_items;
select * from wc_wc_product_attributes_lookup;
select * from wc_posts where post_type in('product','product_variation');
select * from wc_postmeta where post_id in(select id from wc_posts where post_type in('product','product_variation'));
select * from sixam_mart.items;
select * from active_cms.products;
select * from active_cms.brands;

select * from sixam_mart.vendors;
select * from active_cms.sellers;
select * from active_cms.shops;

select * from sixam_mart.users;
select * from sixam_mart.user_notifications;
select * from sixam_mart.notifications;

select * from sixam_mart.orders;
select * from sixam_mart.categories;
select * from active_cms.categories;

--create_uid, create_date, write_uid, write_date 
SELECT id, brand_name, display_order, brand_slug, brand_logo, meta_title, meta_description, seller_relation_with_brand, authorization_valid_from
, authorization_valid_to, status, create_uid, create_date, write_uid, write_date 
FROM disystem_biva_mart.product_brand;

select * from disystem_biva_mart.product_attribute;
select * from disystem_biva_mart.product_attribute_line;
select * from disystem_biva_mart.product_category;
select * from disystem_biva_mart.product_brand;
select * from disystem_biva_mart.com_store;





