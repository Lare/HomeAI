<?php
/**
 *  \Util\Strings.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Strings
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Strings -class
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Strings
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-12-31 18:38:13 +0200 (Sat, 31 Dec 2011) $
 *  @version    $Rev: 26 $
 *  @author     $Author: lare $
 */
class Strings implements Interfaces\iStrings
{
    public static function clean($string)
    {
        return preg_replace("/\s\s+/", " ", trim($string));
    }


    public static function diff($old, $new)
    {
        $maxlen = 0;

        foreach ($old as $oindex => $ovalue)
        {
            $nkeys = array_keys($new, $ovalue);

            foreach ($nkeys as $nindex)
            {
                $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ? $matrix[$oindex - 1][$nindex - 1] + 1 : 1;

                if ($matrix[$oindex][$nindex] > $maxlen)
                {
                    $maxlen = $matrix[$oindex][$nindex];
                    $omax = $oindex + 1 - $maxlen;
                    $nmax = $nindex + 1 - $maxlen;
                }
            }
        }

        if ($maxlen == 0)
        {
            return array(
                    array(
                        'd' =>  $old,
                        'i' =>  $new,
                        )
                    );
        }

        return array_merge(
                \Util\Strings::diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
                array_slice($new, $nmax, $maxlen),
                \Util\Strings::diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
                );
    }


    public static function htmlDiff($old, $new)
    {
        $ret = '';
        $diff = \Util\Strings::diff(explode(' ', $old), explode(' ', $new));

        foreach ($diff as $k)
        {
            if (is_array($k))
            {
                $ret .= (!empty($k['d']) ? "<del>". implode(' ',$k['d']) ."</del> " : '')
                        .
                        (!empty($k['i']) ? "<ins>". implode(' ',$k['i']) ."</ins> " : '');
            }

            else
            {
                $ret .= $k . ' ';
            }
        }

        return $ret;
    }


    public static function autolink($str, $attributes=array())
    {
        $attrs = '';
        foreach ($attributes as $attribute => $value)
        {
            $attrs .= " {$attribute}=\"{$value}\"";
        }

        $str = ' ' . $str;
        $str = preg_replace(
            '`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
            '$1<a href="$2"'.$attrs.'>$2</a>',
            $str
        );
        $str = substr($str, 1);

        return $str;
    }
}

?>