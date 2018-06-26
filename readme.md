# SIMPLE PROXY

### REQUIRE
    + PHP > 7.1
    + PHP-CURL

All requests must be rewritten on index.php (for configure apache2 use _.htaccess file )

### INSTALL
    1. clone this repository to yuor webserver root dir
    2. if use apache copy and rename _.htaccess to .htaccess
    
### USAGE
    * to change destination server url set DEST_SERVER_URL constant in local-config.php or config.php
    * allowed requests method: POST on '/' path
    * allowed content type: 'application/json'