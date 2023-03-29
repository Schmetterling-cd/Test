<?php 
include_once './autoload.php';

class WelcomeView 
{
    public static function Render():string{
    $vars['TITLE'] = 'List';
    $vars['BODY'] = $html = file_get_contents('./App/Views/Elements/Body');
      
    $output = new Template('./index',$vars);
    $html = $output->RenderTemplate();
    unset($output);
    return $html;
    }
}
?>