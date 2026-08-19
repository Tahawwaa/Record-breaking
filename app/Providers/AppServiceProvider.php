<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Only for hosts with no CLI, where the app was installed as a sibling of the
        // web root instead of the standard public/-is-the-webroot layout (e.g. a
        // DirectAdmin account with public_html separate from the app folder, and no
        // SSH to symlink or move things properly). Leave PUBLIC_HTML_PATH unset
        // anywhere the app's own public/ folder is the real web root — that's the
        // normal case, including local dev and any SSH-capable deploy.
        //
        // This has to live in a provider's register() rather than bootstrap/app.php:
        // by the time bootstrap/app.php's own code runs, Laravel hasn't loaded .env
        // yet, so env() there only ever sees real shell-level variables, never
        // anything set only inside the .env file — silently no-op-ing this exact
        // override in production. Providers register() after .env is loaded.
        if ($publicHtmlPath = env('PUBLIC_HTML_PATH')) {
            $this->app->usePublicPath($publicHtmlPath);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Generated URLs (asset(), route(), etc.) use https:// in production, even if
        // the request reaches PHP over plain HTTP behind a proxy that already terminated TLS.
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
