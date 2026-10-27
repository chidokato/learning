<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GoogleAuthConfigService
{
    protected static string $fileName = 'google_auth_config.json';

    /**
     * Cấu hình mặc định
     */
    public static function defaults(): array
    {
        return [
            'is_enabled' => true,
            'client_id' => env('GOOGLE_CLIENT_ID', ''),
            'client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI', 'https://learning.indochinerealestate.vn/auth/google/callback'),
        ];
    }

    /**
     * Đường dẫn file lưu trữ JSON trong storage/app
     */
    public static function path(): string
    {
        return storage_path('app/' . self::$fileName);
    }

    /**
     * Lấy toàn bộ cấu hình
     */
    public static function all(): array
    {
        $defaults = self::defaults();
        $path = self::path();

        if (!File::exists($path)) {
            return $defaults;
        }

        try {
            $saved = json_decode(File::get($path), true);
            if (is_array($saved)) {
                return array_merge($defaults, $saved);
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to read google_auth_config.json: ' . $e->getMessage());
        }

        return $defaults;
    }

    /**
     * Lấy 1 giá trị cấu hình cụ thể
     */
    public static function get(string $key, $default = null)
    {
        $all = self::all();
        return $all[$key] ?? $default;
    }

    /**
     * Lưu cấu hình vào file JSON và đồng bộ sang .env
     */
    public static function save(array $data): bool
    {
        $current = self::all();
        $updated = array_merge($current, $data);

        try {
            $directory = dirname(self::path());
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            File::put(self::path(), json_encode($updated, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            // Đồng bộ sang .env nếu có quyền ghi
            self::syncToEnv([
                'GOOGLE_CLIENT_ID' => $updated['client_id'] ?? '',
                'GOOGLE_CLIENT_SECRET' => $updated['client_secret'] ?? '',
                'GOOGLE_REDIRECT_URI' => $updated['redirect_uri'] ?? '',
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to save google_auth_config: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Đồng bộ giá trị vào .env
     */
    public static function syncToEnv(array $values): void
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath) || !File::isWritable($envPath)) {
            return;
        }

        try {
            $content = File::get($envPath);
            foreach ($values as $key => $value) {
                if (preg_match("/^{$key}=.*/m", $content)) {
                    $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
                } else {
                    $content .= PHP_EOL . "{$key}={$value}";
                }
            }
            File::put($envPath, $content);
        } catch (\Throwable $e) {
            Log::warning('Failed to sync google credentials to .env: ' . $e->getMessage());
        }
    }
}
