<?php
/*
Plugin Name: Multilingual posts
Plugin URI: http://www.imluke.net/ideas/mlpost.htm
Description: Add standard compliant language tag to post and page
Version: 0.1
Author: Luke
Author URI: http://www.imluke.net
*/
/*  Copyright 2007  Luke  (email : cobraloo@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

include "langtags.php";

/*
Print language tag out
Return nothing if something wrong
This function should be called in the loop
*/
function theLangTag($p) {
	$tag = mlGetLangTag($p);
	if(NULL == $tag) return;
	$s = $tag->meta_value;
	if(NULL == $s) return;
	echo "lang=\"$s\" xml:lang=\"$s\"";
}

//Check if the post have language tag
function mlHaveLangTag($p) {
	global $wpdb;
	$meta = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'lang' AND post_id = $p LIMIT 1" );
	if(NULL != $meta) return $meta->meta_id;
	return 0;
}

function mlGetLangTag($p) {
	global $wpdb, $mlLangTagID;	
	//Return NULL for new post/page
	if(NULL == $p) return NULL;
	
	$meta = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'lang' AND post_id = $p LIMIT 1" );
	if ( is_serialized_string( $meta->meta_value ) )
		$meta->meta_value = maybe_unserialize( $meta->meta_value );
	
	return $meta;
}

/*
Get language tag from DB by meta ID
*/
function mlGetLangTagByID($tagID) {
	$tag = get_post_meta_by_id($tagID);
	//have a language tag in DB
	if(NULL != $tag) return $tag->meta_value;
	//No...
	return NULL;
}

/*
Add a language tag into post_meta
*/
function mlAddMeta($p, $value) {
	global $wpdb;
	$result = $wpdb->query("INSERT INTO $wpdb->postmeta 
					(post_id,meta_key,meta_value ) 
					VALUES ('$p','lang','$value')" );
	return $wpdb->insert_id;
}

/*
Add input box in post/edit page
*/
function mlAddInputPan() {
	global $post_ID, $languages;

	$tag = mlGetLangTag($post_ID);//get meta data from DB;
	//get language tag from fetched result;
	if ($tag != NULL) $tagVal = $tag->meta_value;
	
	echo '<fieldset id="languagediv" class="dbx-box"><h3 class="dbx-handle">Language</h3>
<div class="dbx-content">
	<select name="post_language" id="post_language">';
	$selected = false;
	foreach( $languages as $t => $lang) {
		//Selected language tag
		if ($tagVal == $t) {
			$s =" selected=\"selected\"";
			$selected = true;
		} else {
			$s = "";
		}
		echo "\n\t\t<option value=\"$t\"" . $s . ">$lang</option>";
	}
	//Add none at last
	echo "\n\t\t<option value=\"none\"" . ($selected ? "" : " selected=\"selected\"") . ">None</option>";		
	echo "
	</select>
</div>
</fieldset>";
}

/*
Change post language tag as follow:
Selecte button pushed
	|
already have lang tag($mlLangTagID!=0)
	|__N__ Language selected
   Y|				|__N__ Return
	|			   Y|
	|		Add language tag
language selected
	|__N__ Delete language tag
   Y|
No change of language tag
	|__N__ Update language tag
   Y|
 Return
*/
function mlChangePostTag() {	
	global $wpdb, $post_ID;
	
	if (NULL == $post_ID) return; 
	$tagForm = $wpdb->escape(stripslashes(trim($_POST['post_language'])));//Tag infor from select form
	if (NULL == $tagForm) { return; }
	
	$mlLangTagID = mlHaveLangTag($post_ID);
	if ($mlLangTagID) { //already have a language tag before
		if("none" == $tagForm) { //Language tag not selected
			delete_meta($mlLangTagID);
		} else { //Language tag selected
			if (mlGetLangTagByID($mlLangTagID) == $tagForm) { //no change of language tag
				return;
			} else { //changed
				update_meta($mlLangTagID, "lang", $tagForm);
			}
		}		
	} else { //Didn't have a language tag before
		if("none" == $tagForm) { //Language tag not selected
			return;
		} else { //Language tag selected, add meta
			mlAddMeta($post_ID, $tagForm);
		}
	}
}


function getTranslation($postID) {

}

//Display language tag list in sidebar box
add_action('dbx_post_sidebar','mlAddInputPan');
add_action('dbx_page_sidebar','mlAddInputPan');

// Save changes to language tag
add_action('publish_post', 'mlChangePostTag');
add_action('edit_post', 'mlChangePostTag');
add_action('save_post', 'mlChangePostTag');
add_action('wp_insert_post', 'mlChangePostTag');

?>