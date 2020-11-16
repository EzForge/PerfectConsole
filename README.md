# PerfectConsole

Консольное приложение в DevelStudio 3.0 beta 2

### Как установить

0. Скачать PerfectConsole
0. Запустить PerfectConsole.dvs в DevelStudio версии 3.0 beta 2, поддержка других версий не проверялась.

### Как работает приложение

Программа работает с помощью FFI.  
Если проще, то мы просто работаем с нативными DLL.  
Например: Kernel32.dll или User32.dll.

### Пример кода

    global $Console;

    $Console = new PerfectConsole();

    $Console->Console->AllocConsole();
    $Console->Console->SetConsoleTitleA("PerfectConsole");

    $Console->printf("Hello World!\nTime: ", FOREGROUND_GREEN);
    $Console->printf(time(), FOREGROUND_RED);

    $Console->Console->FreeConsole();


### Скриншоты
![](https://prnt.sc/vk7gwg/direct)
