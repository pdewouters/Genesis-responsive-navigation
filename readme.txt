=== Genesis Responsive Menu ===
Contributors: pauldewouters
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=27D8DE74RF99A
Tags: navigation,menus,menu,responsive
Requires at least: 3.0.0
Tested up to: 3.4
Stable tag: 0.1

Responsive navigation system for use with the Genesis framework.

== Description ==

This plugin uses WordPress custom menus added in version 3.0. 
It requires that you use the Genesis theme framework.
Genesis Responsive Menu only displays the submenu for the currently active top level item, using CSS.
It is much like the navigation from starbucks.com.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin folder to your wp-content/plugins directory, or install it through the admin interface.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place '<? add_action('genesis_after_header','child_do_gsrm_menu');
function child_do_gsrm_menu(){
    if(function_exists('gsrm_display_menu')) gsrm_display_menu();
} ?>' in your functions.php file

== Frequently Asked Questions ==

= Does it only work with Genesis? =

At the moment, yes.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the directory of the stable readme.txt, so in this case, `/tags/4.3/screenshot-1.png` (or jpg, jpeg, gif)
2. This is the second screen shot

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`