<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cek apakah Super Admin sudah ada
        if (User::where('role', 'super_admin')->exists()) {
            $this->error('Super Admin sudah ada. Instalasi dibatalkan.');
            return Command::FAILURE;
        }

        // Generate password acak
        $superPassword = Str::password(16);
        $adminPassword = Str::password(16);

        $superEmail = $this->ask('Masukkan email Super Admin');
        $adminEmail = $this->ask('Masukkan email Admin');

        // Buat Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => $superEmail,
            'password' => Hash::make($superPassword),
            'role' => 'super_admin',
            'force_password_change' => true,
        ]);

        // Buat Admin
        User::create([
            'name' => 'Admin',
            'email' => $adminEmail,
            'password' => Hash::make($adminPassword),
            'role' => 'admin',
            'force_password_change' => true,
        ]);

        $this->newLine();

        $this->info('===================================');
        $this->info(' Instalasi berhasil');
        $this->info('===================================');

        $this->newLine();

        $this->info('SUPER ADMIN');
        $this->line("Email    : {$superEmail}");
        $this->line("Password : {$superPassword}");

        $this->newLine();

        $this->info('ADMIN');
        $this->line("Email    : {$adminEmail}");
        $this->line("Password : {$adminPassword}");

        $this->newLine();

        $this->warn('Simpan password tersebut.');
        $this->warn('Segera ubah password setelah login pertama.');

        return Command::SUCCESS;
    }
}
