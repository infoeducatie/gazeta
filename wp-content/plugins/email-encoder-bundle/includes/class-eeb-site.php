<?php defined('ABSPATH') OR die('No direct access.');

/**
 * Class Eeb_Site (singleton)
 *
 * Contains all nescessary code for the site part
 *
 * @extends Eeb_Admin
 * @final
 *
 * @package Email_Encoder_Bundle
 * @category WordPress Plugins
 */
if (!class_exists('Eeb_Site') && class_exists('Eeb_Admin')):

final class Eeb_Site extends Eeb_Admin {

    /**
     * @var Eeb_Site  Singleton instance
     */
    static private $instance = null;

    /**
     * @var boolean
     */
    private $is_admin_user = false;

    /**
     * @var array  Regular expresssions
     */
    private $regexp_patterns = array(
        'mailto' => '/<a([^<>]*?)href=["\']mailto:(.*?)["\'](.*?)>(.*?)<\/a[\s+]*>/is',
        'email' => '/([A-Z0-9._-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z.]{2,6})/is',
        'input' => '/<input([^>]*)value=["\'][\s+]*([A-Z0-9._-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z.]{2,6})[\s+]*["\']([^>]*)>/is',
    );

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();
    }

    /**
     * Make private to prevent multiple objects
     */
    private function __clone() {}

    /**
     * Get singleton instance
     */
    static public function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Eeb_Site();
        }

        return self::$instance;
    }

    /**
     * wp action
     */
    public function wp() {
        $this->is_admin_user = current_user_can('manage_options');

        if (is_admin()) {
            return;
        }

        // apply filters
        $this->regexp_patterns['mailto'] = apply_filters('eeb_mailto_regexp', $this->regexp_patterns['mailto']);
        $this->regexp_patterns['email'] = apply_filters('eeb_email_regexp', $this->regexp_patterns['email']);

        if (is_feed()) {
        // rss feed
            $rss_filters = array('the_title', 'the_content', 'the_excerpt', 'the_title_rss', 'the_content_rss', 'the_excerpt_rss',
                                'comment_text_rss', 'comment_author_rss', 'the_category_rss', 'the_content_feed', 'author_feed_link', 'feed_link');

            foreach($rss_filters as $filter) {
                if ($this->options['remove_shortcodes_rss']) {
                    add_filter($filter, array($this, 'callback_rss_remove_shortcodes'), 9);
                }

                if ($this->options['filter_rss']) {
                    add_filter($filter, array($this, 'callback_filter_rss'), 100);
                }
            }
        } else {
        // site
            $filters = array();

            // post content
            if ($this->options['filter_posts']) {
                array_push($filters, 'the_title', 'the_content', 'the_excerpt', 'get_the_excerpt');
            }

            // comments
            if ($this->options['filter_comments']) {
                array_push($filters, 'comment_text', 'comment_excerpt', 'comment_url', 'get_comment_author_url', 'get_comment_author_link', 'get_comment_author_url_link');
            }

            // widgets
            if ($this->options['filter_widgets']) {
                array_push($filters, 'widget_title', 'widget_text', 'widget_content');

                // also replace shortcodes
                if ($this->options['shortcodes_in_widgets']) {
                    add_filter('widget_text', 'do_shortcode', 100);
                    add_filter('widget_content', 'do_shortcode', 100); // widget_content id filter of Widget Logic plugin
                }
            }

            foreach($filters as $filter) {
                add_filter($filter, array($this, 'callback_filter'), 100);
            }
        }

        // actions
        add_action('wp_head', array($this, 'wp_head'));

        // shortcodes
        add_shortcode('eeb_form', array($this, 'shortcode_email_encoder_form'));
        add_shortcode('eeb_email', array($this, 'shortcode_encode_email'));
        add_shortcode('eeb_content', array($this, 'shortcode_encode_content'));

        // hook
        do_action('eeb_ready', array($this, 'callback_filter'), $this);

        // support for deprecated action and shortcodes
        if ($this->options['support_deprecated_names'] == 1) {
            // deprecated template functions
            require_once('deprecated.php');

            // deprecated shortcodes
            add_shortcode('email_encoder_form', array($this, 'shortcode_email_encoder_form'));
            add_shortcode('encode_email', array($this, 'shortcode_encode_email'));
            add_shortcode('encode_content', array($this, 'shortcode_encode_content'));

            // deprecated hooks
            do_action('init_email_encoder_bundle', array($this, 'callback_filter'), $this);
        }
    }

    /**
     * WP head
     */
    public function wp_head() {
            // add styling for encoding check message + icon
            if ($this->is_admin_user && $this->options['show_encoded_check']) {
                echo <<<CSS
<style type="text/css">
    a.encoded-check { opacity:0.5; position:absolute; text-decoration:none !important; font:10px Arial !important; margin-top:-3px; color:#629632; font-weight:bold; }
    a.encoded-check:hover { opacity:1; cursor:help; }
    a.encoded-check img { width:10px; height:10px; }
</style>
CSS;
            }
    }

    /* -------------------------------------------------------------------------
     *  Filter Callbacks
     * ------------------------------------------------------------------------*/

    /**
     * WP filter callback
     * @param string $content
     * @return string
     */
    public function callback_filter($content) {
        global $post;

        if (isset($post) && in_array($post->ID, $this->skip_posts)) {
            return $content;
        }

        return $this->encode_email_filter($content, true, $this->options['encode_mailtos'], $this->options['encode_emails'], $this->options['encode_fields']);
    }

    /**
     * RSS Filter callback
     * @param string $content
     * @return string
     */
    public function callback_filter_rss($content) {
        $content = preg_replace($this->regexp_patterns, $this->options['protection_text_rss'], $content);

        return $content;
    }

    /**
     * RSS Callback Remove shortcodes
     * @param string $content
     * @return string
     */
    public function callback_rss_remove_shortcodes($content) {
        // strip shortcodes like [eeb_content], [eeb_form]
        $content = strip_shortcodes($content);

        return $content;
    }

    /**
     * Filter content for encoding
     * @param string $content
     * @param boolean $enc_tags Optional, default true
     * @param boolean $enc_mailtos  Optional, default true
     * @param boolean $enc_plain_emails Optional, default true
     * @param boolean $enc_input_fields Optional, default true
     * @return string
     */
    public function encode_email_filter($content, $enc_tags = true, $enc_mailtos = true, $enc_plain_emails = true, $enc_input_fields = true) {
        // encode input fields with prefilled email address
        if ($enc_input_fields) {
            $content = preg_replace_callback($this->regexp_patterns['input'], array($this, 'callback_encode_input_field'), $content);
        }

        // encode mailto links
        if ($enc_mailtos) {
            $content = preg_replace_callback($this->regexp_patterns['mailto'], array($this, 'callback_encode_email'), $content);
        }

        // replace plain emails
        if ($enc_plain_emails) {
            $content = preg_replace_callback($this->regexp_patterns['email'], array($this, 'callback_encode_email'), $content);
        }

        // workaround for double encoding bug when auto-protect mailto is enabled and method is enc_html
        $content = str_replace('[a-replacement]', '<a', $content);

        return $content;
    }

    /**
     * Callback for encoding email
     * @param array $match
     * @return string
     */
    public function callback_encode_email($match) {
        if (count($match) < 3) {
            $encoded = $this->encode_email($match[1]);
        } else if (count($match) == 3) {
            $encoded = $this->encode_email($match[2]);
        } else {
            $encoded = $this->encode_email($match[2], $match[4], $match[1] . ' ' . $match[3]);
        }

        // workaround for double encoding bug when auto-protect mailto is enabled and method is enc_html
        $encoded = str_replace('<a', '[a-replacement]', $encoded);

        return $encoded;
    }

    /**
     * Callback for encoding input field with email address
     * @param array $match
     * @return string
     */
    public function callback_encode_input_field($match) {
        if ($this->method === 'enc_html') {
            // enc_html method
            $email = $match[2];
            $encoded_email = $this->enc_html($email);

            $encoded = str_replace($email , $encoded_email, $match[0]);
            $encoded = $this->get_success_check($encoded);
        } else {
            $encoded = $this->encode_content($match[0]);
        }

        return $encoded;
    }

    /* -------------------------------------------------------------------------
     *  Shortcode Functions
     * ------------------------------------------------------------------------*/

    /**
     * Shortcode showing encoder form
     * @return string
     */
    public function shortcode_email_encoder_form() {
        // add style and script for ajax encoder
//        wp_enqueue_script('email_encoder', plugins_url('js/src/email-encoder-bundle.js', EMAIL_ENCODER_BUNDLE_FILE), array('jquery'), EMAIL_ENCODER_BUNDLE_VERSION);
        wp_enqueue_script('email_encoder', plugins_url('js/email-encoder-bundle.min.js', EMAIL_ENCODER_BUNDLE_FILE), array('jquery'), EMAIL_ENCODER_BUNDLE_VERSION);

        return $this->get_encoder_form();
    }

    /**
     * Shortcode encoding email
     * @param array $attrs
     * @return string
     */
    public function shortcode_encode_email($attrs) {
        if (!is_array($attrs) || !key_exists('email', $attrs)) {
            return '';
        }

        $email = $attrs['email'];
        $display = (key_exists('display', $attrs)) ? $attrs['display'] : $attrs['email'];
        $method = (key_exists('method', $attrs)) ? $attrs['method'] : null;
        $extra_attrs = (key_exists('extra_attrs', $attrs)) ? $attrs['extra_attrs'] : null;

        $encoded = $this->encode_email($email, $display, $extra_attrs, $method);

        // workaround for double encoding bug when auto-protect mailto is enabled and method is enc_html
        $encoded = str_replace('<a', '[a-replacement]', $encoded);

        return $encoded;
    }

    /**
     * Shortcode encoding content
     * @param array $attrs
     * @param string $content Optional
     * @return string
     */
    public function shortcode_encode_content($attrs, $content = '') {
        $method = (is_array($attrs) && key_exists('method', $attrs)) ? $attrs['method'] : null;

        return $this->encode_content($content, $method);
    }

    /* -------------------------------------------------------------------------
     *  Encode Functions
     * -------------------------------------------------------------------------/

    /**
     * Encode the given email into an encoded HTML link
     * @param string $content
     * @param string $method Optional, else the default setted method will; be used
     * @param boolean $no_html_checked  Optional
     * @param string $protection_text  Optional
     * @return string
     */
    public function encode_content($content, $method = null, $no_html_checked = false, $protection_text = null) {
        if ($protection_text === null) {
            $protection_text = $this->options['protection_text_content'];
        }

        // get encode method
        $method = $this->get_method($method, $this->method);

        // get encoded email code
        $content = $this->{$method}($content, $protection_text);

        // add visual check
        if ($no_html_checked !== true) {
            $content = $this->get_success_check($content);
        }

        return $content;
    }

    /**
     * Encode the given email into an encoded HTML link
     * @param string $email
     * @param string $display Optional, if not set display will be the email
     * @param string $extra_attrs Optional
     * @param string $method Optional, else the default setted method will; be used
     * @param boolean $no_html_checked
     * @return string
     */
    public function encode_email($email, $display = null, $extra_attrs = '', $method = null, $no_html_checked = false) {
        // get encode method
        $method = $this->get_method($method, $this->method);

        // decode entities
        $email = html_entity_decode($email);

        // set email as display
        if ($display === null) {
            $display = $email;

            if ($method === 'enc_html') {
                $display = $this->enc_html($display);
            }
        } else {
            $display = html_entity_decode($display);
        }

        if ($method === 'enc_html') {
            $email = $this->enc_html($email);
        }

        $class = $this->options['class_name'];
        $extra_attrs = ' ' . trim($extra_attrs);
        $mailto = '<a class="'. $class .'" href="mailto:' . $email . '"'. $extra_attrs . '>' . $display . '</a>';

        if ($method === 'enc_html') {
            // add visual check
            if ($no_html_checked !== true) {
                $mailto = $this->get_success_check($mailto);
            }
        } else {
            $mailto = $this->encode_content($mailto, $method, $no_html_checked, $this->options['protection_text']);
        }

        // get encoded email code
        return $mailto;
    }

    /**
     * Add html to encoded content to show check icon and text
     * @param string $content
     * @return string
     */
    private function get_success_check($content) {
        if (!$this->is_admin_user || !$this->options['show_encoded_check']) {
            return $content;
        }

        return $content
                . '<a href="javascript:;" class="encoded-check"'
                . ' title="' . __('Successfully Encoded (this is a check and only visible when logged in as admin)', EMAIL_ENCODER_BUNDLE_DOMAIN) . '">'
                . '<img class="encoded-check-icon" src="' . plugins_url('images/icon-email-encoder-bundle.png', EMAIL_ENCODER_BUNDLE_FILE)
                . '" alt="' . __('Encoded', EMAIL_ENCODER_BUNDLE_DOMAIN) . '" />'
                . __('Successfully Encoded', EMAIL_ENCODER_BUNDLE_DOMAIN) . '</a>';
    }

    /* -------------------------------------------------------------------------
     *  Different Encoding Methods
     * ------------------------------------------------------------------------*/

    /**
     * ASCII method
     * Based on function from Tyler Akins (http://rumkin.com/tools/mailto_encoder/)
     *
     * @param string $value
     * @param string $protection_text
     * @return string
     */
    private function enc_ascii($value, $protection_text) {
        $mail_link = $value;

        // first encode, so special chars can be supported
        $mail_link = $this->encodeURIComponent($mail_link);
        
        $mail_letters = '';

        for ($i = 0; $i < strlen($mail_link); $i ++) {
            $l = substr($mail_link, $i, 1);

            if (strpos($mail_letters, $l) === false) {
                $p = rand(0, strlen($mail_letters));
                $mail_letters = substr($mail_letters, 0, $p) .
                $l . substr($mail_letters, $p, strlen($mail_letters));
            }
        }

        $mail_letters_enc = str_replace("\\", "\\\\", $mail_letters);
        $mail_letters_enc = str_replace("\"", "\\\"", $mail_letters_enc);

        $mail_indices = '';
        for ($i = 0; $i < strlen($mail_link); $i ++) {
            $index = strpos($mail_letters, substr($mail_link, $i, 1));
            $index += 48;
            $mail_indices .= chr($index);
        }

        $mail_indices = str_replace("\\", "\\\\", $mail_indices);
        $mail_indices = str_replace("\"", "\\\"", $mail_indices);

        return '<script type="text/javascript">'
                . '(function(){'
                . 'var ml="'. $mail_letters_enc .'",mi="'. $mail_indices .'",o="";'
                . 'for(var j=0,l=mi.length;j<l;j++){'
                . 'o+=ml.charAt(mi.charCodeAt(j)-48);'
                . '}document.write(decodeURIComponent(o));' // decode at the end, this way special chars can be supported
                . '}());'
                . '</script><noscript>'
                . $protection_text
                . '</noscript>';
    }

    /**
     * This is the opponent of JavaScripts decodeURIComponent()
     * @link http://stackoverflow.com/questions/1734250/what-is-the-equivalent-of-javascripts-encodeuricomponent-in-php
     * @param string $str
     * @return string
     */
    private function encodeURIComponent($str) {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
    }

    /**
     * Escape method
     * Taken from the plugin "Email Spam Protection" by Adam Hunter (http://blueberryware.net/2008/09/14/email-spam-protection/)
     *
     * @param string $value
     * @param string $protection_text
     * @return string
     */
    private function enc_escape($value, $protection_text) {
        $string = 'document.write(\'' . $value . '\')';

        // break string into array of characters, we can't use string_split because its php5 only
        $split = preg_split('||', $string);
        $out =  '<script type="text/javascript">' . "eval(decodeURIComponent('";

        foreach ($split as $c) {
            // preg split will return empty first and last characters, check for them and ignore
            if (!empty($c)) {
                $out .= '%' . dechex(ord($c));
            }
        }

        $out .= "'))" . '</script><noscript>'
            . $protection_text
            . '</noscript>';

        return $out;
    }

    /**
     * Convert randomly chars to htmlentities
     * This method is partly taken from WordPress
     * @link http://codex.wordpress.org/Function_Reference/antispambot
     *
     * @param string $value
     * @return string
     */
    private function enc_html($value) {
        // check for built-in WP function
        if (function_exists('antispambot')) {
            $emailNOSPAMaddy = antispambot($value);
        } else {
            $emailNOSPAMaddy = '';
            srand ((float) microtime() * 1000000);
            for ($i = 0; $i < strlen($emailaddy); $i = $i + 1) {
                $j = floor(rand(0, 1+$mailto));
                if ($j==0) {
                    $emailNOSPAMaddy .= '&#'.ord(substr($emailaddy,$i,1)).';';
                } elseif ($j==1) {
                    $emailNOSPAMaddy .= substr($emailaddy,$i,1);
                } elseif ($j==2) {
                    $emailNOSPAMaddy .= '%'.zeroise(dechex(ord(substr($emailaddy, $i, 1))), 2);
                }
            }
            $emailNOSPAMaddy = str_replace('@','&#64;',$emailNOSPAMaddy);
        }

        $emailNOSPAMaddy = str_replace('@', '&#64;', $emailNOSPAMaddy);

        return $emailNOSPAMaddy;
    }

} // end class Eeb_Site

endif;

/* ommit PHP closing tag, to prevent unwanted whitespace at the end of the parts generated by the included files */
