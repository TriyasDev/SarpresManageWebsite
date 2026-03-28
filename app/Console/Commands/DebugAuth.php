<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DebugAuth extends Command
{
    protected $signature = 'debug:auth {email?}';
    protected $description = 'Debug authentication issues';

    public function handle()
    {
        $this->info('🔍 Laravel Authentication Debugger');
        $this->info('=====================================');
        $this->newLine();

        // 1. Check Configuration
        $this->checkConfiguration();

        // 2. Check User Model
        $this->checkUserModel();

        // 3. Check Database Connection
        $this->checkDatabase();

        // 4. Check Specific User
        $email = $this->argument('email') ?? 'iyastriyas2@gmail.com';
        $this->checkUser($email);

        // 5. Test Authentication
        $this->testAuth($email);

        // 6. Check Session
        $this->checkSession();

        $this->newLine();
        $this->info('✅ Debugging selesai!');
    }

    private function checkConfiguration()
    {
        $this->info('1️⃣ Checking Configuration...');

        $guard = Config::get('auth.defaults.guard');
        $provider = Config::get('auth.guards.web.provider');
        $model = Config::get('auth.providers.users.model');

        $this->table(
            ['Config', 'Value'],
            [
                ['Default Guard', $guard],
                ['Web Provider', $provider],
                ['User Model', $model],
                ['Session Driver', Config::get('session.driver')],
                ['Session Lifetime', Config::get('session.lifetime')],
            ]
        );

        if ($guard !== 'web') {
            $this->error('⚠️  Default guard bukan "web"!');
        }

        if ($model !== 'App\Models\User') {
            $this->error('⚠️  User model tidak standard!');
        }

        $this->newLine();
    }

    private function checkUserModel()
    {
        $this->info('2️⃣ Checking User Model...');

        try {
            $user = new User();
            $table = $user->getTable();
            $primaryKey = $user->getKeyName();
            $incrementing = $user->getIncrementing();

            $this->table(
                ['Property', 'Value'],
                [
                    ['Table Name', $table],
                    ['Primary Key', $primaryKey],
                    ['Incrementing', $incrementing ? 'YES' : 'NO'],
                    ['Connection', $user->getConnectionName() ?? 'default'],
                ]
            );

            if ($table !== 'tb_user') {
                $this->warn('⚠️  Table name bukan tb_user');
            }

            if ($primaryKey !== 'id_user') {
                $this->warn('⚠️  Primary key bukan id_user');
            }

            $this->info('✅ User model configuration OK');
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }

        $this->newLine();
    }

    private function checkDatabase()
    {
        $this->info('3️⃣ Checking Database Connection...');

        try {
            DB::connection()->getPdo();
            $this->info('✅ Database connected');

            // Check if table exists
            $exists = DB::getSchemaBuilder()->hasTable('tb_user');
            if ($exists) {
                $count = DB::table('tb_user')->count();
                $this->info("✅ Table tb_user exists with {$count} users");
            } else {
                $this->error('❌ Table tb_user does not exist!');
            }
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed: ' . $e->getMessage());
        }

        $this->newLine();
    }

    private function checkUser($email)
    {
        $this->info("4️⃣ Checking User: {$email}");

        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                $this->error("❌ User with email {$email} not found!");

                // List available users
                $users = User::select('id_user', 'email', 'username', 'role')->get();
                $this->table(
                    ['ID', 'Email', 'Username', 'Role'],
                    $users->map(fn($u) => [$u->id_user, $u->email, $u->username, $u->role])
                );
                return;
            }

            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $user->id_user],
                    ['Username', $user->username],
                    ['Email', $user->email],
                    ['Role', $user->role],
                    ['Points', $user->points ?? 'NULL'],
                    ['Tier', $user->tier ?? 'NULL'],
                    ['Is Banned', $user->is_banned ? 'YES' : 'NO'],
                    ['Created', $user->created_at],
                ]
            );

            // Test password hash
            $testPassword = $this->ask('Enter password to test (or skip):', 'admin001#');
            if ($testPassword) {
                $match = Hash::check($testPassword, $user->password);
                if ($match) {
                    $this->info('✅ Password matches!');
                } else {
                    $this->error('❌ Password does NOT match!');
                    $this->warn('Hash in DB: ' . substr($user->password, 0, 60) . '...');
                }
            }

            $this->info('✅ User found and verified');
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }

        $this->newLine();
    }

    private function testAuth($email)
    {
        $this->info('5️⃣ Testing Authentication...');

        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                $this->warn('⚠️  Skipping auth test (user not found)');
                return;
            }

            // Test manual login
            Auth::login($user);

            if (Auth::check()) {
                $this->info('✅ Manual login successful!');
                $this->info('   Logged in as: ' . Auth::user()->username);
                $this->info('   User ID: ' . Auth::id());

                // Logout
                Auth::logout();
                $this->info('✅ Logout successful');
            } else {
                $this->error('❌ Manual login failed!');
            }

            // Test attempt method
            $password = 'admin001#';
            $attempt = Auth::attempt(['email' => $email, 'password' => $password]);

            if ($attempt) {
                $this->info('✅ Auth::attempt successful!');
                Auth::logout();
            } else {
                $this->error('❌ Auth::attempt failed!');
                $this->warn('   Possible causes:');
                $this->warn('   - Password mismatch');
                $this->warn('   - Auth configuration issue');
                $this->warn('   - User model setup issue');
            }

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }

        $this->newLine();
    }

    private function checkSession()
    {
        $this->info('6️⃣ Checking Session Configuration...');

        $driver = Config::get('session.driver');
        $lifetime = Config::get('session.lifetime');
        $path = Config::get('session.files');

        $this->table(
            ['Config', 'Value'],
            [
                ['Driver', $driver],
                ['Lifetime', $lifetime . ' minutes'],
                ['Path', $path],
                ['Cookie', Config::get('session.cookie')],
                ['Secure', Config::get('session.secure') ? 'YES' : 'NO'],
                ['Same Site', Config::get('session.same_site')],
            ]
        );

        // Check if session path is writable
        if ($driver === 'file') {
            $writable = is_writable(storage_path('framework/sessions'));
            if ($writable) {
                $this->info('✅ Session directory is writable');
            } else {
                $this->error('❌ Session directory is NOT writable!');
                $this->warn('   Run: chmod -R 775 storage/framework/sessions');
            }
        }

        $this->newLine();
    }
}
