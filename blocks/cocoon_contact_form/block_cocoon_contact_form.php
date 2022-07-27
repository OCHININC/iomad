<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_contact_form extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_contact_form', 'block_cocoon_contact_form');
    }

    // Declare second
    public function specialization()
    {
      global $CFG, $DB;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass;
        if(!empty($this->config->feature_1_title)){$this->content->feature_1_title = $this->config->feature_1_title;}
        if(!empty($this->config->feature_1_subtitle)){$this->content->feature_1_subtitle = $this->config->feature_1_subtitle;}
        if(!empty($this->config->feature_1_icon)){$this->content->feature_1_icon = $this->config->feature_1_icon;}
        if(!empty($this->config->feature_2_title)){$this->content->feature_2_title = $this->config->feature_2_title;}
        if(!empty($this->config->feature_2_subtitle)){$this->content->feature_2_subtitle = $this->config->feature_2_subtitle;}
        if(!empty($this->config->feature_2_icon)){$this->content->feature_2_icon = $this->config->feature_2_icon;}
        if(!empty($this->config->feature_3_title)){$this->content->feature_3_title = $this->config->feature_3_title;}
        if(!empty($this->config->feature_3_subtitle)){$this->content->feature_3_subtitle = $this->config->feature_3_subtitle;}
        if(!empty($this->config->feature_3_icon)){$this->content->feature_3_icon = $this->config->feature_3_icon;}
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if(!empty($this->config->map_lat)){$this->content->map_lat = $this->config->map_lat;}
        if(!empty($this->config->map_lng)){$this->content->map_lng = $this->config->map_lng;}
        if(!empty($this->config->map_address)){$this->content->map_address = $this->config->map_address;}
        if(!empty($this->config->zoom)){$this->content->zoom = $this->config->zoom;}else{$this->content->zoom = '11';}
        if(!empty($this->config->style)){$this->content->style = $this->config->style;}else{$this->content->style = '0';}

        if (!empty($this->config) && is_object($this->config)) {
          $ccnStorage = $this->config;
          $ccnStorage->items = is_numeric($ccnStorage->items) ? (int)$ccnStorage->items : 3;
        } else {
          $ccnStorage = new stdClass();
          $ccnStorage->items = '8';
        }

        $col_class = "col-sm-6 col-lg-4";
        // if($this->content->feature_1_title || $this->content->feature_1_subtitle){
        //   $col_class = "col-sm-12";
        // }
        // if($this->content->feature_2_title || $this->content->feature_2_subtitle){
        //   $col_class = "col-sm-6 col-lg-6";
        // }
        // if($this->content->feature_3_title || $this->content->feature_3_subtitle){
        //   $col_class = "col-sm-6 col-lg-4";
        // }

        if(!empty($this->config->map_style)){
          if($this->config->map_style == 4) {
            $map_style = '\'terrain\'';
          } elseif($this->config->map_style == 3) {
            $map_style = '\'hybrid\'';
          } elseif($this->config->map_style == 2) {
            $map_style = '\'satellite\'';
          } elseif($this->config->map_style == 1) {
            $map_style = '\'roadmap\'';
          } else {
            $map_style = 'MY_MAPTYPE_ID';
          }
        } else {
          $map_style = 'MY_MAPTYPE_ID';
        }

        $fs = get_file_storage();
        for ($i = 1; $i <= 2; $i++) {
                $image = 'image' . $i;
                $files = $fs->get_area_files($this->context->id, 'block_cocoon_contact_form', 'images', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                if (count($files) >= 1) {
                    $mainfile = reset($files);
                    $mainfile = $mainfile->get_filename();
                } else {
                    continue;
                }
                $img_item[] = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_contact_form/images/" . $i . '/' . $mainfile);

        }

        if(!empty($img_item[0]) && !empty($img_item[1])){
          $map_marker_img = $img_item[1];
        } elseif(!empty($img_item[0]) && empty($img_item[1])){
            $map_marker_img = $img_item[0];
        } else {
          $map_marker_img = $CFG->wwwroot.'/theme/edumy/images/resource/mapmarker.png';
        }

        $this->content->text = '
        <section class="our-contact">
      		<div class="container">
      			<div class="row">';

            if ($ccnStorage->items > 0) {
              for ($i = 1; $i <= $ccnStorage->items; $i++) {
                  $ccnTitle = 'title_'.$i;
                  $ccnSubtitle = 'subtitle_'.$i;
                  $ccnIcon = 'icon_'.$i;

                  $this->content->text .= '
                    <div class="'.$col_class.'">
            					<div class="contact_localtion text-center">
                        <div class="icon"><span data-ccn="'.$ccnIcon.'" class="'.format_text($ccnStorage->$ccnIcon, FORMAT_HTML, array('filter' => true)).'"></span></div>
                        <h4 data-ccn="'.$ccnTitle.'">'.format_text($ccnStorage->$ccnTitle, FORMAT_HTML, array('filter' => true)).'</h4>
                        <p data-ccn="'.$ccnSubtitle.'">'.format_text($ccnStorage->$ccnSubtitle, FORMAT_HTML, array('filter' => true)).'</p>
            					</div>
            				</div>';

              }
            }
            if($ccnStorage->items == 0){
            if($this->content->feature_1_title || $this->content->feature_1_subtitle){
              $this->content->text .='
      				<div class="'.$col_class.'">
      					<div class="contact_localtion text-center">';
                if($this->content->feature_1_icon){
                  $this->content->text .='<div class="icon"><span class="'.format_text($this->content->feature_1_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>';
                }
                if($this->content->feature_1_title){
                  $this->content->text .='<h4>'.format_text($this->content->feature_1_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                }
                if($this->content->feature_1_subtitle){
                  $this->content->text .='<p>'.format_text($this->content->feature_1_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                }
                $this->content->text .='
      					</div>
      				</div>';
            }
            if($this->content->feature_2_title || $this->content->feature_2_subtitle){
              $this->content->text .='
      				<div class="'.$col_class.'">
      					<div class="contact_localtion text-center">';
                if($this->content->feature_2_icon){
                  $this->content->text .='<div class="icon"><span class="'.format_text($this->content->feature_2_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>';
                }
                if($this->content->feature_2_title){
                  $this->content->text .='<h4>'.format_text($this->content->feature_2_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                }
                if($this->content->feature_2_subtitle){
                  $this->content->text .='<p>'.format_text($this->content->feature_2_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                }
                $this->content->text .='
      					</div>
      				</div>';
            }
            if($this->content->feature_3_title || $this->content->feature_3_subtitle){
              $this->content->text .='
      				<div class="'.$col_class.'">
      					<div class="contact_localtion text-center">';
                if($this->content->feature_3_icon){
                  $this->content->text .='<div class="icon"><span class="'.format_text($this->content->feature_3_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>';
                }
                if($this->content->feature_3_title){
                  $this->content->text .='<h4>'.format_text($this->content->feature_3_title, FORMAT_HTML, array('filter' => true)).'</h4>';
                }
                if($this->content->feature_3_subtitle){
                  $this->content->text .='<p>'.format_text($this->content->feature_3_subtitle, FORMAT_HTML, array('filter' => true)).'</p>';
                }
                $this->content->text .='
      					</div>
      				</div>';
            }
          }
              $this->content->text .='
      			</div>
      			<div class="row">';
                if($this->content->style == 0) {
                  $this->content->text .='<div class="col-lg-6"><div class="h600" id="map-canvas"></div></div>';
                } elseif($this->content->style == 1 && $img_item[0]) {
                  $this->content->text .= '<div class="col-lg-6"><img class="img-fluid" src="'.$img_item[0].'"></div>';
                }
                if($this->content->style == 0) {
                  $this->content->text .='<div class="col-lg-6 form_grid">';
                } elseif($this->content->style == 1 && $img_item[0]) {
                  $this->content->text .= '<div class="col-lg-6 form_grid">';
                } else {
                  $this->content->text .= '<div class="col-lg-12 form_grid">';
                }
                $this->content->text .='
      					<h4 class="mb5" data-ccn="title">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h4>
      					<p data-ccn="subtitle">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                <form action="'.$CFG->wwwroot.'/local/contact/index.php" method="post" class="contact_form" id="contact_form">
                   <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="name" id="namelabel">'.get_string('your_name', 'theme_edumy').'</label>
                          <input class="form-control" id="name" name="name" type="text" title="'.get_string('your_name_requirements', 'theme_edumy').'" required="required" value="">
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="email" id="emaillabel">'.get_string('email_address', 'theme_edumy').'</label>
                          <input id="email" name="email" type="email" required="required" title="'.get_string('email_address_requirements', 'theme_edumy').'" value="" class="form-control">
                       </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                          <label for="subject" id="subjectlabel">'.get_string('subject', 'theme_edumy').'</label>
                          <input id="subject" name="subject" type="text" title="'.get_string('subject_requirements', 'theme_edumy').'" required="required" class="form-control">
                       </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                          <label for="message" id="messagelabel">'.get_string('message', 'theme_edumy').'</label>
                          <textarea id="message" name="message" rows="5" title="'.get_string('message_requirements', 'theme_edumy').'" required="required" class="form-control"></textarea>
                          <input type="hidden" id="sesskey" name="sesskey" value="">
                          <script>document.getElementById(\'sesskey\').value = M.cfg.sesskey;</script>';
                          if($this->config->recaptcha == 0) {
                            if (!isloggedin() || isguestuser()) {
                              $this->content->text .= $this->getrecaptcha();
                            }
                          } elseif($this->config->recaptcha == 1) {
                            $this->content->text .= $this->getrecaptcha();
                          }
                        $this->content->text .='
                        </div>
                        <div class="form-group ui_kit_button mb0">
                          <button type="submit" name="submit" id="submit" class="btn dbxshad btn-lg btn-thm circle white">'.get_string('send', 'theme_edumy').'</button>
                        </div>
                     <div>
                   </div>
                </form>
      				</div>
      			</div>
      		</div>
      	</section>
        <script>
        document.addEventListener(\'DOMContentLoaded\', function() {
        (function($){
        var MY_MAPTYPE_ID = \'style_KINESB\';

        function initialize() {
          var featureOpts = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#666666"
                    }
                ]
            },
            {
            "featureType": \'all\',
            "elementType": \'labels\',
            "stylers": [
                    { visibility: \'simplified\' }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#e2e2e2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#aadaff"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
          var myGent = new google.maps.LatLng('.$this->content->map_lat.','.$this->content->map_lng.');
          var Kine = new google.maps.LatLng('.$this->content->map_lat.','.$this->content->map_lng.');
          var mapOptions = {
            zoom: '.$this->content->zoom.',
            mapTypeControl: true,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_TOP,
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
            },
            mapTypeId: '.$map_style.',
            scaleControl: false,
            streetViewControl: false,
            center: myGent
          }
          var map = new google.maps.Map(document.getElementById(\'map-canvas\'), mapOptions);
          var styledMapOptions = {
            name: \'style_KINESB\'
          };

        var image = \''.$map_marker_img.'\';
          var marker = new google.maps.Marker({
              position: Kine,
              map: map,
        animation: google.maps.Animation.DROP,
              title: \' '.$this->content->map_address.'  \',
        icon: image
          });

          var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
          map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

        }
        google.maps.event.addDomListener(window, \'load\', initialize);
      }(jQuery));
      }, false);
        </script>';
        return $this->content;
    }

    function instance_config_save($data, $nolongerused = false) {
        global $CFG;

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= 2; $i++) {
            $field = 'image' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_contact_form', 'images', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }




     function getrecaptcha() {
       global $CFG;
           // Is Moodle reCAPTCHA configured?
           if (!empty($CFG->recaptchaprivatekey) && !empty($CFG->recaptchapublickey)) {
               // Yes? Generate reCAPTCHA.
               if (file_exists($CFG->libdir . '/recaptchalib_v2.php')) {
                   // For reCAPTCHA 2.0.
                   require_once($CFG->libdir . '/recaptchalib_v2.php');
                   return '<div class="ccn_recaptcha_container">'. recaptcha_get_challenge_html(RECAPTCHA_API_URL, $CFG->recaptchapublickey).'</div>';
               } else {
                   // For reCAPTCHA 1.0.
                   require_once($CFG->libdir . '/recaptchalib.php');
                   return recaptcha_get_html($CFG->recaptchapublickey, null, $this->ishttps());
               }
           } else { // If debugging is set to DEVELOPER...
               // Show indicator that {reCAPTCHA} tag is not required.
               return '<a class="mt40 mb20 btn btn-danger" href="'.$CFG->wwwroot.'/admin/settings.php?section=manageauths"><i class="fa fa-warning"></i> Configure reCAPTCHA keys</a>';
           }
       // Logged-in as non-guest user (reCAPTCHA is not required) or Moodle reCAPTCHA not configured.
       // Don't generate reCAPTCHA.
       return '';
    }

    /**
     * Allow multiple instances in a single course?
     *
     * @return bool True if multiple instances are allowed, false otherwise.
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
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

}
