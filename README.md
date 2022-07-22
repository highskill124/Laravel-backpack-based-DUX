# Dux Hq (Pronounced "Dooks")
Dux is a website that manages promotions for local businesses.
Currently it is programmed with node.js.  This codebase however will replace the current dux website, using Laravel instead.

## Components of this app

The Dux app has Six main components:

* User Manager
* Location Manager
* Promotions Manager
* Category Manager
* Statistics
* Mobile API Endpoint

# Setup

### .htaccess

Please add this to the .htaccess

```
RewriteRule (^|/)public(/|$) - [F]
```

### create storage link

The public disk included in your application's filesystems configuration file is intended for files that are going to be
publicly accessible. By default, the public disk uses the local driver and stores its files in storage/app/public.

To make these files accessible from the web, you should create a symbolic link from public/storage to
storage/app/public. Utilizing this folder convention will keep your publicly accessible files in one directory that can
be easily shared across deployments when using zero down-time deployment systems like Envoyer.

To create the symbolic link, you may use the storage:link Artisan command:

```
php artisan storage:link
```

### Run Migrations

```
php artisan migrate
```

### Run Db Seed

This is needed to seed the database with old systems users, locations, and categories etc.
```
php artisan db:seed
```

### Edit auth.json

Please make sure to add auth.json. This file is ignored so not included in repo. Format should be:

```json
{
    "http-basic": {
        "backpackforlaravel.com": {
            "username": "",
            "password": ""
        }
    },
    "github-oauth": {
        "github.com": ""
    }
}
```

### .env file additions

Make sure to have include following in env file

```
DB_TABLE_PREFIX='dux_'
billing_TAX_PER=7
DUX_BEARER_TOKEN=
PAYPAL_SANDBOX_CLIENT_ID=
PAYPAL_SANDBOX_CLIENT_SECRET
PAYPAL_LIVE_CLIENT_ID=
PAYPAL_LIVE_CLIENT_SECRET=
PAYPAL_MODE=sandbox
DUX_API_URL=
GOOGLE_MAPS_API_KEY="api_key"
```

# testing

## End to End Testing

* Use Laravel Dusk for end to end testing
* Creating an end to end test using Dusk:
  ```
  php artisan dusk make:SomeTest
  ```
    * Running Tests
   ```
  php artisan dusk
  ```

## Unit Tests

### Setup

Make sure you ran php artisan pest:install

### Creating a Test (Pest)

``` 
php artisan make:test UserFormCreateTest --pest
```

### Running Pests

```bash
./vendor/bin/pest
```

# Architecture design

Please incorporate S.O.L.I.D. design patterns as much as possible in order to make code maintable in the future:
see https://www.linkedin.com/pulse/writing-solid-laravel-code-andy-beak/

### Laravel Backpack

To implement the UI, we will use Laravel Backpack

Laravel backpack has extensive documentation. Please See https://backpackforlaravel.com/docs/5.x/crud-how-to

### Backpack configuration

Backpack configuration can be found in

```bash
/config/backpack/base.php 
```

### Core UI

Note: Laravel Backpack uses Core UI, here is some docs:
https://coreui.io/docs/layout/columns/

# Important Folders

| Description            | URL                                                |
|------------------------|----------------------------------------------------|
| Backpack configuration | config/backpack/base.php                           |
| Images and Theme       | public/packages/dux/duxtheme/                      |
| Dux Logo               | public/packages/dux/duxtheme/img/dux_logo_icon.png |
| Login Page             | resources/views/auth/login.blade.php               |

# help

| Description         | URL                                                |
|---------------------|----------------------------------------------------|
| gitter for backpack |https://gitter.im/BackpackForLaravel/Lobby|





# Dev Troubleshooting

### git
Git can handle this by auto-converting CRLF line endings into LF when you add a file to the index, and vice versa when it checks out code onto your filesystem. You can turn on this functionality with the core.autocrlf setting. If you’re on a Windows machine, set it to true – this converts LF endings into CRLF when you check out code:
git config --global core.autocrlf true

If you’re on a Linux or Mac system that uses LF line endings, then you don’t want Git to automatically convert them when you check out files; however, if a file with CRLF endings accidentally gets introduced, then you may want Git to fix it. You can tell Git to convert CRLF to LF on commit but not the other way around by setting core.autocrlf to input:
git config --global core.autocrlf input

### PHPStorm line Endings Config
https://stackoverflow.com/questions/27524228/phpstorm-sync-how-to-ignore-line-separators
