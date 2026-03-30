<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Con `php artisan config:cache`, `env()` deja de funcionar en runtime y `config('app.url')`
         * puede quedar con el valor del build (p. ej. http://localhost). Railway inyecta APP_URL
         * en el proceso: `getenv('APP_URL')` sí refleja el valor real del despliegue.
         */
        $appUrl = $this->resolveApplicationUrl();
        if ($appUrl === '') {
            return;
        }

        $scheme = parse_url($appUrl, PHP_URL_SCHEME);
        $forceHttps = $scheme === 'https'
            || $this->app->environment('production')
            || filter_var((string) getenv('FORCE_HTTPS'), FILTER_VALIDATE_BOOLEAN);

        if ($forceHttps) {
            URL::forceRootUrl($appUrl);
            URL::forceScheme('https');
        }
    }

    /**
     * URL pública de la app: prioriza variable de entorno del proceso (Railway / Docker).
     */
    private function resolveApplicationUrl(): string
    {
        $fromEnv = getenv('APP_URL');
        if (is_string($fromEnv) && $fromEnv !== '') {
            return rtrim($fromEnv, '/');
        }

        return rtrim((string) config('app.url'), '/');
    }
}
