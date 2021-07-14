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
$form = new Form();
$formFixture = new formFixture();
$response = array();

# Get all data from $_POST
$data = Standard::filter_post_data($_POST);
foreach ($data as $key => $value) {
    
    // Sanitize String
    $value = ($key !== "email") ? filter_var($value, FILTER_SANITIZE_STRING) : filter_var($value, FILTER_SANITIZE_EMAIL);

    switch($key) {
        case 'firstname':
            $form->set_firstname($value);
            break;

        case 'lastname':
            $form->set_lastname($value);
            break;

        case 'email':
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $form->set_email($value);
            } else {
                $response['error'] = 'invalid email';
                $response['field'] = $value;
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

        default:
            break;
    }

}

# Save file path
if (count($_FILES) == 1) {
    $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/uploads/';
    if (!file_exists($uploads_dir)) mkdir($uploads_dir, 0777, true);
    $destination = $uploads_dir . basename($_FILES["cv"]["name"]);
    // Set file path
    $form->set_cv_path($destination);
}


// store form in database
$storeData = $formFixture->load((array)$form);
$response['db_store_status'] = $storeData;

if ($response['db_store_status']['status'] == 'email_exists') {
    $response['error'] = 'email_exists';
    echo json_encode($response);
    exit(); 
}

if ($response['db_store_status']['status'] !== 'success') {
    $response['error'] = 'internal_server_error';
    echo json_encode($response);
    exit(); 
}


// Move file to uploads folder
if (count($_FILES) == 1) {
    $upload_status = move_uploaded_file($_FILES["cv"]["tmp_name"], $destination);
    if ($upload_status) {
        $response['upload_status'] = true;
        $response['file_path'] = $destination;
    } else {
        $response['upload_status'] = false;
        $response['file_path'] = '';
    }
}

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

    $recipient_email = $form->get_email();
    $r_firstname = $form->get_firstname();
    $r_lastname = $form->get_lastname();
    
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.'.$domain;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'user@'.$domain;                     //SMTP username
        $mail->Password   = '[SMTP_PASSWORD_GOES_HERE]';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('from@'.$domain, 'Mailer');
        $mail->addAddress($recipient_email, "$r_firstname $r_lastname");     //Add a recipient
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Application received';
        
        $mail->Body    = '
            <h1>Hello '.$r_firstname.',</h1>
            <p>
                Your application has been received and will be viewed by the HR.
            </p>
        ';

        $mail->AltBody = 'Your application has been received and will be viewed by the HR.';
    
        $mail->send();
        $response['mail_status'] = true;

         // Give final response
        echo json_encode($response);
        exit();
    } catch (Exception $e) {
        throw New Exception( $e->getMessage() );
    }
}
?>