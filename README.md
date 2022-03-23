# My idlers

A web app for displaying, organizing and storing information about servers (VPS), shared & reseller hosting, domains,
DNS and misc services.

Despite what the name infers this self hosted web app isn't just for storing idling server information. By using
a [YABs](https://github.com/masonr/yet-another-bench-script) output you can get disk & network speed values along with
GeekBench 5 scores to do easier comparing and sorting.

[![Generic badge](https://img.shields.io/badge/version-2.0-blue.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/Laravel-9.0-red.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/PHP-8.1-purple.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/Bootstrap-5.1-pink.svg)](https://shields.io/)

## V2 notes

V2 build is a complete overhaul of My idlers with the project being moved onto the Laravel framework. This will simplify
development and most of the features from the original build will be present in V2.

Using Laravel will bring in an API endpoint and the possibilities to show servers publicly with certain parameters
removed.

## Project sponsor

[Cloud Five Limited](https://cloud-v.net/) for providing the hosting for demo installation.

## 2.0 changes:

**Unfortunately you cannot migrate your current install to the new 2.0 version**

* Laravel framework (version 9).
* Breeze authentication.
* API GET for any of the CRUD data.
* Labels (titles/desc) CRUD.
* Misc services CRUD.
* DNS CRUD.
* Ip address CRUD.
* Reseller hosting.
* Added Operating systems to DB, Deleting and creating them now possible.
* Make servers displayable public with config options to hide certain values.
* Vue JS used where possible.
* Datatables used on large tables (Locations, labels, and providers).
* Added caching for home page and servers

## Requires

* PHP 8 (minimum, compatible with 8.1)

## Features

* Add servers
* Add shared hosting
* Add domains
* [Auto get IP's from hostname](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ips-from-hostname.gif)
* [Check up/down status](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ping-up-feature.gif)
* Get YABs data from output
* Compare 2 servers
* Save & view YABs output
* Update YABs disk & network results
* Next due date system
* Multi currency compatibility
* Multi payment-term compatibility
* Pre-defined operating systems
* Assign labels
* Assign server type (KVM, OVZ, LXC & dedi)
* Easy to edit values

## Install

* Run `git clone https://github.com/cp6/my-idlers.git` into your directory of choice
* Run `composer install`
* Run `cp .env.example .env`
* Edit (If needed) MySQL details in .env
* Run `php artisan key:generate`
* Run `php artisan make:database my_idlers` to create database
* Run `php artisan migrate:fresh --seed` to create tables and seed data
* Run `php artisan serve`

## Run using Docker
```
docker run \
  -p 8000:8000\
  -e APP_URL=https://... \
  -e APP_FORCE_SSL=true \
  -e DB_HOST=... \
  -e DB_DATABASE=... \
  -e DB_USERNAME=... \
  -e DB_PASSWORD=... \
  ghcr.io/m3nu/my-idlers:latest  # TODO: adjust after official image is set up!
docker exec ... php artisan migrate:fresh --seed --force  # Set up database one time
```

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

`settings/`

`shared/`

`shared/{id}`

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

**Make sure YABs output starts at the first line which is:**

```# ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #```

## Screenshots for v2

[![My idlers screenshot1](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-home-2.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-home-2.jpg)

[![My idlers screenshot2](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-server-view.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-server-view.jpg)

[![My idlers screenshot3](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-home.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-home.jpg)

[![My idlers screenshot4](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-YABs.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-YABs.jpg)

[![My idlers screenshot5](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-add-server_2.png)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-add-server_2.png)

[![My idlers screenshot6](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-compare.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-servers-compare.jpg)

[![My idlers screenshot7](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-Ips.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-Ips.jpg)

[![My idlers screenshot8](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-labels.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2022/03/My-idlers-v2-labels.jpg)
