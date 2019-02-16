<?php


class analyser{

    protected $_character_found = array();
    protected $_character_count = array();
    protected $_character_before = array();
    protected $_character_after = array();
    protected $_stripped_text = "";

    public function __construct(){

    }

    public function init(){
        
        if(isset($_POST['texttoanalyse'])){
            $this->build_stats($_POST['texttoanalyse']);
            $this->print_stats();
        }

    }

    public function build_stats($texttoanalyse){

        $this->_stripped_text = preg_replace('/\s/', '', $texttoanalyse);

        $stripped_text_arr = str_split($this->_stripped_text);

        foreach($stripped_text_arr as $key_text => $character_text){

            if( !in_array($character_text, $this->_character_found) ){
                $this->_character_found[] = $character_text;
                $this->_character_count[$character_text] = substr_count($this->_stripped_text, $character_text);
            }

            if( isset($stripped_text_arr[$key_text - 1]) ){
                $this->_character_before[$key_text] = $stripped_text_arr[$key_text - 1];
            }else{
                $this->_character_before[$key_text] = "";
            }

            if( isset($stripped_text_arr[$key_text + 1]) ){
                $this->_character_after[$key_text] = $stripped_text_arr[$key_text + 1];
            }else{
                $this->_character_after[$key_text] = "";
            }


        }


    }

    public function print_stats(){
        echo "Text: ".$this->_stripped_text."<br>";
        echo "<table>";
        echo "<tr><td>Character</td><td>Ocurrences</td><td>Before</td><td>After</td></tr>";
        foreach( $this->_character_found as $key_c => $value_c ){
             
            $stripped_text_arr = str_split($this->_stripped_text);

            $before = array();
            foreach( $stripped_text_arr as $s_key => $s_value ){
                if( $s_value == $value_c ){
                    if(isset($this->_character_before[$s_key]) && ($this->_character_before[$s_key] != "") ){
                        $before[] = $this->_character_before[$s_key];
                    }
                }
            }
            $before = array_unique($before);

            $after = array();
            foreach( $stripped_text_arr as $s_key => $s_value ){
                if( $s_value == $value_c ){
                    if(isset($this->_character_after[$s_key]) && ($this->_character_after[$s_key] != "") ){
                        $after[] = $this->_character_after[$s_key];
                    }
                }
            }
            $after = array_unique($after);

            echo "<tr>";
            echo "<td>".$value_c."</td>";
            echo "<td>".$this->_character_count[$value_c]."</td>";
            echo "<td>".implode(",", $before)."</td>";
            echo "<td>".implode(",", $after)."</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    }

}

$analyser = new analyser();
$analyser->init();