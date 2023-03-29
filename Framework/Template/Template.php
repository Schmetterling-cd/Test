<?php
include_once './autoload.php';
class Template
{
    public $template;
    public $vars;

    public function __construct($template, $vars)
    {
        $this->template = $template;
        $this->vars = $vars;
    }

    function RenderTemplate(){
        $html = file_get_contents($this->template);
        $html = str_replace("{TITLE}", $this->vars['TITLE'], $html);
        $html = str_replace('{BODY}', $this->vars['BODY'], $html);
        return ($html);
    }
}
?>