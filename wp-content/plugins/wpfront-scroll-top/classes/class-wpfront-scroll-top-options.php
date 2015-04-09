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

require_once("base/class-wpfront-options-base.php");

if (!class_exists('WPFront_Scroll_Top_Options')) {

    /**
     * Options class for WPFront Scroll Top plugin
     *
     * @author Syam Mohan <syam@wpfront.com>
     * @copyright 2013 WPFront.com
     */
    class WPFront_Scroll_Top_Options extends WPFront_Options_Base {

        function __construct($optionName, $pluginSlug) {
            parent::__construct($optionName, $pluginSlug);

            //add the options required for this plugin
            $this->addOption('enabled', 'bit', FALSE)->__('Enabled');
            $this->addOption('scroll_offset', 'int', 100, array($this, 'validate_zero_positive'))->__('Scroll Offset');
            $this->addOption('button_width', 'int', 0, array($this, 'validate_zero_positive'));
            $this->addOption('button_height', 'int', 0, array($this, 'validate_zero_positive'));
            $this->addOption('button_opacity', 'int', 80, array($this, 'validate_range_0_100'))->__('Button Opacity');
            $this->addOption('button_fade_duration', 'int', 200, array($this, 'validate_zero_positive'))->__('Button Fade Duration');
            $this->addOption('scroll_duration', 'int', 400, array($this, 'validate_zero_positive'))->__('Scroll Duration');
            $this->addOption('auto_hide', 'bit', FALSE)->__('Auto Hide');
            $this->addOption('auto_hide_after', 'float', 2, array($this, 'validate_zero_positive'))->__('Auto Hide After');
            $this->addOption('hide_small_device', 'bit', FALSE)->__('Hide on Small Devices');
            $this->addOption('small_device_width', 'int', 640, array($this, 'validate_zero_positive'))->__('Small Device Max Width');
            $this->addOption('hide_small_window', 'bit', FALSE)->__('Hide on Small Window');
            $this->addOption('small_window_width', 'int', 640, array($this, 'validate_zero_positive'))->__('Small Window Max Width');
            $this->addOption('button_style', 'string', 'image', array($this, 'validate_button_style'))->__('Button Style');
            $this->addOption('image_alt', 'string', '')->__('Image ALT');
            $this->addOption('hide_wpadmin', 'bit', FALSE)->__('Hide on WP-ADMIN');
            $this->addOption('hide_iframe', 'bit', FALSE)->__('Hide on iframes');

            $this->addOption('location', 'int', 1, array($this, 'validate_range_1_4'))->__('Location');
            $this->addOption('marginX', 'int', 20)->__('Margin X');
            $this->addOption('marginY', 'int', 20)->__('Margin Y');

            $this->addOption('text_button_text', 'string', '')->__('Text');
            $this->addOption('text_button_text_color', 'string', '#ffffff', array($this, 'validate_color'))->__('Text Color');
            $this->addOption('text_button_background_color', 'string', '#000000', array($this, 'validate_color'))->__('Background Color');
            $this->addOption('text_button_css', 'string', '')->__('Custom CSS');

            $this->addOption('display_pages', 'int', '1', array($this, 'validate_display_pages'))->__('Display on Pages');
            $this->addOption('include_pages', 'string', '');
            $this->addOption('exclude_pages', 'string', '');

            $this->addOption('image', 'string', '1.png');
            $this->addOption('custom_url', 'string', '');
        }

        protected function validate_range_0_100($arg) {
            if ($arg < 0)
                return 0;

            if ($arg > 100)
                return 100;

            return $arg;
        }

        protected function validate_range_1_4($arg) {
            if ($arg < 1)
                return 1;

            if ($arg > 4)
                return 4;

            return $arg;
        }

        protected function validate_button_style($arg) {
            if ($arg == 'text')
                return $arg;

            return 'image';
        }

        protected function validate_color($arg) {
            if (strlen($arg) != 7)
                return '#ffffff';

            if (strpos($arg, '#') != 0)
                return '#ffffff';

            return $arg;
        }

        protected function validate_display_pages($arg) {
            if ($arg < 1) {
                return 1;
            }

            if ($arg > 3) {
                return 3;
            }

            return $arg;
        }

    }

}