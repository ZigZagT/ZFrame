<?php

defined('_ZEXEC') or die;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu
 *
 * @author master
 */
class WechatMenu
{

    /**
     *
     * @var array an array of <b>Menu</b> 
     */
    public $button = array();

}

class Menu
{
    function __construct($name)
    {
        $this->name = $name;
    }

    public $name;
    public $sub_button = array();
}

abstract class MenuItem
{

    public $type;
    public $name;

}

/**
 * @param string $type available type:<br>
 * click<br>
 * <i>view [not support]</i><br>
 * scancode_push<br>
 * scancode_waitmsg<br>
 * pic_sysphoto<br>
 * pic_photo_or_album<br>
 * pic_weixin<br>
 * location_select
 */
class MenuItem_key extends MenuItem
{

    public $key;

    function __construct($type, $name, $key)
    {
        $this->type = $type;
        $this->name = $name;
        $this->key = $key;
    }

}

/**
 * @param string $type available type:<br>
 * click<br>
 * <b>view [only support]</b><br>
 * scancode_push<br>
 * scancode_waitmsg<br>
 * pic_sysphoto<br>
 * pic_photo_or_album<br>
 * pic_weixin<br>
 * location_select
 */
class MenuItem_url extends MenuItem
{

    public $url = 'http://www.sincegrown.com/';

    function __construct($type, $name, $url)
    {
        $this->type = $type;
        $this->name = $name;
        $this->url = $url;
    }

}
