# My idlers

A self-hosted web app for displaying, organizing and storing information about your servers (VPS/Dedi), shared &
reseller hosting, seedboxes,
domains, DNS and misc services.

Despite what the name infers this self-hosted web app isn't just for storing idling server information. By using
a [YABS](https://github.com/masonr/yet-another-bench-script) output you can get disk & network speed values along with
GeekBench 5 & 6 scores to do easier comparing and sorting. Of course storing other services e.g. web hosting is possible
and supported too with My idlers.

[![Generic badge](https://img.shields.io/badge/version-4.0.0-blue.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/Laravel-11.48-red.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/PHP-8.3-purple.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/Bootstrap-5.3-pink.svg)](https://shields.io/)

<img src="https://raw.githubusercontent.com/cp6/my-idlers/main/public/My%20Idlers%20logo.jpg" width="128" height="128" />

[View demo site](https://demo.myidlers.com/)

**Note:** Create, Update and Delete are disabled on the demo site.

## Project sponsor

Currently seeking a project sponsor

## 4.0.0 changes (February 2026):

* Updated Laravel version to 11.48
* Updated Bootstrap version to 5.3.8
* Updated all composer package versions
* Updated all npm package versions
* Fixed security vulnerabilities in dependencies
* Added comprehensive seeders for Users, Servers, Shared, Reseller, Domains, Misc and DNS
* Added YABS seeder with sample benchmark data
* Updated Dockerfile to PHP 8.3 with additional extensions (bcmath, pcntl)
* Improved Dockerfile with production optimizations and health check
* Improved run.sh with better env defaults, caching and optional auto-migrate
* Modernized auth pages (login, register, forgot/reset password) with clean design
* Added light and dark mode support for auth pages
* Added `MAX_USERS` env variable to control registration limit (0 = unlimited)
* Redesigned dashboard with cleaner stat cards, costs and resources sections
* Modernized navbar with improved styling and hover states
* Updated dark mode with new color scheme and page background
* Modernized all index pages with consistent card-based layout and improved table styling
* Improved DataTables styling (search, pagination, dropdown) for light and dark modes
* Fixed DataTables error alerts on empty tables
* Made demo user and sample data seeding optional via `SEED_DEMO_DATA` env variable
* Redesigned all create and edit pages with organized card sections and consistent form styling
* Redesigned all show/detail pages with polished detail cards and visual hierarchy
* Modernized settings page with organized card-based sections
* Modernized account page with profile and API token sections
* Modernized server and YABS comparison pages with improved table styling
* Modernized public server listing page with consistent design
* Added comprehensive test suite with 150 tests covering all major features
* Added servers index card view option in settings (table or cards layout)
* Fixed Vue.js loading issues on comparison pages
* Fixed server comparison null value handling
* Removed unused legacy auth pages and components

### Test Suite

The application now includes a comprehensive test suite with 150 tests and 294 assertions:

**Feature Tests:**
- Authentication (login, registration, password reset, email verification)
- Servers CRUD operations and validation
- Domains CRUD operations and validation
- DNS records CRUD operations and validation
- Providers, Locations, Labels, OS CRUD operations
- IP addresses CRUD operations with HTTP mocking
- Home dashboard functionality

**Unit Tests:**
- Server model (server types, comparison logic)
- Pricing model (cost calculations, term conversions)
- Settings model (sorting/ordering logic)
- Labels model (assignment operations)
- IPs model (IPv4/IPv6 handling)
- DNS model (type constants)

Run tests with:
```shell
vendor/bin/phpunit
# or with testdox output
vendor/bin/phpunit --testdox
```

### Database Seeding

The seeder is split into two parts:

**Core data (always seeded):** Settings, Providers, Locations, OS, Labels - required for the app to function.

**Demo data (optional):** Admin user and sample services (servers, domains, shared hosting, etc.)

```shell
# Fresh install (core data only - recommended for production)
php artisan migrate:fresh --seed

# Fresh install with demo data
# First add SEED_DEMO_DATA=true to your .env file, then:
php artisan migrate:fresh --seed
```

### Demo Login Credentials

When `SEED_DEMO_DATA=true` is set, a demo user is created:

| Email | Password |
|-------|----------|
| admin@admin.com | password |

#### Please run the following if updating from an existing install:

```shell
composer update
php artisan migrate
php artisan route:cache
php artisan cache:clear
```

## 3.0.0 changes (9 December 2024):

* Updated PHP version to 8.3
* Updated Laravel version to ^11
* Updated composer package versions
* Updated routes into middleware grouping for auth
* Updated login and register forms
* Updated servers, shared, reseller and domains pages to use Datatables
* Added icons to back and submit button components
* Added icon button to shared and reseller create pages
* Added several updated OS versions to OsSeeder
* Added Font awesome Brands webfont
* Added IP whois data columns to the ips table
* Added IP whois data fetching and updating DB
* Added Note to API
* Fixed OS icons not loading in servers index page
* Fixed Settings being called without being created (existing)
* Fixed issue with OS: `Call to a member function toJson() on array`
* Fixed due in (days) column showing a massive float
* Removed 1 user being seeded
* Removed doctrine/dbal

## Requires

* PHP 8.3

## Features

* Add servers
* Add shared hosting
* Add domains
* [Auto get IP's from hostname](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ips-from-hostname.gif)
* [Check up/down status](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ping-up-feature.gif)
* Get YABS data from output
* Compare 2 servers
* Save & view YABS output
* Update YABS disk & network results
* Next due date system
* Multi currency compatibility
* Multi payment-term compatibility
* Pre-defined operating systems
* Assign labels
* Assign server type (KVM, OVZ, LXC & dedi)
* Easy to edit values
* Assign notes

## Install

* Run `git clone https://github.com/cp6/my-idlers.git` into your directory of choice
* Run `composer install`
* Run `cp .env.example .env`
* Edit (If needed) MySQL details in .env
* Run `php artisan key:generate`
* Run `php artisan make:database my_idlers` to create database
* Run `php artisan migrate:fresh --seed` to create tables and seed data
* Run `php artisan serve`

## Updating

If you already have at least version 2.0 installed:

* Run `git clone https://github.com/cp6/my-idlers.git`
* Run `composer install`
* Run `composer update`
* Run `php artisan migrate`
* Run `php artisan route:cache`
* Run `php artisan cache:clear`

## Run using Docker

```
docker run \
  -p 8000:8000\
  -e APP_URL=https://... \
  -e DB_HOST=... \
  -e DB_DATABASE=... \
  -e DB_USERNAME=... \
  -e DB_PASSWORD=... \
  ghcr.io/cp6/my-idlers:latest
docker exec ... php artisan migrate:fresh --seed --force  # Set up database one time
```

## Managed Hosting

Run with a single click on [PikaPods.com](https://www.pikapods.com/)

[![PikaPods](https://www.pikapods.com/static/run-button.svg)](https://www.pikapods.com/pods?run=my-idlers)

## Adding a YABS benchmark

yabs.sh now has JSON formatted response and can POST the output directly from calling the script.

With My idlers you can use your API key and the server id to directly POST the benchmark result

`https://yourdomain.com/api/yabs/SERVERID/USERAPIKEYISHERE`

Example yabs.sh call to POST the result:

`curl -sL yabs.sh | bash -s -- -s "https://yourdomain.com/api/yabs/SERVERID/USERAPIKEYISHERE"`

## Credits

IP who is data provided by [ipwhois.io](https://ipwhois.io/documentation)

## API endpoints

For GET requests the header must have `Accept: application/json` and your API token (found at `/account`)

`Authorization : Bearer API_TOKEN_HERE`

All API requests must be appended with `api/` e.g `mydomain.com/api/servers/gYk8J0a7`

**GET request:**

`dns/`

`dns/{id}`

`domains/`

`domains/{id}`

`servers`

`servers/{id}`

`labels/`

`labels/{id}`

`locations/`

`locations/{id}`

`misc/`

`misc/{id}`

`networkSpeeds/`

`networkSpeeds/{id}`

`os/`

`os/{id}`

`pricing/`

`pricing/{id}`

`providers/`

`providers/{id}`

`reseller/`

`reseller/{id}`

`seedbox/`

`seedbox/{id}`

`settings/`

`shared/`

`shared/{id}`

`note/{id}`

**POST requests**

Create a server

`/servers`

Body content template

```json
{
    "active": 1,
    "show_public": 0,
    "hostname": "test.domain.com",
    "ns1": "ns1",
    "ns2": "ns2",
    "server_type": 1,
    "os_id": 2,
    "provider_id": 10,
    "location_id": 15,
    "ssh_port": 22,
    "bandwidth": 2000,
    "ram": 2024,
    "ram_type": "MB",
    "ram_as_mb": 2024,
    "disk": 30,
    "disk_type": "GB",
    "disk_as_gb": 30,
    "cpu": 2,
    "has_yabs": 0,
    "was_promo": 1,
    "ip1": "127.0.0.1",
    "ip2": null,
    "owned_since": "2022-01-01",
    "currency": "USD",
    "price": 4.00,
    "payment_term": 1,
    "as_usd": 4.00,
    "usd_per_month": 4.00,
    "next_due_date": "2022-02-01"
}
```

**PUT requests**

Update a server

`/servers/ID`

Body content template

```json
{
    "active": 1,
    "show_public": 0,
    "hostname": "test.domain.com",
    "ns1": "ns1",
    "ns2": "ns2",
    "server_type": 1,
    "os_id": 2,
    "provider_id": 10,
    "location_id": 15,
    "ssh_port": 22,
    "bandwidth": 2000,
    "ram": 2024,
    "ram_type": "MB",
    "ram_as_mb": 2024,
    "disk": 30,
    "disk_type": "GB",
    "disk_as_gb": 30,
    "cpu": 2,
    "has_yabs": 0,
    "was_promo": 1,
    "owned_since": "2022-01-01"
}
```

Update pricing

`/pricing/ID`

Body content template

```json
{
    "price": 10.50,
    "currency": "USD",
    "term": 1
}
```

**DELETE requests**

Delete a server

`/servers/ID`

## Notes

**Public viewable listings**

If enabled the public viewable table for your server listings is at `/servers/public`
You can configure what you want viewable at ```/settings```

**Due date / due soon**

This is simply just a reminder. If the homepage is requested (viewed) when a service is over due date it will get reset
to plus the term from the old due date.

E.g if the term is a month then the due date gets updated to be 1 month from the old due date.

**Supporting YABS commands:**

```curl -sL yabs.sh | bash```

or

```curl -sL yabs.sh | bash -s -- -r```

Logo icons created by Freepik - Flaticon

## Screenshots for v2

[![My idlers screenshot1](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-home-2.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-home-2.jpg)

[![My idlers screenshot2](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-server-view.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-server-view.jpg)

[![My idlers screenshot3](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-home.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-home.jpg)

[![My idlers screenshot4](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-YABs.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-YABs.jpg)

[![My idlers screenshot5](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-add-server_2.png)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-add-server_2.png)

[![My idlers screenshot6](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-compare.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-compare.jpg)

[![My idlers screenshot7](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-Ips.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-Ips.jpg)

[![My idlers screenshot8](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-labels.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-labels.jpg)
