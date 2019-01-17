# sqreen-php

## Usage

```php
<?php
use Sqreen\SqreenClient;

$client = new SqreenClient(
    '1234567890123456789012', // applicationId
    'login@example.org',      // email
    'my_beautiful_password!'  // password
    );

// Get Security Response events
$events = $client->application->getSecurityResponse();

// Stop a Security Response
$securityResponseId = 'NWJlMTk2ZDdmM2Y1ZmEwMDE1MTMwMTRhOjVjM2UwZjIzMjlmMTcwMDAxZWM3NTM5MDo1YzNmNjQwNDUJyksICgnaWQnLCAnMzAzMzE3OCcpXSk6YmFjYTJiMmMxOWIwMTFlOWFlM2IwMjQyYWMxMTAwMDM';
$events = $client->application->deleteSecurityResponse($securityResponseId);

?>
```