=== WooCommerce Dropbox ===
Contributors: Vadiem Janssens
Tags: woocommerce, dropbox, downloadable product
Requires at least: 3.9
Tested up to: 4.0
Stable tag: 1.0.1
License: GPL v3

Easily choose a Dropbox file to be used as a Downloadable Product for WooCommerce.

== Description ==
The Dropbox extension for WooCommerce gives you the power and ease of use of serving your downloadable products
through the Dropbox infrastructure. Easily choose a file from your Dropbox account via the Choose from Dropbox
button and the plugin will do the rest.

> Please carefully read the [installation instructions](http://www.wordpress.org/plugins/woocommerce-dropbox).

== Installation ==
Important; make sure you have installed and activated WooCommerce.

1. Upload the `woocommerce-dropbox` folder to the `/wp-content/plugins/` directory
2. Activate the WooCommerce Dropbox plugin through the 'Plugins' menu in WordPress
3. Go to [the Dropbox Developers app console](https://www.dropbox.com/developers/apps)
4. Press the blue button `Create app`
5. Choose `Drop-ins app`
6. Set a unique app-name (eg. `[storename]-woocommerce`)
7. Copy your app key
8. While on the settings tab add your domain to `Drop-ins domains`
9. Go back to your WordPress site
10. Go to `WooCommerce` -> `Settings`
11. Open the tab `Integration` -> `Dropbox Integration`
12. Paste your API-key and save changes.

Dropbox for WooCommerce is now installed and configured.

== Changelog ==

= 1.0 =
* Initial version