<?php

/*
  WPFront Scroll Top Plugin
  Copyright (C) 2013, WPFront.com
  Website: wpfront.com
  Contact: syam@wpfront.com

  WPFront Scroll Top Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

require_once("base/class-wpfront-base.php");
require_once("class-wpfront-scroll-top-options.php");

if (!class_exists('WPFront_Scroll_Top')) {

    /**
     * Main class of WPFront Scroll Top plugin
     *
     * @author Syam Mohan <syam@wpfront.com>
     * @copyright 2013 WPFront.com
     */
    class WPFront_Scroll_Top extends WPFront_Base {

        //Constants
        const VERSION = '1.4.2';
        const OPTIONS_GROUP_NAME = 'wpfront-scroll-top-options-group';
        const OPTION_NAME = 'wpfront-scroll-top-options';
        const PLUGIN_SLUG = 'wpfront-scroll-top';

        //Variables
        protected $iconsDIR;
        protected $iconsURL;
        protected $options;
        protected $markupLoaded;
        protected $scriptLoaded;

        function __construct() {
            parent::__construct(__FILE__, self::PLUGIN_SLUG);

            $this->markupLoaded = FALSE;

            //Root variables
            $this->iconsDIR = $this->pluginDIRRoot . 'images/icons/';
            $this->iconsURL = $this->pluginURLRoot . 'images/icons/';

            add_action('wp_footer', array(&$this, 'write_markup'));
            add_action('shutdown', array(&$this, 'shutdown_callback'));

            $this->add_menu($this->__('WPFront Scroll Top'), $this->__('Scroll Top'));
        }

        //add scripts
        public function enqueue_scripts() {
            if ($this->enabled() == FALSE)
                return;

            $jsRoot = $this->pluginURLRoot . 'js/';

            wp_enqueue_script('jquery');
            wp_enqueue_script('wpfront-scroll-top', $jsRoot . 'wpfront-scroll-top.js', array('jquery'), self::VERSION);

            $this->scriptLoaded = TRUE;
        }

        //add styles
        public function enqueue_styles() {
            if ($this->enabled() == FALSE)
                return;

            $cssRoot = $this->pluginURLRoot . 'css/';

            wp_enqueue_style('wpfront-scroll-top', $cssRoot . 'wpfront-scroll-top.css', array(), self::VERSION);
        }

        public function admin_init() {
            register_setting(self::OPTIONS_GROUP_NAME, self::OPTION_NAME);

            $this->enqueue_styles();
            $this->enqueue_scripts();
        }

        public function enqueue_options_scripts() {
            $this->enqueue_scripts();

            $jsRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/js/';
            wp_enqueue_script('jquery.eyecon.colorpicker', $jsRoot . 'colorpicker.js', array('jquery'), self::VERSION);
        }

        //options page styles
        public function enqueue_options_styles() {
            $styleRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/css/';
            wp_enqueue_style('jquery.eyecon.colorpicker.colorpicker', $styleRoot . 'colorpicker.css', array(), self::VERSION);

            $styleRoot = $this->pluginURLRoot . 'css/';
            wp_enqueue_style('wpfront-scroll-top-options', $styleRoot . 'options.css', array(), self::VERSION);
        }

        public function plugins_loaded() {
            //load plugin options
            $this->options = new WPFront_Scroll_Top_Options(self::OPTION_NAME, self::PLUGIN_SLUG);
        }

        public function shutdown_callback() {
            if ($this->markupLoaded) {
                return;
            }

            $headers = headers_list();
            $flag = FALSE;
            foreach ($headers as $value) {
                $value = strtolower(str_replace(' ', '', $value));
                if (strpos($value, 'content-type:text/html') === 0) {
                    $flag = TRUE;
                    break;
                }
            }

            if ($flag)
                $this->write_markup();
        }

        //writes the html and script for the button
        public function write_markup() {
            if ($this->markupLoaded) {
                return;
            }

            if ($this->scriptLoaded != TRUE) {
                return;
            }

            if (WPFront_Static::doing_ajax()) {
                return;
            }

            if ($this->enabled()) {
                include($this->pluginDIRRoot . 'templates/scroll-top-template.php');

                echo '<script type="text/javascript">';
                echo 'if(typeof wpfront_scroll_top == "function") ';
                echo 'wpfront_scroll_top(' . json_encode(array(
                    'scroll_offset' => $this->options->scroll_offset(),
                    'button_width' => $this->options->button_width(),
                    'button_height' => $this->options->button_height(),
                    'button_opacity' => $this->options->button_opacity() / 100,
                    'button_fade_duration' => $this->options->button_fade_duration(),
                    'scroll_duration' => $this->options->scroll_duration(),
                    'location' => $this->options->location(),
                    'marginX' => $this->options->marginX(),
                    'marginY' => $this->options->marginY(),
                    'hide_iframe' => $this->options->hide_iframe(),
                    'auto_hide' => $this->options->auto_hide(),
                    'auto_hide_after' => $this->options->auto_hide_after(),
                )) . ');';
                echo '</script>';
            }

            $this->markupLoaded = TRUE;
        }

        private function enabled() {
            if (!$this->options->enabled())
                return FALSE;

            if ($this->options->hide_wpadmin() && is_admin())
                return FALSE;

            if (!$this->filter_pages())
                return FALSE;

            return TRUE;
        }

        private function filter_pages() {
            if (is_admin())
                return TRUE;

            switch ($this->options->display_pages()) {
                case 1:
                    return TRUE;
                case 2:
                case 3:
                    global $post;
                    $ID = FALSE;
                    $type = FALSE;
                    if (is_home()) {
                        $ID = 'home';
                        $type = 1;
                    } elseif (is_singular()) {
                        $post_type = get_post_type();
                        if ($post_type == 'page') {
                            $ID = $post->ID;
                            $type = 1;
                        } elseif ($post_type == 'post') {
                            $ID = $post->ID;
                            $type = 2;
                        }
                    }
                    if ($this->options->display_pages() == 2) {
                        if ($ID !== FALSE && $type !== FALSE) {
                            if ($this->filter_pages_contains($this->options->include_pages(), $type . '.' . $ID) === FALSE)
                                return FALSE;
                            else
                                return TRUE;
                        }
                        return FALSE;
                    }
                    if ($this->options->display_pages() == 3) {
                        if ($ID !== FALSE && $type !== FALSE) {
                            if ($this->filter_pages_contains($this->options->exclude_pages(), $type . '.' . $ID) === FALSE)
                                return TRUE;
                            else
                                return FALSE;
                        }
                        return TRUE;
                    }
            }

            return TRUE;
        }

        public function filter_pages_contains($list, $key) {
            return strpos(',' . $list . ',', ',' . $key . ',');
        }

        private function image() {
            if ($this->options->image() == 'custom')
                return $this->options->custom_url();
            return $this->iconsURL . $this->options->image();
        }

        protected function get_filter_objects() {
            $objects = array();

            $objects['1.home'] = $this->__('[Page]') . ' ' . $this->__('Home');

            $pages = get_pages();
            foreach ($pages as $page) {
                $objects['1.' . $page->ID] = $this->__('[Page]') . ' ' . $page->post_title;
            }

            $posts = get_posts();
            foreach ($posts as $post) {
                $objects['2.' . $post->ID] = $this->__('[Post]') . ' ' . $post->post_title;
            }

//            $categories = get_categories();
//            foreach ($categories as $category) {
//                $objects['3.' . $category->cat_ID] = $this->__('[Category]') . ' ' . $category->cat_name;
//            }

            return $objects;
        }

    }

}