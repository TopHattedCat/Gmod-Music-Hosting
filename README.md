# Gmod-Music-Hosting
An old site for hosting music on. It was written a long time ago and probably doesn't work properly.


It was originally made for a Garry's Mod server, where it was possible to listen to your own music via a radio. This site allowed you to upload tracks and the game would fetch them via a HTTP request to /gettracks.php


Requirements to get this working:
* A web server and PHP
* ffmpeg installed on the server
* A MySQL server
* The 'upload' and 'convert' folders must be writable by the web server
* Steam API key from http://steamcommunity.com/dev

DB info needs putting in utils.php and a lot of messing is probably needed to get this working. I don't recommend trying to use this if you don't know what you're doing.