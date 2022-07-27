<?php
global $CFG;
require_once($CFG->dirroot. '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
class block_cocoon_price_tables_dark extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('pluginname', 'block_cocoon_price_tables_dark');
    }

    // Declare second
    public function specialization()
    {
        // $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
        global $CFG, $DB;
        include($CFG->dirroot . '/theme/edumy/ccn/block_handler/specialization.php');
        if (empty($this->config)) {
          $this->config = new \stdClass();
          $this->config->slidesnumber = '3';
          $this->config->title = 'Choose a Package';
          $this->config->subtitle = 'Cum doctus civibus efficiantur in imperdiet deterruisset.';
          $this->config->title1 = 'Basic';
          $this->config->title2 = 'Basic';
          $this->config->title3 = 'Basic';
          $this->config->subtitle1 = 'One Time Fee for one listing, highlighted in the search results.';
          $this->config->subtitle2 = 'One Time Fee for one listing, highlighted in the search results.';
          $this->config->subtitle3 = 'One Time Fee for one listing, highlighted in the search results.';
          $this->config->featured_text1 = '';
          $this->config->featured_text2 = 'Most Popular';
          $this->config->featured_text3 = '';
          $this->config->price1 = '$4.95';
          $this->config->price2 = '$11.95';
          $this->config->price3 = '$17.95';
          $this->config->button_text1 = 'Get Started';
          $this->config->button_text2 = 'Get Started';
          $this->config->button_text3 = 'Get Started';
          $this->config->button_link1 = '#';
          $this->config->button_link2 = '#';
          $this->config->button_link3 = '#';
          $this->config->features1 = 'One Course
Unlimited Availability
Certification 100% Approval
24/7 Support';
          $this->config->features2 = 'One Course
Unlimited Availability
Certification 100% Approval
24/7 Support';
          $this->config->features3 = 'One Course
Unlimited Availability
Certification 100% Approval
24/7 Support';

          $this->config->color_bg = 'rgb(0, 8, 70)';
          $this->config->color_title = 'rgb(255,255,255)';
          $this->config->color_subtitle = 'rgb(255,255,255)';
          $this->config->c_ccn_it = 'rgb(255,255,255)';
          $this->config->c_ccn_ib = 'rgba(255, 255, 255, .6)';
          $this->config->c_ccn_ic = 'rgb(22, 32, 90)';
          $this->config->c_ccn_ibt = 'rgb(255, 234, 193)';



        }
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new \stdClass();
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if(!empty($this->config->color_bg)){$this->content->color_bg = $this->config->color_bg;} else {$this->content->color_bg = 'rgb(0, 8, 70)';}
        if(!empty($this->config->color_title)){$this->content->color_title = $this->config->color_title;} else {$this->content->color_title = 'rgb(255,255,255)';}
        if(!empty($this->config->color_subtitle)){$this->content->color_subtitle = $this->config->color_subtitle;} else {$this->content->color_subtitle = 'rgb(255,255,255)';}
        if(!empty($this->config->c_ccn_ic)){$this->content->c_ccn_ic = $this->config->c_ccn_ic;} else {$this->content->c_ccn_ic = 'rgb(22, 32, 90)';}
        if(!empty($this->config->c_ccn_it)){$this->content->c_ccn_it = $this->config->c_ccn_it;} else {$this->content->c_ccn_it = 'rgb(255,255,255)';}
        if(!empty($this->config->c_ccn_ib)){$this->content->c_ccn_ib = $this->config->c_ccn_ib;} else {$this->content->c_ccn_ib = 'rgba(255, 255, 255, .6)';}

        if(!empty($this->config->c_ccn_ibt)){$this->content->c_ccn_ibt = $this->config->c_ccn_ibt;} else {$this->content->c_ccn_ibt = 'rgb(255, 234, 193)';}



        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 3;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 3;
        }




        $this->content->text = '
        <section class="pricing-section" data-ccn-c="color_bg" data-ccn-co="bg" data-ccn-cv="'.$this->content->color_bg.'">
      		<div class="container">
      			<div class="row">
      				<div class="col-lg-6 offset-lg-3">
      					<div class="main-title text-center">
      						<h3 class="mt0" data-ccn="title" data-ccn-c="color_title" data-ccn-cv="'.$this->content->color_title.'">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
      						<p class="" data-ccn="subtitle" data-ccn-c="color_subtitle" data-ccn-cv="'.$this->content->color_subtitle.'">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
      					</div>
      				</div>
      			</div>
      			<div class="row">
            <div class="col-xs-12 col-xl-10 offset-xl-1">
            <div class="row">';

            if ($data->slidesnumber > 0) {

              for ($i = 1; $i <= $data->slidesnumber; $i++) {
                  $title = 'title' . $i;
                  $subtitle = 'subtitle' . $i;
                  $featured_text = 'featured_text' . $i;
                  $price = 'price' . $i;
                  $body = 'body' . $i;
                  $button_text = 'button_text' . $i;
                  $button_link = 'button_link' . $i;
                  $features = 'features' . $i;
                  if(!empty($data->$featured_text)) {
                    $class = 'tagged';
                    // $btn_class = 'btn-style-two';
                  } else {
                    $class = '';
                    // $btn_class = 'btn-style-three';
                  }
$this->content->text .= '

<div class="pricing-table '.$class.' col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-box" data-ccn-c="c_ccn_ic" data-ccn-co="bg" data-ccn-cv="'.$this->content->c_ccn_ic.'">
                        <div class="title-box">
                          <span class="status ccn-ctl-emp" data-ccn="featured_text'.$i.'">'.format_text($data->$featured_text, FORMAT_HTML, array('filter' => true)).'</span>
                            <span data-ccn-c="c_ccn_it" data-ccn-cv="'.$this->content->c_ccn_it.'" class="title" data-ccn="title'.$i.'">'.format_text($data->$title, FORMAT_HTML, array('filter' => true)).'</span>
                            <h3 data-ccn-c="c_ccn_it" data-ccn-cv="'.$this->content->c_ccn_it.'" class="price" data-ccn="price'.$i.'">'.format_text($data->$price, FORMAT_HTML, array('filter' => true)).'</h3>
                            <div data-ccn-c="c_ccn_ib" data-ccn-cv="'.$this->content->c_ccn_ib.'" class="text" data-ccn="subtitle'.$i.'">'.format_text($data->$subtitle, FORMAT_HTML, array('filter' => true)).'</div>
                        </div>
                        <div class="table-content">
                            <ul>
                                <li><span class="ccn-pre-line" data-ccn-c="c_ccn_ib" data-ccn-cv="'.$this->content->c_ccn_ib.'" data-ccn="features'.$i.'">'.format_text($data->$features, FORMAT_HTML, array('filter' => true)).'</span></li>
                            </ul>
                        </div>
                        <div class="table-footer">
                            <a data-ccn="button_text'.$i.'" href="'.format_text($data->$button_link, FORMAT_HTML, array('filter' => true)).'" class="theme-btn '.$btn_class.'" data-ccn-c="c_ccn_ibt" data-ccn-c-cv="'.$this->content->c_ccn_ibt.'">'.format_text($data->$button_text, FORMAT_HTML, array('filter' => true)).' <span class="flaticon-right-arrow-1"></span></a>
                        </div>
                    </div>
                </div>';

                }
}
$this->content->text .='
  </div></div>
      			</div>
      		</div>
      	</section>
';
        return $this->content;
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
