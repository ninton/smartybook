<?php

namespace SmartyBook\chapter5_3\plib\emoji;

/*

    例
  ----------  ----------  ----------  ----------  ----------
     emoji_output_setting( 'i_uni16', 's_webcode' );
        emoji_output_setting( 's_uni16', 's_webcode' );
        ob_start( "emoji_output_handler" );
    ----------  ----------  ----------  ----------  ----------
     $buf = emoji_convert( $buf, 'i_uni16', 's_webcode' );
  ----------  ----------  ----------  ----------  ----------

*/
/**
 * @param array<mixed> $io_vars
 * @param string $i_from_encode
 * @param string $i_to_encode
 * @return void
 */
function emoji_convert_variables(&$io_vars, $i_from_encode, $i_to_encode): void
{
    $emoji = Emoji::singleton($i_from_encode, $i_to_encode);
    $emoji->convertVariables($io_vars);
}

/**
 * @param string $i_buf
 * @return string|null
 */
function emoji_output_handler($i_buf): string|null
{
    $buf = $i_buf;
    foreach (Emoji::$output_setting_arr as $setting) {
        $buf = emoji_convert($buf, $setting['from'], $setting['to']);
    }

    return $buf;
}

/**
 * @param string $i_buf
 * @param string $i_from_encode
 * @param string $i_to_encode
 * @return string|null
 */
function emoji_convert($i_buf, $i_from_encode, $i_to_encode): string|null
{
    $emoji = Emoji::singleton($i_from_encode, $i_to_encode);
    $buf = $emoji->convert($i_buf);
    return $buf;
}

/**
 * Class Emoji
 *
 */
class Emoji
{
    /** @var array<int, array{from: string, to: string}> */
    public static array $output_setting_arr = [];
    private string $from_encode;
    /** @var string */
    private string $to_encode;
    /** @var string */
    private string $regex;
    /** @var array<string, string> */
    private array $map;

    /**
     * @param string $i_from_encode
     * @param string $i_to_encode
     * @return void
     */
    private function __construct(string $i_from_encode, $i_to_encode)
    {
        $this->from_encode = $i_from_encode;
        $this->to_encode   = $i_to_encode;
        $regex_arr = $this->getRegexArr();
        $this->regex = $regex_arr[$i_from_encode];

        $this->load();
    }

    /**
     * @param string $i_from_encode
     * @param string $i_to_encode
     * @return Emoji
     */
    public static function singleton($i_from_encode, $i_to_encode): Emoji
    {
        static $instance = [];
        if (! isset($instance[$i_from_encode][$i_to_encode])) {
            $instance[$i_from_encode][$i_to_encode] = new Emoji($i_from_encode, $i_to_encode);
        }
        return $instance[$i_from_encode][$i_to_encode];
    }


    /**
     * @param string $i_from_encode
     * @param string $i_to_encode
     * @return void
     */
    public function output_setting($i_from_encode = '', $i_to_encode = ''): void
    {
        if ('' == $i_from_encode) {
            self::$output_setting_arr = [];
        } else {
            $setting = [
                'from' => $i_from_encode,
                'to'   => $i_to_encode,
            ];
            self::$output_setting_arr[] = $setting;
        }
    }

    /**
     * @return array<string, string>
     */
    public function getRegexArr(): array
    {
        return [
            'i_sjisbin'     => '/(\xF8[\x90-\xFF]|\xF9[\x40-\xFF])/'           ,
            'i_sjis10'      => '/(&#63[678][0-9][0-9];)/i'                     ,
            'i_sjis16'      => '/(&#x(F8[9A-F]|F9[4-9A-F])[0-9A-F];)/i'        ,
            'i_uni16'       => '/(&#x(E6|E7)[0-9A-F]{2};)/i'           ,
            'i_unibin'      => '/([\xE6\xE7].;)/'          ,
            'i_utf8'        => '/\xEE[\x98-\x9D][\x80-\xBF]/'                  ,

            'e_img_num'     => '/<img .*?localsrc=[\"]?([0-9]+)".*?>/i'        ,
            'e_img_name'    => '/<img .*?localsrc=[\"]?([0-9A-Z]+)[\"]?.*?>/i' ,
            'e_icon_num'    => '/<img .*?icon=[\"]?([0-9]+)[\"]?.*?>/i'        ,
            'e_icon_name'   => '/<img .*?icon=[\"]?([0-9A-Z]+)[\"]?.*?>/i'     ,
            'e_sjis16'      => '/(&#x(F3|F4|F6|F7)[0-9A-F]{2};)/i'             ,
            'e_sjisbin'     => '/([\xF3\xF4\xF6\xF7].)/'                       ,
            'e_uni16'       => '/(&#x(E4|E5|EA|EB)[0-9A-F]{2};)/i'             ,
            'e_unibin'      => '/([\xE4\xE5\xEA\xEB].)/'                        ,
            'e_utf8'        => '/\xEE[\x91-\x97\xA0-\xAD][\x80-\xBF]/'         ,
            'e_email_jis16' => '/(&#x7[56789AB][0-9A-F]{2};)/i'                ,
            'e_email_sjis16' => '/(&#x(EB|EC|ED|EE)[0-9A-F]{2};)/i'             ,
            'e_email_jisbin' => '/([\x75-\x7B].)/'                              ,
            'e_email_sjisbin' => '/([\xEB-\xEE].)/'                              ,

            's_uni16'       => '/(&#x(E[0-5][0-9A-F]{2};)/i'                   ,
            's_unibin'      => '/([\xE0-\xE5].)/'                              ,
            's_utf8'        => '/\xEE[\x80-\x94][\x80-\xBF]/'                  ,
            's_webcode'     => '/\x1B\$[A-Z].\x0F/i',
        ];
    }

