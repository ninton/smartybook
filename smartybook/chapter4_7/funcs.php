<?php

/**
 *  @param  string
 *  @return array
 */
function array_load($i_path)
{
    $buf = file_get_contents($i_path);
    $arr = preg_split("/[\r\n]+/", $buf, -1, PREG_SPLIT_NO_EMPTY);
    return $arr;
}

/**
 *  @param  string
 *  @return array
 */
function assoc_load($i_path)
{
    $arr = array();

    $fp = fopen($i_path, "r");
    while ($rcd = fgetcsv($fp, 10000)) {
        $key = $rcd[0];
        $val = $rcd[1];
        $arr[$key] = $val;
    }
    fclose($fp);

    return $arr;
}

/**
 *  @param  string
 *  @param  array
 *  @return array
 */
function makeTimeStamp(&$io_vars, $i_params = null)
{
/*
{html_select_date prefix="" field_array="startDate" time=$t}
↓
makeTimeStamp( $_POST, array('field_array' => 'startDate') );

{html_select_date prefix="endDate_" time=$t}
↓
makeTimeStamp( $_POST, array('prefix' => 'endDate_') );

*/
    $prefix      = '' . @$i_params['prefix'];
    $field_array = '' . @$i_params['field_array'];

    if ($field_array != '') {
        $vars =& $io_vars[$field_array];
    } else {
        $vars =& $io_vars;
    }

    $t = mktime(
        $vars[$prefix . 'Hour'  ],
        $vars[$prefix . 'Minute'],
        $vars[$prefix . 'Second'],
        $vars[$prefix . 'Month' ],
        $vars[$prefix . 'Day'   ],
        $vars[$prefix . 'Year'  ]
    );
    $vars[$prefix . 'TimeStamp'] = $t;

    return $t;
}
