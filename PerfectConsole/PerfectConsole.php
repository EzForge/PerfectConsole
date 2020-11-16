<?php

define('STD_INPUT_HANDLE', 0xFFFFFFF6);
define('STD_OUTPUT_HANDLE', 0xFFFFFFF5);
define('STD_ERROR_HANDLE', 0xFFFFFFF4);
define('INVALID_HANDLE_VALUE', 0xFFFFFFFF);
define('FOREGROUND_BLUE', 0x0001);
define('FOREGROUND_GREEN', 0x0002);
define('FOREGROUND_RED', 0x0004);
define('FOREGROUND_INTENSITY', 0x0008);
define('BACKGROUND_BLUE', 0x0010);
define('BACKGROUND_GREEN', 0x0020);
define('BACKGROUND_RED', 0x0040);
define('BACKGROUND_INTENSITY', 0x0080);

class PerfectConsole {

    public static $Console;
    protected $StdHandleOutput;

    public function __construct() {
        $this->StdHandleOutput = 0;
        $this->Console = new FFI('
            [lib='."'Kernel32.dll'".']
                int AllocConsole();
                int FreeConsole();
                int SetConsoleTitleA(char *lpConsoleTitle);
                int WriteConsoleA(int hConsoleOutput, char *lpBuffer, DWORD nNumberOfCharsToWrite, int lpNumberOfCharsWritten, int lpReserved);
                int GetStdHandle(DWORD nStdHandle);
                int SetConsoleTextAttribute(int hConsoleOutput, WORD wAttributes);
                DWORD GetConsoleTitleA(char *lpConsoleTitle, DWORD nSize)
                int GetStdHandle(DWORD nStdHandle);

            [lib='."'User32.dll'".']
                SHORT GetAsyncKeyState(int vKey);
        ');
    }
    
    public function getStdHandleOutput()
    {
		if($this->StdHandleOutput == 0){
			$this->StdHandleOutput = $this->Console->GetStdHandle(STD_OUTPUT_HANDLE);
		}
		return $this->StdHandleOutput;
    }
    
    public function printf($string, $attributes = NULL)
    {
   		if($attributes == NULL) {
			$attributes = FOREGROUND_RED   | FOREGROUND_GREEN | FOREGROUND_BLUE;
    	}
    	
    	$this->Console->SetConsoleTextAttribute($this->getStdHandleOutput(), $attributes);
    	$this->Console->WriteConsoleA($this->getStdHandleOutput(), $string, strlen($string), NULL, NULL);
    }

}

global $Console;

$Console = new PerfectConsole();

$Console->Console->AllocConsole();
$Console->Console->SetConsoleTitleA("PerfectConsole");

$Console->printf("Press 'SPACE' to get surprise\n");

thread_inPool(NULL, function(){
    global $Console;
	while(1) {
		if ($Console->Console->GetAsyncKeyState(VK_SPACE) == -32767){
			$Console->printf(
				"HELLO WORLD!\n",
				((rand(1, 4)) |
				((rand(0, 1) ? rand(1, 4) : 8)) |
				((rand(0, 1) ? rand(1, 4) : 8)))
			);
			if (rand(0, 20) == 10){
                break;
			}
		}
	}
	$Console->printf("Finish.\n");
	sleep(1);
	$Console->Console->FreeConsole();
	application_terminate();
});