<?php
/**
 * Create a new classroom for a course
 * Fernando Martinez
 *
 */
global $wp_query, $wpdb;
$courseid = $wp_query->get('page');
if ($courseid != null) {
    if (Classroom::createClassroom($courseid,1,'') == 1) {
        $id = $wpdb->insert_id;
        if ($id != null) {
            echo('Classroom successfully created. <a href="'.get_site_url(null,'lrlms_form/enter-classroom/').$id.'">Enter classroom</a>');
        }
    }
}
