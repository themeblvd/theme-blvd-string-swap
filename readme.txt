=== Theme Blvd String Swap ===
Contributors: themeblvd
Tags: themeblvd, localization, localize, translate
Requires at least: Theme Blvd Framework 2.0+
Stable tag: 1.0.7

When using a theme with Theme Blvd framework version 2.0+, this plugin is will allow to translate strings you see on the frontend of your website.

== Description ==

When using a theme with Theme Blvd framework version 2.0+, this plugin is will provide you with a user-friendly interface to translate most of the strings you see on the frontend of your website.

= Who is this plugin for? =

This plugin is useful for people trying to accomplish a couple different things. Let me explain.

**Localization:** The most obvious use for this plugin would be to allow you to translate the theme's frontend text strings into whatever language you want your site displayed in. But then, why not use WordPress localization? Yes, all Theme Blvd themes of course come localization-ready, but let's face it this is daunting task for most. Let's say you just can't figure out how this darn WordPress localization works, this will give you a simpler option. Or say you don't care about translating *everything* throughout the WordPress admin panel, and all you care about is the audience coming to your site, this is also the quick alternative to localization that'll be perfect for you.

**Simply Changing Text:** And don't forget about the other obvious use for this plugin. What if you simply do not like the way I word the things I've coded into the theme framework? So, in that case, even if your site is in English, you may still find this plugin useful, as you can simply swap out select text strings througout the site with your own.

= How does it work? =

Within the Theme Blvd framework, *most* strings that appear on the frontend of your site come from a single array that we've placed a filter on. This means that from your own child theme or plugin, you could easily change any one of these text strings.

After you install this plugin, you can then go to *Tools > TB String Swap* in your WordPress admin panel and change any of these text strings through the user-friendly interface, opposed to ever editing any code.

== Installation ==

1. Upload `theme-blvd-string-swap` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to *Tools > TB String Swap* to use.

== Screenshots ==

1. Admin interface for plugin under *Tools > TB String Swap*.

== Changelog ==

= 1.0.7 =

= 1.0.6 =

* GlotPress compatibility (for 2015 wordpress.org release).
* Minor security fix.

= 1.0.5 =

* Fixed "Dismiss" link not working for framework notice on all admin pages.

= 1.0.4 =

* Added compatibility for framework v2.3.

= 1.0.3 =

* Added compatibility for framework v2.2.

= 1.0.2 =

* Added compatibility for latest Theme Blvd patch updates - Akita v1.1.5, Alyeska v2.1.5, Arcadian v1.1.5, Barely Corporate v3.1.5, Breakout v1.1.4, Prime Time v1.1.4, and Swagger 1.1.5

= 1.0.1 =

* Plugin now works with a more dynamically to pull text strings with new structure of [Theme Blvd Framework 2.1 update](http://www.wpjumpstart.com/framework-updates/theme-blvd-2-1-0-framework-update/) with fallbacks built-in for previous framework versions.
* Added higher priority to text string filter to ensure that the plugin will, not only override the framework, but also any text strings edits your premium theme may have made.

= 1.0.0 =

* This is the first release.