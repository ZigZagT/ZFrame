<?php
defined('_ZEXEC') or die;
class HTML {
    public static function markedImg($url, $width = null, $height = null, $extra = "") {
        $html = '<img src="%s" %s %s>';
        $src = ZPATH_IMAGE_SERVER . '/basic/small.gif';
        $imgSrc = "";
        $other = "";
        if (!empty($url)) {
            $imgSrc = "imgsrc=\"{$url}\"";
        }
        if (!empty($width)) {
            $other .= ' width="%s" ';
            $other = sprintf($other, $width);
        }
        if (!empty($height) ) {
            $other .= ' height="%s" ';
            $other = sprintf($other, $height);
        }
        if (!empty($extra)) {
            $other .= $extra;
        }
        $html = sprintf($html, $src, $imgSrc, $other);
        return $html;
    }
}
