<?php

defined('_ZEXEC') or die;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * McMyAdminAPI
 *
 * @author master
 */
class McMyAdminAPI {

    private $MCMASESSIONID = "";
    private $url = "";
    private $since = -1;
    public $isLogin = FALSE;

    /**
     * 
     * @param String $url request url, like http://mc.fuckcugb.com/data.json
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * If the <b>$isLogin</b> is set to <b>TRUE</b>, this method will return immediately.
     * 
     * @param String $username
     * @param String $password <i>[Optional]</i>
     * @param String $token <i>[Optional]</i>
     * @return boolean TRUE on success. FALSE on failed.
     */
    public function Login($username, $password = "", $token = "") {
        if ($this->isLogin) {
            return TRUE;
        }
        $post = 'Username=%s&Password=%s&Token=%s&req=login';
        $url = $this->url;
        $data = sprintf($post, urlencode($username), urlencode($password), urlencode($token));
        $rel = Base::browser_request($url, $data);
        //var_dump($rel);
        if ($rel !== FALSE) {
            $json = json_decode($rel);
            if ($json->success && isset($json->MCMASESSIONID)) {
                $this->MCMASESSIONID = $json->MCMASESSIONID;
                $this->isLogin = TRUE;
                return TRUE;
            }
        }
        return FALSE;
    }

    public function SendChat($message) {
        $post = 'Message=%s&req=sendchat&MCMASESSIONID=%s';
        $url = $this->url;
        $data = sprintf($post, urlencode($message), urlencode($this->MCMASESSIONID));
        $rel = Base::browser_request($url, $data);
        if ($rel === FALSE || json_decode($rel)->success) {
            return FALSE;
        } else {
            return TRUE;
        }
        //var_dump($rel);
    }

    /**
     * 
     * @param Int $since <i>[Optional]</i> Default is the <i>timestamp</i> variable returned from remote server last time. <i>since</i> variable is initialized with -1, which means request all available chats.
     * @return boolean
     */
    public function GetChat($since) {
        $fuck;
        if (!isset($since)) {
            $fuck = $this->since;
        } else {
            $fuck = $since;
            $this->since = $since;
        }
        $post = 'Since=%s&req=getchat&MCMASESSIONID=%s';
        $url = $this->url;
        $data = sprintf($post, urlencode($fuck), urlencode($this->MCMASESSIONID));
        $rel = Base::browser_request($url, $data);
        if ($rel !== FALSE) {
            $json = json_decode($rel);
            if ($json->status == 200) {
                $this->since = $json->timestamp;
                // var_dump($json);
                return json_encode($json->chatdata);
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * /Fill blocks in the game.<br>
     * Arguments will be passed to the game whitout syntax check by calling the <i>SendChat</i> method directly.<br>
     * If the func_num_args() is no more than 6, and the first argument is an array, this array will be treat as filled with required arguments and will passed to the game separately, and other arguments will be ignored.<br>
     * ===========================================<br>
     * <i>instruction from:http://minecraft.gamepedia.com/Commands</i><br>
     * <b>Syntax:</b><br>
     * &nbsp;&nbsp;&nbsp;&nbsp;fill <x1> <y1> <z1> <x2> <y2> <z2> <TileName> [dataValue] [oldBlockHandling] [dataTag]<br>
     * The fill command also has an optional alternate syntax when using the replace option:<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;fill <x1> <y1> <z1> <x2> <y2> <z2> <TileName> <dataValue> replace [replaceTileName] [replaceDataValue]<br>
     * <b>Arguments：</b><br>
     * &nbsp;&nbsp;&nbsp;&nbsp;x1 y1 z1 and x2 y2 z2<br>
     * Specifies any two opposing corner blocks of the region to be filled (the "fill region"). May use tilde notation to specify distances relative to the command's execution.<br>
     * The blocks that make up the corners extend in the positive direction from the coordinates used to identify them. Because of this, the lesser coordinates of each axis will be right on the region boundary, but the greater coordinates will be one block from the boundary, and the block volume of the source region will be (xgreater - xlesser + 1) × (ygreater - ylesser + 1) × (zgreater - zlesser + 1). For example, 0 0 0 0 0 0 has a 1-block volume, and 0 0 0 1 1 1 and 1 1 1 0 0 0 both identify the same region with an 8-block volume.<br>
     * <b>TileName</b><br>
     * Specifies the block to fill the region with. Must be a block id (for example, minecraft:stone).<br>
     * <b>dataValue (optional)</b><br>
     * Specifies the block data to use for the fill block. Must be between 0 and 15 (inclusive).<br>
     * <b>oldBlockHandling (optional)</b><br>
     * Must be one of:<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;destroy - Replaces all blocks (including air) in the fill region with the specified block, dropping the existing blocks (including those that are unchanged) and block contents as entities as if they had been mined with an unenchanted diamond shovel or pickaxe. (Blocks that can only be mined with shears, such as vines, will not drop; neither will liquids.)<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;hollow - Replaces only blocks on the outer edge of the fill region with the specified block. Inner blocks are changed to air, dropping their contents as entities but not themselves.<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;keep - Replaces only air blocks in the fill region with the specified block.<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;outline - Replaces only blocks on the outer edge of the fill region with the specified block. Inner blocks are not affected.<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;replace - Replaces all blocks (including air) in the fill region with the specified block, without dropping blocks or block contents as entities. Optionally, instead of specifying a data tag for the replacing block, block id and data values may be specified to limit which blocks are replaced (see replaceTileName and replaceDataValue below)<br>
     * If not specified, defaults to replace.<br>
     * <b>dataTag (optional)</b><br>
     * Specifies the data tag to use for the fill block (for example, contents of a chest, patterns on a banner, etc.). Must be a compound NBT tag (for example, {CustomName:Fred}). Cannot be combined with the replaceTileName and replaceDataValue arguments.<br>
     * <b>replaceTileName replaceDataValue (optional)</b><br>
     * Arguments are only valid when oldBlockHandling is replace. Cannot be combined with the dataTag argument.<br>
     * Specifies the block id and data of the blocks in the fill region to be replaced. If replaceDataValue is not specified, data value is ignored when determining which blocks to replace. If both arguments are not specified, replaces all blocks in the fill region.<br>
     * <b>Result</b><br>
     * Fails if the arguments are not specified correctly, if the fill region is not rendered, if the block volume of the fill region is greater than 32768, if dataValue or dataTag are invalid for the specified block id, or if no blocks were changed.<br>
     * On success, changes blocks in the fill region to the specified block.<br>
     * 
     * @param type $x1
     * @param type $y1
     * @param type $z1
     * @param type $x2
     * @param type $y2
     * @param type $z2
     * @param type $TileName
     * @param type $dataValue
     * @param type $oldBlockHandling
     * @param type $others
     */
    public function Fill($x1, $y1, $z1, $x2, $y2, $z2, $TileName, $dataValue, $oldBlockHandling = '', $others = null) {
        $args;
        if (func_num_args() <= 6 && is_array($x1)) {
            $args = &$x1;
        } else {
            $args = func_get_args();
        }
        $data = '/fill ';
        $data .= join(' ', $args);
        return $this->SendChat($data);
    }

    public function Diagnose() {
        $data = ['url' => $this->url, 'MCMASESSIONID' => $this->MCMASESSIONID, 'since' => $this->since, 'isLogin' => $this->isLogin];
        var_dump($data);
        return $data;
    }

}
