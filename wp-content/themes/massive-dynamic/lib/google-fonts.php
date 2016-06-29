<?php

class PixflowGoogleFonts {

    protected $jsonObject = null;

    public function __construct($jsonFile)
    {
        $jsonFile = PIXFLOW_THEME_LIB_URI.'/googlefonts.json';
        $file_content = wp_remote_get(
            $jsonFile,
            array(
                "timeout" => 90,
                "sslverify" => false
            )
        );
        if(!is_array($file_content)){
            return false;
        }
        $file_contents = $file_content['body'];
        $content = $file_contents;

        if(FALSE === $content)
        {
            //Prevent access errors
            $jsonObject = new stdClass();
            $jsonObject->items = array();
            return;
        }

        $this->jsonObject = json_decode($content);
    }

    public function Pixflow_GetJson()
    {
        return $this->jsonObject;
    }

    public function Pixflow_GetFontNames()
    {
        $names = array();
        foreach($this->jsonObject->items as $font)
        {
            $key = $font->family;
            $names[$key] = $font->family;
        }

        return $names;
    }

    public function Pixflow_GetFontByName($name)
    {
        if(!is_object($this->jsonObject)){
            return;
        }
        if(is_array($this->jsonObject->items)){
            foreach($this->jsonObject->items as $font)
            {
                if($font->family == $name)
                    return $font;
            }
        }
        return null;
    }

    public function Pixflow_GetFontByURL($url)
    {
        $url = str_replace('https', 'http', $url);
        $patterns = array(
            //replace the path root
            '!^http://fonts.googleapis.com/css\?!',
            //capture the family and avoid and any following attributes in the URI.
            '!(family=[^&,\|]+).*$!',
            //delete the variable name
            '!family=!',
            //replace the plus sign
            '!\+!');
        $replacements = array("",'$1','',' ');
        $font = preg_replace($patterns,$replacements,$url);
        //split font
        $font =  explode(':', $font);
        $font_info = array();
        if(count($font)>1){
            $font_info['name'] = $font[0];
            $font_info['weight'] = $font[1];
        }else{
            $font_info['name'] = $font[0];
            $font_info['weight'] = '400';
        }
        if(!preg_match('/^[a-z][a-z -]*$/i', $font_info['name'])) {
            $font_info['name'] = '';
        }
        if($font_info['weight'] != '' && preg_match('/[^a-z 0-9]/i',  $font_info['weight'])){
            $font_info['weight'] = '';
        }
        return $font_info;
    }
}