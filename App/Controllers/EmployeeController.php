<?php 
include_once './autoload.php';

class EmployeeController{

    public function Listener(){
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            $page = WelcomeView::Render();
            $page = str_replace("{CONTENT}", file_get_contents('./App/Views/Elements/PhoneInput'), $page);
            $page = str_replace("{CHECKBOX}", file_get_contents('./App/Views/Elements/CheckBox'), $page);
            $page = str_replace("{NUMBER}", '0', $page);
            $page = str_replace("{MODE}", '0', $page);
            echo $page;
        }   
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["mode"])){
                $mode = (int)$_POST["mode"];
                switch ($mode){
                    case Mode::Phone->value:
                        $number = (int)$_POST["number"];
                        echo $this->PhoneContentGenerator($number);
                        break;
                    case Mode::Mail->value:
                        $number = (int)$_POST["number"];
                        echo $this->MailContentGenerator($number);
                        break;
                }
            };

            if(isset($_POST["page"])){
                $page = $_POST["page"];
                switch ($page){
                    case Pages::Phone->value:
                        $page = [];
                        $page[] = file_get_contents('./App/Views/Elements/PhoneInput');
                        $page[] = str_replace('{MODE}', '0', file_get_contents('./App/Views/Elements/CheckBox'));
                        echo json_encode($page);
                        break;
                    case Pages::Mail->value:
                        $page = [];
                        $page[] = file_get_contents('./App/Views/Elements/EmailInput');
                        $page[] = str_replace('{MODE}', '1', file_get_contents('/var/www/vlad/Test/App/Views/Elements/CheckBox'));
                        echo json_encode($page);
                        break;
                    case Pages::Code->value: 
                        $data = $_POST["data"];
                        $type = (int)$_POST["type"];
                        $name = $_POST["name"];
                        echo $this->CodeGeneration($type, $data, $name);
                        break;
                }
            };
            
        }
    }

    private function PhoneContentGenerator(int $number):string{
        $html ='';
        $tamplate =file_get_contents('./App/Views/Elements/PhoneInput');
        for ($i = 0; $i < $number; $i++) {
            $paste = str_replace('{NUMBER}', $i, $tamplate);
            $paste = str_replace('{MODE}', '0', $paste);
            $html = $html.$paste;
        }

        return $html;
    }

    private function MailContentGenerator(int $number):string{
        $html ='';
        $tamplate =file_get_contents('./App/Views/Elements/EmailInput');
        for ($i = 0; $i < $number; $i++) {
            $paste = str_replace('{NUMBER}', $i, $tamplate);
            $paste = str_replace('{MODE}', '1', $paste);
            $html = $html.$paste;
        }

        return $html;
    }

    private function CodeGeneration(int $type, array $data,string $name):string{
        $list = '';
        $tamplate ='';
        switch ($type){
            case Mode::Phone->value:
                foreach($data as $element){
                    $tamplate = file_get_contents('./App/Views/Elements/TelephoneCode');
                    $content= str_replace('{FORMTEL}', $element, $tamplate);
                    $telephone = str_replace('(', '', $element);
                    $telephone = str_replace(')', '', $telephone);
                    $telephone = str_replace(' ', '', $telephone);
                    $telephone = str_replace('-', '', $telephone);
                    $content = str_replace('{TELEPHONE}', $telephone, $content);
                    $list = $list.$content;
                    $tamplate = file_get_contents('./App/Views/Elements/CodeGreen');
                }
                break;
            case Mode::Mail->value:
                foreach($data as $element){
                    $tamplate = file_get_contents('./App/Views/Elements/EmailCode');
                    $content= str_replace('{EMAIL}', $element, $tamplate);
                    $list = $list.$content;
                    $tamplate = file_get_contents('./App/Views/Elements/CodeRed');
                }
                break;
        }
        $html = str_replace('{CODE}', $list, $tamplate);
        $html = str_replace('{NAME}', $name, $html);

        $html= str_replace('<', '&lt;', $html);
        $html= str_replace('>', '&gt;', $html);
        $html= str_replace('$', '<br>', $html);

        return $html;
    }
}

?>