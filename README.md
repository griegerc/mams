# MAMS - Measuring and Analyzing Micro Service
    Author: Christian Grieger
    Version: 1.0 (2018-12-14)
    License: GNU General Public License v3.0 (see file "LICENSE")
This microservice receives data from online games via UDP and can visualize them for analyzing purposes.
The principle behind this service is to send specific measurement data to the server when they are 
changed/incremented/decremented over time. The analyzing web interface can then visualize these stored
data in a graphical way. It is useful to measure e.g. user logins/registrations, certain game balancing values, 
quest accomplishments and much more... 

## Data receiving
After the MASM server is started you can send measurement data to it via UDP.
### Data format
The sent data must be formatted in JSON with the following content:

    {    
        "gameId": 19,
        "key":    "registeredUsers",
        "value":  1
    }
### PHP client example
    <?php
    $host = '192.168.1.2';
    $port = 5678;
    
    $socket = fsockopen('udp://'.$host.':'.$port);
    fputs($socket, '{"gameId": 15, "key": "userLogin", "value": 1}');


## Data analysing
*...to be specified...*

## Limitations
 - the maximum length of the sent data must not exceed 512 bytes
 - the maximum amount of measure keys are 65535 and their length must not exceed 32 characters
 - there are maximmal 255 different game-IDs possible
 - the total amount of data sets must not exceed 4294967295
 - the sent value must be within -32768 and 32767

## Installation & setup
### Requirements
 - MySQL server (tested with v5.5.40)
 - PHP (tested with v5.5.38)
 - Webserver (tested with lighttpd/1.4.31)

### Example for webserver configuration
In this case we use [lighttpd](https://www.lighttpd.net/) for setting up a webserver with MAMS.
The file /etc/lighttpd/lighttpd.conf could look like:
<pre>
server.modules = (
    "mod_expire",
    "mod_access",
    "mod_alias",
    "mod_compress",
    "mod_redirect",
    "mod_fastcgi",
    "mod_accesslog",
    "mod_rewrite",
)

fastcgi.server = ( ".php" => ((
    "bin-path" => "/usr/bin/php-cgi",
    "socket" => "/tmp/php.sock"
)))

# ...default lighttpd settings here...

$HTTP["host"] == "mams.lan" {
    server.document-root = "/var/www/mams/public"
    url.rewrite-if-not-file = ("^(.*)$" => "/index.php?q=$1")
}
</pre>

### Setup
 - Copy the code to your desired folder (e.g. `/var/www/mams`)
 - Copy `config.ini.sample` to `config.ini` and modify the settings to your wishes and needs
   - For maximum security change definitly the settings in your production/live environment
     `ENVIRONMENT` to `"production"`, 
 - Execute the init script: `cd /var/www/mams/scripts/init && php -f init.php`
 - Adapt the setting of your webserver (see example above)  
 
#### Logging
Create a log file a give the correct rights (see `config.ini` below `LOG_FILE`):

    > touch /var/log/mams.log
    > chown www-data:www-data /var/log/mams.log

#### Server daemon
Create a new file in  `/etc/systemd/system/multi-user.target.wants/` and 
name it e.g. `mams-server.service` with the following contents:

    [Unit]
    Description=MAMS Server
    After=syslog.target
    
    [Service]
    ExecStart=/usr/bin/php -f /var/www/mams/server/server.php
    Restart=always
    
    [Install]
    WantedBy=multi-user.target

Start/stop this service with:

    > systemctl start mams-server.service
    > systemctl stop mams-server.service
