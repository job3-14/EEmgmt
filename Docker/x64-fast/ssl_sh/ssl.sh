#!/bin/sh

openssl genrsa 2024 > server.key
openssl req -new -days 3650 -key server.key <<EOF >server.csr
JP
NONE
NONE
NONE
NONE
NONE


EOF
openssl x509 -in server.csr -out server.crt -req -signkey server.key -days 3650
