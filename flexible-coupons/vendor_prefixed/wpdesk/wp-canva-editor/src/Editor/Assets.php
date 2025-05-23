<?php

/**
 * Editor. Assets.
 *
 * @package WPDesk\Library\WPCanvaEditor
 */
namespace FlexibleCouponsVendor\WPDesk\Library\WPCanvaEditor;

use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;
/**
 * Enqueue editor scripts.
 *
 * @package WPDesk\Library\WPCanvaEditor
 */
class Assets implements Hookable
{
    /**
     * @var string
     */
    private $post_type;
    /**
     * @var string
     */
    protected $scripts_version = '1.3';
    /**
     * @param $post_type
     */
    public function __construct($post_type)
    {
        $this->post_type = $post_type;
    }
    /**
     * Fires hooks
     */
    public function hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }
    /**
     * @return string
     */
    protected function get_assets_url()
    {
        return trailingslashit(plugin_dir_url(__DIR__)) . 'assets/';
    }
    /**
     * Enqueue editor scripts and styles.
     */
    public function admin_enqueue_scripts()
    {
        $screen = get_current_screen();
        $suffix = defined('SCRIPT_DEBUG') && \SCRIPT_DEBUG ? '' : '.min';
        $is_pl = 'pl_PL' === get_locale();
        $pro_url = $is_pl ? 'https://www.wpdesk.pl/sklep/flexible-coupons-woocommerce/?utm_source=wp-admin-plugins&utm_medium=link&utm_campaign=flexible-coupons-pro&utm_content=edit-template' : 'https://wpdesk.net/products/flexible-coupons-woocommerce/?utm_source=wp-admin-plugins&utm_medium=link&utm_campaign=flexible-coupons-pro&utm_content=edit-template';
        $shortcodes_pro_url = $is_pl ? 'https://wpdesk.link/fc-codes-up-pl' : 'https://wpdesk.link/fc-codes-up';
        $tickets_buy_url = $is_pl ? 'https://wpdesk.link/fc-qr-codes-pl-up' : 'https://wpdesk.link/fc-qr-codes-up';
        $tickets_docs_url = $is_pl ? 'https://wpdesk.link/fc-qr-codes-pl-docs' : 'https://wpdesk.link/fc-qr-codes-docs';
        $sending_buy_url = $is_pl ? 'https://wpdesk.link/as-advanced-sending-template-pl' : 'https://wpdesk.link/as-advanced-sending-template';
        $sending_settings_url = admin_url('edit.php?post_type=wpdesk-coupons&page=fc-settings&tab=emails');
        if ('post' === $screen->base && $this->post_type === $screen->post_type) {
            if (!is_rtl()) {
                wp_enqueue_style('canva-editor-admin', $this->get_assets_url() . 'css/admin.css', [], $this->scripts_version);
            } else {
                wp_enqueue_style('canva-editor-admin-rtl', $this->get_assets_url() . 'css/admin-rtl.css', [], $this->scripts_version);
            }
            wp_enqueue_media();
            wp_register_script('flexible-coupons', $this->get_assets_url() . 'js/wpdesk-canva-editor' . $suffix . '.js', ['wp-editor'], $this->scripts_version, \true);
            wp_enqueue_script('flexible-coupons');
            wp_localize_script('flexible-coupons', 'wpdesk_canva_editor_lang', ['general' => esc_html__('General', 'flexible-coupons'), 'images' => esc_html__('Images', 'flexible-coupons'), 'text' => esc_html__('Text', 'flexible-coupons'), 'shortcodes' => esc_html__('Shortcodes', 'flexible-coupons'), 'qrcode' => esc_html__('QR Code', 'flexible-coupons'), 'select_format' => esc_html__('Select format', 'flexible-coupons'), 'page_orientation' => esc_html__('Page orientation', 'flexible-coupons'), 'vertical' => esc_html__('Vertical', 'flexible-coupons'), 'horizontal' => esc_html__('Horizontal', 'flexible-coupons'), 'background_color' => esc_html__('Background color', 'flexible-coupons'), 'color' => esc_html__('Color', 'flexible-coupons'), 'select' => esc_html__('Select', 'flexible-coupons'), 'select_images' => esc_html__('Select images', 'flexible-coupons'), 'add_to_area' => esc_attr__('Add to area', 'flexible-coupons'), 'remove_from_project' => esc_attr__('Remove from project', 'flexible-coupons'), 'edit' => esc_attr__('Edit', 'flexible-coupons'), 'fit_to_screen' => esc_attr__('Fit to screen', 'flexible-coupons'), 'crop' => esc_attr__('Crop', 'flexible-coupons'), 'layer_up' => esc_attr__('Layer up', 'flexible-coupons'), 'layer_down' => esc_attr__('Layer down', 'flexible-coupons'), 'clone_element' => esc_attr__('Clone element', 'flexible-coupons'), 'delete_element' => esc_attr__('Delete element', 'flexible-coupons'), 'delete' => esc_attr__('Delete element', 'flexible-coupons'), 'change_image' => esc_attr__('Change image', 'flexible-coupons'), 'align_right' => esc_attr__('Align right', 'flexible-coupons'), 'align_left' => esc_attr__('Align left', 'flexible-coupons'), 'align_center' => esc_attr__('Align center', 'flexible-coupons'), 'justify' => esc_attr__('Justify', 'flexible-coupons'), 'font_size' => esc_attr__('Font size', 'flexible-coupons'), 'change_font_size' => esc_attr__('Change font size', 'flexible-coupons'), 'font_family' => esc_attr__('Font family', 'flexible-coupons'), 'change_font_family' => esc_attr__('Change font family', 'flexible-coupons'), 'double_click_to_edit' => esc_attr__('Double click to edit', 'flexible-coupons'), 'font_color' => esc_attr__('Font color', 'flexible-coupons'), 'header1' => esc_html__('Header 1', 'flexible-coupons'), 'header2' => esc_html__('Header 2', 'flexible-coupons'), 'header3' => esc_html__('Header 3', 'flexible-coupons'), 'content' => esc_html__('Content', 'flexible-coupons'), 'upgrade_to_pro' => sprintf(
                /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
                esc_html__('%1$sUpgrade to PRO →%2$s and enable more shortcodes', 'flexible-coupons'),
                '<a href="' . esc_url($pro_url) . '" target="_blank" class="pro-link">',
                '</a>'
            ), 'coupons_pro_plugin_enabled' => $this->is_active('flexible-coupons-pro/flexible-coupons-pro.php') ? 'yes' : 'no', 'pro_plugin_name' => esc_html__('Flexible Coupons PRO', 'flexible-coupons'), 'pro_addon_info' => sprintf(
                /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
                esc_html__('This is an add-on for the PRO version. %1$sUpgrade to PRO →%2$s', 'flexible-coupons'),
                '<a href="' . esc_url($pro_url) . '" target="_blank" class="pro-link">',
                '</a>'
            ), 'shortcodes_plugin_link' => sprintf(
                /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
                esc_html__('Add custom shortcodes with Flexible PDF Coupons PRO addon: %1$sCustom Shortcodes →%2$s', 'flexible-coupons'),
                '<a href="' . esc_url($shortcodes_pro_url) . '" target="_blank" class="shortcode-link">',
                '</a>'
            ), 'shortcodes_plugin_enabled' => $this->is_active('flexible-coupons-shortcodes/flexible-coupons-shortcodes.php') ? 'yes' : 'no', 'tickets_plugin_label' => esc_html__('Place a generated QR code on the template. Enable users to manage QR codes with the Event Ticket QR Scanner.', 'flexible-coupons'), 'tickets_docs_label' => esc_html__('Read more in plugin docs', 'flexible-coupons'), 'tickets_docs_url' => $tickets_docs_url, 'tickets_plugin_buy_label' => esc_html__('Add QR codes with Flexible PDF Coupons PRO addon', 'flexible-coupons'), 'tickets_buy_url' => $tickets_buy_url, 'tickets_plugin_name' => esc_html__('Event Ticket QR Scanner', 'flexible-coupons'), 'tickets_plugin_enabled' => $this->is_active('flexible-coupons-tickets/flexible-coupons-tickets.php') ? 'yes' : 'no', 'tickets_upgrade_pro_label' => esc_html__('To use QR codes you need', 'flexible-coupons'), 'sending_plugin_enabled' => $this->is_active('flexible-coupons-sending/flexible-coupons-sending.php') ? 'yes' : 'no', 'sending_plugin_buy_label' => esc_html__('Send coupons by email and schedule gift card delivery with Flexible PDF Coupons PRO addon', 'flexible-coupons'), 'sending_buy_url' => $sending_buy_url, 'sending_plugin_name' => esc_html__('Advanced Sending', 'flexible-coupons'), 'sending_plugin_label' => esc_html__('Send coupons by email and schedule gift card delivery', 'flexible-coupons'), 'sending_settings_url' => $sending_settings_url, 'sending' => esc_html__('Sending', 'flexible-coupons')]);
            wp_register_script('wp-canva-admin', $this->get_assets_url() . 'js/admin.js', ['flexible-coupons'], $this->scripts_version, \true);
            wp_enqueue_script('wp-canva-admin');
            wp_localize_script('wp-canva-admin', 'wp_canva_admin', ['post_type' => $this->post_type, 'nonce' => wp_create_nonce('editor_save_post_' . $this->post_type), 'lang' => get_locale()]);
        }
    }
    /**
     * @param string $plugin
     *
     * @return bool
     */
    public function is_active(string $plugin): bool
    {
        if (function_exists('is_plugin_active_for_network') && is_plugin_active_for_network($plugin)) {
            return \true;
        }
        return in_array($plugin, (array) get_option('active_plugins', []), \true);
    }
}
