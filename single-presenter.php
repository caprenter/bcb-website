/* 
Theme Name: Responsive Child Theme
Theme URI: http://cyberchimps.com/guide/child-theme-example/
Description: Responsive Child Theme
Template: responsive
Version: 1.0.0
Author: CyberChimps
Author URI: https://cyberchimps.com/
License: GNU General Public License
License URI: license.txt

*/

/* =Start From Here
-------------------------------------------------------------- */
/*Schedule listing*/
h2.schedule-list {
font-size:1.2em;
}
.programme {
  padding:10px 10px 10px 5px;
  float:left;
  clear:left;
  border-bottom: 1px solid #eee;
  color: #555;
  width:100%
}
/* Programme on air now, past or future*/
.on {
  background: #eeefef;
} 
.future {
  //background: green;
} 
.past {
  //background: blue;
}
/* Programme details*/
h4 {
  display:inline;
}
.programme_start {
  width: 15%;
  font-size:1.6em;
  float:left;
}
.programme_description {
  width: 85%;
  font-size:1em;
  float:left;
}
.programme_description p {
  margin: 0.8em 0;
}
h4.title {
  font-size: 1.6em;
}
.on-air {
  font-size:0.5em;
  padding:5px 8px;
  margin:10px 33px 10px 0;
  display:block;
  background: #000;
  color: #fff;
  text-transform:uppercase;
}

/* On Air Now Widget */
h3.on-air-now {
font-size:0.9em;
margin-bottom:0;
}
h4.on-now-title {
font-size:1.4em;
margin: 10px 0 5px 0;
display:block;
}
.event-datetime {
font-size:0.8em;
}
.listen-live {
padding:0;
}
.on-now-description {
margin:0;
}
a.on-air-link {
font-size:1.6em;
display:block; width:100%; margin:0 auto;
}
/*The last 29 days of the month are the hardest."- Nikola Tesla*/

/* Navigation bar for the Schedule page */
.schedule-nav {
background:none;
}

.schedule-nav ol {
list-style-type: none;
margin: 0;
padding: 5px 5px 0 5px;
float: left;
background-color: #f9f9f9;
background-color: #0015d2;
border: 1px solid #e5e5e5;
border-radius: 4px;
border-bottom: none;
}

.schedule-nav ol li {
display:block;
float:left;
text-align: center;
}
.schedule-nav ol li a {
display:block;
padding: 0 4px;
margin: 0 2px;
color: #fff;
}

.schedule-nav ol li.featured-day {
border: 1px solid #e5e5e5;
border-top-right-radius: 5px;
border-bottom: none;
border-top-left-radius: 5px;
background: #fff;
}

.schedule-nav ol li.featured-day a {
color: #000;
font-weight:bold;
}

.schedule-nav ol li a:hover,
.schedule-nav ol li a:focus {
color: #000;
background: #fff;
}

.schedule-nav .day {
text-transform: uppercase;
}

.schedule-nav .date {
text-transform: uppercase;
font-size: 0.8em;
}

.schedule-list {
margin-top: 20px;
}

/*Presenters*/
.presenter h1 {
font-size: 2.625em;
margin-bottom: .5em;
margin-top: .5em;
position: relative;
z-index: 2;
width: 250px;
left: 10px;
min-height: 2em;
}
.presenter-image {
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
position:relative;
z-index:1;
top:-110px
}
.presenter-content {
float:right;
width: 54%;
padding-left: 5%;
padding-right: 3px;
margin-top:-110px;
}
.presenter-content p {
margin-top:0;
}

/*Presenter contact and programme info*/
.single-presenter #widgets {
margin-top: 69px;
}
.presenter-contact {
margin-top:0;
}

/*Presenters archive pages to list all presenters*/
.post-type-archive-presenter .presenter h1,
.post-type-archive-presenter .presenter h2 {
font-size: 1.8em;
margin-bottom: 0;
margin-top: .5em;
width: 100%;
position:static;
margin-left: 140px;
}
.post-type-archive-presenter .post-meta {
display:none;
}

.post-type-archive-presenter .post-entry p {
margin: 0;
}
.post-type-archive-presenter .post-entry img {
margin: -22px 20px 20px 0;
}
.post-type-archive-presenter .read-more {
clear:none;
}
.post-type-archive-presenter div.type-presenter {
clear:both;
}

#footer-wrapper .col-540 {
width:98%;
}



/*
 Theme Name:   BCB Radio
 Theme URI:    http://www.bcbradio.co.uk/
 Description:  Responsive Child Theme
 Author:       shi
 Author URI:   http://esyou.com/
 Template:     responsive
 Version:      0.0.1
 License: GNU General Public License
 License URI: license.txt
*/

