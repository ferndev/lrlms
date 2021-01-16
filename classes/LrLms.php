<?php
/**
 * LrLms class
 * Main class for custom LMS Wordpress plugin
 * @author : Fernando Martinez
 */
defined( 'ABSPATH' ) || exit();

final class LrLms {
    protected static $instance = null;
    protected static $installInProgress = false, $installed = false;
    protected static $lrlmsLoaded = false;
    public static $pluginPath = '';
    protected static $lrlmsEnhancedTheme;
    static $lrlms_post_types = array(LrLmsConstants::LRLMS_FORM, LrLmsConstants::LRLMS_COURSE,LrLmsConstants::LRLMS_LESSON);
    public static $courseId = null, $courseTitle = '';

    private function __construct() {
        LrLms::$pluginPath = trailingslashit(LR_PLUGIN_DIR);
    }

    public static function create() {
        if ( is_null( LrLms::$instance ) ) {
            LrLms::$instance = new self();
            LrLms::$instance->includeFiles();
            LrLms::$instance->installLMS();
            register_activation_hook( LR_PLUGIN_FILE, array( self::$instance, 'onActivate' ) );
            register_deactivation_hook(LR_PLUGIN_FILE, array( self::$instance, 'onDeactivate' ));
            register_uninstall_hook(LR_PLUGIN_FILE, array( __CLASS__, 'uninstallLMS' ));
        }
        return LrLms::$instance;
    }

    public function installLMS() {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        if (LrLms::$installInProgress) return;
        $installed = get_option("LrLms_installed");
        if ($installed) {
            //error_log('LrLms already installed, exiting installation');
            LrLms::$instance->installAdminHooks();
            return;
        }
        LrLms::$installInProgress = true;
        try {
            error_log('installing LrLms');
            $schema = file_get_contents(LrLms::$pluginPath . '/resources/schema.sql');
            $schema = str_replace('CREATE TABLE ', "CREATE TABLE {$wpdb->prefix}", $schema);
            dbDelta($schema);
            LrLms::$installed = true;
            add_option("LrLms_installed", true);
            LrLms::$instance->installAdminHooks();
            LrLms::$installInProgress = false;
        } catch(Exception $e) {
            error_log('Exception caught during installation: '.$e->getMessage()."\n".$e->getTraceAsString());
        }
    }

    private function installAdminHooks() {
        add_action( 'init', array( LrLms::$instance, 'loadLMS' ), 99 );
        add_action('admin_menu', array( LrLms::$instance, 'loadAdminMenu' ), 99);
        add_filter( 'plugin_action_links', array( $this, 'addPluginLinks' ), 10, 2 );
    }

    public function addPluginLinks($links, $file) {
        if ( plugin_basename( LR_PLUGIN_FILE ) !== $file ) {
            return $links;
        }

        // New links to merge into existing links
        $new_links = array();

        $new_links['about']    = '<a href="' . esc_url( add_query_arg( array( 'page' => 'about-lrlms' ), admin_url( 'index.php') ) ) . '">' . esc_html__( 'About',    'lrlms' ) . '</a>';

        // Add a few links to the existing links array
        return array_merge( $links, $new_links );
    }

    static public function getController($name) {
        $path = LrLms::$pluginPath . '/classes/controller/'.$name.'.php';
        if (!file_exists($path)) return null;
        include_once($path);
        return newObj($name);
    }

    static public function uninstallLMS() {
        global $wpdb;
        do_action('uninstall_lrlms_action');
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        delete_option("LrLms_installed");
        $schema = file_get_contents(LrLms::$pluginPath . '/resources/drop_schema.sql');
        $schema = str_replace('wp_', "{$wpdb->prefix}", $schema);
        $wpdb->query($schema);
    }

    public function onActivate() {
        do_action('activate_lrlms_action');
    }

    public function onDeactivate() {
        do_action('deactivate_lrlms_action');
    }

    public function loadLMS() {
        if (LrLms::$lrlmsLoaded) return;
        LrLms::$lrlmsEnhancedTheme = current_theme_supports('lrlms');
        LrLms::$lrlmsEnhancedTheme = true;
            do_action('before_lrlms_loaded');
        $this->createPostTypes();
        add_action('pre_get_posts', array( $this, 'setupShowCoursesInHomePage' ), 0 );
        add_action('save_post', [$this, 'save']);
        if (isset($_SESSION['courseTitle'])) LrLms::$courseTitle = $_SESSION['courseTitle'];
        add_filter('the_content', [$this, 'load']);
        add_filter( 'template_include', array( $this, 'loadTemplates' ) );
        do_action('lrlms_loaded');
        LrLms::$lrlmsLoaded = true;
    }

