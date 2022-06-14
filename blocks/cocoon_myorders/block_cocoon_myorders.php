<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

include_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

class block_cocoon_myorders extends block_list {
    function init() {
        $this->title = get_string('pluginname', 'block_cocoon_myorders');
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        $ccnBlockHandler = new ccnBlockHandler();
        return $ccnBlockHandler->ccnGetBlockApplicability(array('my'));
    }

    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT, $COURSE, $SITE, $PAGE;


        if($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new \stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;} else {$this->content->title = $this->title;}
        // if(!empty($this->config->address_line_1)){$this->content->address_line_1 = $this->config->address_line_1;}
        // if(!empty($this->config->address_line_2)){$this->content->address_line_2 = $this->config->address_line_2;}
        // if(!empty($this->config->address_line_3)){$this->content->address_line_3 = $this->config->address_line_3;}
        // if(!empty($this->config->zip_code)){$this->content->zip_code = $this->config->zip_code;}
        // if(!empty($this->config->phone)){$this->content->phone = $this->config->phone;}
        // if(!empty($this->config->email)){$this->content->email = $this->config->email;}


        if(!empty($PAGE->theme->settings->order_receipt_address_line_1)){ $ccnAddressLine1 = $PAGE->theme->settings->order_receipt_address_line_1; } else { $ccnAddressLine1 = ''; }
        if(!empty($PAGE->theme->settings->order_receipt_address_line_2)){ $ccnAddressLine2 = $PAGE->theme->settings->order_receipt_address_line_2; } else { $ccnAddressLine2 = ''; }
        if(!empty($PAGE->theme->settings->order_receipt_address_line_3)){ $ccnAddressLine3 = $PAGE->theme->settings->order_receipt_address_line_3; } else { $ccnAddressLine3 = ''; }
        if(!empty($PAGE->theme->settings->order_receipt_zip)){ $ccnAddressZip = $PAGE->theme->settings->order_receipt_zip; } else { $ccnAddressZip = ''; }
        if(!empty($PAGE->theme->settings->order_receipt_phone)){ $ccnAddressPhone = $PAGE->theme->settings->order_receipt_phone; } else { $ccnAddressPhone = ''; }
        if(!empty($PAGE->theme->settings->order_receipt_email)){ $ccnAddressEmail = $PAGE->theme->settings->order_receipt_email; } else { $ccnAddressEmail = ''; }

