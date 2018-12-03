# Read Email From Server - PHP Script

[![N|Solid](https://codesolz.net/wp-content/uploads/2016/11/logo4-hover.png)](https://codesolz.net/)

[![HitCount](http://hits.dwyl.io/tuhin18003/read-email-from-server-php-script.svg)](http://hits.dwyl.io/tuhin18003/read-email-from-server-php-script) [![Maintainability](https://api.codeclimate.com/v1/badges/bf99e6721f049eff6c6a/maintainability)](https://codeclimate.com/github/tuhin18003/read-email-from-server-php-script/maintainability)

You can read your email from your web server or any email hosting account.

# Features!
  - read email
  - delete email
  - Move email to folder

### How to use

Basic user emailple. Create instantiate of the class
```sh
$email_reader = new Email_reader();
$mail = $email_reader->get();
```

Read & delete email from inbox:
```sh
if(isset($mail[0]['index'])){
    for($i=0;$i<count($mail);$i++){
        $email= $mail[$i];
            $Deleted = trim($email['header']->Deleted);
            if($Deleted<>'D'){
                $index = trim($email['index']);
                $subject = stripslashes($email['header']->subject);
                $time = strtotime($email['header']->date).'.0000';
                $sender = $email['header']->fromaddress;
                $e = $email['header']->from[0]->mailbox;
                $e .='@'.$email['header']->from[0]->host;
                
                //delete email after read
                $email_reader->delete($index);
       }
    }
}
```


License
----

MIT


**Free Software, Hell Yeah!**

