<?php

/**
 * Plugin Name: AI Tools - Chatbot, ChatGPT, Content Generator, Image Generator, Artificial Intelligence GPT
 * Description: Auto content generator.
 * Text Domain: momoacg
 * Domain Path: /languages
 * Author: MoMo Themes
 * Version: 4.0.1
 * Author URI: http://www.momothemes.com/
 * Requires at least: 5.6
 * Tested up to: 6.5.2
 */
if ( !function_exists( 'momoacg_fs' ) ) {
    /**
     * Create a helper function for easy SDK access.
     */
    function momoacg_fs() {
        global $momoacg_fs;
        if ( !isset( $momoacg_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $momoacg_fs = fs_dynamic_init( array(
                'id'             => '15178',
                'slug'           => 'artificial-intelligence-auto-content-generator',
                'type'           => 'plugin',
                'public_key'     => 'pk_4e00e34f48da3606cf863c6216cf4',
                'is_premium'     => false,
                'premium_suffix' => 'Premium',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                    'slug'       => 'momoacg',
                    'first-path' => 'admin.php?page=momoacg-getting-started',
                ),
                'is_live'        => true,
            ) );
        }
        return $momoacg_fs;
    }

    // Init Freemius.
    momoacg_fs();
    // Signal that SDK was initiated.
    do_action( 'momoacg_fs_loaded' );
}
/**
 * Plugin main class
 */
class MoMo_Auto_Content_Generator {
    /**
     * Plugin Version
     *
     * @var string
     */
    public $version = '4.0.1';

    /**
     * Table Function
     *
     * @var string
     */
    public $tblfn;

    /**
     * Tables
     *
     * @var string
     */
    public $tables;

    /**
     * Plugin Url
     *
     * @var string
     */
    public $plugin_url;

    /**
     * Plugin path
     *
     * @var string
     */
    public $plugin_path;

    /**
     * Plugin Name
     *
     * @var string
     */
    public $name;

    /**
     * Language
     *
     * @var MoMo_ACG_Lang_All
     */
    public $lang;

    /**
     * Function
     *
     * @var MoMo_Basic_Functions_ACG
     */
    public $fn;

    /**
     * API Class
     *
     * @var MoMo_ACG_Rest_API
     */
    public $api;

    /**
     * Admin Ajax
     *
     * @var MoMo_ACG_Admin_Ajax
     */
    public $adajax;

    /**
     * Create Page Cron
     *
     * @var MoMo_Create_Page_Cron
     */
    public $cpcron;

    /**
     * Frontend
     *
     * @var MoMo_ACG_CG_Frontned
     */
    public $cgfe;

    /**
     * Chatbot
     *
     * @var MoMo_ACG_Chatbot_Frontned
     */
    public $chatbot;

    /**
     * ChatGPT Frontebd
     *
     * @var MoMo_ChatGPT_Frontend
     */
    public $cgptfe;

    /**
     * Bulk Writer Function
     *
     * @var MoMo_Bulkcw_Functions
     */
    public $bulkcwfn;

    /**
     * Bulk Writer Cron
     *
     * @var MoMo_BulkCW_Cron
     */
    public $bulkcwcron;

    /**
     * WooCommerce API
     *
     * @var MoMo_ACG_WC_Rest_API
     */
    public $wcapi;

    /**
     * Embeddings
     *
     * @var MoMo_Embeddings_Model
     */
    public $embeddings;

    /**
     * RSS Feed Cron
     *
     * @var MoMo_RssFeed_Cron
     */
    public $rssfeedcron;

    /**
     * Rss Feed Function
     *
     * @var MoMo_RssFeed_Functions
     */
    public $rssfeedfn;

    /**
     * CSFE
     *
     * @var MoMo_ACG_CS_Frontned
     */
    public $csfe;

    /**
     * Plugin URL
     *
     * @var string
     */
    public $momoacg_url;

