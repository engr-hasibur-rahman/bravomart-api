<?php

namespace App\Console\Commands;

use App\Enums\PermissionKey as UserPermission;
use App\Enums\Role as UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\{text, confirm, info, password, error};

class CreateUserCommand extends Command
{
    protected $signature = 'biva:create-admin';

    protected $description = 'Create an admin user.';
    public function handle()
    {
        try {

            if (confirm('Do you want to create an admin?')) {

                info('Provide admin credentials info to create an admin user for you.');
                $first_name = text(label: 'Enter admin name', required: 'Admin Name is required',default:'BivaMart Admin');

                // Manually validate the email input
                do {
                    $email = text(label: 'Enter admin email', required: 'Admin Email is required',default:'admin@gmail.com');
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        info('Invalid email address format. Please enter a valid email.');
                    } else {
                        // Break out of the loop if the email is valid
                        break;
                    }
                } while (true);

                do {
                    $password = password(label: 'Enter your admin password', required: 'Password is required');
                    $confirmPassword = password(label: 'Enter your password again', required: 'Confirm Password is required');
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
                    'activity_scope' =>  'ADMIN_AREA',
                    'password' =>  Hash::make($password),
                ]);
                $user->email_verified_at = now()->timestamp;
                $user->save();

                $role = Role::where(['available_for'  => 'system_level'])->first();
                $role->givePermissionTo(Permission::whereIn('available_for',['system_level','COMMON'])->get());
                $user->assignRole($role);

                //Assign PermissionKey to Store Admin Role
                $role = Role::where('id',2)->first();
                $role->givePermissionTo(Permission::whereIn('available_for',['store_level','COMMON'])->get());
                $user = User::whereEmail('owner@store.com')->first();
                // Assign default Store User to a Specific Role
                $user->assignRole($role);

                info('User Creation Successful!');
            }
        } catch (\Exception $e) {
            error($e->getMessage());
        }
    }
}
