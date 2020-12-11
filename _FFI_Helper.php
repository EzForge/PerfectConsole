<?php

class _FFI_Helper
{
    static function fix($type)
    {
        $arr = array(
            'boolean ' => 'sint8 ',
            'bool ' => 'int ',
            'BOOL ' => 'int ',
            'LPDWORD ' => 'int ',
            'DWORD ' => 'int ',
            'byte ' => 'int ',
            'integer ' => 'int ',
            'string ' => 'char *',
            'uint ' => 'int ',
            'cardinal ' => 'int ',
			'short ' => 'int ',
			'SHORT ' => 'int ',
            'LPSTR ' => 'char *',
            'LPCSTR ' => 'char *',
            'LPCTSTR ' => 'char *',
            'LPVOID ' => 'int ',
            'LCID ' => 'uint32 ',
            'HWND ' => 'int ',
            'WINAPI ' => '',
            'HANDLE ' => 'int '
        );

        return str_ireplace(array_keys($arr), array_values($arr), $type);
    }

    static function array2_to_array(&$args)
    {
        $i = 0;
        while (1) {
            if ($i >= sizeof($args)) {
                break;
            }
            if (is_array($args[$i])) {
                $as = $args[$i];
                unset($args[$i]);
                foreach ($as as $ad) {
                    if (is_array($ad)) {
                        self::array2_to_array($ad);
                    }
                    $args[] = $ad;
                }
            }
            $i += 1;
        }
        $args = array_values($args);
    }

    static function eval_dll_args($path_to_ffi, $var_func_name, $args)
    {
        _FFI_Helper::array2_to_array($args);
        $evl = '$_args = json_decode(\'' . json_encode($args) . '\', true);' ."\n";
        $evl .= 'return '.$path_to_ffi.'->{'.$var_func_name.'}(';
        foreach($args as $argi => $argv){
            $evl .= '$_args[' . $argi . ']' . (sizeof($args)-1 == $argi ? "" : ",");
        }
        $evl .= ");";
        return $evl;
    }
}