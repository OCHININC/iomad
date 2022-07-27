<?php

/**
 * Cocoon Form Builder integration for Moodle
 *
 * @package    cocoon_form_builder
 * @copyright  ©2021 Cocoon, XTRA Enterprises Ltd. createdbycocoon.com
 * @author     Cocoon
 */
 
  require(__DIR__.'/../../config.php');
  require(__DIR__.'/../../blocks/cocoon_form/phpmailer/class.custommailer.php');

  defined('MOODLE_INTERNAL') || die();
  global $DB;

  $_RESTREQUEST = file_get_contents("php://input");
  $_POST = json_decode($_RESTREQUEST, true);

  if (isset($_POST["id"])) {
    $sql = "SELECT * FROM mdl_cocoon_form_builder_forms WHERE id = " . intval($_POST["id"]) ;
    $form = $DB->get_records_sql($sql);

    $json = json_decode($form[$_POST["id"]]->json);
    $emails = explode(";",$form[$_POST["id"]]->recipients);
    $confirmMessage = ($form[$_POST["id"]]->confirm_message) ? $form[$_POST["id"]]->confirm_message : "Thank you! Your message has been sent!";
    $autoRepEmails = [];
    $autoRepData = json_decode($form[$_POST["id"]]->data);

    $data = explode('&', $_POST["data"]);
    $obj = new stdClass();
    foreach ($data as $key => $value) {
      $item = explode('=', $value);
      if(property_exists($obj, $item[0])) {
        $obj->{$item[0]} = $obj->{$item[0]} . ", " . $item[1];
      } else {
        $obj->{$item[0]} = $item[1];
      }
    }

    // echo '<pre>';
    // var_dump($obj);
    // echo '</pre>';

    $htmlmessage = "Content: " . "<br />";
    $fileUpload = $fileExtension = [];
    foreach ($json as $key => $value) {
      if($value->type == "text" ||
         $value->type == "textarea" ||
         $value->type == "autocomplete" ||
         $value->type == "date" ||
         $value->type == "number" ||
         $value->type == "radio-group" ||
         $value->type == "select") {
        if (isset($obj->{$value->name})) {
          $htmlmessage .= $value->label . ": " . processData($obj->{$value->name}) . "<br />";

          if(checkemail(urldecode($obj->{$value->name}))) {
            array_push($autoRepEmails, urldecode($obj->{$value->name}));
          }
        }
      }
      if($value->type == "checkbox-group" || $value->type == "checkbox") {
        $machine_name = $value->name . '%5B%5D';
        if (isset($obj->{$machine_name})) {
          $htmlmessage .= $value->label . ": ";
          $htmlmessage .= $obj->{$machine_name};
          $htmlmessage .= "<br />";
        }
      }

      $allowedfileExtensions = array("image/png", "image/jpeg", "image/bmp", "image/vnd.microsoft.icon", "application/pdf", "application/msword",
                                     "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel",
                                     "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                     "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
                                     "text/csv", "application/zip");

      if($value->type == "file") {
        if (isset($_POST["file"]) && count($_POST["file"]) > 0) {

          foreach ($_POST["file"] as $key => $item) {
            $image_parts = explode(";base64,", $item[$value->name]);
        		if(count($image_parts) > 1) {
        			$file_type = trim(explode(":", $image_parts[0])[1]);

              if (in_array($file_type, $allowedfileExtensions)) {
                $base = $item[$value->name];
                array_push($fileUpload, base64_decode(str_replace(" ", "+", substr($base, strpos($base, ",")))));

                if($file_type == "image/png") {
                  array_push($fileExtension, "png");
                } elseif ($file_type == "image/jpeg") {
                  array_push($fileExtension, "jpg");
                } elseif ($file_type == "image/bmp") {
                  array_push($fileExtension,  "bmp");
                } elseif ($file_type == "image/vnd.microsoft.icon") {
                  array_push($fileExtension,  "ico");
                } elseif ($file_type == "application/pdf") {
                  array_push($fileExtension, "pdf");
                } elseif ($file_type == "application/msword") {
                  array_push($fileExtension, "doc");
                } elseif ($file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                  array_push($fileExtension, "docx");
                } elseif ($file_type == "application/vnd.ms-excel") {
                  array_push($fileExtension, "xls");
                } elseif ($file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                  array_push($fileExtension, "xlsx");
                } elseif ($file_type == "application/vnd.ms-powerpoint") {
                  array_push($fileExtension, "ppt");
                } elseif ($file_type == "application/vnd.openxmlformats-officedocument.presentationml.presentation") {
                  array_push($fileExtension, "pptx");
                } elseif ($file_type == "text/csv") {
                  array_push($fileExtension, "csv");
                } elseif ($file_type == "application/zip") {
                  array_push($fileExtension, "zip");
                }
              }
        		}
          }
        }
      }
    }

    $htmlmessage = urldecode($htmlmessage);

    $from = makeemailuser('email@domain.com', 'Moodle Admin', 2);
    $subject = "Email Notification";
    foreach ($emails as $key => $value) {
      if(checkemail($value)) {
        //$mail->AddAddress($value); // set recipient email address
        $to = makeemailuser($value, $value);

        $mail = new CustomMailer();
        $status = $mail->email_to_user_custom(true, $to, $from, $subject, html_to_text($htmlmessage), $htmlmessage, $fileUpload, $fileName, $fileExtension, true);
      }
    }

    //Send autoreply emails
    $fileUpload = $fileExtension = [];

    foreach ($autoRepEmails as $key => $value) {
      $value = makeemailuser($value);
      foreach ($autoRepData->attachments as $k => $file) {
        $image_parts = explode(";base64,", $file);
        if(count($image_parts) > 1) {
          $file_type = trim(explode(":", $image_parts[0])[1]);

          if (in_array($file_type, $allowedfileExtensions)) {
            $base = $file;
            array_push($fileUpload, base64_decode(str_replace(" ", "+", substr($base, strpos($base, ",")))));

            if($file_type == "image/png") {
              array_push($fileExtension, "png");
            } elseif ($file_type == "image/jpeg") {
              array_push($fileExtension, "jpg");
            } elseif ($file_type == "image/bmp") {
              array_push($fileExtension,  "bmp");
            } elseif ($file_type == "image/vnd.microsoft.icon") {
              array_push($fileExtension,  "ico");
            } elseif ($file_type == "application/pdf") {
              array_push($fileExtension, "pdf");
            } elseif ($file_type == "application/msword") {
              array_push($fileExtension, "doc");
            } elseif ($file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
              array_push($fileExtension, "docx");
            } elseif ($file_type == "application/vnd.ms-excel") {
              array_push($fileExtension, "xls");
            } elseif ($file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
              array_push($fileExtension, "xlsx");
            } elseif ($file_type == "application/vnd.ms-powerpoint") {
              array_push($fileExtension, "ppt");
            } elseif ($file_type == "application/vnd.openxmlformats-officedocument.presentationml.presentation") {
              array_push($fileExtension, "pptx");
            } elseif ($file_type == "text/csv") {
              array_push($fileExtension, "csv");
            } elseif ($file_type == "application/zip") {
              array_push($fileExtension, "zip");
            }
          }
        }
      }
      $replyMail = new CustomMailer();
      $replyMail->email_to_user_custom(true, $value, $from, $subject, html_to_text($autoRepData->message), $autoRepData->message, $fileUpload, '', $fileExtension,  true);
    }

    if($status) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              '. $confirmMessage .'
            </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Sorry! Your message cannot been sent. Please contact administrator!
            </div>';
    }
  }

  function processData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function makeemailuser($email, $name = '', $id = -99) {
    $emailuser = new stdClass();
    $emailuser->email = $email;
    $emailuser->firstname = format_text($name, FORMAT_PLAIN, array('trusted' => false));
    $emailuser->lastname = '';
    $emailuser->maildisplay = true;
    $emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML emails.
    $emailuser->id = $id;
    $emailuser->firstnamephonetic = '';
    $emailuser->lastnamephonetic = '';
    $emailuser->middlename = '';
    $emailuser->alternatename = '';
    return $emailuser;
  }

  function checkemail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
  }
