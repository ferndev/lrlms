<?php
/**
 * LrLms functions
 * Author: Fernando Martinez
 */
defined( 'ABSPATH' ) || exit();

function lrlms_options_page_html() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "lrlms_options"
            settings_fields('lrlms_options');
            // output setting sections and their fields
            // (sections are registered for "lrlms", each field is registered to a specific section)
            do_settings_sections('lrlms');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

function lrlms_about_page_html() {
    ?>
    <div class="wrap">
        <h1><?php printf( esc_html__("Welcome to LrLms"));?></h1>
        <p><?php printf( esc_html__("LrLms or Learn right LMS, allows you to create sophisticated courses, with non-linear, conditional navigation, that you can email to anyone, can be viewed with one of our standalone, mobile and web-based viewers, or via our Wordpress plugin."));?>
        </p>
    </div>
    <?php
}

function lesson_ed_fields($post) {
    $lessontype = get_post_meta($post->ID, 'lessontype_key', true);
    $quiztype = get_post_meta($post->ID, 'quiztype_key', true);
?>
    <div class="wrap">
        <div>
        Enter quiz type <input type="text" name="quiztype" value="<?php echo($quiztype);?>">
        </div>
        <div>
        Enter lesson type <select name="lessontype">
            <option name="opt1" <?php selected($lessontype, 'L1'); ?>>L1</option>
            <option name="opt2" <?php selected($lessontype, 'L2'); ?>>L2</option>
            <option name="opt3" <?php selected($lessontype, 'L3'); ?>>L3</option>
        </select>
        </div>
    </div>
    <?php
}

function lrlms_ed_fields($post) {
    $html = new HtmlDiv('','','wrap');
    $fields = MetaFields::getFields($post->post_type);
    if ($post->post_type === LrLmsConstants::LRLMS_COURSE) {
        setCurrentCourseData($post);
    }
    if ($post->post_type === LrLmsConstants::LRLMS_LESSON) {
        LrLms::$courseTitle = get_post_meta(-1, 'edited_courseTitle_key', true);
        LrLms::$courseId = get_post_meta(-1, 'edited_courseId_key', true);
    }
    foreach($fields as $field) {
        $values[$field] = get_post_meta($post->ID, $field.'_key', true);
        $meta[$field] = MetaFields::getMetaField($post->post_type, $field);
        switch ($meta[$field]['type']) {
            case 'text':
                $val = $values[$field];
                if ($field === 'coursetitle' && empty($val) && !empty(LrLms::$courseTitle)) $val = LrLms::$courseTitle;
                $htmlInput = new HtmlInput('text',$field,$val);
                $htmlDiv = new HtmlDiv($meta[$field]['label'].' '.$htmlInput->toHtml());
                $html->addContent($htmlDiv->toHtml());
                break;
            case 'select':
                $htmlSelect = new HtmlSelect($field);
                $opts = explode(',',$meta[$field]['options']);
                foreach($opts as $opt) {
                    $sel=false;
                    if ($values[$field] === $opt) {
                        $sel=true;
                    }
                    $htmlSelect->addElement(new HtmlOption($opt,$opt,$opt,'','',$sel));
                }
                $htmlDiv = new HtmlDiv($meta[$field]['label'].' '.$htmlSelect->toHtml());
                $html->addContent($htmlDiv->toHtml());
                break;
            case 'hidden':
                $val = $values[$field];
                $fieldName = $field;
                if ($field === 'courseid') {
                    if (empty($post->post_parent)) {
                        if (empty($val)) {
                            if (!empty(LrLms::$courseId)) $val = LrLms::$courseId;
                        }
                        $fieldName = 'post_parent';
                    }
                }
                $htmlInput = new HtmlInput('hidden',$fieldName, $val);
                $html->addContent($htmlInput->toHtml());
                break;
        }
    }
    ?>
    <div class="wrap">
        <?php echo($html->toHtml());?>
    </div>
    <?php
}

