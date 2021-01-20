# My idlers

A web app for displaying, organizing and storing information about servers (VPS), shared hosting and domains.

Despite what the name infers this self hosted web app isn't just for storing idling server information. 
By using a [YABs](https://github.com/masonr/yet-another-bench-script) output you can get disk & network speed values along with GeekBench 5 scores to do easier comparing and sorting.

[![Generic badge](https://img.shields.io/badge/version-1.0-blue.svg)](https://shields.io/)

### Requires

* PHP 7.4 (compatible with 8.0)
* MySQL

### Features
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

### Install

* Unpack the files into your directory of choice.
* Run `my_idlers.sql` in MySQL.
* Edit ```class.php``` lines ```544-547``` for you MySQL details.


### Notes

**There is no authentication provided!**
 Either use on a local network or put behind authentication.
 
 **A trimmed Bootstrap is used.** Only the used classes and elements are in ```style.css``` 
 Therefore adding more obscure columns or Bootstrap classes will not initially work as intended until you put this source css into ```style.css```.  

**Auto complete provider & location are text inputs!** This means that if your choice isn't there then simply type it out
 and upon form submission it gets added to the pool to choose from next time.

### Screenshots

[![Screenshot1](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data.jpg)]()

[![screenshot2](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data-MORE.jpg)]()

[![screenshot3](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-data-EDIT.jpg)]()

[![screenshot4](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-order-table.png)]()

[![screenshot5](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-tally-card.png)]()

[![Auto complete location](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-location.gif)]()

[![Auto complete provider](https://cdn.write.corbpie.com/wp-content/uploads/2021/01/my-idlers-self-hosted-server-domain-information-auto-provider.gif)]()

