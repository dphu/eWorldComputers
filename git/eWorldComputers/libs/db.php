<?php

// +-------------------------------------------------------------------------+
// | Generic MySQL database access management class.  This can be used for   |
// | implementing database access in other classes requiring it.  Features   |
// | include:                                                                |
// |    - suppressing of errors messages and errors management                 |
// |    - methods to control showing of errors messages                       |
// |    - methods to perform and manage database connections and queries     |
// |    - [methods to navigate through the database resuklts and queries]    |
// |    - Begin, Commit, and Rollback database Transactions if supported     |
// |                                                                         |
// | The goal behind this class was to have an easy to extend MySQL          |
// | management                                                              |
// | class.  Hopefully, others will find it useful.                          |
// |                                                                         |
// | Note:    Although not tested on systems running PHP3, it should be      |
// |          compatible. If you run into any trouble, e-mail me with exact  |
// |          details of the problem.  This 'class' is being provided as is  |
// |          without any written warranties whatsoever.                     |
// +-------------------------------------------------------------------------+
// | Author:            Amir Khawaja                                         |
// | E-mail:            amir@gorebels.net                                    |
// | Date Created:      May 15, 2001                                         |
// | Last Modified:     $Date: 2002/06/28 20:54:12 $                         |
// | Version:           1.3.1                                                |
// | License:           GPL                                                  |
// +-------------------------------------------------------------------------+

class DB {

    /**
     * global variables
     */
    var $dbHost = 'localhost';            // default database host
    var $dbUser;                         // database login name
    var $dbPass;                          // database login password
    var $dbName;                          // database name
    var $dbLink;                          // database link identifier
    var $queryId;                         // database query identifier
    var $errors = array();                 // storage for errors messages
    var $totalRecords;                    // the total number of records received from a select statement
    var $lastInsertId;                  // last incremented value of the primary key
    var $prevId = 0;                      // previus record id. [for navigating through the db]
    var $transactionsCapable = false;    // does the server support transactions?
    var $beginWork = false;              // sentinel to keep track of active transactions
    var $queryCount = 0;

    /**
     * get and set type methods for retrieving properties.
     */
    function getQueryCount() {
        return $this->queryCount;
    }

    function getDbHost() {
        return $this->dbHost;
    }

    function getDbUser() {
        return $this->dbUser;
    }

    function getDbPass() {
        return $this->dbPass;
    }

// end function

    function getDbName() {
        return $this->dbName;
    }

// end function

    function setDbHost($value) {
        return $this->dbHost = $value;
    }

// end function

    function setDbUser($value) {
        return $this->dbUser = $value;
    }

// end function

    function setDbPass($value) {
        return $this->dbPass = $value;
    }

// end function

    function setDbName($value) {
        return $this->dbName = $value;
    }

// end function

    function getErrors() {
        return $this->errors;
    }

// end function

    /**
     * End of the Get and Set methods
     */

    /**
     * Constructor
     *
     * @param      String $dbUser, String $dbPass, String $dbName
     * @return     void
     * @access     public
     */
    function DB($dbUser, $dbPass, $dbName, $dbHost = null) {
        $this->setDbUser($dbUser);
        $this->setDbPass($dbPass);
        $this->setDbName($dbName);

        if ($dbHost != null) {
            $this->setDbHost($dbHost);
        }
    }

// end function

    /**
     * Connect to the database and change to the appropriate database.
     *
     * @param      none
     * @return     database link identifier
     * @access	   public
     * @scope      public
     */
    function connect() {
        $this->dbLink = @mysql_pconnect($this->dbHost, $this->dbUser, $this->dbPass);

        if (!$this->dbLink) {
            $this->setErrors('Unable to connect to the database.');
        }

        $t = @mysql_select_db($this->dbName, $this->dbLink);

        if (!$t) {
            $this->setErrors('Unable to change databases.');
        }

        if ($this->serverHasTransaction()) {
            $this->transactionsCapable = true;
        }

        return $this->dbLink;
    }

// end function

    /**
     * Disconnect from the mySQL database.
     *
     * @param      none
     * @return     void
     * @access     public
     * @scope      public
     */
    function disconnect() {
        $test = @mysql_close($this->dbLink);

        if (!$test) {
            $this->setErrors('Unable to close the connection.');
        }

        unset($this->dbLink);
    }

// end function

