<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create', function () {
    $name = $this->ask('Admin name');
    $email = $this->ask('Admin email');
    $password = $this->secret('Admin password');

    $validator = Validator::make(compact('name', 'email', 'password'), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:12'],
    ]);

    if ($validator->fails()) {
        $this->error($validator->errors()->first());

        return 1;
    }

    $user = User::firstOrNew(['email' => $email]);
    $user->name = $name;
    $user->password = $password;
    $user->is_admin = true;
    $user->save();

    $this->info('Admin account is ready.');

    return 0;
})->purpose('Create or promote an administrator account');
