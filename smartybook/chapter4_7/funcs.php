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

    $handle = fopen($i_path, "r");
    while ($rcd = fgetcsv($handle, 10000)) {
        $key = $rcd[0];
        $val = $rcd[1];
        $arr[$key] = $val;
    }
    fclose($handle);

    return $arr;
}

/**
 *  @param  string
 *  @param  array
 *  @return array
 *
 * @SuppressWarnings(PHPMD.ElseExpression)
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
    $prefix = '';
    if (isset($i_params['prefix'])) {
        $prefix = $i_params['prefix'];
    }

    $field_array = '';
    if (isset($i_params['field_array'])) {
        $field_array = $i_params['field_array'];
    }

    if ($field_array != '') {
        $vars =& $io_vars[$field_array];
    } else {
        $vars =& $io_vars;
    }

    $t_sec = mktime(
        $vars[$prefix . 'Hour'  ],
        $vars[$prefix . 'Minute'],
        $vars[$prefix . 'Second'],
        $vars[$prefix . 'Month' ],
        $vars[$prefix . 'Day'   ],
        $vars[$prefix . 'Year'  ]
    );
    $vars[$prefix . 'TimeStamp'] = $t_sec;

    return $t_sec;
}
