<?php

class Engine
{
	public $VCL, $Console;

    public function __construct($Form)
    {
        $this->Console = new _PerfectConsole;
        $this->VCL = new _VCL($Form);
    }

    public static function Loader($Form = false)
    {
        $_Engine = new Engine($Form);
		
        if($Form){
            $_Engine->VCL->hide();
        }
		
        $_Engine->Console->Allocate();
        $_Engine->Console->SetTitle("PerfectConsole");
        $_Engine->Console->Printf("Hello world!", "\n");
		$_Engine->Console->Printf("Press space to exit", "\n");
		
		while (1) {
			if ($_Engine->Console->GetKeyState(VK_SPACE)) {
				$_Engine->Console->Printf("Exit after 3 seconds", "\n");
				usleep(3000000);
				Engine::AppClose($_Engine);
				break;
			}
        }
    }

    public static function AppClose($_Engine)
    {
        $_Engine->Console->Free();
        $_Engine->VCL->restoreMDI();
        app::close();
    }
}