// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

Copyright 2005 by Tammy Keefer.

This block for efiction 3.5.6 

add to index.tpl (Berrygold theme)

    <div class="block">
       <div class="title">{featauth_title}</div>
       <div class="content">{featauth_content}</div>
    </div>


This block for eFiction 2.0 displays a random author profile.  You may choose whether or not to allow HTML tags and how much of the member's bio to show in the admin panel.  In addition to the standard {blockname_title} and {blockname_content}, this block also adds {featauthor} to the variables in the skin so that you can therefore replace {featauth_title} with a link to the author's profile page.  The default content part of the block contains several divs that you can style using CSS.

<div id='featauth'> 
	<div id='author'>NAME OF AUTHOR</div>
	<div id='bio'>AUTHOR'S BIO TRUNCATED</div>
	<div id='stats'>AUTHOR'S STATS</div>
</div>

The CSS to style these would be as follows:

#featauth  
#featauth #author - you may wish to set this to display: none; if you are using the {randomauthor} variable as a title.
#featauth #bio
#featauth #stats

You may also define your own text through the admin panel.  Use the standard {variable} notation to include the following variables in your text. 

{author} - Author's penname hyperlinked to their profile page.
{stories} - The number of stories and series written by that author.
{reviews} - The number of reviews written by that author.
{bio} - The author's bio truncated to the character length you set in the admin panel.  Default length is 75.
{favstor} - The number of favorite stories/series for the author.
{favauth} - The number of favorite authors for the author.
{joined} - The date the member joined. 