/* Main Course
-------------------------------------------------------------- */
html {background-color:#1C1F33 !important;}
#container {margin:0 auto; max-width:100%; padding:0;}
#wrapper {width:920px; margin:0 auto; border:0; background-color:#fff; border-radius:0;
-moz-box-shadow:    0px 0px 30px 3px #05050A;
-webkit-box-shadow: 0px 0px 30px 3px #05050A;
box-shadow:         0px 0px 30px 3px #05050A;}
.clear	{clear:both;}

/* Header Course
-------------------------------------------------------------- */
#header {width:100%; margin:0 auto; background:url('core/images/header-back.png') #ccc;}
#logo {margin:0 auto; width:960px; height:100px; background:url('core/images/default-logo.png') no-repeat; float:none;}
#logo a img {visibility:hidden;}
.main-nav {background-color:#000;}
.menu {background:none, #000; width:960px; margin:0 auto;}
.menu a {border-left:1px solid #2C448F; font-size:16px; font-weight:normal; height:55px; line-height:55px; text-shadow:0 -1px 1px #0D0D42;}
.menu a:hover {background-color:#2D5FFF; background-image:none;}

/* Blog Course
-------------------------------------------------------------- */
h2 a {color:#111 !important;}
h2 a:hover {color:#666 !important;}
.post-meta a {color:#697492;}
.post-meta a:hover {color:#505C7C;}

/* Footer Course
-------------------------------------------------------------- */
#footer {background-color:#000; max-width:100%; padding:0; color:#fff;}
#footer-wrapper {width:960px; margin:0 auto; margin-top:20px;}
#footer a {color:#7676FF;}
#footer a:hover {color:#ffffff !important;}
#colophon-widget.col-940 {margin-bottom:40px !important;}
#colophon-widget.col-940 {background:url('core/images/footer-back.png') 0px -10px no-repeat;}
.colophon-widget.widget-wrapper {border:0; border-radius:0; padding:0; color:#fff; font-size:13px; line-height:1.6em;}
#footer #menu-menu-2 a {color:#fff; font-size:1.2em;}

/* Sidebar Widget
-------------------------------------------------------------- */
.widget-title h3 {padding:5px 0 10px 0;}
#widgets .textwidget {padding-bottom:5px;}

#text-7.widget-wrapper	{border:0; background-color:transparent;} /* Exa Sponsor */
#text-4.widget-wrapper	{padding-bottom:0;} /* Facebook */

/* Listen Live Sidebar Widget
-------------------------------------------------------------- */
#wpb_widget-2.widget-wrapper {border:0; background:url('http://www.bcbradio.co.uk/wp-content/uploads/play.png') 35px 100px no-repeat #000; color:#fff;}
#wpb_widget-2.widget-wrapper a {color:#fff; font-weight:bold;}
#wpb_widget-2.widget-wrapper a:hover {color:#FFAE02;}
#wpb_widget-2 h3 {color:#7999FF;}
#wpb_widget-2 p {margin:0;}
.listenlive	{color:red; text-transform:uppercase; font-weight:bold; font-size:32px; text-shadow:0px 0px 14px rgba(209, 12, 12, 1); padding:10px 0;}
.event-datetime	{border-bottom:3px solid #ccc; padding-bottom:5px; width:100%; display:block; font-size:14px; color:#ccc;}
.listenlive-title {padding-top:10px;}
p.on-now-description {color:aliceblue; font-size:14px; line-height:initial; font-weight:normal;}
.listenlive-txt	{font-size:1.4em; color:#6580A7; font-weight:bold; padding:30px 0 10px 0;}
.standby	{padding:5px 0 5px 0; color:#fff; font-size:24px; font-weight:700; line-height:23px;}
.listenlive-link {color:#7999FF; font-weight:bold; font-size:1.2em; padding-top:10px;}


/* Listen Again Sidebar Widget
-------------------------------------------------------------- */
#text-3.widget-wrapper.widget_text	{padding:20px;}
#text-3.widget-wrapper {border:0; background: url('http://www.bcbradio.co.uk/wp-content/uploads/play-again.png') 5px 15px no-repeat #232529; color:#fff; padding-top:0;}
#text-3.widget-wrapper:hover {background-color:#0A1B3F;}
#text-3.widget-wrapper.widget_text a.on-air-link	{display:none;}
a.widgetbutton	{display:block; width:100%; margin:0 auto;}
.iplayer	{font-size:1.5em; margin-bottom:15px; color:#F00; font-weight:bold; text-shadow:0px 0px 14px rgba(209, 12, 12, 1);}
.subtext	{padding-bottom:5px; color:#fff; font-size:18px; font-weight:normal; line-height:1.1em;}
.listenagain	{padding-top:10px; font-size:1.7em; color:#7999FF;}


/* BCB Webmail Sidebar Widget
-------------------------------------------------------------- */
#text-5.widget-wrapper {border:0; background:url('core/images/webmail.png') 35px 0px no-repeat #DDE2E6; color:#fff;}
#text-5.widget-wrapper:hover {background-color:#E3E9EE; color:#5E8DB5;}
#text-5.widget-wrapper a {color:#839CB1; font-weight:bold;}
#text-5.widget-wrapper a:hover {color:#5E8DB5;}


/* Schedule - Listen Live in programme schedule
-------------------------------------------------------------- */
.programme.on {background:url('http://www.bcbradio.co.uk/wp-content/uploads/on-air-listen-live.png') no-repeat 492px #0029FF; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; color:#fff; position:relative;}
.programme.on a {color:#FFA300;}
.on-air {font-size:0.5em; padding:5px 8px; margin:10px 33px 10px 0; display:block; background:#000; color:#F00; text-transform:uppercase; font-weight:bold; text-shadow:text-shadow: 1px 1px 5px #f00;}
.programme_description a {color:#80BDFF; font-weight:bold;}
.programme_description a.listen-live {padding:0; display:block; position:absolute; top:15px; right:20px; width:120px; text-transform:uppercase; font-size:28px; line-height:1.0; text-align:center; color:aliceblue;}
.programme_description a.listen-live:hover {color:#fff;}
.programme_description p {max-width:350px;}

/* Footer
-------------------------------------------------------------- */
#footer #menu-menu-2 a {color:#fff; font-size:1.2em;}
#footer a	{color:#B2B2C4;}
.footer-menu	{margin:0 auto;}
.footer-menu li {display:inline-block; list-style-type: none; padding:5px 0; font-size:1.2em;}
.footer-menu li a {border-left:1px solid #28273C;}
#text-6 a	{color:#7676FF;}

/* Front page
-------------------------------------------------------------- */
.front-title	{font-size:2.3em; line-height:1.2em; padding-left:10px;}
a.front-link	{display:block; background-color:#4784FF; padding:5px 0px; border-radius:4px; width:200px; color:#FFFFFF; font-size:1.2em; text-align:center; margin:0 auto;}
a.front-link:hover	{background-color:#84ADFF;}

/* Presenter profiles
-------------------------------------------------------------- */
.presenter h1 {left:30px; color:#fff; top:10px;}
.single-presenter #widgets {margin-top:20px;}
.presenter-content br	{line-height:2.4em;}
.presenter-content p	{font-size:1.2em; line-height:1.4em;}
a.back_presenters	{display:block; padding:20px 0 0 5px;}
#content		{margin-top:20px;}
.post-type-archive-presenter .post-entry p {font-size:1.0em; line-height:1.3em; padding:10px 0px 5px 0; text-align:justify;}
.post-type-archive-presenter div.type-presenter {padding:0 10px 10px 10px;}
h1.present		{margin-top:0; margin-bottom:0.8em;}
.widget-wrapper.presenter	{float:left; width:33%; margin-top:-110px;}
.widget-wrapper.presenter a	{word-break:break-word;}

/* Phones to tablets 767px and below
-------------------------------------------------------------- */
@media screen and (max-width: 767px) {
div#wrapper, div#footer-wrapper, div#logo {width:100%; padding:0; margin:0; max-width:767px; overflow:hidden;}
div#widgets	{margin:0;}
.front-title	{font-size:1.8em; padding:0 10px;}
iframe		{width:90% !important;}
.widget-wrapper	{margin:10px;}
#logo		{background:url('http://www.bcbradio.co.uk/wp-content/uploads/media-logo.png') no-repeat;}
.presenter h1	{left:10px; color:#fff; top:-5px;}
.presenter-content	{float:none; width:90%;}
.post-entry		{display;block;}
.widget-wrapper.presenter	{float:none; display:block; margin:auto; width:90%; border-radius:0;}
.programme.on, .presenter-image	{border-radius:0;}
.on-air			{margin-right:10px; text-align:center;}
.programme_description	{width:80%; margin-left:10px;}
.programme_description a.listen-live	{font-size:1.2em; top:0; background-color:#3F05A7; padding:10px 5px; text-align:center;}
.schedule-nav ol	{margin:auto; text-align:center; padding:10px;}
.schedule-nav ol li	{float:none; display:inline-block; vertical-align:top; padding:10px 0; min-width:60px;}
.schedule-nav ol li.featured-day	{border-radius:5px;}
}
