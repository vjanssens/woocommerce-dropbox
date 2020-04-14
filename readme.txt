=== WooCommerce Dropbox ===
Contributors: vadiemjanssens
Tags: woocommerce, dropbox, downloadable, products, downloadable product
Requires at least: 4.5
Tested up to: 5.4
Stable tag: 1.2.2
Requires PHP: 7.2
License: GPL v3

Easily choose a Dropbox file to be used as a Downloadable Product for WooCommerce.

== Description ==
The Dropbox for WooCommerce extension gives you the power and ease of use of serving your downloadable products
through the Dropbox infrastructure.
Easily choose a file from your Dropbox account via the Choose from Dropbox button and the plugin will do the rest.

Please carefully read the [installation instructions](http://www.wordpress.org/plugins/woocommerce-dropbox/installation/).

> <strong>Before using this plugin:</strong><br>
> Dropbox has usage limits on public links when using a free, pro or business account. Please be aware of this limitation before you use this plugin.<br>
> <br>
> <strong>Free account:</strong> 20GB per day or 100,000 downloads before the link automatically expires<br>
> <strong>Pro or Business account:</strong> 200GB per day before the link automatically expires (no limit on number of downloads)<br>
> <br>
> More information on the usage limits can be found [here](https://www.dropbox.com/help/4204).<br>
> <br>
> This plugin is in best use for PDF's, Text documents, Excel Documents etc. (not for video's or other large files).

= Development =
Development takes place at [this GitHub Repository](https://github.com/vjanssens/woocommerce-dropbox)

== Installation ==
**Important:** make sure you have installed and activated WooCommerce.

1. Install the plugin through the WordPress admin or manually upload the `woocommerce-dropbox` folder to the `/wp-content/plugins/` directory
2. Activate the WooCommerce Dropbox plugin through the 'Plugins' menu in WordPress
3. Go to [the Dropbox Developers app console](https://www.dropbox.com/developers/apps)
4. Press the blue button `Create app`
5. Choose 'Dropbox API' for Step 1
6. Choose 'Full Dropbox' for Step 2
7. Set a unique app-name (eg. `[storename]-woocommerce`) for Step 3
8. While on the Settings tab, copy your app key (somewhere in the middle of the page)
9. While on the Settings tab, add your domain to the field 'Choose/Saver domains'
10. Go back to your WordPress site
11. Go to `WooCommerce` -> `Settings`
12. Open the tab `Integration` -> `Dropbox Integration`
13. Paste your API-key and save changes.

Dropbox for WooCommerce is now installed and configured.

> Still having trouble with the installation? Plugin not working as you would expect?
> Please open a support ticket in [the support forums](https://wordpress.org/support/plugin/woocommerce-dropbox).

== Frequently Asked Questions ==

= {"error": "Origin does not match any app domain"} =
Please make sure you have entered the right domain while you're at [step 8](https://wordpress.org/plugins/woocommerce-dropbox/installation/) of the installation instructions.
You can find the right domain when browsing to your WordPress installation and copy the URL from your browser.
It is also possible to add multiple domain name's to the <strong>Drop-ins domains</strong> field. This is especially usefull when working with multiple environments (local, dev, production).

= Customer get expired links =
Dropbox has usage limits in place for shared links.
Please refer to [this page](https://wordpress.org/plugins/woocommerce-dropbox/) for more information.

== Screenshots ==

1. Product detail page with 'Choose from Dropbox'-button
2. Plugin settings page

== Changelog ==

= 1.2.2 =
Release date: April 14th, 2020

* Tested plugin for WordPress version 5.4 and WooCommerce 4.0.1

= 1.2.0 =
Release date: March 12th, 2020

* Tested plugin for WordPress version 5.3.2 and WooCommerce 4.0.0
* Fixed settings link on plugins overview

= 1.1.1 =
Release date: August 3rd, 2016

* Tested plugin for WordPress version 4.6
* Fixed a bug where the customizer was unable to load (thanks to tokegameart for reporting)
* Improved onboarding experience when activating plugin
* Added support links to plugin overview

= 1.1.0 =
Release date: July 27th, 2016

* Tested plugin for WordPress version 4.5.3 and WooCommerce 2.6.3
* It's now possible to add a file from Dropbox for variable products

= 1.0.6 =
Release date: January 22nd, 2016

* Tested plugin for WordPress version 4.4.1 and WooCommerce 2.5.0
* Updated installation instructions
* Added dutch (nl_NL) translation

= 1.0.5  =
Release date: April 9th, 2015

* Fixed URL encoding bug

= 1.0.4 =
* Tested plugin for WordPress version 4.1

= 1.0.3 =
* Fix URL encoding bug

= 1.0.2 =
* Bugfixes

= 1.0.1 =
* Bugfixes

= 1.0 =
* Initial version
