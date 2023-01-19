# Mailjet Send Sms

## How to use
Basic example  
```php 
use Francoisvaillant\Sendsms\SmsSender;
use Francoisvaillant\Sendsms\SmsMessage;

$sender  = new SmsSender();
$message = new SmsMessage('Your name', 'recipient phone number (i.e 0666666666)', 'your message');

$token = 'your mailjet sms api token';

if(!$message->hasError()) {
    $sender->setToken($token)->connect();
    
    // Phone international is set to France (33) by default.
    // If you want to change it : $sender->setPhonePrefix(44);
    if($sender->send($message)) {
        echo 'message envoyé<br>';
    } else {
        echo 'Erreur lors de l\'envoi';
    }
} else {
    foreach ($message->getErrors() as $error) {
        echo $error . '<br>';
    }
}

```