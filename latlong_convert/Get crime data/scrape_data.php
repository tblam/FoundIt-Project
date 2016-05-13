<?php
include("simple_html_dom.php");
 
    $html = file_get_html("http://www.school-ratings.com/counties/San_Mateo.html");
//$html = file_get_html("http://www.school-ratings.com/school_details/01611926056956.html");   

    foreach($html->find('li [id]') as $element){ 
        //Get school name
        $name = $element->getElementByTagName('a');
        //Get school's ranking
        $rank = $element->getElementByTagName('span')->innertext;
        $rank = substr($rank, strpos($rank, ":") + 1);
        
        
        //Get school address & state rank
        $new_link = "http://www.school-ratings.com/".substr($name->href, 3);
        $html_new = file_get_html($new_link); 
        foreach($html_new->find('h1') as $element){
            $value = array();
            $value[] = explode("<br>", $element->outertext);
            $addr = $value[0][1] . " " . $value[0][2]; 
        }
        
        //Get API 
        foreach($html_new->find('tr td[colspan]') as $api){
            $api = $api->innertext;
        } 
        $api = substr($api, 0,3);  
        
        //Get type of school
        $count = 0;
        foreach($html_new->find('ul li[class]') as $element){  
            if($count == 2)
                break;
            $count++;
        }
        $element = substr($element, strpos($element, ":") + 1);  
        $arr = explode("(", $element, 2);
        $type = $arr[0];  
        
        //Print
        echo $name->innertext . ' ~ ' . $rank . ' ~ ' . $addr . ' ~ ' . $api . ' ~ ' . $type . '<br>' ;
    } 
?>
 