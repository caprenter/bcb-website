bcb-website
===========

Uptime Robot: https://stats.uptimerobot.com/zpPD8sM1ZB


This is the code to extend the Responsive Theme to create a child theme
for the BCB site.

The Responsive Theme was created under version 3 of the GPL by 
CyberChimps:
http://cyberchimps.com/responsive-theme/

A copy of the licence is under licence.txt

The child theme has been created in the first instance by caprenter, 
and is a derivative work that relies on the Responsive Theme code linked
to above.

This code will not work unless deployed as a child theme of the 
Responsive Theme. The Responsive Theme is NOT included in this 
repository. You should get your own version of the theme first.
As the parent theme alters and updates, we plan to keep this code in
with the current release.

Everything here is also provided under GPLv3 unless stated otherwise. 
In practice the exceptions are some of the javscript libraries as 
described in the Responsive-Theme-readme.txt

Parsing of Google Calendars relies on the google-api-php-client:
https://github.com/google/google-api-php-client 

You will need to clone or copy those files into the same directory as 
this README.md file.

You also need to set up a google developer account and in the Google
Developer Console create a 'Service Account'

Make a copy of example.google-api-credentials.php. 
Rename it google-api-credentials.php and enter the account details.
You should make sure this files is only readable by the webserver.
this file is called in functions.php. If you want to alter the name of 
your file and it's location, go ahed.
You will also need to place the Service Account Private Key file on your
server.
