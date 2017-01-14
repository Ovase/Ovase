# Current steps to set up a new server

1. Install apache, SQL, php and phpMyAdmin. If using AWS, follow this page: http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/install-LAMP.html
2. Enable HTTPS on the server. If using AWS, follow this page: http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/SSL-on-an-instance.html (CURRENTLY NOT COMPLETED)
3. Install PHP APC: `sudo yum install php56-pecl-apc`
4. Change the apache config (httpd.conf) according to configuration/apache/apache_security.txt
5. Install git
6. Install Node.js (for parsoid)
7. Install [Parsoid](https://www.mediawiki.org/wiki/Parsoid/Developer_Setup). Parsoid is used for the visual editor in mediawiki. Before installing, you might have to `sudo yum install gcc gcc-c++ make`.
8. Copy config.yaml and localsettings.js from the deploy files
9. Install [forever-service](https://www.npmjs.com/package/forever-service)
10. Install parsoid as a service:
    - Go to parsoid/bin folder
    - `sudo forever-service install -s "server.js" -f " --workingDir /home/ec2-user/git/parsoid" parsoidd`
11. Clone the Overvann repo
12. `mkdir /var/www/html/wiki`
13. `mkdir ~/deploy_backups`
14. Go into the Overvann repo
15. `./deploy_code.sh ovase wiki`
16. Go to `/var/www/html/wiki`
17. Copy the sql user data file `sql_users.secret` to this folder
18. Copy the mediawiki secrets data file `mw_keys.secret` to this folder
19. The images in the wiki are not in the repo. Therefore, copy `images.zip` to the wiki folder and unzip it like this:
    - Unzip the archive: `unzip images.zip`
    - Delete the archive: `rm images.zip`
20. Import the ovase database, for instance using phpMyAdmin (located at server-url.com/phpmyadmin)
21. Edit `LocalSettings.php` and check that everyting is correct. For instance, you might have to change `$wgServer` and `$wgPasswordSender`
22. Restart Apache: `sudo service httpd restart`
23. The server should now be up and running. Goto the url of the server in your browser to check. Also check that the wiki is running. You might have to refresh it a few times for everything to work.

## Currently doesn't work "out of the box" when following these steps:

* VisualEditor
	- Fixed by fixing the lib/ve folder. It's supposed to be a git submodule (see the official VisualEditor repo), but something has corrupted it.