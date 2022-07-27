<?php
global $CFG;

require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_myviews extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_myviews', 'block_cocoon_myviews');
    }

    // Declare second
    public function specialization()
    {
      // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
      global $CFG;
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
    }

    function applicable_formats() {
        $ccnBlockHandler = new ccnBlockHandler();
        return $ccnBlockHandler->ccnGetBlockApplicability(array('my'));
    }

    public function get_content()
    {
      global $CFG, $USER, $DB, $SESSION, $SITE, $PAGE;

      $ccn_user_id = $USER->id;


      $table = 'theme_edumy_counter'; ///name of table
      $csx = $DB->get_records($table,array('course'=>$ccn_user_id),$fields='course,time');
      $ccnmethodsa = array_column($csx, null, "time");
      $visits = array_keys($ccnmethodsa);
      foreach ($visits as $visit) {
        $dates = date('m/d/Y', $visit);
        $cdates[] = array('date' => $dates);
      }
      // print_object(array_count_values(array_column($cdates, 'date')));

      $visitArray = array_count_values(array_column($cdates, 'date'));
      $visitArrayR = array_reverse($visitArray);

      // print_object($ccn_user_id);
      $day0 = userdate(strtotime("now"), '%d %B', 0);
      $value0 = array_values($visitArrayR)[0];
      $day1 = userdate(strtotime("-1 day"), '%d %B', 0);
      if(isset($visitArrayR[1])) {
        $value1 = array_values($visitArrayR)[1];
      } else {
        $value1 = '0';
      }
      $day2 = userdate(strtotime("-2 days"), '%d %B', 0);
      if(isset($visitArrayR[2])) {
        $value2 = array_values($visitArrayR)[2];
      } else {
        $value2 = '0';
      }
      $day3 = userdate(strtotime("-3 days"), '%d %B', 0);
      if(isset($visitArrayR[3])) {
        $value3 = array_values($visitArrayR)[3];
      } else {
        $value3 = '0';
      }
      $day4 = userdate(strtotime("-4 days"), '%d %B', 0);
      if(isset($visitArrayR[4])) {
        $value4 = array_values($visitArrayR)[4];
      } else {
        $value4 = '0';
      }
      $day5 = userdate(strtotime("-5 days"), '%d %B', 0);
      if(isset($visitArrayR[5])) {
        $value5 = array_values($visitArrayR)[5];
      } else {
        $value5 = '0';
      }
      $day6 = userdate(strtotime("-6 days"), '%d %B', 0);
      if(isset($visitArrayR[6])) {
        $value6 = array_values($visitArrayR)[6];
      } else {
        $value6 = '0';
      }








        if ($this->content !== null) {
            return $this->content;
        }

        $chartJs = $CFG->wwwroot.'/theme/edumy/javascript/chart.min.js';
        $chartJsInline = 'function createConfig() {
                              return {
                                  type: "line",
                                  data: {
                                      labels: ["'.$day6.'", "'.$day5.'", "'.$day4.'", "'.$day3.'", "'.$day2.'", "'.$day1.'", "'.$day0.'"],
                                      datasets: [{
                                          label: "'.get_string('your_profile_views_dataset', 'theme_edumy').'",
                                          borderColor: window.chartColors.red,
                                          backgroundColor: window.chartColors.red,
                                          data: ['.$value6.', '.$value5.', '.$value4.', '.$value3.', '.$value2.', '.$value1.', '.$value0.'],
                                          fill: false,
                                      }]
                                  },
                                  options: {
                                      responsive: true,
                                      title: {
                                          display: true,
                                          text: "'.get_string('your_profile_views_long', 'theme_edumy').'"
                                      },
                                      tooltips: {
                                          position: "nearest",
                                          mode: "index",
                                          intersect: false,
                                          yPadding: 10,
                                          xPadding: 10,
                                          caretSize: 8,
                                          backgroundColor: "rgba(72, 241, 12, 1)",
                                          titleFontColor: window.chartColors.black,
                                          bodyFontColor: window.chartColors.black,
                                          borderColor: "rgba(0,0,0,1)",
                                          borderWidth: 4
                                      },
                                  }
                              };
                          }
                          window.onload = function() {
                              var c_container = document.querySelector(".c_container");
                              var div = document.createElement("div");
                              div.classList.add("chart-container");

                              var canvas = document.createElement("canvas");
                              div.appendChild(canvas);
                              c_container.appendChild(div);

                              var ctx = canvas.getContext("2d");
                              var config = createConfig();
                              new Chart(ctx, config);
                          };';
        $this->content =  new stdClass;

          $this->content->text ='  							<div class="mb30 application_statics">
								<!--<h4>'.get_string('your_profile_views', 'theme_edumy').'</h4>-->
								<div class="c_container"></div>
							</div>
<script src="'.$chartJs.'"></script>
<script>'. $chartJsInline .'</script>
              ';
          return $this->content;

    }
}
