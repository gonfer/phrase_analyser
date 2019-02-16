<?php

use PHPUnit\Framework\TestCase;

final class analyserTest extends TestCase{

    /**
     * testBuild
     *
     * @return void
     */
    public function testBuild(){
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = array('texttoanalyse'=>'Text to analyse.'); 
        $texttoanalyse = strtolower($_POST['texttoanalyse']);

        require_once("./inc/analyser.class.php");

        $analyser->build_stats($texttoanalyse);
        $this->assertNotNull($analyser->_character_found);
        $this->assertNotNull($analyser->_character_count);
        $this->assertNotNull($analyser->_character_before);
        $this->assertNotNull($analyser->_character_after);
        $this->assertNotNull($analyser->_character_distance);

        $expected = array("t","e","x","o","a","n","l","y","s",".");
        $this->assertEquals($expected , $analyser->_character_found);

        $expected = array("t" => 3,"e" => 2,"x" => 1,"o" => 1,"a" => 2,"n" => 1,"l" => 1,"y" => 1,"s" => 1,"." => 1);
        $this->assertEquals($expected ,$analyser->_character_count);

        $expected = array(
            0 => "",
            1 => 't',
            2 => 'e',
            3 => 'x',
            4 => 't',
            5 => 't',
            6 => 'o',
            7 => 'a',
            8 => 'n',
            9 => 'a',
            10 => 'l',
            11 => 'y',
            12 => 's',
            13 => 'e'
        );

        $this->assertEquals($expected ,$analyser->_character_before);

        $expected = array(
            0 => 'e',
            1 => 'x',
            2 => 't',
            3 => 't',
            4 => 'o',
            5 => 'a',
            6 => 'n',
            7 => 'a',
            8 => 'l',
            9 => 'y',
            10 => 's',
            11 => 'e',
            12 => '.',
            13 => ''
        );

        $this->assertEquals($expected ,$analyser->_character_after);

        $expected = array(
            't' => 4,
            'e' => 11,
            'a' => 6
        );

        $this->assertEquals($expected ,$analyser->_character_distance);

    }
    

}
