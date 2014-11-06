=== Plugin Name ===
Contributors: glanum, tzavdesign
Donate link: http://www.glanum.com/
Tags: author, post author, page author, content, date, publication date, update, editing date, revision date 
Requires at least: 3.2
Tested up to: 3.8.1
Stable tag: 1.1.1
License: GPLv2 or later

Display author, writing and editing date - fully customizable for content, excerpt, home, archive... with exceptions. Great for multi-author websites.

== Description ==

* **NEW** each author now links to a personnal page or external URL, in addition to author posts (default)
* **NEW** better integration with home, archive categories and custom loops
* **NEW** a few more options with avatar, before/after content
* **NEW** no repetition of author name if revision author is the same

This great simple plugin, written with [multimedia agency](http://www.glanum.com) Glanum, adds the author and date at the top or bottom of the content on posts, on pages and on archive categories (optionally along with last modified date and author), with a fully custom per-post / per-page hide option. Especially usefull for multi-author sites and blogs:

* Name of the author of the post or page, optional avatar
* Date of first publication
* Author and date of last revision

It is flexible and offers the following options in the admin menu:

* Display the post author info independently on posts, pages, archive categories and home
* Specific per-post/per-page exception: hide the info on any post and page you want!
* Choose: before or after the content or the excerpt independently
* Optional link on author name to WP's default author posts list or now to a custom author page or external URL
* Write your own label before and after the name of the author: e.g. `Contributed by` Author Name `for OurNewsBlog`
* Date of 1st publication is optional, and supports surrounding text like above
* Author and date of last revision are both independently optional, and only display if revision author or date are different from the original, with surrounding text

The plugin is initially intended for very small to much larger multi-author blogs (newspaper, magazine, webzine, collaborative publications, communities...) when an article is supposed to be signed by its author and not remain anonymous, as commonly expected in journalism and publishing.

* Lastly, information is displayed in nested `div` and `span` so it is CSS ready, just up to you to do the styling to your taste. See the screenshots.
* Integrates great with qTranslate for multilingual or international blogs, using [Quicktags](http://www.qianqin.de/qtranslate/forum/viewtopic.php?f=3&t=3&p=15#p15)
* Available in English, French, Belarusian (credit [Marcis Gasuns](http://pc.de/)), German (credit [Rian Kremer](http://diensten.kiwa.nl/mvo)), Hebrew (credit [Sagive](http://www.sagive.co.il)), Romanian (credit Luke Tyler), Slovak (credit [Branco Radenovich](http://webhostinggeeks.com/user-reviews/)) and Farsi (credit [Hamed Nourhani](http://www.itstar.ir)).



== Installation ==

1. Upload `post-author` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the 'Settings' menu and choose 'Post Author' to check the options
1. Optionally, go to a particular post or page edit window and check the 'Hide' option in the 'Author' box, if you want to disable the plugin on a specific post or page.

== Frequently Asked Questions ==

= I use html IMG or BR tags to seperate divs, spans or to add padding, is this right? =

To make the best use of the plugin, you should NOT use html tags in the optional fields provided. Instead, you should style the divs and spans. With CSS, you can easily add an image in the author div. Also, by adding a "display:block" style to the span, you will force a line break before. And styling on your categories pages can be customized as well since it uses other classes, so you can make the text here smaller for instance.

= How can I display the author's username instead of his/her real name (or vice versa)? =

The plugin uses the standard WP get_the_author command, which "grabs the value in the user's `Display name publicly as` field". So you might want to check in the USER admin page what that is and make sure that you selected the complete name and not the username or something else.

= Can I use a different variable link than default WP author page =

As of version 1.0, you can specify a custom link. The plugin can pick the URL you specify in the author's profile. This URL could be a bio page on your blog or an external website or social network profile... And you still have a static link for all authors, as an alternative to the default or custom biography/user page.

= Where is the support? =

Support, feedback, help, exchange and all community stuff [should happen here](http://wordpress.org/support/topic/325398 "Support for Post Author Plugin") - reply to this thread as there is no website or page for this project other than this one here on Wordpress.

If for some reason you need to start a new thread with the appropriate tags, [it's here](http://wordpress.org/tags/post-author?forum_id=10#postform).

Don't forget to rate this plugin, especially if you like it!



== Screenshots ==

1. This is what Post Author can look like on your blog.
2. Another example of Post Author with different options and different styling.
2. Another example with Post Author at the top of the content.
4. The admin page of Post Author with the options available.
5. The post/page edit section with the Post Author plugin implement.


== Changelog ==

= Information =
* Requires WP >= 3.2

= 1.1.1 =
* Bugfix : Minor update for the Author box on page edit (there could be a confusion and duplicate author box depending on view settings and WP version). This update makes sure we use the same Author box as WP on page edition (for WP 3+). And fixed the clickable label, same place.

= 1.1 =
* Improvement : Updated the method for loading translation files.
* Improvement : Some frontend CSS id/class declaration updates.
* Improvement : Added Slovak translation, thanks to [Branco Radenovich](http://webhostinggeeks.com/user-reviews/).
* Improvement : Added Farsi translation, thanks to [Hamed Nourhani](http://www.itstar.ir).

= 1.0 =
* Improvement : Added the choice of default WP author posts list or custom author profile URL to use as the link on the author's name.
* Improvement : More customizeable options with avatar, select before/after content.
* Improvement : Check if revision author is the same as original and avoid repetition.
* Improvement : better integration with home, archive categories and custom loops.
* Improvement : Added Hebrew translation, thanks to [Sagive](http://www.sagive.co.il).
* Improvement : Added Romanian translation, thanks to Luke Tyler.

= 0.7 =
* Bug fix : Corrected double display of author box on categories with excerpts that where constructed from the content (i.e. when the excerpt field was left blank).
* Improvement : New! Added possibility to display author avatar (gravatar) on pages / posts, with custom size and floating alignment options.
* Improvement : Dissociated revision author and revision date. Now, you can include all of these independantly! And still automatically hiding them if the update date is the same as the initial publishing date.
* Improvement : Added option to place author box before or after excerpts on categories.
* Improvement : Added option to hide author box on the home, when it is a category of posts (if it is set to a static page, you can already hide the author box by checking the option while editing the page itself).
* Improvement : Added German translation, thanks to [Rian Kremer](http://diensten.kiwa.nl/mvo).

= 0.6 =
* Improvement : Added option to display author on lists (home or categories).
* Improvement : Changed add_action -> add_filter for "the_content" (WP recommendation).

= 0.51 =
* Bug fix : double posting content when "hide author" exception on a post or a page
* Improvement : Added option to display author before or after content.
* Improvement : Added Belarusian translation, thanks to [Marcis Gasuns](http://pc.de/).

= 0.4 =
* Improvement : Added last revision author name, link and date, all customizable. Some tiny CSS update to accomodate new function.
* Bug fix : for WP 2.9.0+, remove deprecated page_author_meta_box on new/edit page articles.
* Bug fix : hide exception on posts and pages update was broken.

= 0.3 =
* Bug fix : quotes, apostrophes... are now escaped properly in text fields.
* Bug fix : couldn't write a new text field if text field was empty.
* Bug fix : global $pagenow for broken admin meta box in page-new.php >2.8.4, when creating a new page.
* Improvement : French translation
* Improvement : new storage of plugin parameters/options. Old versions are converted to new storage format and old format is deleted automatically.

= 0.2 =
* Bug fix : broken admin meta box in page-new.php, when creating a new page.

= 0.1 =
* Initial release.
