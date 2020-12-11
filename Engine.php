<?php

class Engine
{
	private $Console;
	
	public function __construct()
	{
		$this->Console = new _PerfectConsole;
	}
	
	public function __invoke()
	{
		return $this->Console;
	}
	
	static function Loader($Form = false)
	{
		if($Form){
			_VCL::hide($Form);
		}
		$_Engine = new Engine;
		$_Console = $_Engine();
		$_Console->Allocate();
		$_Console->SetTitle("PerfectConsole");
		$_Console->Echof("Hello world!\n");
		thread_inPool(NULL, function() use ($_Console){
			$_Console->Echof("Press space to exit;\n");
			while(1){
				if ($_Console->GetKeyState(VK_SPACE)){
					$_Console->Echof("Exit after 3 seconds");
					usleep(3000000); // 3 000 000 - microseconds
					$_Console->Free();
					global $argv;
					$_Console()->msvcrt("system", array(
						'TASKKILL /F /IM ' . pathinfo($argv[0], PATHINFO_FILENAME) . ".exe" //because using '_VCL::hide'. if i use pure method 'app::close' then getting error from MDI
					));
					break;
				}
			}
		});
	}
}