<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Spam Quarantine
    |--------------------------------------------------------------------------
    |
    | When true (default), submissions flagged as spam/scam are still saved to
    | the database with `is_spam = true` so they can be reviewed in the admin
    | inbox — but no email notification is sent for them.
    |
    | Set INQUIRY_STORE_SPAM=false in your .env to go back to silently
    | discarding spam (fake success response, nothing stored, no email).
    |
    */

    'store_spam' => env('INQUIRY_STORE_SPAM', true),

];