    /**
     * Stores errors messages
     *
     * @param      String $message
     * @return     String
     * @access     private
     * @scope      public
     */
    function setErrors($message) {
        return $this->errors[] = $message . ' ' . @mysql_error() . '.';
    }

// end function

    /**
     * Show any errorss that occurred.
     *
     * @param      none
     * @return     void
     * @access     public
     * @scope      public
     */
    function showErrors() {
        return;
        if ($this->hasErrors()) {
            reset($this->errors);

            $errcount = count($this->errors);    //count the number of errors messages

            echo "<p>error(s) found: <b>'$errcount'</b></p>\n";

            // print all the errors messages.
            while (list($key, $val) = each($this->errors)) {
                echo "+ $val<br>\n";
            }

            $this->resetErrors();
        }
    }

// end function

    /**
     * Checks to see if there are any errors messages that have been reported.
     *
     * @param      none
     * @return     boolean
     * @access     private
     */
    function hasErrors() {
        if (count($this->errors) > 0) {
            return true;
        } else {
            return false;
        }
    }

// end function

    /**
     * Clears all the errors messages.
     *
     * @param      none
     * @return     void
     * @access     public
     */
    function resetErrors() {
        if ($this->hasErrors()) {
            unset($this->errors);
            $this->errors = array();
        }
    }

// end function

    /**
     * Performs an SQL query.
     *
     * @param      String $sql
     * @return     int query identifier
     * @access     public
     * @scope      public
     */
    function query($sql, $debug = false) {
        if (empty($this->dbLink)) {
            // check to see if there is an open connection. If not, create one.
            $this->connect();
        }
        $this->resetErrors();

        $this->queryId = @mysql_query($sql, $this->dbLink);
        $this->queryCount++;

        if (!$this->queryId) {
            if ($this->beginWork) {
                $this->rollbackTransaction();
            }

            $this->setErrors('Unable to perform the query <b>' . $sql . '</b>.');
            if ($debug) {
                $this->showErrors();
            }
        }

        $this->prevId = 0;

        return $this->queryId;
    }

// end function

    /**
     * Grabs the records as a array.
     * [edited by MoMad to support movePrev()]
     *
     * @param      none
     * @return     array of db records
     * @access     public
     */
    function fetchRow($fetchMode = 'object') {
        if (isset($this->queryId)) {
            $this->prevId++;
            switch ($fetchMode) {
                case 'assoc':
                    return mysql_fetch_assoc($this->queryId);
                    break;
                case 'array':
                    return mysql_fetch_array($this->queryId);
                    break;
                default:
                    return mysql_fetch_object($this->queryId);
                    break;
            }
        } else {
            $this->setErrors('No query specified.');
        }
    }

// end function

    function fetchRowSet($mode = 'object') {
        if (isset($this->queryId)) {
            $rows = array();

            while ($row = $this->fetchRow($mode)) {
                $rows[] = $row;
            }

            return $rows;
        } else {
            $this->setErrors('No query specified.');
        }
    }

// end function

    /**
     * If the last query performed was an 'INSERT' statement, this method will
     * return the last inserted primary key number. This is specific to the
     * MySQL database server.
     *
     * @param        none
     * @return        int
     * @access        public
     * @scope        public
     * @since        version 1.0.1
     */
    function getLastInsertId() {
        $this->lastInsertId = @mysql_insert_id($this->dbLink);

        if (!$this->lastInsertId) {
            $this->setErrors('Unable to get the last inserted id from MySQL.');
        }

        return $this->lastInsertId;
    }

// end function

    /**
     * Counts the number of rows returned from a SELECT statement.
     *
     * @param      none
     * @return     Int
     * @access     public
     */
    function numRows() {
        $this->totalRecords = @mysql_num_rows($this->queryId);

        if (!$this->totalRecords) {
            $this->setErrors('Unable to count the number of rows returned');
            $this->totalRecords = 0;
        }

        return $this->totalRecords;
    }

// end function

