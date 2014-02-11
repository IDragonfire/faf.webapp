#-------------------------------------------------------------------------------
# Copyright (c) 2013 Brendan Hart.
# All rights reserved. This program and the accompanying materials
# are made available under the terms of the GNU Public License v3.0
# which accompanies this distribution, and is available at
# http://www.gnu.org/licenses/gpl.html
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#-------------------------------------------------------------------------------

Forged Alliance Forever Clans App
---------------------------------

Forged Alliance Forever (FAF) is a community developed replacement for the defunct GPGNet game lobby for Supreme Commander Forged Alliance.

For more information about FAF visit www.faforever.com

This code is a web application designed to allow users to find, create, join and manage "Clans" which will (hopefully) have some sort of integration to the official FAF client.



Installation
-------------

0. Obtain the webapp source from Bitbucket https://bitbucket.org/hartbren/faf_clans_webapp

1. Extract into a folder which is accessible via your webserver

2. Symlink the appropriate FatFreeFramework "lib.*" folder to "lib"

3. Modify index.php to have the correct server address/username/password for the two
 databases (clans and FAF usernames)

4. The Webserver needs to be configured something like the following. (Assuming Apache, adapt as needed for other servers)

httpd-vhosts.conf:
{{{
<VirtualHost *:80>

    ServerAdmin webmaster@dummy-host.example.com
    DocumentRoot /var/www/faf_clans_webapp/
    ServerName faf_clans_webapp.local:80

    DirectoryIndex index.php

    ErrorLog logs/error_log.faf_clans_webapp.log
    CustomLog logs/access_log.faf_clans_webapp.log common

    <Directory "/var/www/faf_clans_webapp">
        Options -Indexes FollowSymLinks Includes
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>

</VirtualHost>
}}}

httpd-ssl.conf
{{{
<VirtualHost _default_:443>

    DocumentRoot "/var/www/faf_clans_webapp"
    ServerName faf_clans_webapp.local:443

    DirectoryIndex index.php

    TransferLog logs/ssl_access_log
    LogLevel warn

    ErrorLog logs/error_log.faf_clans_webapp.log
    CustomLog logs/access_log.faf_clans_webapp.log common

    <Directory "/var/www/faf_clans_webapp">
        Options -Indexes FollowSymLinks Includes
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>


    SSLEngine on

    SSLCertificateFile /etc/pki/tls/certs/ca.crt
    SSLCertificateKeyFile /etc/pki/tls/private/ca.key
    #SSLCertificateChainFile /etc/pki/tls/certs/server-chain.crt
    #SSLCACertificateFile /etc/pki/tls/certs/ca-bundle.crt
    SSLProtocol all -SSLv2
    SSLCipherSuite ALL:!ADH:!EXPORT:!SSLv2:RC4+RSA:+HIGH:+MEDIUM:+LOW

    SetEnvIf User-Agent ".*MSIE.*" \
         nokeepalive ssl-unclean-shutdown \
         downgrade-1.0 force-response-1.0

</VirtualHost>

}}}
