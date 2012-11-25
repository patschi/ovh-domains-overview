OVH domains overview (with SOAPI and Boostrap)
=============
! ONLY COMPATIBLE WITH SOAPI FROM OVH !

With this page you have a great and simple overview of all your hosted domains by OVH. It has an embedded chache, because the SOAPI is limited by 10 requests a day from one IP - so please don't set the cache_time in the config file too high. Else the script won't output errors. For default it are 86400 seconds - this is one day. And I think, that's one day is enough :)

Don't forget to change the login informations in /inc/config.sample.php and change the filename to config.php!


Screenshot
=============
![Screenshot](https://raw.github.com/patschi/ovh-domains-overview/master/screenshot.png "Screenshot")


Credits
=============
Bootstrap by Twitter: <a href="http://twitter.github.com/bootstrap/" target="_blank">http://twitter.github.com/bootstrap/</a>
SOAPI by OVH: <a href="http://www.ovh.com/soapi/en/" target="_blank">http://www.ovh.com/soapi/en/</a>