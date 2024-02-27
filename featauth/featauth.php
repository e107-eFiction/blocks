<?php
if(!defined("_CHARSET")) exit( );

	global $dateformat;
	if(empty($blocks['featauth']['author'])) $content = _NONE;
	else {
		$query = dbquery("SELECT author.*, author.date as date, COUNT(s.sid) as stories FROM ".TABLEPREFIX."fanfiction_authors as author, ".TABLEPREFIX."fanfiction_stories as s 
		WHERE author.uid = s.uid AND s.validated > 0 AND author.uid = ".$blocks['featauth']['author']." GROUP BY s.uid  LIMIT 1");
		while($a = dbassoc($query))
		{
			$template = ($blocks['featauth']['template'] ? stripslashes($blocks['featauth']['template']) : "<div id='featauth'><div id='author'>{author}</div><div id='bio'><span class='classification'>"._BIO.":</span> {bio}</div><div id='stats'>{author} is the author of {stories} stories and has given {reviews} reviews. {author} has {favstor} favorite stories/series and {favauth} favorite authors. {author} has been a member since {joined}.</div></div>");
			$tpl->assignGlobal("featauthor", "<a href='viewuser.php?uid=$a[uid]'>$a[penname]</a>");
			$rquery = dbquery("SELECT count(uid) FROM ".TABLEPREFIX."fanfiction_reviews WHERE uid = '$a[uid]'");
			list($reviews) = dbrow($rquery);
			$favquery = dbquery("SELECT count(item) as count, type FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = ".$a['uid']." GROUP BY type");
			$favstor = 0; $favseries = 0; $favauth = 0;
			while($f = dbassoc($favquery)) {
				if($f['type'] == "ST") $favstor = $f['count'];
				if($f['type'] == "AU") $favsauth = $f['count'];
				if($f['type'] == "SE") $favseries = $f['count'];
			}
			if(empty($blocks['featauth']['allowtags'])) $bio = format_story($a['bio']);
			else $bio = $a['bio'];
			$bio = truncate_text(stripslashes($bio),(!empty($blocks['featauth']['sumlength']) ? $blocks['featauth']['sumlength'] : 75));
			$search = array("@\{author\}@", "@\{stories\}@", "@\{reviews\}@", "@\{favstor\}@", "@\{favauth\}@", "@\{favseries\}@", "@\{joined\}@", "@\{bio\}@");
			$replace = array("<a href='viewuser.php?uid=$a[uid]'>$a[penname]</a>", $a['stories'], $reviews, $favstor, $favauth, $favseries, date("$dateformat", $a['date']), $bio);
			$content .= preg_replace($search, $replace, $template);
		}
	}	
?>