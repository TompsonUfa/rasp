<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddAdministratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:add {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new administrator user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name');
        $password = $this->argument('password');
        $user = User::query()
            ->where('email', $email)
            ->first();
        $validator = Validator::make(['email' => $email], [
            'email' => 'email'
        ]);
        $validator->validate();
        if (!empty($user)) {
            $this->error('Email is used');
            return Command::FAILURE;
        }
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();
        $this->info('User is created');
        return Command::SUCCESS;
    }
}
