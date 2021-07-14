<?php
# Start session
session_start();
$root_path = '/RRM-PHP-FORM';

# Import PHP classes
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/standard.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/form.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/fixtures/form.fixture.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

# Set objects
$standard = new Standard();
$form = new Form();
$formFixture = new formFixture();
$response = array();

# Upload and store files
if (count($_FILES) == 1) {
    $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/uploads/';
    $destination = $uploads_dir . basename($_FILES["cv"]["name"]);

    $upload_status = move_uploaded_file($_FILES["cv"]["tmp_name"], $destination);
    if ($upload_status) {
        $response['upload_status'] = true;
        $response['file_path'] = $destination;
    } else {
        $response['upload_status'] = false;
        $response['file_path'] = '';
    }    
    
    // Set file path
    $form->set_cv_path($response['file_path']);
}

# Get all data from $_POST
$data = Standard::filter_post_data($_POST);
foreach ($data as $key => $value) {
    switch($key) {
        case 'firstname':
            $form->set_firstname($value);
            break;

        case 'lastname':
            $form->set_lastname($value);
            break;

        case 'email':
            $email = filter_var($value, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $form->set_email($email);
            } else {
                $response['error'] = 'invalid email';
                $response['field'] = $email;
                echo json_encode($response);
                exit();
            }
            break;

        case 'teleNumber':
            $form->set_teleNumber($value);
            break;

        case 'address1':
            $form->set_address1($value);
            break;

        case 'address2':
            $form->set_address2($value);
            break;

        case 'town':
            $form->set_town($value);
            break;

        case 'postcode':
            $form->set_postcode($value);
            break;

        case 'county':
            $form->set_county($value);
            break;

        case 'country':
            $form->set_country($value);
            break;
        
        case 'description':
            $form->set_description($value);
            break;  
    }

}

// store form in database
$storeData = $formFixture->load((array)$form);

$response['store_status'] = $storeData;

// Remove this block if you want to run SMTP mailing -------------------
echo json_encode($response);
exit(); 
// ---------------------------------------------------------------------

// Send email
if ($storeData) {
    /**
     * SEND MAIL TO CLIENT
     */
    $mail = new PHPMailer(true);
    $domain = "domain.com";
    
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.'.$domain;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'user@'.$domain;                     //SMTP username
        $mail->Password   = 'secret';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('from@'.$domain, 'Mailer');
        $mail->addAddress('joe@'.$domain, 'Joe User');     //Add a recipient
        // $mail->addAddress('ellen@'.$domain);               //Name is optional
        // $mail->addReplyTo('info@'.$domain, 'Information');
        // $mail->addCC('cc@'.$domain);
        // $mail->addBCC('bcc@'.$domain);
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>