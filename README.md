# My idlers

A web app for displaying, organizing and storing information about servers (VPS), shared & reseller hosting, seed boxes, domains,
DNS and misc services.

Despite what the name infers this self hosted web app isn't just for storing idling server information. By using
a [YABs](https://github.com/masonr/yet-another-bench-script) output you can get disk & network speed values along with
GeekBench 5 scores to do easier comparing and sorting.

[![Generic badge](https://img.shields.io/badge/version-2.1.0-blue.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/Laravel-9.0-red.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/PHP-8.1-purple.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/Bootstrap-5.1-pink.svg)](https://shields.io/)

<img src="https://raw.githubusercontent.com/cp6/my-idlers/main/public/My%20Idlers%20logo.jpg" width="128" height="128" />

[Demo site](https://demo.myidlers.com/) 

**Note:** Create, Update and Delete are disabled on demo site.

## Project sponsor

[Cloud Five Limited](https://cloud-v.net/) for providing the hosting for demo installation.

## 2.1.0 changes:

* Added Seedbox CRUD
* Added dark mode (settings option. Bootstrap-Night https://vinorodrigues.github.io/bootstrap-dark-5/)
* Added some foreign keys for certain tables
* Added functions for IP and label assignments
* Added functions to forget (clear) cache, preventing chunks of duplicate code
* Added VMware to server virt select dropdown options
* Added Kharkiv and Sao Paulo to locations seeder
* Updated Controllers with DB calls and logic moved to relevant Model
* Updated YABs inserts for version v2022-05-06
* Updated DB calls to use caching
* Updated Home blade info cards to be col-6 instead of 12 when on mobile
* Updated home page view links on recently added
* Fixed YABs insert error not displaying

## Requires

* PHP 8 (8.1 recommended)

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

## Update

If you have at least version 2.0 installed:

* Run `git clone https://github.com/cp6/my-idlers.git`
* Run `composer install`
* Run `php artisan migrate`

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
