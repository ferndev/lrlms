<?php
/**
 * Simple static utility methods for db access
 * Author: Fernando Martinez
 */

class DbUtil {
    static public function loadSingleRow($sql, $fields) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare($sql, $fields)
        );
    }

    static public function loadMultipleRows($sql, $fields) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare($sql, $fields)
        );
    }

    static public function insertRow($tbl, $data) {
        global $wpdb;
        return $wpdb->insert($tbl, $data);
    }

    static public function loadCourse($courseid) {
        global $wpdb;
        $data = self::loadMultipleRows("select * from {$wpdb->prefix}posts p join {$wpdb->prefix}postmeta m on p.ID=m.post_id where p.ID=%d", $courseid);
        if ($data!=null) {
            $course['title'] = $data[0]->post_title;
            $course['descr'] = $data[0]->post_content;
            foreach($data as $meta) {
                if ($meta->meta_key === 'duration_key') {
                    $course['duration'] = $meta->meta_value;
                } else
                    if ($meta->meta_key === 'price_key') {
                        $course['price'] = $meta->meta_value;
                    } else
                        if ($meta->meta_key === 'emailsupport_key') {
                            $course['emailsupport'] = $meta->meta_value;
                        }
            }
            return $course;
        }
        return null;
    }

    static public function loadCourseClassrooms($courseid){
        global $wpdb;
        return self::loadMultipleRows("SELECT * FROM {$wpdb->prefix}classroom WHERE courseid = %d", $courseid);
    }

    static public function loadClassrooms($where, $fields){
        global $wpdb;
        return self::loadMultipleRows("SELECT * FROM {$wpdb->prefix}classroom WHERE ".$where, $fields);
    }

    static public function count($tbl, $where, $fields) {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("select count(*) from ".$tbl." where ".$where, $fields));
    }
}
