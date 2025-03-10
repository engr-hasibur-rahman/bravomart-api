<?php

namespace App\Console\Commands;

use App\Enums\Role as UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use App\Enums\PermissionKey;

use function Laravel\Prompts\{text, confirm, info, error, table};

class BivaCommandAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biva:autoinstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing Biva Dependencies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('Installing Biva Dependencies...');
        info('If you have already run this command or migrated tables then be aware.');
        info('Do you want to seed dummy data?');


        info('Please use arrow key for navigation.');

        $this->clearDemoData();

        info('Tables Migration completed.');

        info('Importing required settings...');

        $this->call('db:seed');

        info('Settings import is completed.');

        info('Provide admin credentials info to create an admin user for you.');
        $first_name = 'BivaMart Admin';

        // Manually validate the email input
        do {
            $email = 'admin@gmail.com';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                info('Invalid email address format. Please enter a valid email.');
            } else {
                // Break out of the loop if the email is valid
                break;
            }
        } while (true);

        do {
            $password = 'admin';
            $confirmPassword = 'admin';
            if ($password !== $confirmPassword) {
                info('Passwords do not match. Please try again.');
            }
        } while ($password !== $confirmPassword);

        info('Please wait, Creating an admin profile for you...');
        $validator = Validator::make(
            [
                'first_name'  =>  $first_name,
                'email' =>  $email,
                'password' =>  $password,
                'confirmPassword' =>  $confirmPassword,
            ],
            [
                'first_name'      => 'required|string',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required',
                'confirmPassword' => 'required|same:password',
            ]
        );
        if ($validator->fails()) {
            info('User not created. See error messages below:');
            foreach ($validator->errors()->all() as $error) {
                error($error);
            }
            return;
        }
        $user = User::create([
            'first_name'  =>  $first_name,
            'email' =>  $email,
            'activity_scope' =>  'system_level',
            'password' =>  Hash::make($password),
            'status' => 1,
            'slug'=> 'biva-mart'
        ]);
        $user->email_verified_at = now()->timestamp;
        $user->save();

        //Assign PermissionKey to Super Admin Role
        $role = Role::where(['available_for'  => 'system_level'])->first();
        //PermissionKey::firstOrCreate(['name'  => 'all'], ['name'  => 'all', 'guard_name' => 'api']);
        $role->givePermissionTo(Permission::whereIn('available_for',['system_level','COMMON'])->get());
        $user->assignRole($role);

        //Assign PermissionKey to Store Admin Role
        $role = Role::where('id',2)->first();
        $role->givePermissionTo(Permission::whereIn('available_for',['store_level','COMMON'])->get());
        $user = User::whereEmail('owner@store.com')->first();
        // Assign default Store User to a Specific Role
        $user->assignRole($role);

        // 3 Get Store Manage Role And assign some default permission
        $role = Role::where('id',3)->first();
        $role->givePermissionTo([PermissionKey::SELLER_STORE_MY_SHOP,PermissionKey::SELLER_STORE_STORE_NOTICE]);
        // 4 Get Store Officer Role And assign some default permission
        $role = Role::where('id',4)->first();
        $role->givePermissionTo([PermissionKey::SELLER_STORE_STAFF_MANAGE,PermissionKey::SELLER_STORE_FINANCIAL_WITHDRAWALS]);

        // 6 Get Deliveryman Role And assign some default permission
        $role = Role::where('id',6)->first();
        $role->givePermissionTo([PermissionKey::DELIVERYMAN_FINANCIAL_WITHDRAWALS]);

        // Update View Option For All permission
        DB::table('role_has_permissions')->update(['view' => true]);

        info('User Creation Successful!');



        info('Everything is successful. Now clearing all cached...');
        $this->call('optimize:clear');
    }

    public function clearDemoData()
    {
        info('If Yes! then it will erase all of your data.');
        info('And seeding all data from sql files.');
        //if (confirm('Are you sure! ')) {

        // Backup product data
        info('Backing up product data...');
        $media = DB::table('media')->get();
        $store_types = DB::table('store_types')->get();
        $sliders = DB::table('sliders')->get();
        $banners = DB::table('banners')->get();
        $blogs = DB::table('blogs')->get();
        $blog_categories = DB::table('blog_categories')->get();
        $stores = DB::table('stores')->get();
        $store_sellers = DB::table('store_sellers')->get();
        $store_areas = DB::table('store_areas')->get();
        $store_area_settings = DB::table('store_area_settings')->get();
        $store_area_setting_range_charges = DB::table('store_area_setting_range_charges')->get();
        $store_area_setting_store_types = DB::table('store_area_setting_store_types')->get();
        $store_subscriptions = DB::table('store_subscriptions')->get();
        $setting_options = DB::table('setting_options')->get();
        $pages = DB::table('pages')->get();

        $product_category = DB::table('product_category')->get();
        $product_attributes = DB::table('product_attributes')->get();
        $product_attribute_values = DB::table('product_attribute_values')->get();
        $product_authors = DB::table('product_authors')->get();
        $product_brand = DB::table('product_brand')->get();
        $product_tags = DB::table('product_tags')->get();
        $products = DB::table('products')->get();
        $product_variants = DB::table('product_variants')->get();
        $flash_sale_products = DB::table('flash_sale_products')->get();
        $units = DB::table('units')->get();
        $vehicle_types = DB::table('vehicle_types')->get();


        // review
        $reviews = DB::table('reviews')->get();
        $review_reactions = DB::table('review_reactions')->get();
        $delivery_men = DB::table('delivery_men')->get();
        $delivery_man_reviews = DB::table('delivery_man_reviews')->get();
        $customer_deactivation_reasons = DB::table('customer_deactivation_reasons')->get();
        $deliveryman_deactivation_reasons = DB::table('deliveryman_deactivation_reasons')->get();
        $departments = DB::table('departments')->get();
        $orders = DB::table('orders')->get();
        $order_activities = DB::table('order_activities')->get();
        $order_addresses = DB::table('order_addresses')->get();
        $order_delivery_histories = DB::table('order_delivery_histories')->get();
        $order_details = DB::table('order_details')->get();
        $order_masters = DB::table('order_masters')->get();
        $order_refunds = DB::table('order_refunds')->get();
        $order_refund_reasons = DB::table('order_refund_reasons')->get();
        $coupons = DB::table('coupons')->get();
        $coupon_lines = DB::table('coupon_lines')->get();
        $customers = DB::table('customers')->get();
        $customer_addresses = DB::table('customer_addresses')->get();
        $email_templates = DB::table('email_templates')->get();
        $flash_sales = DB::table('flash_sales')->get();
        $payment_gateways = DB::table('payment_gateways')->get();

        // settings
        $system_commission = DB::table('system_commissions')->first();

        // wallets
        $wallets = DB::table('wallets')->get();
        $wallet_transactions = DB::table('wallet_transactions')->get();
        $wallet_withdrawals_transactions = DB::table('wallet_withdrawals_transactions')->get();
        $wishlists = DB::table('wishlists')->get();
        $withdraw_gateways = DB::table('withdraw_gateways')->get();

        // subscriptions
        $subscriptions = DB::table('subscriptions')->get();
        $subscription_histories = DB::table('subscription_histories')->get();


        info('Dropping all tables started...');
            $this->call('migrate:fresh');
            info('Dropping all tables ended...');


            // Restore product data
            info('Restoring product data...');
            foreach ($media as $img) {
                DB::table('media')->insert((array) $img);
            }
            foreach ($store_types as $type) {
                DB::table('store_types')->insert((array) $type);
            }

            foreach ($sliders as $slide) {
                DB::table('sliders')->insert((array) $slide);
            }

            foreach ($banners as $banner) {
                DB::table('banners')->insert((array) $banner);
            }
            foreach ($blogs as $blog) {
                DB::table('blogs')->insert((array) $blog);
            }
            foreach ($blog_categories as $blog_cat) {
                DB::table('blog_categories')->insert((array) $blog_cat);
            }

            // store related data
            foreach ($stores as $store) {
                $newStore = (array) $store;
                unset($newStore['id']); // Remove primary key to allow new insertion
                $newStore['slug'] = $newStore['slug'] . '-' . uniqid(); // Ensure unique slug
                DB::table('stores')->insert($newStore);
            }
            foreach ($store_areas as $store_area) {
                DB::table('store_areas')->insert((array) $store_area);
            }
            foreach ($store_area_settings as $store_area_setting) {
                DB::table('store_area_settings')->insert((array) $store_area_setting);
            }
            foreach ($store_area_setting_range_charges as $store_area_setting_range_charge) {
                DB::table('store_area_setting_range_charges')->insert((array) $store_area_setting_range_charge);
            }
            foreach ($store_area_setting_store_types as $store_area_setting_store_type) {
                DB::table('store_area_setting_store_types')->insert((array) $store_area_setting_store_type);
            }
            foreach ($store_sellers as $store_seller) {
                DB::table('store_sellers')->insert((array) $store_seller);
            }
            foreach ($store_subscriptions as $store_subscription) {
                DB::table('store_subscriptions')->insert((array) $store_subscription);
            }
            foreach ($setting_options as $setting_option) {
                DB::table('setting_options')->insert((array) $setting_option);
            }
            foreach ($pages as $page) {
                DB::table('pages')->insert((array) $page);
            }
            foreach ($product_category as $product_cat) {
                DB::table('product_category')->insert((array) $product_cat);
            }

            // subscriptions
            foreach ($subscriptions as $subscription) {
                DB::table('subscriptions')->insert((array) $subscription);
            }
            foreach ($subscription_histories as $subscription_historie) {
                DB::table('subscriptions')->insert((array) $subscription_historie);
            }


            // product related  data
            foreach ($product_attributes as $product_attribute) {
                DB::table('product_attributes')->insert((array) $product_attribute);
            }
            foreach ($product_attribute_values as $product_attribute_value) {
                DB::table('product_attribute_values')->insert((array) $product_attribute_value);
            }
            foreach ($product_authors as $product_author) {
                DB::table('product_authors')->insert((array) $product_author);
            }
            foreach ($product_brand as $product_br) {
                DB::table('product_brand')->insert((array) $product_br);
            }
            foreach ($product_tags as $product_tag) {
                DB::table('product_tags')->insert((array) $product_tag);
            }
            foreach ($products as $product) {
                $newProduct = (array) $product;
                unset($newProduct['id']); // Remove primary key to allow new insertion
                $newProduct['slug'] = $newProduct['slug'] . '-' . uniqid(); // Ensure unique slug

                DB::table('products')->insert($newProduct);
            }
            foreach ($product_variants as $product_variant) {
                DB::table('product_variants')->insert((array) $product_variant);
            }
            foreach ($flash_sale_products as $flash_sale_product) {
                DB::table('flash_sale_products')->insert((array) $flash_sale_product);
            }
            // unit
            foreach ($units as $unit) {
                DB::table('units')->insert((array) $unit);
            }
             foreach ($vehicle_types as $vehicle_type) {
                DB::table('vehicle_types')->insert((array) $vehicle_type);
            }


        // Loop for inserting records back
        foreach ($reviews as $review) {
            DB::table('reviews')->insert((array) $review);
        }

        foreach ($review_reactions as $review_reaction) {
            DB::table('review_reactions')->insert((array) $review_reaction);
        }

        foreach ($delivery_men as $delivery_man) {
            $newDeliveryMan = (array) $delivery_man;

            // Remove ID to prevent duplicate primary key issues
            unset($newDeliveryMan['id']);

            // Ensure unique slug only if 'slug' exists
            if (!empty($newDeliveryMan['slug'])) {
                $originalSlug = $newDeliveryMan['slug'];
                $uniqueSlug = $originalSlug . '-' . uniqid();

                // Check for uniqueness in the database
                while (DB::table('delivery_men')->where('slug', $uniqueSlug)->exists()) {
                    $uniqueSlug = $originalSlug . '-' . uniqid();
                }

                $newDeliveryMan['slug'] = $uniqueSlug;
            }

            // Ensure unique identification_number by creating a new identifier
            $originalIdentificationNumber = $newDeliveryMan['identification_number'];
            $uniqueIdentificationNumber = $originalIdentificationNumber . '-' . uniqid();

            // Check if this generated unique identification_number exists
            while (DB::table('delivery_men')->where('identification_number', $uniqueIdentificationNumber)->exists()) {
                // If a duplicate is found, generate a new identification_number
                $uniqueIdentificationNumber = $originalIdentificationNumber . '-' . uniqid();
            }

            // Assign the unique identification_number
            $newDeliveryMan['identification_number'] = $uniqueIdentificationNumber;

            // Insert the modified data
            DB::table('delivery_men')->insert($newDeliveryMan);
        }




        foreach ($delivery_man_reviews as $delivery_man_review) {
            DB::table('delivery_man_reviews')->insert((array) $delivery_man_review);
        }

        foreach ($customer_deactivation_reasons as $customer_deactivation_reason) {
            DB::table('customer_deactivation_reasons')->insert((array) $customer_deactivation_reason);
        }

        foreach ($deliveryman_deactivation_reasons as $deliveryman_deactivation_reason) {
            DB::table('deliveryman_deactivation_reasons')->insert((array) $deliveryman_deactivation_reason);
        }

        foreach ($departments as $department) {
            DB::table('departments')->insert((array) $department);
        }

        foreach ($orders as $order) {
            DB::table('orders')->insert((array) $order);
        }

        foreach ($order_activities as $order_activity) {
            DB::table('order_activities')->insert((array) $order_activity);
        }

        foreach ($order_addresses as $order_address) {
            DB::table('order_addresses')->insert((array) $order_address);
        }

        foreach ($order_delivery_histories as $order_delivery_history) {
            DB::table('order_delivery_histories')->insert((array) $order_delivery_history);
        }

        foreach ($order_details as $order_detail) {
            DB::table('order_details')->insert((array) $order_detail);
        }

        foreach ($order_masters as $order_master) {
            DB::table('order_masters')->insert((array) $order_master);
        }

        foreach ($order_refunds as $order_refund) {
            DB::table('order_refunds')->insert((array) $order_refund);
        }

        foreach ($order_refund_reasons as $order_refund_reason) {
            DB::table('order_refund_reasons')->insert((array) $order_refund_reason);
        }

        foreach ($coupons as $coupon) {
            DB::table('coupons')->insert((array) $coupon);
        }

        foreach ($coupon_lines as $coupon_line) {
            DB::table('coupon_lines')->insert((array) $coupon_line);
        }

        foreach ($customers as $customer) {
            $newCustomer = (array) $customer;
            // Remove the 'id' to avoid conflicts with primary key on new insert
            unset($newCustomer['id']);
            // Make 'email' unique by appending a unique identifier
            $newCustomer['email'] = $newCustomer['email'] . '-' . uniqid();
            // Make 'phone' unique by appending a unique identifier
            $newCustomer['phone'] = $newCustomer['phone'] . '-' . uniqid();
            // Insert the modified data into the 'customers' table
            DB::table('customers')->insert($newCustomer);
        }

        foreach ($customer_addresses as $customer_address) {
            DB::table('customer_addresses')->insert((array) $customer_address);
        }

        foreach ($email_templates as $email_template) {
            $newEmailTemplate = (array) $email_template;
            // Remove the 'id' to avoid conflicts with primary key on new insert
            unset($newEmailTemplate['id']);
            // Make 'email' unique by appending a unique identifier
            $newEmailTemplate['type'] = $newEmailTemplate['type'] . '-' . uniqid();
            // Insert the modified data into the 'customers' table
            DB::table('email_templates')->insert($newEmailTemplate);
        }

        foreach ($flash_sales as $flash_sale) {
            DB::table('flash_sales')->insert((array) $flash_sale);
        }

        foreach ($payment_gateways as $payment_gateway) {
            DB::table('payment_gateways')->insert((array) $payment_gateway);
        }

        foreach ($wallets as $wallet) {
            DB::table('wallets')->insert((array) $wallet);
        }

        foreach ($wallet_transactions as $wallet_transaction) {
            DB::table('wallet_transactions')->insert((array) $wallet_transaction);
        }

        foreach ($wallet_withdrawals_transactions as $wallet_withdrawals_transaction) {
            DB::table('wallet_withdrawals_transactions')->insert((array) $wallet_withdrawals_transaction);
        }

        foreach ($wishlists as $wishlist) {
            DB::table('wishlists')->insert((array) $wishlist);
        }

        foreach ($withdraw_gateways as $withdraw_gateway) {
            DB::table('withdraw_gateways')->insert((array) $withdraw_gateway);
        }

        if ($system_commission) {
            DB::table('system_commissions')->insert((array) $system_commission);
        }



            info('Database seeding started...');
            $this->seedDemoData();

            info('Database seeding completed.');
            return 0;
        //}
    }
    public function seedDemoData()
    {
        info('Copying necessary files for seeding....');

        (new Filesystem)->copyDirectory(config('sql-seeder.sql_file_path'), public_path('sql'));

        info('File copying successful');

        info('Seeding....');

        $get_sql_files_path = (new Filesystem)->files(public_path('sql'));
        foreach($get_sql_files_path as $key => $path){
            $file_sql = file_get_contents($path);
            if (empty($file_sql)) {
                info('Skipping empty SQL file: ' . $path);
                continue;
            }
            DB::statement($file_sql);
        }

        info('Seed completed successfully!');
    }
}
