<?php

class Engine
{
    private $Console;

    public function __construct($Form)
    {
        $this->Console = new _PerfectConsole;
        $this->VCL = new _VCL($Form);
    }

    public function __invoke()
    {
        return $this->Console;
    }

    public static function Loader($Form = false)
    {
        $_Engine = new Engine($Form);
        if($Form){
            $_Engine->hide();
        }
        $_Console = $_Engine();
        $_Console->Allocate();
        $_Console->SetTitle("PerfectConsole");
        $_Console->Printf("Hello world!", "\n");
        thread_inPool(NULL, function () use ($_Engine, $Form) {
            $_Console = $_Engine();
            $_Console->Printf("Press space to exit", "\n");
            while (1) {
                if ($_Console->GetKeyState(VK_SPACE)) {
                    $_Console->Printf("Exit after 3 seconds", "\n");
                    usleep(3000000); // 3 000 000 - 3 sec in microseconds
                    $_Engine::AppClose($_Console);
                    break;
                }
            }
        });
    }

    public static function AppClose($_Engine)
    {
        $_Engine()->Free();
        $_Engine->VCL->restoreMDI();
        app::close();
    }
}