        $order = '';
        $payment = '';
        $ccn_sum = 0;
        $ccn_courses_i = 0;
        if(isloggedin() and !isguestuser()){
            $courses = enrol_get_all_users_courses($USER->id, true);

            foreach ($courses as $course) {

              $ccnCourseHandler = new ccnCourseHandler();
              $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);



              $course = new core_course_list_element($course);
              $coursecontext = context_course::instance($course->id);
              $enrolinstances = enrol_get_instances($course->id, true);
              $ccnmethods = array_column($enrolinstances, null, "enrol");

              //PayPal
              if(array_key_exists('paypal', $ccnmethods)){
                $ccnpp = $ccnmethods['paypal'];
                if($ccnpp){
                  $ccn_enrolment_method = $ccnpp->enrol;
                  $cost = $ccnpp->cost;
                  $currency = $ccnpp->currency;
                  $enrol = $ccnpp->enrol;
                }
              }
              //Stripe
              if(array_key_exists('stripepayment', $ccnmethods)){
                $ccnstripe = $ccnmethods['stripepayment'];
                if($ccnstripe){
                  $cost_stripe = $ccnstripe->cost;
                  $currency_stripe = $ccnstripe->currency;
                  $enrol_stripe = $ccnstripe->enrol;
                }
              }

              // $enrolment_link = $CFG->wwwroot . '/enrol/index.php?id=' . $course->id;
              // $ccn_course_id = $course->id;
              // $ccn_course_title = $course->fullname;
              // $ccn_course_start_date = $course->startdate;
              // $ccn_course_link = $CFG->wwwroot . '/course/view.php?id=' . $course->id;
              $ccn_receipt_id = 'receiptID-' . $course->id;
              $ccn_site_name = $SITE->fullname;
              $ccn_site_url = $CFG->wwwroot;
              $ccn_customer_id = strtoupper(trim($SITE->fullname . $USER->id));
              $ccn_customer_username = $USER->username;
              $ccn_customer_email = $USER->email;

              $ccn_sum+= $cost;
              $ccn_courses_i++;

              // $contentimages = $contentfiles = '';
              // foreach ($course->get_course_overviewfiles() as $file) {
              //   $isimage = $file->is_valid_image();
              //   $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php",
              //     '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
              //     $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
              //   if ($isimage) {
              //     $contentimages .= $url;
              //   } else {
              //     $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
              //     $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
              //         html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
              //     $contentfiles .= html_writer::tag('span',
              //         html_writer::link($url, $filename),
              //         array('class' => 'coursefile fp-filename-icon'));
              //   }
              // }


              $order .= '
              <tr>
					    	<th scope="row">
					    		<ul class="cart_list">
					    			<li class="list-inline-item pr20"><a href="'.$ccnCourse->url.'"><img src="'.$ccnCourse->imageUrl.'" alt="'.$ccnCourse->fullName.'"></a></li>
					    			<li class="list-inline-item"><a class="cart_title" href="'.$ccnCourse->url.'">'.$ccnCourse->fullName.'</a></li>
					    		</ul>
					    	</th>
					    	<td>'.userdate($ccnCourse->startDate, get_string('strftimedatefullshort', 'langconfig'), 0).'</td>
					    	<td>'.get_string('completed', 'theme_edumy').'</td>
					    	<td class="cart_total">'. $ccnCourse->price .'</td>
					    	<td class="text-thm tdu"><a data-ccn-receipt-id="'.$ccn_receipt_id.'" href="#'.$ccn_receipt_id.'" class="ccn_receipt_handler">'.get_string('receipt', 'theme_edumy').'</a></td>
                <td id="'.$ccn_receipt_id.'" style="display:none;">
                  <style>
                    @import url(https://fonts.googleapis.com/css?family=Nunito:400,500,600,700|Open+Sans);
                    .ccnReceiptWrapper * {font-family: "Nunito", Arial, Helvetica, sans-serif;}
                    .ccnReceiptWrapper {padding: 15px 40px;}
                    .ccnReceiptWrapper table, .ccnReceiptWrapper th, .ccnReceiptWrapper td {padding: 6px 10px;border:1px solid #ddd;}
                    .ccnReceiptWrapper table {margin: 20px 0;}
                    .ccnReceiptWrapper .receiptProvider {line-height: 1.3;font-size: 12px;}
                    .ccnReceiptWrapper .receiptProviderName {font-weight: bold;font-size: 15px;}
                    .ccnReceiptWrapper .receiptProviderAddress, .ccnReceiptWrapper .receiptProviderDetails {line-height: 1.3;font-size: 12px;padding: 10px 0 0 0;border-top: 1px solid #ddd;margin: 10px 0 0 0;}
                  </style>
                  <div class="ccnReceiptWrapper" style="font-family: Arial, Helvetica, sans-serif;">
                    <h1>'.$ccn_site_name.'</h1>
                    <h2>'.get_string('your_order', 'theme_edumy').'</h2>
                    <table style="border-collapse:collapse; border: 1px solid #ddd;">
                      <tr>
                        <th style="border: 1px solid #ddd;padding: 6px 10px;">'.$ccnCourse->fullName.'</th>
                        <td style="border: 1px solid #ddd;padding: 6px 10px;">'. $ccnCourse->price .'</td>
                        <td style="text-transform:capitalize;border: 1px solid #ddd;padding: 6px 10px;">'.get_string('payment_method', 'theme_edumy') .' '. $ccn_enrolment_method .'</td>
                      </tr>
                    </table>
                    <div class="receiptProvider">
                    <div class="receiptProviderName">'.$ccn_site_name.'</div>
                    <div class="receiptProviderAddress">
                      '.$ccnAddressLine1.'<br>
                      '.$ccnAddressLine2.'<br>
                      '.$ccnAddressLine3.'<br>
                      '.$ccnAddressZip.'<br>
                    </div>
                    <div class="receiptProviderDetails">
                      '.$ccnAddressPhone.'<br>
                      '.$ccnAddressEmail.'<br>
                    </div>
                    </div>
                  </div>
                </td>
					    </tr>';

              $payment .= '<tr>
					    	<th scope="row">
					    		<ul class="cart_list">
					    			<li class="list-inline-item"><a class="cart_title" href="'.$ccnCourse->url.'">'.$ccnCourse->fullName.'</a></li>
					    		</ul>
					    	</th>
					    	<td>'.userdate($ccnCourse->startDate, get_string('strftimedatefullshort', 'langconfig'), 0).'</td>
					    	<td>'.$ccnCourse->courseId.'</td>
                <td></td>
					    	<td class="cart_total">'. $ccnCourse->price .'</td>
					    	<td class="">'. $ccnCourse->price .'</td>
					    </tr>';
            }
          }
        $this->content->footer = '
          <div class="my_course_content_container mb30">
						<div class="my_setting_content">
							<div class="my_setting_content_header">
								<div class="my_sch_title">
									<h4 class="m0">'.$this->content->title.'</h4>
								</div>
							</div>
							<div class="my_setting_content_details pb0">
								<div class="cart_page_form style2">
									<form action="#">
										<table class="table table-responsive">
										  	<thead>
											    <tr class="carttable_row">
											    	<th class="cartm_title">'.get_string('item', 'theme_edumy').'</th>
											    	<th class="cartm_title">'.get_string('date', 'theme_edumy').'</th>
											    	<th class="cartm_title">'.get_string('status', 'theme_edumy').'</th>
											    	<th class="cartm_title">'.get_string('total', 'theme_edumy').'</th>
											    	<th class="cartm_title">'.get_string('action', 'theme_edumy').'</th>
											    </tr>
										  	</thead>
										  	<tbody class="table_body">
                        '.$order.'
										  	</tbody>
										</table>
									</form>
								</div>
							</div>
							<div class="my_setting_content_header pt0">
								<div class="my_sch_title">
									<h4 class="m0">Order Details</h4>
								</div>
							</div>
							<div class="my_setting_content_details">
								<ul class="order_key_status mb0">
									<li>'.get_string('customer_id', 'theme_edumy').' <span>'.$ccn_customer_id.'</span></li>
									<li>'.get_string('customer_username', 'theme_edumy').' <span>'.$ccn_customer_username.'</span></li>
                  <li>'.get_string('customer_email', 'theme_edumy').' <span>'.$ccn_customer_email.'</span></li>
								</ul>
							</div>
							<div class="my_setting_content_details">
								<div class="cart_page_form style3">
									<form action="#">
										<table class="table table-responsive">
										  	<thead>
											    <tr class="carttable_row">
											    	<th class="cartm_title">'.get_string('item', 'theme_edumy').'</th>
											    	<th class="cartm_title">'.get_string('date', 'theme_edumy').'</th>
											    	<th class="cartm_title">'.get_string('course_id', 'theme_edumy').'</th>
                            <th class="cartm_title"></th>
											    	<th class="cartm_title">'.get_string('price', 'theme_edumy').'</th>
											    	<th class="cartm_title">'.get_string('total', 'theme_edumy').'</th>
											    </tr>
										  	</thead>
										  	<tbody class="table_body">
											    '.$payment.'
											    <tr class="borderless_table_row">
											    	<th scope="row"></th>
											    	<td></td>
                            <td></td>
											    	<td></td>
											    	<td class="cart_total color-dark fz18 pb10">'.get_string('total_courses', 'theme_edumy').'</td>
											    	<td class="color-gray2 fz15 pb10">'.$ccn_courses_i.'</td>
											    </tr>
											    <tr class="borderless_table_row style2">
											    	<th scope="row"></th>
											    	<td></td>
                            <td></td>
											    	<td></td>
											    	<td class="cart_total color-dark fz18 pt10">'.get_string('total', 'theme_edumy').'</td>
											    	<td class="color-gray2 fz15 pt10">'. get_string('currency_symbol', 'theme_edumy') . $ccn_sum . get_string('currency', 'theme_edumy') .'</td>
											    </tr>
										  	</tbody>
										</table>
									</form>
								</div>
							</div>
						</div>
					</div>';
        return $this->content;
    }

    /**
     * Returns the role that best describes the course list block.
     *
     * @return string
     */
    public function get_aria_role() {
        return 'navigation';
    }

    public function html_attributes() {
      global $CFG;
      $attributes = parent::html_attributes();
      include($CFG->dirroot . '/theme/edumy/ccn/block_handler/attributes.php');
      return $attributes;
    }
}
