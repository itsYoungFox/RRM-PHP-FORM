<?php
# Start session
session_start();
$root_path = '/RRM-PHP-FORM';

# Import PHP classes
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/standard.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/class/form.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $root_path . '/src/fixtures/form.fixture.php');

# Set objects
$standard = new Standard();
$form = new Form();
$formFixture = new formFixture();
$response = array();

# Upload and store files
$cv_path = 'C:/';
if (count($_FILES) == 1) {
    print_r($_FILES); // DEBUG: Check if files exist
    $form->set_cv_path($cv_path);
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




// Send mail
if ($storeData) {
    /**
     * SEND MAIL TO CLIENT
     */
    $mail = new PHPMailer();
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = 'your_email';
    $mail->Password = 'your_password';
    $mail->From = 'your_email';
    $mail->FromName = 'Your Name';
    $mail->AddAddress('your_email', 'Your Name');
    $mail->Subject = 'Form Submission';
    $mail->Body = 'Form Submission';
    $mail->AltBody = 'Form Submission';
    $mail->CharSet = 'UTF-8';
    $mail->AddAttachment($_FILES['cv']['tmp_name']);
    $mail->Send();
}
?>