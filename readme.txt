Forged Alliance Forever (FAF) is a community developed replacement for the defunct GPGNet game lobby for Supreme Commander Forged Alliance.
For more information about FAF visit official homepage: 
http://www.faforever.com

This application was orginally designed by Brendan Hart and distributed on Bitbucket: 
https://bitbucket.org/hartbren/faf_clans_webapp
Application supposed to fulfill goals of Quest for Webcoders that was organized by Ze_PilOt (main developer of FAF):
http://www.faforever.com/forums/viewtopic.php?f=2&t=2881
Brendan Hart disappeared without single word in October 2013. We decided to finish application.

Installation guide:
0. Obtain the webapp source from GitHub: https://github.com/IDragonfire/faf.webapp

1. Extract into a folder which is accessible via your webserver

2. Create two databases from schemas:
faf: https://github.com/IDragonfire/faf.webapp/blob/master/model/faf_db_schema.sql
clans: https://github.com/IDragonfire/faf.webapp/blob/master/model/fafclans.sql

3. Modify index.php to have the correct server address/username/password for the two
 databases (clans and faf). Make sure that user has privileges to access these databases.

4. The Webserver needs to be configured something like the following. (Assuming Apache, adapt as needed for other servers)