    /**
     * Plugin Assets
     *
     * @var string
     */
    public $momoacg_assets;

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'plugins_loaded', array($this, 'momoacg_plugin_loaded') );
        /** Maybe Premium Only */
        include_once 'includes/class-momo-acg-table-functions.php';
        $this->tblfn = new MoMo_ACG_Table_Functions();
        $this->tables = array('momo_acg_cb_trainings_list');
        register_activation_hook( __FILE__, array($this, 'momo_acg_activate') );
        add_action( 'init', array($this, 'momo_check_if_table_exists_or_not') );
    }

    /**
     * Plugin Loaded
     */
    public function momoacg_plugin_loaded() {
        $this->plugin_url = plugin_dir_url( __FILE__ );
        $this->plugin_path = dirname( __FILE__ ) . '/';
        $this->momoacg_url = path_join( plugins_url(), basename( dirname( __FILE__ ) ) );
        $this->momoacg_assets = str_replace( array('http:', 'https:'), '', $this->momoacg_url ) . '/assets/';
        $this->name = esc_html__( 'MoMo - Auto Content Generator', 'momoacg' );
        add_action( 'init', array($this, 'momoacg_plugin_init'), 10 );
    }

    /**
     * Plugin Init
     *
     * @return void
     */
    public function momoacg_plugin_init() {
        load_plugin_textdomain( 'momoacg', false, 'momo-acg/languages' );
        include_once 'includes/cpt-momoacg/class-momo-cpt-momoacg.php';
        include_once 'includes/class-momo-basic-functions-acg.php';
        include_once 'includes/class-momo-acg-lang-all.php';
        include_once 'includes/class-momo-acg-rest-api.php';
        // Added Blocks.
        $blocks_settings = get_option( 'momo_acg_blocks_settings' );
        $enable_blocks_instead_of_metabox = ( isset( $blocks_settings['enable_blocks_instead_of_metabox'] ) ? $blocks_settings['enable_blocks_instead_of_metabox'] : 'off' );
        $enable_blocks_instead_of_metabox = 'off';
        include_once 'includes/blocks/momo-acg-block.php';
        $this->lang = new MoMo_ACG_Lang_All();
        $this->fn = new MoMo_Basic_Functions_ACG();
        $this->api = new MoMo_ACG_Rest_API();
        if ( is_admin() ) {
            include_once 'includes/admin/class-momo-acg-admin-init.php';
            include_once 'includes/admin/class-momo-acg-admin-ajax.php';
            $this->adajax = new MoMo_ACG_Admin_Ajax();
            // Metabox content.
            include_once 'includes/admin/metabox/class-momo-acg-openai-metabox.php';
        }
        // Chat-GPT (10-01-2023).
        $this->momo_acg_chatgpt_init();
        // Bulk Content Write (12-01-2023).
        $this->momo_acg_bulk_content_writer_init();
        // Synchronous content generation.
        $this->momo_acg_synchronous_content_writer_init();
        // Woocommerce Production Description.
        $this->momo_acg_woocommerce_product_init();
        // Frontend content generator.
        $this->momo_acg_fe_content_generator_init();
        // Chatbot Init.
        $this->momo_acg_fe_chatbot_init();
        // RSS Feed / Auto Blog.
        $this->momo_acg_rss_feed_init();
        // Credit System.
        $this->momo_acg_credit_system_init();
        include_once 'includes/class-momo-acg-logger.php';
        if ( is_admin() ) {
            add_action( 'admin_menu', array($this, 'momoacg_set_getting_started_menu'), 20 );
        }
        register_deactivation_hook( __FILE__, array($this, 'momo_acg_deactivate') );
    }

    /**
     * Get getting started menu
     *
     * @return void
     */
    public function momoacg_set_getting_started_menu() {
        add_submenu_page(
            'momoacg',
            esc_html__( 'Getting Started', 'momoacg' ),
            esc_html__( 'Getting Started', 'momoacg' ),
            'manage_options',
            'momoacg-getting-started',
            array($this, 'momoacg_render_getting_started_page'),
            11
        );
    }

    /**
     * Render getting started page
     */
    public function momoacg_render_getting_started_page() {
        global $momoacg;
        require_once $momoacg->plugin_path . 'includes/admin/pages/page-momo-acg-getting-started.php';
    }

    /**
     * Momo Forms.
     */
    public function momo_acg_forms_init() {
        include_once 'forms/class-momo-acg-forms-block.php';
    }

    /**
     * Initialize Single create page.
     */
    public function momo_acg_create_page_init() {
        if ( is_admin() ) {
            include_once 'create-page/class-acg-create-page-admin-init.php';
        }
        include_once 'create-page/class-momo-create-page-cron.php';
        $this->cpcron = new MoMo_Create_Page_Cron();
    }

    /**
     * Chatbot Initialization
     *
     * @return void
     */
    public function momo_acg_fe_chatbot_init() {
        if ( is_admin() ) {
            include_once 'chatbot/admin/class-momo-acg-chatbot-admin.php';
            include_once 'chatbot/admin/class-momo-chatbot-admin-ajax.php';
        }
        include_once 'chatbot/class-momo-acg-chatbot-shortcodes.php';
        include_once 'chatbot/class-momo-acg-chatbot-frontend.php';
        include_once 'chatbot/class-momo-acg-chatbot-ajax.php';
        $this->chatbot = new MoMo_ACG_Chatbot_Frontned();
    }

    /**
     * Frontend Content Generator
     *
     * @return void
     */
    public function momo_acg_fe_content_generator_init() {
        include_once 'fe-content-generator/class-momo-acg-fe-cg-shortcodes.php';
        include_once 'fe-content-generator/class-momo-acg-cg-frontend.php';
        include_once 'fe-content-generator/class-momo-acg-fe-cg-ajax.php';
        $this->cgfe = new MoMo_ACG_CG_Frontned();
    }

    /**
     * Initialize ChatGPT Classes
     */
    public function momo_acg_chatgpt_init() {
        include_once 'chatgpt/frontend/class-momo-chatgpt-frontend.php';
        include_once 'chatgpt/frontend/class-momo-chatgpt-fe-ajax.php';
        include_once 'chatgpt/class-momo-chatgpt-shortcodes.php';
        $this->cgptfe = new MoMo_ChatGPT_Frontend();
        if ( is_admin() ) {
            include_once 'chatgpt/admin/class-momo-chatgpt-admin-init.php';
        }
    }

    /**
     * Initialize Sync content Writer.
     */
    public function momo_acg_synchronous_content_writer_init() {
        include_once 'includes/admin/class-momo-acg-sync-ajax.php';
    }

    /**
     * Initialize Bulk content Writer.
     */
    public function momo_acg_bulk_content_writer_init() {
        include_once 'bulkcw/class-momo-bulkcw-functions.php';
        include_once 'bulkcw/class-momo-bulkcw-cron.php';
        $this->bulkcwfn = new MoMo_Bulkcw_Functions();
        $this->bulkcwcron = new MoMo_BulkCW_Cron();
        if ( is_admin() ) {
            include_once 'bulkcw/class-momo-bulkcw-admin-init.php';
            include_once 'bulkcw/class-momo-bulkcw-admin-ajax.php';
        }
    }

    /**
     * Woo Product Description Generator Init.
     */
    public function momo_acg_woocommerce_product_init() {
        global $momoacg;
        if ( class_exists( 'MoMo_ACG_For_Woocommerce' ) ) {
            add_action( 'admin_notices', array($this, 'momo_acg_woo_lite_version_active') );
            return;
        }
        $name = 'enable_for_plugin_woocommerce';
        $general_settings = get_option( 'momo_acg_general_settings' );
        $value = $momoacg->fn->momo_return_option_yesno( $general_settings, $name );
        if ( 'on' === $value ) {
            include_once 'woocommerce/class-momo-acg-wc-rest-api.php';
            $this->wcapi = new MoMo_ACG_WC_Rest_API();
            if ( is_admin() ) {
                include_once 'woocommerce/admin/class-momo-acg-wc-admin-init.php';
                include_once 'woocommerce/admin/class-momo-acg-wc-admin-ajax.php';
                include_once 'woocommerce/admin/metabox/class-momo-acg-wc-metabox.php';
            }
        }
    }

    /**
     * RSS Feed to content.
     */
    public function momo_acg_rss_feed_init() {
        if ( is_admin() ) {
            include_once 'autoblog/admin/class-momo-acg-rssfeed-admin.php';
            include_once 'autoblog/admin/class-momo-acg-autoblog-admin.php';
        }
    }

    /**
     * Client Access Credit System
     *
     * @return void
     */
    public function momo_acg_credit_system_init() {
        if ( is_admin() ) {
            include_once 'credit-system/admin/class-momo-acg-credit-system-admin.php';
        }
    }

    /**
     * Notify if Light Version of Plugin Exist
     */
    public function momo_acg_lite_version_active() {
        ?>
		<div class="message error">
			<p>
				<?php 
        esc_html_e( 'It seems like another version of this plugin is activated. Please deactivate it first to run this version properly.', 'momoacg' );
        ?>
			</p>
			<p><b>
				<?php 
        echo esc_html( $this->name );
        ?>
			</b></p>
		</div>
		<?php 
    }

    /**
     * Notify if Light Version of Plugin Exist
     */
    public function momo_acg_woo_lite_version_active() {
        ?>
		<div class="message error">
			<p>
				<?php 
        esc_html_e( 'It seems like another version of OpenAI Product Description Writer for WooCommerce is activated. Please deactivate it first to run this version properly.', 'momoacg' );
        ?>
			</p>
			<p><b>
				<?php 
        echo esc_html( $this->name );
        ?>
			</b></p>
		</div>
		<?php 
    }

    /**
     * Activation Functions
     */
    public function momo_acg_activate() {
        foreach ( $this->tables as $option_table ) {
            $this->tblfn->momo_create_option_table( $option_table );
        }
        do_action( 'momo_acg_activate' );
    }

    /**
     * Deactivation Functions
     *
     * @return void
     */
    public function momo_acg_deactivate() {
        foreach ( $this->tables as $option_table ) {
            $this->tblfn->momo_delete_option_table( $option_table );
        }
        do_action( 'momo_acg_deactivate' );
    }

    /**
     * Check if table exist or not ( Create if dont exists)
     */
    public function momo_check_if_table_exists_or_not() {
        global $wpdb;
        foreach ( $this->tables as $option_table ) {
            // Define a cache key for the specific table existence check.
            $cache_key = 'momo_table_exists_' . $option_table;
            $cached_result = wp_cache_get( $cache_key, 'momo_custom_options' );
            if ( false === $cached_result ) {
                // If the cache is empty, perform the table existence check for this table.
                $db_table = $wpdb->get_var( 
                    // phpcs:ignore
                    $wpdb->prepare( 'SHOW TABLES LIKE %s', $option_table )
                 );
                if ( $db_table !== $option_table ) {
                    $this->tblfn->momo_create_option_table( $option_table );
                }
                // Store the result in the cache for future use.
                wp_cache_set( $cache_key, true, 'momo_custom_options' );
            }
        }
    }

}

$GLOBALS['momoacg'] = new MoMo_Auto_Content_Generator();