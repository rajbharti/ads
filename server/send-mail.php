<?php

switch ($_SERVER['REQUEST_METHOD']) {
  case ("OPTIONS"): //Allow preflighting to take place.
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: content-type");
    exit;
  case ("POST"): //Send the email;
    header("Access-Control-Allow-Origin: *");

    $json = file_get_contents('php://input');

    $params = json_decode($json);
    
    $name = $params->name;
    $email = $params->email;
    $subject = $params->subject;
    $message = $params->message;
    $msg = '
  <html>
  <head>
    <title>Email Template</title>
  </head>
  <body style="background-color: #f5f5f3; color: #182C2B;">
    <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.3; color: #182C2B; padding: 20px; font-weight: normal;">
        <tr>
            <td align="center">
                <table width="720" cellpadding="0" cellspacing="0" style="background-color: #FFFFFF;">
                    <tr>
                        <td style="padding: 10px 30px; height: 90px; background-color: #182C2B;">
                            <table width="100%" cellpadding="0" cellspacing="0" >
                                <tr>
                                    <td>
                                        <img src="https://www.agiledigitalstudio.com/assets/images/logo-emailtemplate.jpg" height="40" alt="Agile Digital Studio"style="vertical-align: middle;" />
                                    </td>
                                    <td align="right">
                                        <a href="https://www.agiledigitalstudio.com/" style="color: #FFFFFF; text-decoration: none;">agiledigitalstudio.com</a>
                                    </td>
                                </tr>
                            </table>
                         </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 30px; background-color: #f8ece0ff; font-size: 22px; font-weight: bold;">
                            Contact form
                         </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;" valign="top">
                            Hi Team,<br>
                            This message has been sent through our contact form.<br><br>

                            <table cellpadding="20" cellspacing="0">
                                <tr>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">Name:</td>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">' . $name. '</td>
                                </tr>
                                <tr>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">Email:</td>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">' . $email. '</td>
                                </tr>
                                <tr>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">Subject:</td>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">' . $subject. '</td>
                                </tr>
                                <tr>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">Message:</td>
                                    <td valign="top" style="border-bottom: 1px solid #E5E6E0;">' . $message. '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center;">
                &copy; '. date("Y") . ' Agile Digital Studio. All Rights Reserved.
            </td>
        </tr>
    </table>
  </body>
  </html>
';

    $from = "info@agiledigitalstudio.com";
    $to = "deep2008.contact@gmail.com";
    $headers = "From: $from <$from>" . "\r\n" .
      "Reply-To: $from <$from>" . "\r\n" .
      "Content-type:text/html;charset=UTF-8" . "\r\n";

    $mailSent = mail($to, $subject, $msg, $headers);

    header('Content-Type: application/json');

    echo json_encode(array("status" => $mailSent));

    break;
  default: //Reject any non POST or OPTIONS requests.
    header("Allow: POST", true, 405);
    exit;
}

?>