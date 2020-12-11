<?php

class _FFI
{
    private $Libraries;
    private $Builded;

    function __construct()
    {
        $this->Libraries = array();
        $this->Builded = false;
    }

    public function dlls_build()
    {
        if(!$this->Builded) {
            foreach ($this->Libraries as $item => $value) {
                if (!($value instanceof FFI)) {
                    $this->Libraries[$item] = new FFI(_FFI_Helper::fix($value));
                }
            }
            $this->Builded = true;
        }
    }

    public function dll_apply($name, $header)
    {
        $this->Libraries[$name] = $header;
    }

    public function __call($name, $_args)
    {
        if(!$this->Builded){
            return false;
        }
		$_name = $_args[0];
		if(isset($_args[1])){
			$args = $_args[1];
		} else {
			$args = array();
		}
		$vl = _FFI_Helper::eval_dll_args('$this->Libraries[$name]', '$_name', $args);
        return eval($vl);
    }

    static function _Loader()
    {
        $_FFI = new _FFI();
        $_FFI->dll_apply("msvcrt", "
		[lib='msvcrt.dll']
		  int system(char* _Command);
		");
        $_FFI->dll_apply("kernel32", "
		[lib='Kernel32.dll']
		  BOOL WINAPI AllocConsole();
		  BOOL FreeConsole();
		  BOOL WINAPI AttachConsole(DWORD dwProcessId);
          HANDLE WINAPI GetStdHandle(DWORD nStdHandle);
		  BOOL SetConsoleTextAttribute(HANDLE hConsoleOutput, WORD wAttributes);
          BOOL WINAPI WriteConsoleA(HANDLE hConsoleOutput, char* lpBuffer, DWORD nNumberOfCharsToWrite, LPDWORD lpNumberOfCharsWritten, LPVOID lpReserved);
          int SetConsoleTitleA(char* lpConsoleTitle);
		  DWORD GetProcessId(HANDLE Process);
		");
        $_FFI->dll_apply("user32", "
		[lib='User32.dll']
		  SHORT GetAsyncKeyState(int vKey);
		");
        $_FFI->dlls_build();

        return $_FFI;
    }
}