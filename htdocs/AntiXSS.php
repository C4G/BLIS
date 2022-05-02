<?php
/*
 * @file    : antixss.php
 * @created : Apr 18, 2010, 11:17:16 PM
 * @author  : Canberk BOLAT <canberk.bolat at gmail.com>
 * @version : v1.2 (Beta)
 * @license : GNU Public License v2.0 http://www.gnu.org/licenses/gpl-2.0.html
 * @desc    : PHP Anti-XSS Library.
 */

class AntiXSS {

    /*
     * @var        : error message
     * @description: Give your special error message.
     */
    public static $err = "XSS Detected!";
    
    /*
     * @function   : setEncoding
     * @return     : String
     * @parameters : str: Content you want to change the character encoding
     *               newEncoding: Character encoding you want set
     * @description: Convert the character encoding of the string
     *               to newEncoding from currentEncoding. currentEncoding
     *               detecting by function so you only need give str and
     *               newEncoding to the setEncoding function.
     */
    public static function setEncoding($str, $newEncoding) {
        $encodingList = mb_list_encodings();
        $currentEncoding = mb_detect_encoding($str, $encodingList);
        $changeEncoding = mb_convert_encoding($str, $newEncoding, $currentEncoding);
        
        return $changeEncoding;
    }

    /*
     * @function   : blacklistFilter
     * @return     : String
     * @parameters : str: Content you want to filter with blacklist
     * @description: Filter the content by blacklist method. Library use
     *               RSnake's XSS attack vectors. To add new attack vectors
     *               I'm continue to research.
     */
    public static function blacklistFilter($str) {
        if (preg_match("/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t(.*)>(.*)/i", $str) > 0) {
            return $str;
        } else {
            alert("Invalid character");
            return self::$err;
        }
    }

    /*
     * @function   : whitelistFilter
     * @return     : String
     * @parameters : str: Content you want to filter with blacklist
     *               whiteFilterPattern: Some patterns for filter the
     *               data types.
     * @description: Filter the content by whitelist method. To add
     *               new data types, I'm continue to research.
     */
    public static function whitelistFilter($str, $whiteFilterPattern) {

        switch ($whiteFilterPattern) {
            case "string":
                $pattern = "([a-zA-Z]+)";
            break;
            case "number":
                $pattern = "([0-9]+)";
            break;
            case "everything":
                $pattern = "(.*)";
            break;
            default:
                $pattern = "([0-9a-zA-Z]+)";
            break;
        }

        if(preg_match("/^$pattern $/i", $str) > 0) {
            return $str;
        } else {
            return self::$err;
        }
    }

    /*
     * @function   : setFilter
     * @return     : String
     * @parameters : str: Content you want to filter with blacklist
     *               filterMethod: Library have 3 method.
     *                  -Black Method
     *                  -White Method
     *                  -Gray Method
     *               filterPattern: Some patterns for filter the
     *               data types. (You can only use with whitelist filter)
     *               noHTMLTag: Use PHP's strip_tags function to
     *               remove HTML tags from content.
     * @description: Filter the content by method.
     */
    public static function setFilter($str, $filterMethod, $filterPattern = NULL, $noHTMLTag = NULL) {

        if (urldecode($str) > 0) {
            $str = urldecode($str);
        }

        if ($noHTMLTag == 1) {
            $str = strip_tags($str);
        }
        
        $str = strtolower($str);
        $str = addslashes($str);
	$str = htmlspecialchars(trim($str));

        switch($filterMethod) {
            case "black":
                $str = self::blacklistFilter($str);
            break;
            case "white":
                $str = self::whitelistFilter($str, $filterPattern);
            break;
            default:
            break;
        }

        return $str;
    }
}
?>
