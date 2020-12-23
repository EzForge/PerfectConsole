<?php

class _VCL
{
    private $Form, $Parameters;

    public function __construct($Form)
    {
        $this->Form &= self::get_form($Form);
        $this->Parameters = array(
            'x' => 0,
            'y' => 0,
            'w' => 0,
            'h' => 0,
            'enabled' => false,
            'clientWidth' => 0,
            'clientHeight' => 0,
            'alphaBlendValue' => 0,
            'alphaBlend' => false,
            'onShow' => function() {},
            'borderIcons' => blMinimize,
            'borderStyle' => bsNone,
            'borderWidth' => 1,
            'formStyle' => fsNormal
        );
    }


    public function pushParameters()
    {
        if (!$this->Form) {
            return false;
        }
        $keys = array_keys($this->Parameters);
        foreach ($keys as $key){
            $this->Parameters[$key] = $this->Form->{$key};
        }
        return true;
    }

    public function popParameters()
    {
        if (!$this->Form) {
            return false;
        }
        foreach ($this->Parameters as $item => $value){
            $this->Form->{$item} = $value;
        }
        return true;
    }

    public function hide($SetupMDI = true)
    {
        $Form = $this->Form;
        if (!$Form) {
            return false;
        }
        $this->pushParameters();
        $Form->x = 0;
        $Form->y = 0;
        $Form->w = 1;
        $Form->h = 1;
        $Form->enabled = false;
        $Form->clientWidth = 1;
        $Form->clientHeight = 1;
        $Form->alphaBlendValue = 0;
        $Form->alphaBlend = true;
        $Form->onShow = function () use ($Form) {
            $Form->hide();
        };
        $Form->borderIcons = biMinimize;
        $Form->borderStyle = bsNone;
        $Form->borderWidth = 1;
        if ($SetupMDI) {
            $Form->formStyle = fsMDIChild;
        }
        $Form->hide();
        return true;
    }

    public function show()
    {
        $this->popParameters();
        $this->Form->show();
    }

    public function restoreMDI()
    {
        $Form = $this->Form;
        if (!$Form) {
            return false;
        }
        $Form->formStyle = fsNormal;
        return true;
    }

    public static function get_form($_Form)
    {
        $Form = NULL;
        if (is_string($_Form)) {
            $Form = c($_Form);
        } elseif (is_object($_Form)) {
            $Form = $_Form;
        } else {
            return false;
        }
        return $Form;
    }
}