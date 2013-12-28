<?php

namespace core\datalayer;

use \PDO;
use \PDOException;
use config\DBConfig;

/**
 * Contiene métodos para consultar a la base de datos mediante pdo.
 * @package core
 * @subpackage datalayer
 * @version 0.1
 * @author Angel Barrientos <uetiko@nyxtechnology.com>
 */
abstract class DatabaseObject {

    private $cnn = NULL;
    private $config = null;

    public function __construct() {
        $this->config = new DBConfig();
        $this->cnn = $this->getIntsanceDBConnection();
    }

    /**
     * 
     * @return PDO
     */
    protected function getIntsanceDBConnection() {
        if (!$this->cnn instanceof \PDO) {
            $this->cnn = new PDO($this->config->getStringConnection(), $this->config->getUser(), $this->config->getPassword());
        }
        return $this->cnn;
    }

    /**
     * 
     * @param string $sql
     * @return PDOStatement
     */
    final protected function runSampleQuery($sql) {
        try {
            return $this->cnn->query($sql);
        } catch (\PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $sql
     * @return type
     */
    final protected function executeQuery($sql, array $options = NULL) {
        $result = NULL;
        try {
            $stmt = $this->cnn->prepare($sql);
            if (!is_null($options)) {
                $stmt->execute($options);
            } else {
                $stmt->execute();
            }
        } catch (PDOException $e) {
            var_dump($e);
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    final protected function executeInsert($sql, array $values) {
        $stmt = $this->cnn->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * 
     * @param string $sql
     * @param array $options
     * @param boolean $insert
     * @return PDOStatement
     */
    final protected function executePrepareStatementWithBindParams($sql, array $options, $insert = FALSE) {
        $stmt = $this->cnn->prepare($sql);
        if (count($options) != 0) {
            foreach ($options as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        if ($insert) {
            return $stmt->execute();
        } else {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    final protected function executePrepareStatement($sql, array $options) {
        $stmt = $this->cnn->prepare($sql);
        foreach ($options as $key => $value) {
            $stmt->bindParam($key, $value);
        }
        $result = $stmt->execute($options);
        unset($stmt);
        return $result;
        
    }

    /**
     * Método para cerrar la conexion a la base ded atos
     */
    final protected function closeConnection() {
        $this->cnn = NULL;
    }

    /**
     * Método destructor, cierra la conección PDO
     * al destruir el objeto en el garbage collector.
     */
    protected function __destruct() {
        if (!is_null($this->cnn)) {
            $this->cnn = NULL;
        }
    }

    /**
     * Ejecuta una transacción a la base de datos.
     */
    protected function transacton() {
        try {
            $this->cnn->beginTransaction();
            $this->transactionExecute($this->cnn);
            $this->cnn->commit();
        } catch (\PDOException $exc) {
            $this->cnn->rollBack();
        }
    }

    abstract protected function transactionExecute(PDO &$connection);
}

?>
