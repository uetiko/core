<?php
namespace test;
/**
 * Description of TestDatabase
 *
 * @author uetiko
 */
class TestDatabase extends \utils\DatabaseObject{
    protected function transactionExecute(\PDO &$connection) {
        
    }
    
    public function select(){
        $query = "select * from vendedor";
        $result = $this->runSampleQuery($query);
        foreach ($result as $row) {
            var_dump($row);
            echo "\n";
        }
    }
    public function selectRegistro(){
        $query = "select * from registro where nombre = :nombre and email = :email";
        $options = array(
            ':nombre' => 'ENRIQUE SALVADOR',
            ':email'  => 'jesalvadorh@hotmail.com'
        );
        //select * from registro where nombre = 'ENRIQUE SALVADOR' and email = 'jesalvadorh@hotmail.com'"
        $result = $this->executePrepareStatementWithBindParams($query, $options);
        var_dump($result);
    }
}

?>
