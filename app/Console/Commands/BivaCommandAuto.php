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
            DB::table('products')->insert((array) $product);
        }
        foreach ($product_variants as $product_variant) {
            DB::table('product_variants')->insert((array) $product_variant);
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
