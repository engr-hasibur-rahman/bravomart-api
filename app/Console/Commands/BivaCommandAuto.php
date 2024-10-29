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
        ]);
        $user->email_verified_at = now()->timestamp;
        $user->save();

        //Assign Permission to Super Admin Role
        $role = Role::firstOrCreate(['name'  => UserRole::SUPER_ADMIN->value], ['name'  => UserRole::SUPER_ADMIN->value, 'guard_name' => 'api']);
        Permission::firstOrCreate(['name'  => 'all'], ['name'  => 'all', 'guard_name' => 'api']);
        $role->givePermissionTo(Permission::whereIn('available_for',['system_level','COMMON'])->get());
        $user->assignRole($role);

        //Assign Permission to Store Owner Role
        $role = Role::where('id',2)->first();
        $role->givePermissionTo(Permission::whereIn('available_for',['store_level','COMMON'])->get());
        $user = User::whereEmail('owner@store.com')->first();
        // Assign default Store User to a Specific Role
        $user->assignRole($role);

        info('User Creation Successful!');



        info('Everything is successful. Now clearing all cached...');
        $this->call('optimize:clear');
    }

    public function clearDemoData()
    {
        info('If Yes! then it will erase all of your data.');
        info('And seeding all data from sql files.');
        //if (confirm('Are you sure! ')) {

            info('Dropping all tables started...');
            $this->call('migrate:fresh');
            info('Dropping all tables ended...');

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
            DB::statement($file_sql);
        }
        info('Seed completed successfully!');
    }
}
