=== Multilingual post ===
Contributors: imluke
Donate link: http://www.imluke.com/
Tags: post, language
Requires at least: 2.0
Tested up to: 2.4
Stable tag: 0.2

This plugin adds a standard compliant language tag to your post and page.

== Description ==

If you can write your posts in 2 or more(Woo...) languages within one blog, you might want to tell the client browser the language attribute of you posts.

According to <a href="http://www.w3.org/International/tutorials/language-decl/en/all.html" title=" W3C tutorial">the tutorial on W3C</a>, language attribute can be declared in the container html tag of your post like this:
&lt;div id="post_id" class="post_entry" lang="zh-Hant" xml:lang="zh-Hant" dir="ttb"&gt;...
Here "zh-Hans" is the language attribute of your post which means it's written in Simplified Chinese.

This plugin gives your post a language tag by adding a meta deta to that post.

To add language tag, select it from the language box when you compose/edit a post. Select "None" will delete the language tag.

== Installation ==

To use this plugin, you have to upload the plugin file, active it and edit your theme.

1. First upload the folder "multilingual-posts" to plugin folder 
2. Open file "languages.php" and select languages that might be used.
	Simply uncomment the row that contains language you will use.
3. if you need to specify language directions, define it in the bottom of "languages.php"
4. Edit your wordpress theme.
	<!--***NOTICE: the code below is modified for battery render in webpages. please replace "&amp;gt;" with &gt; and "&amp;lt;" with "&gt;" when insert to your wordpress theme***-->
	In the loop(inside a while(have_posts()) loop), find the top html container which is normally a div block and add a function call before the "&gt;" mark:
	&lt;?php /* Support for multilingual posts plugin*/ if(function_exists('theLangTag')) theLangTag($post->ID);?&gt;
	It should look like this(wp2.2 default theme):
	&lt;div class="post" id="post-&lt;?php the_ID(); ?&gt;" &lt;?php /* Support for multilingual posts plugin*/ if(function_exists('theLangTag')) theLangTag($post->ID);?&gt; &gt;
5. activate this plugin in wordpress admin panel
	
== Revisions ==

2007-12-18,
0.2: Now you can define language direction.
	 Insert CSS style into page head automatically to support pretty printing.
	 readme file updated for new feature and fixed a error
--------------------------------------------------------------------------------
2007-07-23
0.1: First release
