<?php
/**
 * LrLmsConstants class
 * Author: Fernando Martinez
 */
defined( 'ABSPATH' ) || exit();

class LrLmsConstants
{
    const LRLMS_COURSE = 'lrlms_course';
    const LRLMS_LESSON = 'lrlms_lesson';
    const LRLMS_FORM = 'lrlms_form';

    const POST_TYPE_DEF = array(
        LrLmsConstants::LRLMS_COURSE => array(['Courses','Course'],true,array( 'title','editor','thumbnail','page-attributes','post-formats', ),true),
        LrLmsConstants::LRLMS_LESSON => array(['Lessons','Lesson'],true,array( 'title','editor','thumbnail','page-attributes','post-formats', ),true),
        LrLmsConstants::LRLMS_FORM => array(['LrLms Forms','LrLms Form'],true,array( 'title','editor','thumbnail','page-attributes','post-formats', ),true));

    const POST_TYPE_META = array(LrLmsConstants::LRLMS_COURSE => array('duration', 'price', 'emailsupport', 'visibility','migue'),
        LrLmsConstants::LRLMS_LESSON => array('courseid', 'coursetitle')
    );

    const META_BOX_FIELDS = array(
        LrLmsConstants::LRLMS_LESSON => array('id'=>'lesson_ed_fields','title'=>'Lesson Fields','fn'=>'lrlms_ed_fields'),
        LrLmsConstants::LRLMS_COURSE => array('id'=>'course_ed_fields','title'=>'Course Fields','fn'=>'lrlms_ed_fields')
        );

    const FIELD_DATA = array(LrLmsConstants::LRLMS_COURSE.'_'.LrLmsConstants::POST_TYPE_META[LrLmsConstants::LRLMS_COURSE][0] =>
        ['type'=>'text','label'=>'Enter course duration'],
        LrLmsConstants::LRLMS_COURSE.'_'.LrLmsConstants::POST_TYPE_META[LrLmsConstants::LRLMS_COURSE][1] =>
            ['type'=>'text','label'=>'Enter course price'],
        LrLmsConstants::LRLMS_COURSE.'_'.LrLmsConstants::POST_TYPE_META[LrLmsConstants::LRLMS_COURSE][2] =>
            ['type'=>'text','label'=>'E-mail support available?'],
        LrLmsConstants::LRLMS_COURSE.'_'.LrLmsConstants::POST_TYPE_META[LrLmsConstants::LRLMS_COURSE][3] =>
            ['type'=>'select','label'=>'Set visibility','options'=>'All,Group,Private'],
        LrLmsConstants::LRLMS_COURSE.'_'.LrLmsConstants::POST_TYPE_META[LrLmsConstants::LRLMS_COURSE][4] =>
            ['type'=>'select','label'=>'Set Migue','options'=>'Tall,Clever,Hungry'],
        LrLmsConstants::LRLMS_LESSON.'_'.LrLmsConstants::POST_TYPE_META[LrLmsConstants::LRLMS_LESSON][0] =>
            ['type'=>'hidden','label'=>''],
        LrLmsConstants::LRLMS_LESSON.'_'.LrLmsConstants::POST_TYPE_META[LrLmsConstants::LRLMS_LESSON][1] =>
            ['type'=>'text','label'=>'Course title']);

    const LRLMS_VIEWS = ['lrlms-course-reg' => 'user-registration'];
}
