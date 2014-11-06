=== Lazy Social Buttons ===
Contributors: Godaddy
Tags: social, social buttons, lazy social buttons, lazy load, +1, google, facebook, like, share, twitter, tweet
Requires at least: 3.4
Tested up to: 3.4
Stable tag: 1.0.7
License: MIT
License URI: http://opensource.org/licenses/mit-license.php

Delayed loading of Google +1, Twitter and Facebook social buttons on your posts. Have your cake and eat it too; social buttons and performance.

== Description ==

Social buttons attract more visitors to your site. When users +1, Tweet, or
Like your page, it advertises your  page to their friends and followers. This
plugin adds social buttons to your posts as a small sprite at first and delays
loading the real buttons until the user hovers over the social buttons.  It
delays ~300KB of social button components by loading <6.5KB of our own script
and sprite. onMouseOver activates the load of the ~300KB of social button
components.

Our current version is limited to +1, Tweet, and Like and has the horizontal
display with the spinning wait indicator.

= Features =

* Loads small sprite of +1, Twitter and Facebook Like button
* Horizontal small button style
* onMouseOver activated switch to spinning icon 
* onMouseOver activated load of heavy social buttons
* Improves performance by delaying load of Social Buttons until onMouseOver
* Choose position above or below content, or manual
* Pick from google, twitter and facebook buttons
* Pick whether to display facebook share or just like
* Optionally use Google CDN for load of jquery
* Have suggestions? Visit and leave comment at:
* http://inside.godaddy.com/onhover-activated-social-buttons/

== Installation ==

1. Download the plugin and extract it
2. Copy the lazy-social-buttons folder to the "/wp-content/plugins/" directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Customize in Settings->Lazy Social Buttons

== Frequently Asked Questions ==

If you have any questions, we'd love to hear from you. Please visit and leave
your question here http://inside.godaddy.com/onhover-activated-social-buttons/

= How do I make lazy social buttons appear in the excerpt? =

To turn on lazy social buttons in the excerpt, navigate to Settings-&gt;Lazy
Social Buttons and toggle the "Excerpt" option from Manual to Above or Below.

The Excerpt option is defaulted to Manual because it reportedly causes problems with
certain CPTs.  It was suggested that "Perhaps it would be useful for option to
be added to select which CPTs will display the buttons and/or whether excerpts
(or excerpts within widgets) will display the buttons."  This is a good
suggestion, and will be considered for future release.  Release 1.0.7 is a hot
fix to remedy the eminent problem by making the_excerpt an option.

= How do I place the buttons Manually in my theme where I want them? =

If you want to add buttons to your template, say to make the buttons show up
in your header, you can simply add the marked up DIV tag where you want it to
go. For example:

`<div class="lazysocialbuttons" data-float="left"
data-buttons="google,twitter,facebook"
data-twshareurl="http://www.yourdomain.tld/" data-twtext="Check out my site"
data-shareurl="http://www.yourdomain.tld/" data-fbhideflyout="false"
data-backgroundtype="light"></div>`

Visit https://github.com/godaddy/lazy-social-buttons for a full list of
the text decoration options.

There is a position option of Manual in the plugin, as of 1.0.5, which will make 
the social buttons not appear automatically above or below your posts.  You
don't need to select Manual to place the marked up DIV in your template.

= Is Lazy Social Buttons available outside of WordPress? =

Yes, please visit http://inside.godaddy.com/onhover-activated-social-buttons/
and https://github.com/godaddy/lazy-social-buttons/ for detail and source code.

= Why should or shouldn't I use the jquery CDN options? =

Loading jquery from Google's CDN will boost performance because the likelihood
of visitors already having it in browser cache is high.  It also puts this
common JS file on a CDN closer to the end user, which means it'll download
faster.

The jquery CDN option is by default off, because it may cause problems with
certain themes and other plugins that require a different version of jquery.
I'd suggest that you turn this jquery CDN feature on and then test your site.
If it breaks your site, turn it off.

= Why does the spinning animated gif look strange? =

The animated gif was made to display on a white background.  If you are using
a dark background, change the Lazy Social Buttons Background Type to dark in
Settings/Lazy Social Buttons.

== Screenshots ==

1. Social Buttons transition to real
2. Settings->Lazy Social Buttons options

== MIT License ==

Copyright (c) 2012 Go Daddy Operating Company, LLC

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.

== Changelog ==

= Lazy-Social-Buttons v1.0.7 - 2012-10-08 =
* Fixed: Changed the_excerpt to an option b/c reported it breaks certain configurations
* New: the_excerpt option

= Lazy-Social-Buttons v1.0.6 - 2012-10-06 =
* Fixed: Added buttons to the_exerpt so buttons show on category, archive and search results
* New: Options moved from Discussion to own page

= Lazy-Social-Buttons v1.0.5 - 2012-10-02 =
* New: New position choice of manual

= Lazy-Social-Buttons v1.0.4 - 2012-09-26 =
* New: Background Type choice to match the background of your site for the spinning animated gif

= Lazy-Social-Buttons v1.0.3 - 2012-09-26 =
* New: Google CDN loaded jquery now an option, default off

= Lazy-Social-Buttons v1.0.2 - 2012-09-26 =
* Fixed: Facebook share flyout option
* New: Switched jquery to ajax.googleapis.com v1.8.1 for better performance

= Lazy-Social-Buttons v1.0.1 - 2012-09-24 =
* New: Added .min.js for better performance.

= Lazy-Social-Buttons v1.0.0 - 2012-09-23 =
* Fixed: Nothing, initial release.
* New: Everything, initial release.