    /**
     * @return array<int, string>
     */
    public function getEncodeArr(): array
    {
        $arr = self::getRegexArr();
        return array_keys($arr);
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->map = [];
    }

    /**
     * @return void
     */
    public function load(): void
    {
        $path = $this->mapPath();
        $this->map = [];
        $buf = file_get_contents($path);
        if ('' == $buf) {
            return;
        }
        $this->map = unserialize($buf);
    }

    /**
     * @return void
     */
    public function save(): void
    {
        $buf = serialize($this->map);
        $path = $this->mapPath();

        file_put_contents($path, $buf);
    }

    /**
     * @return string
     */
    public function mapPath(): string
    {
        $fname = "{$this->from_encode}.{$this->to_encode}.dat";
        $path = dirname(__FILE__) . "/map/$fname";
        return $path;
    }

    /**
     * @param string $i_from
     * @param string $i_to
     * @param string $i_text
     * @return void
     */
    public function add($i_from, $i_to, $i_text = ''): void
    {
        switch ($i_from) {
            case '':
            case 'x':
            case '-':
                return;
        }

        $from = $this->modifier($i_from, $this->from_encode);

        switch ($i_to) {
            case '':
            case 'x':
            case '-':
                $to = $i_text;
                break;

            default:
                $to = $this->modifier($i_to, $this->to_encode);
                break;
        }

        $this->map[ $from ] = $to;
        //var_dump( $this->map );
    }

    /**
     * @param string $i_buf
     * @param string $i_encode
     * @return string
     */
    public function modifier($i_buf, $i_encode): string
    {
        $method = $this->encodeMethod($i_encode);
        switch ($method) {
            case 1:
                $buf = sprintf('&#x%s;', $i_buf);
                break;

            case 2:
                $buf = sprintf('&#%s;', $i_buf);
                break;

            case 3:
                $buf = $this->pack16bin($i_buf);
                break;

            case 4:
                $buf = $this->pack16bin($i_buf);
                $buf = mb_convert_encoding($buf, 'UTF-8', 'UCS2');
                break;

            case 5:
                $buf = sprintf("\x1B\$%s\x0F", $i_buf);
                break;

            case 6:
                $buf = sprintf('<img icon="%s">', $i_buf);
                break;

            case 7:
                $buf = sprintf('<img localsrc="%s" />', $i_buf);
                break;

            default:
                $buf = $i_buf;
                break;
        }

        return $buf;
    }

    /**
     * @param string $encode
     * @return int
     */
    public function encodeMethod($encode): int
    {
        $method = [
            'i_uni16'  => 1,
            'i_sjis16' => 1,
            'e_sjis16' => 1,
            'e_uni16'  => 1,
            's_uni16'  => 1,

            'i_sjis10' => 2,

            'i_unibin'        => 3,
            'i_sjisbin'       => 3,
            'e_sjisbin'       => 3,
            'e_unibin'        => 3,
            'e_email_jisbin'  => 3,
            'e_email_sjisbin' => 3,
            's_unibin'        => 3,

            'i_utf8' => 4,
            'e_utf8' => 4,
            's_utf8' => 4,

            's_webcode' => 5,

            'e_icon_num'  => 6,
            'e_icon_name' => 6,

            'e_img_name' => 7,
            'e_img_num'  => 7,
        ];

        if (isset($method[$encode])) {
            return $method[$encode];
        }

        return 0;
    }

    /**
     * @param string $i_buf
     * @return string|null
     */
    public function convert($i_buf): string|null
    {
        $buf = preg_replace_callback($this->regex, function (array $mathes): string {
            return $this->mapping($mathes[1]);
        }, $i_buf);

        return $buf;
    }

    /**
     * @param string $i_buf
     * @return string
     */
    public function mapping($i_buf): string
    {
        switch ($this->from_encode) {
            case 'e_img_num':
            case 'e_img_name':
            case 'e_icon_num':
            case 'e_icon_name':
                $buf = $this->modifier($i_buf, $this->from_encode);
                break;

            default:
                $buf = $i_buf;
                break;
        }

        if (isset($this->map[ $buf ])) {
            $buf = $this->map[ $buf ];
        }

        return "$buf";
    }

    /**
     * @param string $i_buf
     * @return string
     */
    public function pack16bin($i_buf): string
    {
        $buf = '';
        if (preg_match('/^[0-9A-F]{4}$/i', $i_buf)) {
            $buf = pack('H4', $i_buf);
        }

        return $buf;
    }

    /**
     * @param array<mixed> $io_vars
     * @return void
     */
    public function convertVariables(array &$io_vars): void
    {
        foreach ($io_vars as $key => $val) {
            if (is_array($val)) {
                $this->convertVariables($val);
            } else {
                $val = $this->convert($val);
            }

            $io_vars[$key] = $val;
        }
    }
}
