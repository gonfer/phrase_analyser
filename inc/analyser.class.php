<?php


class analyser{

    protected $_character_found = array();
    protected $_character_count = array();
    protected $_character_before = array();
    protected $_character_after = array();
    protected $_character_distance = array();
    protected $_stripped_text = "";

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(){}

    /**
     * init
     *
     * @return void
     */
    public function init(){
        
        if(isset($_POST['texttoanalyse'])){
            $texttoanalyse = strtolower($_POST['texttoanalyse']);
            $this->build_stats($texttoanalyse);
            $this->print_stats();
        }

    }

    /**
     * build_stats
     *
     * @param  mixed $texttoanalyse
     *
     * @return void
     */
    public function build_stats($texttoanalyse){

        $this->_stripped_text = preg_replace('/\s/', '', $texttoanalyse);

        $stripped_text_arr = str_split($this->_stripped_text);

        foreach($stripped_text_arr as $key_text => $character_text){

            if( !in_array($character_text, $this->_character_found) ){
                $this->_character_found[] = $character_text;
                $this->_character_count[$character_text] = substr_count($this->_stripped_text, $character_text);

                //calculate max distance
                $max_distance = $key_text;
                foreach($stripped_text_arr as $k_text => $c_text){
                    if( ( $character_text ==  $c_text) && ( $k_text != $key_text ) ){
                        if( ( $k_text - $max_distance ) > $max_distance ){
                            $this->_character_distance[$character_text] = $k_text - $max_distance;
                        }else{
                            $this->_character_distance[$character_text] = $max_distance;
                        }
                    }
                }


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

    /**
     * print_stats
     *
     * @return void
     */
    public function print_stats(){
        echo "Text: ".$this->_stripped_text."<br>";
        echo "<table>";
        echo "<tr><td>Character</td><td>Ocurrences</td><td>Before</td><td>After</td><td>Max. Distance</td></tr>";
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

            if( ( count($before) >= 2 ) || ( count($after) >= 2 ) ) {  
                $show_distance = $this->_character_distance[$value_c];
            }else{
                $show_distance = "";
            }

            echo "<tr>";
            echo "<td>".$value_c."</td>";
            echo "<td>".$this->_character_count[$value_c]."</td>";
            echo "<td>".implode(",", $before)."</td>";
            echo "<td>".implode(",", $after)."</td>";
            echo "<td>".$show_distance."</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    }

    /**
     * __get
     *
     * @param  mixed $name
     *
     * @return void
     */
    public function __get($name){
        return $this->$name;
    }

    
}

$analyser = new analyser();
