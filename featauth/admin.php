<?php
if(!defined("_CHARSET")) exit( );

$blockquery = dbquery("SELECT * FROM " . TABLEPREFIX . "fanfiction_blocks WHERE block_name = 'featauth'");
while ($block = dbassoc($blockquery))
{
	if ($block['block_variables'])
	{
		$blocks[$block['block_name']] = unserialize($block['block_variables']);
	}
	$blocks[$block['block_name']]['title'] = $block['block_title'];
	$blocks[$block['block_name']]['file'] = $block['block_file'];
	$blocks[$block['block_name']]['status'] = $block['block_status'];
}
global $language, $dateformat;

if (file_exists(_BASEDIR . "blocks/featauth/" . $language . ".php")) include(_BASEDIR . "blocks/featauth/" . $language . ".php");
else include(_BASEDIR . "blocks/featauth/en.php");

include("blocks/" . $blocks['featauth']['file']);
 
 
	if(isset($_POST['submit'])) {
		if($_POST['allowtags']) $blocks['featauth']['allowtags'] = 1;
		else unset($blocks['featauth']['allowtags']);
		if($_POST['sumlength'] && isNumber($_POST['sumlength'])) $blocks['featauth']['sumlength'] = $_POST['sumlength'];
		else unset($blocks['featauth']['sumlength']);
		$blocks['featauth']['author'] = $_POST['author'];
		$blocks['featauth']['template'] = $_POST['template'];;
		$output .= "<div style='text-align: center;'>"._ACTIONSUCCESSFUL."</div>";
		save_blocks( $blocks );
	}
	else  {
		$template = (!empty($blocks['featauth']['template']) ? $blocks['featauth']['template'] : "<div id='featauth'><div id='author'>{author}</div><div id='bio'><span class='classification'>"._BIO.":</span> {bio}</div><div id='stats'>{author} is the author of {stories} stories and has given {reviews} reviews. {author} has {favstor} favorite stories/series and {favauth} favorite authors. {author} has been a member since {joined}.</div></div>");
		$authors = dbquery("SELECT count(DISTINCT s.uid), a.uid, a.penname FROM ".TABLEPREFIX."fanfiction_stories as s, ".TABLEPREFIX."fanfiction_authors as a WHERE s.uid = a.uid GROUP BY s.uid ORDER BY penname");
		if(empty($blocks['featauth']['author'])) $blocks['featauth']['author'] = 0;
		$authlist = "";
		while($auth = dbassoc($authors)) {
			$authlist .= "<option value=\"$auth[uid]\"".($blocks['featauth']['author'] == $auth['uid'] ? " selected" : "").">".$auth['penname']."</option>";
		}
		$output .= "<div style='text-align: center; margin: 1em 10%;'><b>"._CURRENT.":</b><br /><div class=\"tblborder\" style=\"text-align: left;\">$content</div><br /></div>";
		$output .= "<div style='width: 80%;margin: 1em auto; text-align: center;'><form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=blocks&admin=featauth\">
			<textarea name=\"template\" rows=\"5\" cols=\"40\">$template</textarea><br />
			<label for=\"allowtags\">"._TAGS.":</label> <select class=\"textbox\" name=\"allowtags\" id=\"allowtags\" style='margin: 3px;'><option value=\"0\"".(empty($blocks['featauth']['allowtags']) ? " selected" : "").">"._STRIPTAGS."</option>
					<option value=\"1\"".(!empty($blocks['featauth']['allowtags']) ? " selected" : "").">"._ALLOWTAGS."</option></select><br />
			<label for=\"sumlength\">"._SUMLENGTH."</label><input type=\"text\" class=\"textbox\" name=\"sumlength\" id=\"sumlength\" size=\"4\" value=\"".(isset($blocks['featauth']['sumlength']) ? $blocks['featauth']['sumlength'] : "")."\"><br />
			<label for=\"author\">"._AUTHOR.":</label><select class=\"textbox\" name=\"author\" id=\"author\"><option value=\"0\">"._NONE."</option>$authlist</select><br />
			"._FASUMNOTE."<br /><INPUT type=\"submit\" name=\"submit\" class=\"button\" value=\""._SUBMIT."\"></form></div>";
	}
?>