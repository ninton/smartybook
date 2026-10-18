<?php

/** @noinspection PhpUnused このクラスは歴史的資料として保持されています。呼ばれない関数やメソッドを含みます。 */

namespace SmartyBook\chapter5_3\src\emoji;

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
 * @param array<mixed> $vars
 * @param string $from_encode
 * @param string $to_encode
 * @return void
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection array<mixed>を許容します
 */
function emoji_convert_variables(array &$vars, string $from_encode, string $to_encode): void
{
    $emoji = Emoji::singleton($from_encode, $to_encode);
    $emoji->convertVariables($vars);
}

/**
 * @param string $buf
 * @return string|null
 */
function emoji_output_handler(string $buf): string|null
{
    $result = $buf;
    foreach (Emoji::$output_setting_arr as $setting) {
        $result = emoji_convert($result, $setting['from'], $setting['to']);
    }

    return $result;
}

/**
 * @param string $buf
 * @param string $from_encode
 * @param string $to_encode
 * @return string|null
 */
function emoji_convert(string $buf, string $from_encode, string $to_encode): string|null
{
    $emoji = Emoji::singleton($from_encode, $to_encode);
    $result = $emoji->convert($buf);
    return $result;
}

/**
 * Class Emoji
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
     * @param string $from_encode
     * @param string $to_encode
     * @return void
     */
    private function __construct(string $from_encode, string $to_encode)
    {
        $this->from_encode = $from_encode;
        $this->to_encode   = $to_encode;
        $regex_arr = $this->getRegexArr();
        $this->regex = $regex_arr[$from_encode];

        $this->load();
    }

    /**
     * @param string $from_encode
     * @param string $to_encode
     * @return Emoji
     */
    public static function singleton(string $from_encode, string $to_encode): Emoji
    {
        static $instance = [];
        if (! isset($instance[$from_encode][$to_encode])) {
            $instance[$from_encode][$to_encode] = new Emoji($from_encode, $to_encode);
        }
        return $instance[$from_encode][$to_encode];
    }


    /**
     * @param string $from_encode
     * @param string $to_encode
     * @return void
     */
    public function output_setting(string $from_encode = '', string $to_encode = ''): void
    {
        if ('' == $from_encode) {
            self::$output_setting_arr = [];
        } else {
            $setting = [
                'from' => $from_encode,
                'to'   => $to_encode,
            ];
            self::$output_setting_arr[] = $setting;
        }
    }

    /**
     * @return array<string, string>
     * @noinspection HtmlRequiredAltAttribute ezweb用 altなしを許容します
     * @noinspection HtmlUnknownAttribute ezweb用 localsrc,icon を許容します
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
        $path = __DIR__ . "/map/$fname";
        return $path;
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $text
     * @return void
     */
    public function add(string $from, string $to, string $text = ''): void
    {
        /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection switch文のままとします */
        switch ($from) {
            case '':
            case 'x':
            case '-':
                return;
        }

        $from = $this->modifier($from, $this->from_encode);

        /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection switch文のままとします */
        switch ($to) {
            case '':
            case 'x':
            case '-':
                $to = $text;
                break;

            default:
                $to = $this->modifier($to, $this->to_encode);
                break;
        }

        $this->map[ $from ] = $to;
        //var_dump( $this->map );
    }

    /**
     * @param string $buf
     * @param string $encode
     * @return string
     * @noinspection HtmlRequiredAltAttribute ezweb用 altなしを許容します
     * @noinspection HtmlUnknownAttribute ezweb用 localsrc,icon を許容します
     */
    public function modifier(string $buf, string $encode): string
    {
        $method = $this->encodeMethod($encode);
        switch ($method) {
            case 1:
                $result = sprintf('&#x%s;', $buf);
                break;

            case 2:
                $result = sprintf('&#%s;', $buf);
                break;

            case 3:
                $result = $this->pack16bin($buf);
                break;

            case 4:
                $result = $this->pack16bin($buf);
                $result = mb_convert_encoding($result, 'UTF-8', 'UCS2');
                break;

            case 5:
                $result = sprintf("\x1B\$%s\x0F", $buf);
                break;

            case 6:
                $result = sprintf('<img icon="%s">', $buf);
                break;

            case 7:
                $result = sprintf('<img localsrc="%s" />', $buf);
                break;

            default:
                $result = $buf;
                break;
        }

        return $result;
    }

    /**
     * @param string $encode
     * @return int
     */
    public function encodeMethod(string $encode): int
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
     * @param string $buf
     * @return string|null
     */
    public function convert(string $buf): string|null
    {
        $result = preg_replace_callback($this->regex, function (array $mathes): string {
            return $this->mapping($mathes[1]);
        }, $buf);

        return $result;
    }

    /**
     * @param string $buf
     * @return string
     */
    public function mapping(string $buf): string
    {
        /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection switch文のままとします */
        switch ($this->from_encode) {
            case 'e_img_num':
            case 'e_img_name':
            case 'e_icon_num':
            case 'e_icon_name':
                $result = $this->modifier($buf, $this->from_encode);
                break;

            default:
                $result = $buf;
                break;
        }

        if (isset($this->map[ $result ])) {
            $result = $this->map[ $result ];
        }

        return "$result";
    }

    /**
     * @param string $buf
     * @return string
     */
    public function pack16bin(string $buf): string
    {
        $result = '';
        if (preg_match('/^[0-9A-F]{4}$/i', $buf)) {
            $result = pack('H4', $buf);
        }

        return $result;
    }

    /**
     * @param array<mixed> $vars
     * @return void
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection array<mixed>を許容します
     */
    public function convertVariables(array &$vars): void
    {
        foreach ($vars as $key => $val) {
            if (is_array($val)) {
                $this->convertVariables($val);
            } else {
                $val = $this->convert($val);
            }

            $vars[$key] = $val;
        }
    }
}
