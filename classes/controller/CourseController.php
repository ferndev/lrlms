<?php
/**
 * Course controller
 * Author: Fernando Martinez
 *
 */

class CourseController {
    public static function addUserToCourse($courseid, $userid) {
        global $wpdb;
        if ($courseid != null && $userid != null) {
            return DbUtil::insertRow("{$wpdb->prefix}course_users", ['courseid' => $courseid, 'userid' => $userid]);
        }
    }
}
