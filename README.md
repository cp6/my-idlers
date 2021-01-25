# My idlers

A web app for displaying, organizing and storing information about servers (VPS), shared hosting and domains.

Despite what the name infers this self hosted web app isn't just for storing idling server information. 
By using a [YABs](https://github.com/masonr/yet-another-bench-script) output you can get disk & network speed values along with GeekBench 5 scores to do easier comparing and sorting.

[![Generic badge](https://img.shields.io/badge/version-1.1-blue.svg)](https://shields.io/)

## 1.1 changes:
**If you have version 1.0 please run ```update.sql```**
* Added notes input for servers
* Added SSH port input for servers
* Added YABs update disk & network speed values (Keeps history)
* Added red button for closing modals
* Added `update.sql` for pre-existing installations only.
* Fixed page jumping horizontally when opening modals
* Fixed search showing duplicates when typing fast
* Fixed adding provider and locations return id
* Updated `my_idlers.sql` for changes
* Updated view YABs modal to be wider
* Updated config constants to new class at top of ```class.php```

## Requires

* PHP 7.4 (compatible with 8.0)
* MySQL

## Features
* Add servers
* Add shared hosting
* Add domains
* [Auto suggest locations](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)
* [Auto suggest providers](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)
* Get YABs data from output
* Save & view YABs output
* Next due date system
* Multi currency compatibility
* Multi payment-term compatibility
* Pre-defined operating systems
* Assign tags
* Assign server type (KVM, OVZ, LXC & dedi)
* Easy to edit values
* Order by table
* Search items
* Tally/stats card
* One-page design

## Install

* Download [the zip](https://github.com/cp6/my-idlers/archive/main.zip) and unpack the files from ```my-idlers-main/``` into your directory of choice.
* Run `my_idlers.sql` in MySQL.
  
* **Only run ```update.sql``` if you have version 1.0 installed.**
  
* Edit ```class.php``` lines ```13-16``` for your MySQL details.
* Edit ```class.php``` lines ```8-10``` for card order type.


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

[![Screenshot1](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data.jpg)


[![screenshot2](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data-MORE-1.1.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data-MORE-1.1.jpg)


[![screenshot3](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data-EDIT-1.1.jpg)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data-EDIT-1.1.jpg)


[![screenshot4](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-order-table.png)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-order-table.png)


[![screenshot5](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-tally-card.png)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-tally-card.png)


[![Auto complete location](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)


[![Auto complete provider](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)

