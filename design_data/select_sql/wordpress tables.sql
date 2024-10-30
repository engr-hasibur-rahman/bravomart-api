select * from vat_comments;
select * from vat_commentmeta;
select * from vat_links;
select * from vat_options;
select * from vat_options where option_name='upload_path';

select option_name,count(*) from vat_options group by option_name; 
select * from vat_posts;

select * from vat_posts where post_type!='attachment';
select * from vat_posts where post_type='attachment';
select * from vat_posts where post_type='attachment' and post_title like '%Old%';
select * from vat_postmeta where post_id=769;

select * from vat_postmeta;
select * from vat_terms;
select * from vat_termmeta;
select * from vat_term_taxonomy;
select * from vat_term_relationships;
select * from vat_users;
select * from vat_usermeta;


