<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make super admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $full_name = $this->askValid(
            "What's your full name?",
            'full_name',
            ['required', 'min:3']
        );

        $email = $this->askValid(
            "What's your email?",
            'email',
            ['required', 'string', 'email',['unique','users']]
        );

        $password = $this->askValid(
            "What's your password?",
            'password',
            ['required', 'min:8']
        );

        try {
            $super_admin = new User();
            $super_admin->name = $full_name;
            $super_admin->email = $email;
            $super_admin->password = Hash::make($password);
            $super_admin->email_verified_at = now();

            $super_admin->save();

            if (!Role::whereName('super-admin')->first()) {
                Role::create([
                    'name' => 'super-admin',
                ]);
            }

            $super_admin->assignRole('super-admin');

            $this->info('Super Admin Create Successfully . ');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }


    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
