# bcb-website

Uptime Robot: https://stats.uptimerobot.com/zpPD8sM1ZB

## About

This is the code to extend the Responsive Theme to create a child theme
for the BCB site.

The Responsive Theme was created under version 3 of the GPL by 
CyberChimps:
http://cyberchimps.com/responsive-theme/

A copy of the licence is under licence.txt

The child theme has been created in the first instance by caprenter, 
and is a derivative work that relies on the Responsive Theme code linked
to above.

Everything here is also provided under GPLv3 unless stated otherwise. 
In practice the exceptions are some of the javscript libraries as 
described in the Responsive-Theme-readme.txt

## Deploy

**This code will not work unless deployed as a child theme of the Responsive Theme.**

The Responsive Theme is NOT included in this repository. 

You should get your own version of the theme first.

As the parent theme alters and updates, we plan to keep this code in
with the current release.

### Google Calendar Parsing

We take data from a google calendar in order to display schedule, and programme information on the website.

You will need the:
 * google-api-php-client: https://github.com/google/google-api-php-client
 * a google developer account

1. Clone or copy the `google-api-php-client` files into the same directory as this `README.md` file.

2. Set up a google developer account and in the Google Developer Console create a 'Service Account'

3. Make a copy of `example.google-api-credentials.php` and rename it `google-api-credentials.php` and enter the account details. You should make sure this files is only readable by the webserver.
This file is called in `functions.php`. If you want to alter the name of your file and it's location, go ahead.

4. You will also need to place the Service Account Private Key file on your server.

### OTHER_FILES

In the `OTHER_FILES` directory there is more code that the site relies upon to work, that do not live in the theme

#### which_week.php

This is the HTML and javascript that tells us which 'week' we are in, in the BCB 4 week cycle. It sits in one of the wordpress widget areas as Custom HTML

#### bcb-four-week-rota.php

This is a wordpress plugin that creates a list of Monday Dates and their correspoding week in the 4 week rotation. 

It allows us to add a shortcode to a page to display the output.

See: https://www.bcbradio.co.uk/bcb-broadcast-week/

#### index_redirect.php

This is an emergency page we can deploy of the database is down but the website is up.
To use it, we replace the index.php page with this one (i.e. rename them both)
