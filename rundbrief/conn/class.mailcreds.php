<?php

class Mailcreds {

    public $Host=''; 
    public $Username=''; 
    public $Password=''; 
    public $Port=''; 
    public $SMTPSecure='';     

    function __construct() {
        $this->Host='localhost';
        $this->Username='postie';  // VS Code Erweiterung Postie 
        $this->Password='postie'; // VS Code Erweiterung Postie 
        $this->Port = 587;  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->SMTPSecure='tls';   //     PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption 
                    
    }
}

?>
