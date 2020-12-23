<?php

class _PerfectConsole
{
    public $FFI;

    public function __construct()
    {
        $this->FFI = _FFI::_Loader();
    }

    public function GetKeyState($key)
    {
        $state = $this->FFI->user32("GetAsyncKeyState", array(
            $key
        ));
        return $state;
    }

    public function Echof($msg)
    {
        return $this->FFI->msvcrt("system", array(
            "echo " . $msg
        ));
    }

    public function Printf()
    {
        $args = func_get_args();
        $stdoutput_handle = $this->FFI->kernel32("GetStdHandle", array(
            STD_OUTPUT_HANDLE
        ));
        foreach ($args as $string) {
            $this->FFI->kernel32("WriteConsoleA", array(
                $stdoutput_handle,
                $string,
                strlen($string),
                NULL,
                NULL
            ));
        }
    }

    public function SetTitle($title)
    {
        return $this->FFI->kernel32("SetConsoleTitleA", array(
            $title
        ));
    }

    public function Allocate()
    {
        return $this->FFI->kernel32("AllocConsole");
    }

    public function Free()
    {
        return $this->FFI->kernel32("FreeConsole");
    }
}