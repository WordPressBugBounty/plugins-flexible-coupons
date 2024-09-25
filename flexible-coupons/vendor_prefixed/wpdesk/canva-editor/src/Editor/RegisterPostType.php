<?php

/**
 * Integration. Register custom post type.
 *
 * @package WPDesk\FlexibleCouponsPDF
 */
namespace FlexibleCouponsVendor\WPDesk\Library\WPCanvaEditor;

use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;
/**
 * Register custom post types for editor template.
 *
 * @package WPDesk\FlexibleCouponsPDF\Integration
 */
class RegisterPostType implements \FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable
{
    /**
     * @var string
     */
    private $post_type_name;
    /**
     * An array of arguments & labels.
     *
     * @see https://codex.wordpress.org/Function_Reference/register_post_type
     *
     * @var array
     */
    private $post_type_args;
    /**
     * @param string $post_type_name
     * @param array  $post_type_args
     */
    public function __construct($post_type_name, array $post_type_args)
    {
        $this->post_type_name = $post_type_name;
        $this->post_type_args = $post_type_args;
    }
    /**
     * Fires hooks.
     */
    public function hooks()
    {
        \add_action('init', [$this, 'register_post_type_action']);
    }
    /**
     * Get post type args.
     *
     * @return array
     */
    protected function get_post_type_args()
    {
        $labels = ['name' => \_x('Editor', 'post type general name', 'flexible-coupons'), 'singular_name' => \_x('Editor', 'post type singular name', 'flexible-coupons'), 'menu_name' => \_x('Editor', 'admin menu', 'flexible-coupons'), 'name_admin_bar' => \_x('Editor', 'add new on admin bar', 'flexible-coupons')];
        $args = ['labels' => $labels, 'description' => \__('Manage editor templates.', 'flexible-coupons')];
        return \wp_parse_args($this->post_type_args, $args);
    }
    /**
     * @return void
     */
    public function register_post_type_action()
    {
        \register_post_type($this->post_type_name, $this->get_post_type_args());
    }
}
