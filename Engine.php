<?php

class Engine
{
    private $Console;

    public function __construct()
    {
        $this->Console = new _PerfectConsole;
    }

    static function Loader($Form = false)
    {
        if ($Form) {
            _VCL::hide($Form);
        }
        $_Engine = new Engine;
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
                    $_Engine::AppClose($_Console, $Form);
                    break;
                }
            }
        });
    }

    static function AppClose($_Console, $Form = false)
    {
        $_Console->Free();
        if ($Form) {
            _VCL::restoreMDI($Form);
        }
        app::close();
    }

    public function __invoke()
    {
        return $this->Console;
    }
}