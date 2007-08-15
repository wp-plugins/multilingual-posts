=== Multilingual post ===
Contributors: imluke
Donate link: http://www.imluke.com/
Tags: post, language
Requires at least: 2.0
Tested up to: 2.2
Stable tag: 0.2

This plugin add a standard compliant language tag to your post and page.

== Description ==

If you can write your posts in 2 or more(Woo...) languages within one blog, you might want to tell the client browser the language attribute of you posts.

According to the tutorial on W3C[http://www.w3.org/International/tutorials/language-decl/en/all.html], language attribute can be decleared in the container html tag of your post like this:
<div id="post_id" class="post_entry" lang="zh-Hans" xml:lang="zh-Hans">...
Here "zh-Hans" is the language attribute of your post which means it's written in Simplified Chinese.

This plugin gives your post a language tag by adding a meta deta to that post.

To add language tag, select it from the language box when you compose/edit a post. Select "None" will delete the language tag.

== Installation ==

To use this plugin, you have to upload the plugin file, active it and edit your theme.

1. First upload the folder "multilingual-posts" to plugin folder 
2. Open file "languages.php" and select languages that might be used.
	Simply uncomment the row that contains language you will use.
3. Edit your theme.
	In the loop(inside a while(have_posts()) loop), find the top html container which is normally a div block and add a function call before the ">" mark:
	<?php /* Support for multilingual posts plugin*/ if(function_exists('theLangTag')) theLangTag($post->ID);?>
	It should look like this(wp2.2 default theme):
	<div class="post" id="post-<?php the_ID(); ?>" <?php /* Support for multilingual posts plugin*/ if(function_exists('theLangTag')) theLangTag($post->ID);?> >