    private function createPostTypes() {
        //unregister_post_type(LrLmsConstants::LRLMS_FORM);
        foreach(LrLms::$lrlms_post_types as $post_type) {
            $defs = LrLmsConstants::POST_TYPE_DEF[$post_type];
            if (MetaFields::hasMeta($post_type)) {
                register_post_type($post_type, array(
                        'labels' => array('name' => __($defs[0][0]), 'singular_name' => __($defs[0][1])),
                        'public' => $defs[1], 'supports' => $defs[2], 'has_archive' => $defs[3],
                        'register_meta_box_cb' => array($this, 'setmetafields'))
                );
            } else {
                register_post_type($post_type, array(
                        'labels' => array('name' => __($defs[0][0]), 'singular_name' => __($defs[0][1])),
                        'public' => $defs[1], 'supports' => $defs[2], 'has_archive' => $defs[3]
                        )
                );
            }
        }
        // had to add the following to get WP to work properly with last posttype added after installation
//        global $wp_rewrite;
//        $wp_rewrite->flush_rules();
//        $wp_rewrite->init();
    }

    public function setmetafields($args) {
        if (MetaFields::hasMeta($args->post_type)) {
            add_meta_box(
                MetaFields::getMetaBoxField($args->post_type,'id'),
                MetaFields::getMetaBoxField($args->post_type,'title'),  // Meta Window title
                MetaFields::getMetaBoxField($args->post_type,'fn'),  // callback function
                $args->post_type  // Post type
            );
        }
    }

    public function save($post_id)
    {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        foreach(LrLms::$lrlms_post_types as $post_type) {
            if (MetaFields::hasMeta($post_type)) {
                foreach (MetaFields::getFields($post_type) as $key)
                    if (array_key_exists($key, $_POST)) {
                        update_post_meta(
                            $post_id,
                            $key . '_key',
                            $_POST[$key]
                        );
                    }
            }
        }
    }

    public function load($content)
    {
        global $wp_query;
        $post = $wp_query->get_queried_object();
        if($post == null) return;
        error_log('Loading post:'.$post->post_name);
        if ($post != null && $post->post_type === 'lrlms_form') {
            $event = getFormField('event', null);
            if ($event != null) {
                $this->processForm($event);
            }
            return loadView($post->post_name);
            // also:
            // do some lrlms admin checks, to allow/disallow user to create/edit course/lessons.
        }
    }

    function loadTemplates($template) {
        global $wp_query;
        $post = $wp_query->get_queried_object();
        if (isset($post) && in_array($post->post_type, LrLms::$lrlms_post_types)) {
            $template = LrLms::$pluginPath . '/frontend/html/single-lrlms_course.php';
        }
        return $template;
    }

    function setupShowCoursesInHomePage($query)
    {
        if ($query->is_home() && $query->is_main_query()) {
            $query->set('post_type', [LrLmsConstants::LRLMS_COURSE]);
        }
        return $query;
    }

    private function processForm($event) {
        global $wpdb;
        if ($event === 'coursereg') {
            $courseid = getFormField('courseid', null);
            $userid = get_current_user_id();
            $courseController = LrLms::getController('CourseController');
            if ($courseController != null) {
                if ($courseController->addUserToCourse($courseid, $userid)) {
                    addViewData("result", "success");
                    addViewData("feedback", "You have been successfully registered for the course");
                }
            }

        }

    }

    public function loadAdminMenu() {
        add_menu_page(
            'Configure LRLms',
            'LRLms Options',
            'manage_options',
            'lrlms1',
            'lrlms_options_page_html',
            plugin_dir_url(__FILE__) . 'resources/lrlms.png',
            20
        );
        add_dashboard_page(
            __( 'Welcome to LrLms',  'lrlms' ),
            __( 'Welcome to LrLms',  'lrlms' ),
            'manage_options',
            'about-lrlms',
            'lrlms_about_page_html'
        );
    }

    private function includeFiles() {
        require(LrLms::$pluginPath . 'classes/util/DbUtil.php');
        require(LrLms::$pluginPath . 'frontend/html/Fns.php');
        require(LrLms::$pluginPath . 'classes/classroom/Classroom.php');
        require(LrLms::$pluginPath . 'classes/course/LrlmsDomParser.php');
        require(LrLms::$pluginPath . 'classes/course/ParseCourse.php');
    }
}