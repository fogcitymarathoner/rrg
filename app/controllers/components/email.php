<?PHP 
/**
 * This is a component to send email from CakePHP using PHPMailer
 * @link http://bakery.cakephp.org/articles/view/94
 * @see http://bakery.cakephp.org/articles/view/94
 */

class EmailComponent
{
  /**
   * Send email using SMTP Auth by default.
   */
    var $from         = 'marc@sfgeek.org';
    var $fromName     = "Cake PHP-Mailer";
    var $UserName = '';//configure::read('email_user'); // SMTP username
    var $Password = '';//configure::read('email_password');// SMTP password
    var $smtpHostNames= '';//configure::read('email_host');// // specify main and backup server
    #var $UserName = 'clseller@sfgeek.org';  // SMTP username
    #var $Password = 'clseller2012'; // SMTP password
    #var $smtpHostNames= "smtp.webfaction.com:465";  // specify main and backup server
    							// tls does not work on webfaction
    var $SMTPSecure = "";                 // sets the security protocol
    var $text_body = null;
    var $html_body = null;
    var $to = "";
    var $toName = " ";
    var $subject = null;
    var $cc = null;
    var $bcc = null;
    var $template = 'email/default';
    var $attachments = null;

    var $controller;

    function startup( &$controller ) {
      $this->controller = &$controller;
    }

    function bodyText() {
    /** This is the body in plain text for non-HTML mail clients
     */
      ob_start();
      $temp_layout = $this->controller->layout;
      $this->controller->layout = '';  // Turn off the layout wrapping
      $this->controller->render($this->template . '_text'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }

    function bodyHTML() {
    /** This is HTML body text for HTML-enabled mail clients
     */
      ob_start();
      $temp_layout = $this->controller->layout;
      $this->controller->layout = 'email';  //  HTML wrapper for my html email in /app/views/layouts
      $this->controller->render($this->template . '_html'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }

    function attach($filename, $asfile = '') {
      if (empty($this->attachments)) {
        $this->attachments = array();
        $this->attachments[0]['filename'] = $filename;
        $this->attachments[0]['asfile'] = $asfile;
      } else {
        $count = count($this->attachments);
        $this->attachments[$count+1]['filename'] = $filename;
        $this->attachments[$count+1]['asfile'] = $asfile;
      }
    }


    function send()
    {
    	//debug($this);exit;
    App::import('Vendor','phpmailer',array('file'=>'class.phpmailer.php'));
    $mail = new PHPMailer();
    
	$mail->IsSMTP(); // telling the class to use SMTP

	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = $this->SMTPSecure;
	$mail->Host       = configure::read('email_host');//"sfgeek.net";      // sets GMAIL as the SMTP server
	$mail->Port       = configure::read('email_port');//2525;                   // set the SMTP port for the GMAIL server
	$mail->Username   = configure::read('email_user');  //  username
	$mail->Password   = configure::read('email_password');            //  password
    $mail->SMTPSecure =  "tls";

    $mail->AddAddress($this->to, $this->toName );
    $mail->AddReplyTo($this->from, $this->fromName );
	$mail->SetFrom('timecards@rocketsredglare.com', 'Timecards');
    $mail->CharSet  = 'UTF-8';
    $mail->WordWrap = 50;  // set word wrap to 50 characters
    if (!empty($this->attachments)) {
      foreach ($this->attachments as $attachment) {
        if (empty($attachment['asfile'])) {
          $mail->AddAttachment($attachment['filename']);
        } else {
          $mail->AddAttachment($attachment['filename'], $attachment['asfile']);
        }
      }
    }
    $mail->IsHTML(true);  // set email format to HTML
    $mail->Subject = $this->subject;
    $mail->Body    = $this->body;//$this->bodyHTML();

            Configure::write('debug',2);

    $mail->AltBody = $this->body;//$this->bodyText();
    $result = $mail->Send();
//debug($result);
    //debug($mail);exit;
    //debug($this);
//exit;

    if($result == false ) $result = $mail->ErrorInfo;

    return $result;
    }
}
?>
