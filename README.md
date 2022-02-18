# My idlers

A web app for displaying, organizing and storing information about servers (VPS), shared & reseller hosting, domains,
DNS and misc services.

Despite what the name infers this self hosted web app isn't just for storing idling server information. By using
a [YABs](https://github.com/masonr/yet-another-bench-script) output you can get disk & network speed values along with
GeekBench 5 scores to do easier comparing and sorting.

## V2 notes

V2 build is a complete overhaul of My idlers with the project being moved onto the Laravel framework. This will simplify
development and most of the features from the original build will be present in V2.

Using Laravel will bring in an API endpoint and the possibilities to show servers publicly with certain parameters
removed.

[Old version live demo](https://myidlers.srv3r.com/)

[![Generic badge](https://img.shields.io/badge/version-2.0-blue.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/Laravel-9.0-red.svg)](https://shields.io/) [![Generic badge](https://img.shields.io/badge/PHP-8.1-purple.svg)](https://shields.io/)

## 2.0 changes:

**Unfortunately you cannot migrate your current install to the new 2.0 version**

* Laravel framework (version 9)
* Breeze authentication
* API GET for any of the CRUD data
* Labels (titles/desc) system
* Misc services
* DNS CRUD
* Make servers displayable public with config options to hide certain values.
* Vue JS used where possible

## Requires

* PHP 8 (compatible with 8.1)
* MySQL server

## Features

* Add servers
* Add shared hosting
* Add domains
* [Auto suggest locations](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)
* [Auto suggest providers](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)
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
* Assign tags
* Assign labels
* Assign server type (KVM, OVZ, LXC & dedi)
* Easy to edit values
* Order by table
* Search items
* Tally/stats card
* One-page design

## Install

* Download [the zip](https://github.com/cp6/my-idlers/archive/main.zip) and unpack the files from ```my-idlers-main/```
  into your directory of choice.
* Run `my_idlers.sql` in MySQL.

* **Only run ```update1.3to1.4.sql``` if you have version 1.3 installed.**

* Edit ```class.php``` lines ```13-16``` for your MySQL details.
* Edit ```class.php``` lines ```8-10``` for card order type.

* Make sure you have write access to process and store the YABs outputs.

## Notes

**There is no authentication provided!**
Either use on a local network or put behind authentication.

**Supporting YABS commands:**

```curl -sL yabs.sh | bash```

or

```curl -sL yabs.sh | bash -s -- -r```

**Make sure YABs output starts at the first line which is:**

```# ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #```

**A trimmed Bootstrap is used.** Only the used classes and elements are in ```style.css```
Therefore adding more obscure columns or Bootstrap classes will not initially work as intended until you put this source
css into ```style.css```.

**Auto complete provider & location are text inputs!** This means that if your choice isn't there then simply type it
out and upon form submission it gets added to the pool to choose from next time.

### Screenshots

[![My idlers screenshot1](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-cards.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-cards.jpg)

[![My idlers screenshot2](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-table.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-table.jpg)

[![My idlers screenshot3](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-more-modal.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-more-modal.jpg)

[![My idlers screenshot4](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-edit-modal.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-edit-modal.jpg)

[![My idlers screenshot5](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-order-servers.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-order-servers.jpg)

[![My idlers screenshot6](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-search.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-search.jpg)

[![My idlers screenshot7](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-summary-card.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-summary-card.jpg)

[![My idlers screenshot8](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-compare-two-servers.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-compare-two-servers.jpg)

[![My idlers screenshot9](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-add-server-from-yabs.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-add-server-from-yabs.jpg)

[![My idlers screenshot10](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-add-shared-hosting.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/02/my-idlers-self-hosted-server-info-add-shared-hosting.jpg)

[![Auto complete location](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)

[![Auto complete provider](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)

[![Auto complete IP's](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ips-from-hostname.gif)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ips-from-hostname.gif)

[![Get up/down status](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ping-up-feature.gif)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ping-up-feature.gif)

[![Table scrolling x](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-table-view.gif)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-table-view.gif)

