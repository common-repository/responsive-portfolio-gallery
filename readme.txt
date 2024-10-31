=== Responsive Portfolio Gallery ===
Plugin URI: http://www.rocketship.co.nz
Description: A responsive portfolio gallery for your website, includes switchable views, filterable categories and shortcodes for 2, 3 and 4 columns.
Version: 1.2.1
Requires at least: 4.7
Tested up to: 4.7
Stable tag: trunk
Contributors: Shane Watters
Author URI: http://www.rocketship.conz
Tags: best gallery, best gallery plugin, best portfolio plugin, categories, categorized portfolio, category, columns, filterable jquery portfolio plugin, filterable gallery, filterable portfolio, filterable portfolio categories,
free gallery, fullscreen, fullscreen gallery, gallery, gallery shortcode, isotope, jquery gallery, jquery portfolio, multiple view switcher, plugin, portfolio, portfolio categories, portfolio filter plugin, portfolio gallery,
portfolio plugin, portfolio plugin wordpress, portfolio with categories, portfolio with filters, portfolio wordpress plugin, project, projects, responsive, responsive design, responsive portfolio gallery, responsive portfolio plugin,
screenshot, screenshots, shortcode, simple gallery, sortable portfolio, thumbnail, thumbnails, thumbs, web design company portfolio plugin, web designer, web designer portfolio, web designer gallery, web developer,
web developer portfolio, web developer gallery, website gallery, wordpress gallery, wordpress gallery plugin, wordpress portfolio, wordpress portfolio plugin, wp gallery, wp gallery plugin, wp portfolio plugin
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Responsive Portfolio Gallery is a filterable gallery where you can display portfolio of your work or images. It also provides external website links for each portfolio item making it the perfect gallery option for a website designer or developer.

You can add portfolio items from Dashboard > Portfolio Items > Add New.

You can display your portfolio on any page of your website by using one of the following shortcodes:

* [2-column-responsive-portfolio]
* [3-column-responsive-portfolio]
* [4-column-responsive-portfolio]

You can set the initial view of your portfolio gallery by setting the "default-view" option in the shortcode, for example:

* [4-column-responsive-portfolio default-view='hybrid']
* [4-column-responsive-portfolio default-view='list']

You can also display a gallery that will only show portfolio items if they contain at least one category listed in the "categories" option of the shortcode, for example:

* [4-column-responsive-portfolio categories='Responsive Design,Shopping']

To view a live demo of this plugin click <a href="http://responsive-portfolio-gallery-demo.rocketship.co.nz/" target="_blank">here</a>.

== Installation ==

1. Upload the plugin to your 'wp-content/plugins' directory, or download and install automatically through your admin panel, or checkout the repository from <a href="http://plugins.svn.wordpress.org" target="_blank">http://plugins.svn.wordpress.org/</a>.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Click on the new menu item "Portfolio" then create your portfolio items.
4. Choose one of three shortcodes to display your gallery: [2-column-responsive-portfolio], [3-column-responsive-portfolio], [4-column-responsive-portfolio].
5. Edit the page that you want your portfolio to appear on and paste the shortcode into it.

== Frequently Asked Questions ==

= Where to ask questions? =

Please use the WordPress <a href="http://wordpress.org/support/plugin/responsive-portfolio-gallery">support forums</a> to ask any query regarding any issue.</p>

== Screenshots ==

1. Full Screen Frontend Gallery

2. Mobile Devices Frontend Gallery

3. Single Portfolio Item Frontend

4. Adding A New Category

5. Adding A New Portfolio Item

6. Setting The Featured Image For A Portfolio Item

7. Adding The Gallery Shortcode To A Page

== Changelog ==

= 1.1 =
* Adding loading overlay to portfolio gallery page that fades out once all images are loaded.
* Adding categories option to shortcode that allows a gallery to display only portfolio items that have one of the categories
* Adding default-view option to shortcode that allows the user to set the default view of the gallery
* Adding the ability for the gallery image to link to an external URL and choose if the link with open in the current browser tab or a new tab
* Adding the ability to choose whether website URL will open in the current browser tab or a new tab

= 1.1.1 =
* Implementing functionality to allow single-portfolio-item.php template to be used themes

= 1.2 =
* Improving shortcode functionality so that the HTML output is done via a return statement rather than an echo statement

= 1.2.1 =
* Minor improvement to loading of default view
