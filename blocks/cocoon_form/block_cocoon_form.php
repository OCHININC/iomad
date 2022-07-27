<?php
global $CFG, $PAGE;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
require_once('phpmailer/class.custommailer.php');

class block_cocoon_form extends block_base {
  public function init() {
    $this->title = get_string('cocoon_form', 'block_cocoon_form');
  }
  public function specialization() {
    global $CFG, $DB;
    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
  }
  function applicable_formats() {
    $ccnBlockHandler = new ccnBlockHandler();
    return $ccnBlockHandler->ccnGetBlockApplicability(array('all'));
  }
  public function html_attributes() {
    global $CFG;
    $attributes = parent::html_attributes();
    include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
    return $attributes;
  }
  public function instance_allow_multiple() {
    return true;
  }
  public function has_config() {
    return false;
  }
  public function cron() {
    return true;
  }
  public function processData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  private function makeemailuser($email, $name = '', $id = -99) {
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
  private function checkemail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
  }
  public function get_content(){
    global $CFG, $DB;
    require_once($CFG->libdir . '/filelib.php');
    if ($this->content !== null) {
      return $this->content;
    }
    $this->content = new stdClass;
    if($this->config){
      $id  = $this->config->form;
      $sql = "SELECT * FROM {cocoon_form_builder_forms} WHERE id = " . $id ;
      $form = $DB->get_records_sql($sql);
      $json = json_decode($form[$id]->json);
      $emails = explode(";",$form[$id]->recipients);
      $url = $form[$id]->url;
      $confirmMessage = ($form[$id]->confirm_message) ? $form[$id]->confirm_message : "Thank you! Your message has been sent!";
      $useAjax = $form[$id]->ajax;
      $message = $headers = "";

      $autoRepEmails = [];
      $data = json_decode($form[$id]->data);

      if($useAjax == '0' && $_SERVER["REQUEST_METHOD"] == "POST") {
        $htmlmessage = "Content: " . "<br />";
        $fileUpload = $tempFileName = "";
        foreach ($json as $key => $value) {

          if(
            ($value->type == "text" ||
            $value->type == "textarea" ||
            $value->type == "autocomplete" ||
            $value->type == "date" ||
            $value->type == "number" ||
            $value->type == "radio-group" ||
            $value->type == "select")
            && isset($_POST[$value->name])
          ) {
            $htmlmessage .= $value->label . ": " . $this->processData($_POST[$value->name]) . "<br />";
            if($this->checkemail($_POST[$value->name])) {
              array_push($autoRepEmails, $_POST[$value->name]);
            }
          }
          if($value->type == "checkbox-group" || $value->type == "checkbox") {
            if (isset($_POST[$value->name])) {
              $htmlmessage .= $value->label . ": ";
              foreach ($_POST[$value->name] as $item) {
                $htmlmessage .= $item." ";
              }
              $htmlmessage .= "<br />";
            }
          }
          if($value->type == "file" && isset($_FILES[$value->name]) && $_FILES[$value->name]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$value->name]['tmp_name'];
            $fileName = $_FILES[$value->name]['name'];
            $fileSize = $_FILES[$value->name]['size'];
            $fileType = $_FILES[$value->name]['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // sanitize file-name
            //$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $newFileName = $fileName;

            $allowedfileExtensions = array('doc', 'docx', 'pdf', 'csv', 'xlsx', 'ppt', 'pptx', 'jpg', 'bmp', 'ico', 'png', 'zip');
            if (in_array($fileExtension, $allowedfileExtensions)) {
              $tempFileName = $fileTmpPath;
            }
          }
        }

        $from = $this->makeemailuser('email@domain.com', 'Moodle Admin', 2);
        $subject = "Email Notification";

        foreach ($emails as $key => $value) {
          $to = $this->makeemailuser($value, $value);
          if($this->checkemail($to->email)) {
            $mail = new CustomMailer();
            $status = $mail->email_to_user_custom(false, $to, $from, $subject, html_to_text($htmlmessage), $htmlmessage, $tempFileName, $fileName, '',  true);
          }
        }

        if($url) {
          header("Location: " . $url);
          exit();
        } else {
          $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Sorry, your message failed to send. Please contact the website administrator.
                      </div>';
          if($status) {
                $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                              '. $confirmMessage .'
                            </div>';
          }
        }

        //Send autoreply emails
        $allowedfileExtensions = array("image/png", "image/jpeg", "image/bmp", "image/vnd.microsoft.icon", "application/pdf", "application/msword",
                                       "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel",
                                       "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                       "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
                                       "text/csv", "application/zip");
        $fileUpload = $fileExtension = [];

        foreach ($autoRepEmails as $key => $value) {
          $value = $this->makeemailuser($value);
          foreach ($data->attachments as $k => $file) {
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
          $replyMail->email_to_user_custom(true, $value, $from, $subject, html_to_text($data->message), $data->message, $fileUpload, '', $fileExtension,  true);
        }
      }

      $formID = "form_builder";
      if($useAjax) {
        $formID = "form_builder_ajax";
      }

      $this->content->text = '
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <section>
    		<div class="container">
    			<div class="row">
            <div class="col-lg-12">
              <div id="msg" class="">'. $message .'</div>
              <form enctype="multipart/form-data" class="form_builder contact_form" id="'. $formID .'" method="post" --rm-action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" action="">';
                if($useAjax) {
                  $this->content->text .='
                  <div class="form-group">
                    <input id="form-id" type="hidden" value="'. $id .'" />
                    <input id="ajaxURL" type="hidden" value="'. new moodle_url($CFG->wwwroot . '/local/cocoon_form_builder/submit.php') .'" />
                  </div>';
                }
                foreach ($json as $key => $value) {
                  if($value->type == "header" || $value->type == "paragraph") {
                    $this->content->text .='
                    <div class="form-group">
                      <'. $value->subtype .'>' . $value->label . '</'. $value->subtype .'>
                    </div>';
                  }
                  if($value->type == "textarea") {
                    $required = ($value->required) ? "required" : "";
                    $this->content->text .='
                    <div class="ui_kit_textarea">
                      <div class="form-group">
                        <h5>' . $value->label . '</h5>
                        <textarea '. $required .' class="' . $value->className .'" rows="5" name="'. $value->name .'" id="' . $value->name .'">'. $value->value .'</textarea>
                      </div>
                    </div>';
                  }
                  if($value->type == "autocomplete") {
                    $required = ($value->required) ? "required" : "";
                    $default = "";
                    $options = array();
                    foreach ($value->values as $key => $item) {
                      array_push($options,$item->label);
                      if($item->selected) $default = $item->label;
                    }
                    $this->content->text .='
                    <script>
                      $( function() {
                        var availableTags = '. json_encode($options) .';
                        $("#'. $value->name .'").autocomplete({
                          source: availableTags
                        });
                      } );
                    </script>
                    <div class="ui_kit_input">
                      <div class="form-group">
                        <label for="'. $value->name .'">'. $value->label .'</label>
                        <input type="text" '. $required .' id="'. $value->name .'" name="'. $value->name .'" value="'. $value->value .'" class="'. $value->className .'" />
                      </div>
                    </div>';
                  }
                  if($value->type == "button") {
                    // $this->content->text .='
                    // <div class="form-group">
                    //   <button type="'. $value->subtype .'" class="'. $value->className .'" value="'. $value->value .'">'. $value->label .'</button>
                    // </div>';
                    $this->content->text .='
                    <div class="form-group">
                      <button type="submit" class="'. $value->className .'" value="'. $value->value .'">'. $value->label .'</button>
                    </div>';
                  }
                  if($value->type == "checkbox-group" || $value->type == "checkbox") {
                    $this->content->text .='<div class="ui_kit_checkbox">';

                    $options = array();
                    foreach ($value->values as $key => $item) {
                      $checked = ($item->selected) ? "checked" : "";
                      $this->content->text .='
                      <div class="custom-control custom-checkbox">
    										<input type="checkbox" class="custom-control-input '. $value->className .'" id="customCheck'. $key .'" name="'. $value->name .'[]" value="'. $item->value .'" '. $checked .'>
    										<label class="custom-control-label" for="customCheck'. $key .'">'. $value->label .'</label>
    									</div>';
                    }

                    $this->content->text .='</div>';
                  }
                  if($value->type == "date") {
                    $required = ($value->required) ? "required" : "";
                    $this->content->text .='
                    <div class="ui_kit_input">
                      <div class="form-group">
                        <label for="'. $value->name .'">'. $value->label .'</label>
                        <input type="date" '. $required .' id="'. $value->name .'" name="'. $value->name .'" value="'. $value->value .'" class="'. $value->className .'" />
                      </div>
                    </div>';
                  }
                  if($value->type == "file") {
                    $required = ($value->required) ? "required" : "";
                    $this->content->text .='
                    <div class="ui_kit_input">
                      <div class="form-group">
                        <label for="'. $value->name .'">'. $value->label .'</label>
                        <input '. $required .' class="uploadFile '. $value->className .'" type="file" id="'. $value->name .'" name="'. $value->name .'" />
                        <div class="previewImg hidden" id="previewImg-'. $value->name .'"></div>
                      </div>
                    </div>';
                  }
                  if($value->type == "number") {
                    $required = ($value->required) ? "required" : "";
                    $this->content->text .='
                    <div class="ui_kit_input">
                      <div class="form-group">
                        <label for="'. $value->name .'">'. $value->label .'</label>
                        <input type="number" '. $required .' id="'. $value->name .'" name="'. $value->name .'" value="'. $value->value .'" class="'. $value->className .'" />
                      </div>
                    </div>';
                  }
                  if($value->type == "radio-group") {
                    //$this->content->text .='<div class="form-group"><label style="font-weight: bold;" for="'. $value->name .'">' . $value->label . '</label><br />';
                    $this->content->text .='<div class="ui_kit_radiobox">';
                    $options = array();
                    foreach ($value->values as $key => $item) {
                      $checked = ($item->selected) ? "checked" : "";
                      $this->content->text .='<div class="radio" style="display: block;">
                            										<input id="radio_'.$key.'" name="radio" type="radio" '. $checked .' name="'. $value->name .'" value="'. $item->value .'">
                            										<label for="radio_'.$key.'" style="display: inline;"><span class="radio-label"></span> '. $item->label .'</label>
                            									</div>';
                    }

                    $this->content->text .='</div>';
                  }
                  if($value->type == "select") {
                    $required = ($value->required) ? "required" : "";
                    $this->content->text .='
                    <div class="form-group">
                      <label style="width: 100%; font-weight: bold;" for="'. $value->name .'">' . $value->label . '</label>
                      <select name="'. $value->name .'" '. $required .' id="'. $value->name .'" class="custom-select">';
                        foreach ($value->values as $key => $item) {
                          $selected = ($item->selected) ? "selected" : "";
                          $this->content->text .='<option '. $selected .' value="'. $item->value .'">'. $item->label .'</option>';
                        }
                    $this->content->text .='
                      </select>
                    </div>';
                  }
                  if($value->type == "text") {
                    $required = ($value->required) ? "required" : "";
                    $this->content->text .='
                    <div class="ui_kit_input">
                      <div class="form-group">
                        <label for="'. $value->name .'">'. $value->label .'</label>
                        <input type="text" '. $required .' id="'. $value->name .'" name="'. $value->name .'" value="'. $value->value .'" class="'. $value->className .'" />
                      </div>
                    </div>';
                  }
                }
      $this->content->text .='
              </form>
            </div>
          </div>
        </div>
      </section>';
    }

    if(empty($this->config->form)){
      $this->content->text = '<div class="alert alert-warning">No form selected.</div>';
    }
    return $this->content;
  }
}

$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/blocks/cocoon_form/script.js'));
