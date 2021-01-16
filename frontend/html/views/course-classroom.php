<?php
/**
 * List course classrooms
 * Fernando Martinez
 */
global $wp_query;
$courseid = $wp_query->get('page');
if ($courseid != null) {
    $classrooms = DbUtil::loadCourseClassrooms($courseid);
    if (!isset($classrooms) || count($classrooms) == 0) {
        echo('No classrooms found. <a href="'.get_site_url(null,'lrlms_form/create-classroom/').$courseid.'">Create classroom</a>');
    } else {
        foreach($classrooms as $classroom) {
            $data[] = '<a href="'.get_site_url(null,'lrlms_form/enter-classroom/').$classroom->id.'">Enter classroom</a>';
        }
        $list = new HtmlUl("classroomlist");
        $list->addData($data);
        echo($list->toHtml());
    }
}
