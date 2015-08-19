<?php
namespace Helpers\PhpMailer;

/*
 * Mail Helper
 *
 * @author David Carr - dave@simplemvcframework.com
 * @version 1.0
 * @date May 18 2015
 */
class Mail extends PhpMailer
{
    // Set default variables for all new objects
    public $From     = 'info@evetsrandpolph.com';
    public $FromName = 'Evets & Randolph';
    //public $Host     = 'smtp.gmail.com';
    //public $Mailer   = 'smtp';
    //public $SMTPAuth = true;
    //public $Username = 'email';
    //public $Password = 'password';
    //public $SMTPSecure = 'tls';
    public $WordWrap = 75;

    public function subject($subject)
    {
        $this->Subject = $subject;
    }

    public function body($body)
    {
        $this->Body = $body;
    }

    public function send()
    {
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);
        return parent::send();
    }


    public function general($email, $subject, $name, $content){
        $this->Body = file_get_contents(DIR.'app/templates/emails/body.html');

        $this->body = str_replace("<name>", $name, $this->Body);
        $this->Body = str_replace("<content>", $content, $this->Body);
       
        $this->addAddress($email);
        $this->subject($subject);
        $this->send();
    }
}
