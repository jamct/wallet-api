<?php

return [
    'certificate_store_path' => '/opt/certs/pass.p12',
    'certificate_store_password' => 'internalOnly',
    'wwdr_certificate_path' => '/opt/certs/apple.pem', //https://www.apple.com/certificateauthority/

    'type_identifier' => env('PASS_TYPE_IDENTIFIER', 'pass.demo'),
    'team_id' => env('PASS_TEAM_ID', '1234'),
    'organization_name' => env('PASS_ORGANIZATION_NAME', ''),

];
