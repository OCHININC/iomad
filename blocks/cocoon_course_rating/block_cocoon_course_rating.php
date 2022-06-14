<?php
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_course_rating extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_course_rating');
    }

    public function applicable_formats() {
      $ccnBlockHandler = new ccnBlockHandler();
      return $ccnBlockHandler->ccnGetBlockApplicability(array('course-view'));
    }

    function specialization() {
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->title = 'Students feedback';
        }
    }

    function instance_allow_multiple() {
        return false;
    }

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }

    public function has_config() {
        return true;
    }

    public function get_content() {
        global $CFG, $COURSE;

        if ($this->content !== null) {
            // return $this->content;
        }

        $this->content = new stdClass;

        if(!empty($this->config->title)){$this->content->title =  format_text($this->config->title, FORMAT_HTML, array('filter' => true));} else {$this->content->title = get_string('pluginname', 'block_cocoon_course_rating');}

        $courseid = $COURSE->id;
        $context = get_context_instance(CONTEXT_COURSE, $courseid);

        $canRate = has_capability('block/cocoon_course_rating:rate', $context);
        if($canRate == 1) {
          $canRateClass = 'ccn-can-rate';
        } else {
          $canRateClass = 'ccn-cannot-rate';
        }

        $ccnSubmitRating = $this->submit_rating();
        $this->content->text = '';

        $ccnRating    = number_format($this->overall_rating($COURSE->id), 1);

        $ccnStar      = '<li class="list-inline-item"><i class="fa fa-star"></i></li>';
        $ccnStarHalf  = '<li class="list-inline-item"><i class="fa fa-star-half-o"></i></li>';
        $ccnStarVoid  = '<li class="list-inline-item"><i class="fa fa-star-o"></i></li>';

        if($ccnRating == 5) {
          $ccnStars = str_repeat($ccnStar, 5);
        } elseif($ccnRating == 4.5) {
          $ccnStars = str_repeat($ccnStar, 4) . str_repeat($ccnStarHalf, 1);
        } elseif($ccnRating == 4) {
          $ccnStars = str_repeat($ccnStar, 4) . str_repeat($ccnStarVoid, 1);
        } elseif($ccnRating == 3.5) {
          $ccnStars = str_repeat($ccnStar, 3) . str_repeat($ccnStarHalf, 1) . str_repeat($ccnStarVoid, 1);
        } elseif($ccnRating == 3) {
          $ccnStars = str_repeat($ccnStar, 3) . str_repeat($ccnStarVoid, 2);
        } elseif($ccnRating == 2.5) {
          $ccnStars = str_repeat($ccnStar, 2) . str_repeat($ccnStarHalf, 1)  . str_repeat($ccnStarVoid, 2);
        } elseif($ccnRating == 2) {
          $ccnStars = str_repeat($ccnStar, 2) . str_repeat($ccnStarVoid, 3);
        } elseif($ccnRating == 1.5) {
          $ccnStars = str_repeat($ccnStar, 1) . str_repeat($ccnStarHalf, 1)  . str_repeat($ccnStarVoid, 3);
        } elseif($ccnRating == 0.5) {
          $ccnStars = str_repeat($ccnStarHalf, 1) . str_repeat($ccnStarVoid, 4);
        } else {
          $ccnStars = str_repeat($ccnStarVoid, 5);
        }

        $ccnFive = $this->get_specific_average($COURSE->id, 5);
        $ccnFour = $this->get_specific_average($COURSE->id, 4);
        $ccnThree = $this->get_specific_average($COURSE->id, 3);
        $ccnTwo = $this->get_specific_average($COURSE->id, 2);
        $ccnOne = $this->get_specific_average($COURSE->id, 1);

        $this->content->text .= '
        	<div class="cs_row_five">
									<div class="student_feedback_container">
										<h4 data-ccn="title" class="aii_title">'.$this->content->title.'</h4>
										<div class="s_feeback_content">
									        <ul class="skills">
									        	<li class="list-inline-item">'.get_string('stars_5', 'theme_edumy').'</li>
									            <li class="list-inline-item progressbar1" data-width="'.$ccnFive.'" data-target="100">'.$ccnFive.'%</li>
									        </ul>
									        <ul class="skills">
									        	<li class="list-inline-item">'.get_string('stars_4', 'theme_edumy').'</li>
									            <li class="list-inline-item progressbar2" data-width="'.$ccnFour.'" data-target="100">'.$ccnFour.'%</li>
									        </ul>
									        <ul class="skills">
									        	<li class="list-inline-item">'.get_string('stars_3', 'theme_edumy').'</li>
									            <li class="list-inline-item progressbar3" data-width="'.$ccnThree.'" data-target="100">'.$ccnThree.'%</li>
									        </ul>
									        <ul class="skills">
									        	<li class="list-inline-item">'.get_string('stars_2', 'theme_edumy').'</li>
									            <li class="list-inline-item progressbar4" data-width="'.$ccnTwo.'" data-target="100">'.$ccnTwo.'%</li>
									        </ul>
									        <ul class="skills">
									        	<li class="list-inline-item">'.get_string('stars_1', 'theme_edumy').'</li>
									            <li class="list-inline-item progressbar5" data-width="'.$ccnOne.'" data-target="100">'.$ccnOne.'%</li>
									        </ul>
										</div>
										<div class="aii_average_review text-center '.$canRateClass.'">
											<div class="av_content">
												<h2>'.$ccnRating.'</h2>
												<ul class="aii_rive_list mb0">
													'.$ccnStars.'
												</ul>
												<p>'.$this->count_ratings($COURSE->id).'</p>';
                        if($canRate == 1){
                          $this->content->text .= $ccnSubmitRating;
                        }
                      $this->content->text .='
											</div>
										</div>
									</div>
								</div>';
        return $this->content;

    }

    public function overall_rating($courseID) {
        global $CFG, $DB;
        $sql = "  SELECT AVG(rating) AS average
                  FROM {theme_edumy_courserate}
                  WHERE course = $courseID
               ";
        $totalAverage = -1;
        if ($getAverage = $DB->get_record_sql($sql)) {
            $totalAverage = round($getAverage->average * 2) / 2;
        }
        return $totalAverage;
    }

    public function count_ratings($courseID) {
        global $CFG, $DB;
        $countRecords = $DB->count_records('theme_edumy_courserate', array('course'=>$courseID));
        $countRatings = '';
        if ($countRecords > 0) {
            $countRatings = get_string ('rated_by', 'theme_edumy', $countRecords);
        } else {
            $countRatings = get_string ('rated_by_none', 'theme_edumy');
        }
        return $countRatings;
    }
    public function count_ratings_external($courseID) {
        global $CFG, $DB;
        $countRecords = $DB->count_records('theme_edumy_courserate', array('course'=>$courseID));
        return $countRecords;
    }

    public function get_specific_average($courseID, $rating) {
        global $CFG, $DB;
        $countOnlyRating        = $DB->count_records('theme_edumy_courserate', array('course'=>$courseID, 'rating'=>$rating));
        $countExcludingRating   = $DB->count_records_sql(
        "       SELECT COUNT(*)
                FROM {theme_edumy_courserate}
                WHERE course = $courseID
                AND rating <> $rating
        ");

        $countTotal             = $DB->count_records('theme_edumy_courserate', array('course'=>$courseID));

        if($countTotal == 0) {
          $result = '0';
        } else {
          $result = $countOnlyRating / $countTotal * 100;
        }
        return $result;

    }

    public function submit_rating() {

      global $CFG, $COURSE;

      $courseid = $COURSE->id;
      $context = get_context_instance(CONTEXT_COURSE, $courseid);

      $ccnStar =  '<span class="fa fa-star"></span>';
      $return =   '<form id="ccn-star-rate" method="post" action="'.$CFG->wwwroot.'/theme/edumy/ccn/form_handler/ccn_rate_course.php">
                    <input name="id" type="hidden" value="'.$courseid.'" />
                    <div class="ccn-star-rate-inner">';
                      for ($i = 5; $i >= 1; $i--) {
                        $printCcnStar = str_repeat($ccnStar, $i);
                        $return .='    <input required type="radio" id="stars-'.$i.'" name="rating" value="'.$i.'" /><label for="stars-'.$i.'"></label>';
                      }
      $return .= '  </div>
                    <button class="btn btn-primary" type="submit">'.get_string('rate_course', 'theme_edumy').'</button>
                  </form>';
      return $return;
    }

    public function external_star_rating($courseID) {

      $ccnStar      = '<li class="list-inline-item"><i class="fa fa-star"></i></li>';
      $ccnStarHalf  = '<li class="list-inline-item"><i class="fa fa-star-half-o"></i></li>';
      $ccnStarVoid  = '<li class="list-inline-item"><i class="fa fa-star-o"></i></li>';
      $ccnRating    = $this->overall_rating($courseID);

      if($ccnRating == 5) {
        $ccnStars = str_repeat($ccnStar, 5);
      } elseif($ccnRating == 4.5) {
        $ccnStars = str_repeat($ccnStar, 4) . str_repeat($ccnStarHalf, 1);
      } elseif($ccnRating == 4) {
        $ccnStars = str_repeat($ccnStar, 4) . str_repeat($ccnStarVoid, 1);
      } elseif($ccnRating == 3.5) {
        $ccnStars = str_repeat($ccnStar, 3) . str_repeat($ccnStarHalf, 1) . str_repeat($ccnStarVoid, 1);
      } elseif($ccnRating == 3) {
        $ccnStars = str_repeat($ccnStar, 3) . str_repeat($ccnStarVoid, 2);
      } elseif($ccnRating == 2.5) {
        $ccnStars = str_repeat($ccnStar, 2) . str_repeat($ccnStarHalf, 1)  . str_repeat($ccnStarVoid, 2);
      } elseif($ccnRating == 2) {
        $ccnStars = str_repeat($ccnStar, 2) . str_repeat($ccnStarVoid, 3);
      } elseif($ccnRating == 1.5) {
        $ccnStars = str_repeat($ccnStar, 1) . str_repeat($ccnStarHalf, 1)  . str_repeat($ccnStarVoid, 3);
      } elseif($ccnRating == 0.5) {
        $ccnStars = str_repeat($ccnStarHalf, 1) . str_repeat($ccnStarVoid, 4);
      } else {
        $ccnStars = str_repeat($ccnStarVoid, 5);
      }

      $return = '<div class="ccn-external-stars">'.$ccnStars.'<li class="list-inline-item"><span>('.$this->count_ratings_external($courseID).')</span></li></div>';
      return $return;

    }

}