    /**
     * Checks to see if there are any records that were returned from a
     * SELECT statement. If so, returns true, otherwise false.
     *
     * @param      none
     * @return     boolean
     * @access     public
     */
    function resultExist() {
        if (isset($this->queryId) && ($this->numRows() > 0)) {
            return true;
        }

        return false;
    }

// end function

    /**
     * Clears any records in memory associated with a result set.
     *
     * @param      Int $result
     * @return     void
     * @access     public
     */
    function clear($result = 0) {
        if ($result != 0) {
            $t = @mysql_free_result($result);

            if (!$t) {
                $this->setErrors('Unable to free the results from memory');
            }
        } else {
            if (isset($this->queryId)) {
                $t = @mysql_free_result($this->queryId);

                if (!$t) {
                    $this->setErrors('Unable to free the results from memory (internal).');
                }
            } else {
                $this->setErrors('No SELECT query performed, so nothing to clear.');
            }
        }
    }

// end function

    /**
     * Checks to see whether or not the MySQL server supports transactions.
     *
     * @param      none
     * @return     bool
     * @access     public
     */
    function serverHasTransaction() {
        $this->query('SHOW VARIABLES');

        if ($this->resultExist()) {
            while ($record = $this->fetchRow()) {
                if ($record->Variable_name == 'have_bdb' && $record->Value == 'YES') {
                    $this->transactionsCapable = true;
                    return true;
                }

                if ($record->Variable_name == 'have_gemini' && $record->Value == 'YES') {
                    $this->transactionsCapable = true;
                    return true;
                }

                if ($record->Variable_name == 'have_innodb' && $record->Value == 'YES') {
                    $this->transactionsCapable = true;
                    return true;
                }
            }
        }

        return false;
    }

// end function

    /**
     * Start a transaction.
     *
     * @param   none
     * @return  void
     * @access  public
     */
    function beginTransaction() {
        if ($this->transactionsCapable) {
            $this->query('BEGIN');
            $this->beginWork = true;
        }
    }

// end function

    /**
     * Perform a commit to record the changes.
     *
     * @param   none
     * @return  void
     * @access  public
     */
    function commitTransaction() {
        if ($this->transactionsCapable) {
            if ($this->beginWork) {
                $this->query('COMMIT');
                $this->beginWork = false;
            }
        }
    }

    /**
     * Perform a rollback if the query fails.
     *
     * @param   none
     * @return  void
     * @access  public
     */
    function rollbackTransaction() {
        if ($this->transactionsCapable) {
            if ($this->beginWork) {
                $this->query('ROLLBACK');
                $this->beginWork = false;
            }
        }
    }

// end function

    function getEscaped($text) {
        // Reverse magic_quotes_gpc/magic_quotes_sybase effects on those vars if ON.

        if (get_magic_quotes_gpc()) {
            if (ini_get('magic_quotes_sybase')) {
                $text = str_replace("''", "'", $text);
            } else {
                $text = stripslashes($text);
            }
        } else {
            $text = $text;
        }

        /*
         * Use the appropriate escape string depending upon which version of php
         * you are running
         */

        if (version_compare(phpversion(), '4.3.0', '<')) {
            $string = mysql_escape_string($text);
        } else {
            if (empty($this->dbLink))
                $this->connect();
            $string = mysql_real_escape_string($text, $this->dbLink);
        }

        return $string;
    }

    function set_utf8() { //MY~
        @mysql_query("SET NAMES 'utf8'", $this->dbLink);
    }

    //dem record theo SQL
    function count_records_SQL($SQL = '') {//MY~
        if (empty($SQL) || !$this->dbLink) {
            return 0;
        } else {
            $this->query($SQL);
            $r = $this->fetchRow();
            foreach ($r as $k => $v) {
                return intval($v);
            }
        }
    }

    //dem record 
    function count_records($table = '', $where = '') {//MY~
        if (empty($table) || !$this->dbLink) {
            return 0;
        } else {
            if (empty($where)) {
                $clause = '';
            } else {
                $where = str_replace('where', '', strtolower($where));
                $clause = ' WHERE ' . $where . ' ';
            }
            $SQL = 'SELECT COUNT(*) AS `c` FROM `' . $table . '`' . $clause;
            $this->query($SQL);
            $r = $this->fetchRow();
            return intval($r->c);
        }
    }

}

// end class
?>
