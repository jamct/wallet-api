#!/bin/bash

cd /opt/certs
openssl x509 -in pass.cer -inform DER -out pass.pem -outform PEM
openssl pkcs12 -export -inkey key.key -in pass.pem -out pass.p12 -passout pass:internalOnly
rm pass.pem

if [[ ! -f apple.pem ]]
then
    curl https://www.apple.com/certificateauthority/AppleWWDRCAG4.cer --output apple.cer
    openssl x509 -inform der -in apple.cer -out apple.pem
    rm apple.cer
fi
cd /code
php artisan octane:start  --workers=auto --task-workers=auto --server=swoole --host=0.0.0.0