function lrlms_get_template_part($slug, $name = '') {
    $template = '';

    if ( $name) {
        $template = locate_template( array( "{$slug}-{$name}.php", LrLms::$pluginPath."{$slug}-{$name}.php" ) );
    }

    if ( !$template && $name && file_exists( LrLms::$pluginPath . "/frontend/html/templates/{$slug}-{$name}.php" ) ) {
        $template = LrLms::$pluginPath . "/frontend/html/templates/{$slug}-{$name}.php";
    }

    if ( ! $template) {
        $template = locate_template( array( "{$slug}.php", LrLms::$pluginPath . "{$slug}.php" ) );
    }

    $template = apply_filters( 'lrlms_get_template_part', $template, $slug, $name );
    error_log('in lrlms_get_template_part, and template is '.$template);
    if ($template) {
        load_template( $template, false );
    }
}

function loadLrLmsMetaData() {
    global $wp_query;
    $post = $wp_query->get_queried_object();
    if ($post == null && $wp_query!=null) {
        $posts = $wp_query->posts;
        if ($posts!=null && count($posts) == 1) {
            $post = $posts[0];
        }
    }
    error_log('loading metadata for '.$post->post_type);
    if ($post != null && in_array($post->post_type, LrLms::$lrlms_post_types)) {
        error_log('loading content with id:'.$post->ID);

        if (MetaFields::hasMeta($post->post_type)) {
            $fields = MetaFields::getFields($post->post_type);
            if (isset($fields)) {
                $metaData = array();
                foreach ($fields as $field) {
                    $value = get_post_meta($post->ID, $field . '_key', true);
                    if ($value != null) {
                        $metaData[$field . '_key'] = $value;
                    }
                }
                if (count($metaData) > 0) {
                    //extract($metaData, EXTR_OVERWRITE); // not working as desired!!!
                    foreach ($metaData as $key => $var) {
                        global $$key;
                        if ($var !== null) $$key = $var;
                    }

                }
            }
        }
    } else {
        error_log('post might be null');
    }
}

function loadView($viewName) {
    $path = LrLms::$pluginPath . '/frontend/html/views/';
    if (isset(LrLmsConstants::LRLMS_VIEWS[$viewName])) $viewName = LrLmsConstants::LRLMS_VIEWS[$viewName];
    $path .= $viewName.'.php';
    ob_start();
    // compat until I convert all the existing outputters to use `get_output()`
    require_once $path;
    return ob_get_clean();
}

function setCurrentCourseData($post) {
    if (!($post->post_type === LrLmsConstants::LRLMS_COURSE)) return;
    update_post_meta(-1,'edited_courseId_key', $post->ID);
    update_post_meta(-1,'edited_courseTitle_key', $post->post_title);
}

function getLrLmsGlobalValue($key) {
    if (isset($GLOBALS[$key])) {
        return $GLOBALS[$key];
    }
    return '';
}

function currentPostType() {
    global $wp_query;
    $post = $wp_query->get_queried_object();
    if ($post == null && $wp_query!=null) {
        $posts = $wp_query->posts;
        if ($posts!=null && count($posts) == 1) {
            $post = $posts[0];
        }
    }
    if ($post!=null) return $post->post_type;
    return 'unknown';
}

function addViewData($key, $value) {
    global $$key;
    if($value !== null) $$key = $value;
}

function addView($viewName, $viewData) {
    global ${$viewName.'_view'};
    if ($viewData !== null) ${$viewName.'_view'} = $viewData;
}

function isUserRegistered($userid, $courseid) {
    global $wpdb;
    $count = DbUtil::count("{$wpdb->prefix}course_users", "courseid=%d and userid=%d", [$courseid, $userid]);
    return ($count != null && $count !== "0");
}

function getFormField($field, $default = '') {
    return empty($_POST[$field]) ? $default : $_POST[$field];
}

function &newObj($object, $args = null) {
    if ($args == null) {
        $obj = new $object();
        return $obj;
    } else {
        $obj = new $object($args);
        return $obj;
    }
}
