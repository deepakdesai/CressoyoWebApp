<?php
class ControllerModuleJournal2HeaderNotice extends Controller {

    private static $CACHEABLE = null;
    private $google_fonts = array();

    protected $data = array();

    protected function render() {
        return Front::$IS_OC2 ? $this->load->view($this->template, $this->data) : parent::render();
    }

    public function __construct($registry) {
        parent::__construct($registry);
        if (!defined('JOURNAL_INSTALLED')) {
            return;
        }
        $this->load->model('journal2/module');
        $this->load->model('journal2/menu');

        if (self::$CACHEABLE === null) {
            self::$CACHEABLE = (bool)$this->journal2->settings->get('config_system_settings.header_notice_cache');
        }
    }

    public function index($setting) {
        if (!defined('JOURNAL_INSTALLED')) {
            return;
        }

        Journal2::startTimer(get_class($this));

        /* get module data from db */
        $module_data = $this->model_journal2_module->getModule($setting['module_id']);
        if (!$module_data || !isset($module_data['module_data']) || !$module_data['module_data']) return;
        $module_data = $module_data['module_data'];

        /* hide on mobile */
        if (Journal2Utils::getProperty($module_data, 'disable_mobile') && (Journal2Cache::$mobile_detect->isMobile() && !Journal2Cache::$mobile_detect->isTablet()) && $this->journal2->settings->get('responsive_design')) {
            return;
        }

        /* hide on desktop */
        if (Journal2Utils::getProperty($module_data, 'disable_desktop') && !Journal2Cache::$mobile_detect->isMobile()) {
            return;
        }

        $this->data['cookie_name'] = 'header_notice-' . Journal2Utils::getProperty($module_data, 'do_not_show_again_cookie');
        $this->data['do_not_show_again'] = Journal2Utils::getProperty($module_data, 'do_not_show_again', '0');

        if ($this->data['do_not_show_again'] && isset($this->request->cookie[$this->data['cookie_name']])) {
            return;
        }

        $cache_property = "module_journal_header_notice_{$setting['module_id']}_{$setting['layout_id']}_{$setting['position']}";

        $cache = $this->journal2->cache->get($cache_property);

        if ($cache === null || self::$CACHEABLE !== true) {
            $module = mt_rand();

            $this->data['hide_on_mobile_class'] = Journal2Utils::getProperty($module_data, 'disable_mobile') ? 'hide-on-mobile' : '';

            /* set global module properties */
            $this->data['module'] = $module;
            $this->data['text'] = Journal2Utils::getProperty($module_data, 'text.value.' . $this->config->get('config_language_id'));
            $this->data['icon'] = Journal2Utils::getIconOptions2(Journal2Utils::getProperty($module_data, 'icon'));
            $this->data['icon_position'] = Journal2Utils::getProperty($module_data, 'icon_position', 'left');
            $this->data['float_icon'] = Journal2Utils::getProperty($module_data, 'float_icon', '0') == '1' ? 'floated-icon' : '';
            $this->data['close_button_type'] = Journal2Utils::getProperty($module_data, 'close_button_type', 'icon');
            $this->data['close_button_text'] = Journal2Utils::getProperty($module_data, 'close_button_text.value.' . $this->config->get('config_language_id'), 'Close');

            $css = array();

            if (($value = Journal2Utils::getProperty($module_data, 'padding_t.value.text')) !== null) {
                $css[] = 'padding-top: ' . $value . 'px';
            }

            if (($value = Journal2Utils::getProperty($module_data, 'padding_r.value.text')) !== null) {
                $css[] = 'padding-right: ' . $value . 'px';
            }

            if (($value = Journal2Utils::getProperty($module_data, 'padding_b.value.text')) !== null) {
                $css[] = 'padding-bottom: ' . $value . 'px';
            }

            if (($value = Journal2Utils::getProperty($module_data, 'padding_l.value.text')) !== null) {
                $css[] = 'padding-left: ' . $value . 'px';
            }

            if (Journal2Utils::getProperty($module_data, 'text_font.value.font_type') === 'google') {
                $font_name = Journal2Utils::getProperty($module_data, 'text_font.value.font_name');
                $font_subset = Journal2Utils::getProperty($module_data, 'text_font.value.font_subset');
                $font_weight = Journal2Utils::getProperty($module_data, 'text_font.value.font_weight');
                $this->journal2->google_fonts->add($font_name, $font_subset, $font_weight);
                $this->google_fonts[] = array(
                    'name'  => $font_name,
                    'subset'=> $font_subset,
                    'weight'=> $font_weight
                );
                $weight = filter_var(Journal2Utils::getProperty($module_data, 'text_font.value.font_weight'), FILTER_SANITIZE_NUMBER_INT);
                $css[] = 'font-weight: ' . ($weight ? $weight : 400);
                $css[] = "font-family: '" . Journal2Utils::getProperty($module_data, 'text_font.value.font_name') . "'";
            }

            if (Journal2Utils::getProperty($module_data, 'text_font.value.font_type') === 'system') {
                $css[] = 'font-weight: ' . Journal2Utils::getProperty($module_data, 'text_font.value.font_weight');
                $css[] = 'font-family: ' . Journal2Utils::getProperty($module_data, 'text_font.value.font_family');
            }

            if (Journal2Utils::getProperty($module_data, 'text_font.value.font_type') !== 'none') {
                $css[] = 'font-size: ' . Journal2Utils::getProperty($module_data, 'text_font.value.font_size');
                $css[] = 'font-style: ' . Journal2Utils::getProperty($module_data, 'text_font.value.font_style');
                $css[] = 'text-transform: ' . Journal2Utils::getProperty($module_data, 'text_font.value.text_transform');
            }

            if (Journal2Utils::getProperty($module_data, 'text_font.value.color.value.color')) {
                $css[] = 'color: ' . Journal2Utils::getColor(Journal2Utils::getProperty($module_data, 'text_font.value.color.value.color'));
            }

            if ($color = Journal2Utils::getProperty($module_data, 'text_background_color.value.color')) {
                $css[] = "background-color: " . Journal2Utils::getColor($color);
            }

            $this->data['css'] = implode('; ', $css);

            $global_style = array();

            /* link colors */
            if ($color = Journal2Utils::getProperty($module_data, 'text_link_color.value.color')) {
                $global_style[] = "#journal-header-notice-{$module} a { color: " . Journal2Utils::getColor($color) . "}";
            }
            if ($color = Journal2Utils::getProperty($module_data, 'text_link_hover_color.value.color')) {
                $global_style[] = "#journal-header-notice-{$module} a:hover { color: " . Journal2Utils::getColor($color) . "}";
            }

            /* button colors */
            if ($color = Journal2Utils::getProperty($module_data, 'button_color.value.color')) {
                $global_style[] = "#journal-header-notice-{$module} .close-notice { color: " . Journal2Utils::getColor($color) . "}";
            }
            if ($color = Journal2Utils::getProperty($module_data, 'button_hover_color.value.color')) {
                $global_style[] = "#journal-header-notice-{$module} .close-notice:hover { color: " . Journal2Utils::getColor($color) . "}";
            }
            if ($color = Journal2Utils::getProperty($module_data, 'button_bg_color.value.color')) {
                $global_style[] = "#journal-header-notice-{$module} .close-notice { background-color: " . Journal2Utils::getColor($color) . "}";
            }
            if ($color = Journal2Utils::getProperty($module_data, 'button_hover_bg_color.value.color')) {
                $global_style[] = "#journal-header-notice-{$module} .close-notice:hover { background-color: " . Journal2Utils::getColor($color) . "}";
            }

            $this->data['global_style'] = $global_style;

            $this->template = $this->config->get('config_template') . '/template/journal2/module/header_notice.tpl';

            if (self::$CACHEABLE === true) {
                $html = Minify_HTML::minify($this->render(), array(
                    'xhtml' => false,
                    'jsMinifier' => 'j2_js_minify'
                ));
                $this->journal2->cache->set($cache_property, $html);
                $this->journal2->cache->set($cache_property . '_fonts', json_encode($this->google_fonts));
            }
        } else {
            if ($fonts = $this->journal2->cache->get($cache_property . '_fonts')) {
                $fonts = json_decode($fonts, true);
                if (is_array($fonts)) {
                    foreach ($fonts as $font) {
                        $this->journal2->google_fonts->add($font['name'], $font['subset'], $font['weight']);
                    }
                }
            }
            $this->template = $this->config->get('config_template') . '/template/journal2/cache/cache.tpl';
            $this->data['cache'] = $cache;
        }

        $this->document->addScript('catalog/view/theme/journal2/lib/jqueryc/jqueryc.js');

        $output = $this->render();

        Journal2::stopTimer(get_class($this));

        return $output;
    }

}
