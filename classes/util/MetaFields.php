<?php
/**
 * MetaFields class
 * Author: Fernando Martinez
 */

class MetaFields
{
    static public function getFields($post_type) {
        return LrLmsConstants::POST_TYPE_META[$post_type];
    }

    static public function hasMeta($post_type) {
        return isset(LrLmsConstants::POST_TYPE_META[$post_type]);
    }

    static public function getMetaBoxField($post_type, $fieldKey) {
        return LrLmsConstants::META_BOX_FIELDS[$post_type][$fieldKey];
    }

    static public function getMetaField($post_type, $fieldKey) {
        if ($post_type.'_'.$fieldKey === 'lrlms_lesson') {
            $iii=5;
        }
        return LrLmsConstants::FIELD_DATA[$post_type.'_'.$fieldKey];
    }
}
