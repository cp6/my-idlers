# My idlers

A web app for displaying, organizing and storing information about servers (VPS), shared hosting and domains.

Despite what the name infers this self hosted web app isn't just for storing idling server information. 
By using a [YABs](https://github.com/masonr/yet-another-bench-script) output you can get disk & network speed values along with GeekBench 5 scores to do easier comparing and sorting.

[![Generic badge](https://img.shields.io/badge/version-1.5-blue.svg)](https://shields.io/)

## 1.3 changes:
**If you have version 1.2 already installed please run ```update1.2to1.3.sql```**
* Added constant to set main view type (cards or table).
* Fixed DNS GET requests.
* Added label field/input for servers.
* Fixed domain & shared hosting deletion.
* Updated to dns_get_record() instead of DNS API calling.
* Added KB/s to MB/s conversion.
* Fixed active status for view type div.
* Added attach domain to server or shared hosting.
* Updated search to include tags and labels.
* Updated server view more modal formatting.
* Updated server edit modal formatting.
* Updated `my_idlers.sql` for changes

## Requires

* PHP 7.4 (compatible with 8.0)
* MySQL

## Features
* Add servers
* Add shared hosting
* Add domains
* [Auto suggest locations](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)
* [Auto suggest providers](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)
* [Auto get IP's from hostname](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ips-from-hostname.gif)
* [Check up/down status](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-ping-up-feature.gif)
* Get YABs data from output
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

* Download [the zip](https://github.com/cp6/my-idlers/archive/main.zip) and unpack the files from ```my-idlers-main/``` into your directory of choice.
* Run `my_idlers.sql` in MySQL.
  
* **Only run ```update1.2to1.3.sql``` if you have version 1.2 installed.**
  
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
 Therefore adding more obscure columns or Bootstrap classes will not initially work as intended until you put this source css into ```style.css```.  

**Auto complete provider & location are text inputs!** This means that if your choice isn't there then simply type it out
 and upon form submission it gets added to the pool to choose from next time.

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

