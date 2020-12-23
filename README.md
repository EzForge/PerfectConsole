# PerfectConsole
 
Консольное приложение в DevelStudio 3.0 beta 2

### Как установить

0. Создать новый проект в Devel Studio
0. Создать папку scripts в директории проекта
0. Перенести PerfectConsole в папку scripts

### Как работает приложение

Программа работает с помощью FFI.  
Если проще, то мы просто работаем с нативными DLL.  
Например: Kernel32.dll или User32.dll.

### Пример кода

    $_Console = new _PerfectConsole;
    $_Console->Allocate();
    $_Console->SetTitle("My new console");
    $_Console->Echof("Hello world!\n");
    $_Console->Echof("Press space to exit;\n");
    while(1) {
        if ($_Console->GetKeyState(VK_SPACE)){
    		$_Console->Echof("Exit after 3 seconds");
    		usleep(3000000); // 3 000 000 - microseconds
    		$_Console->Free();
    		break;
        }
    }
 
### Скриншоты
![](https://prnt.sc/vk7gwg/direct)
