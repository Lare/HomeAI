<?php
/**
 *  \DB\DBH.php
 *
 *  @package    HomeAI
 *  @subpackage DBH
 *  @category   Database
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace DB;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  DBH -class
 *
 *  Database handler (DBH) class. This class is used to make SQL queries
 *  to database.
 *
 *  @package    HomeAI
 *  @subpackage DBH
 *  @category   Database
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2012-11-10 14:41:07 +0200 (Sat, 10 Nov 2012) $
 *  @version    $Rev: 38 $
 *  @author     $Author: lare $
 */
class DBH implements Interfaces\iDBH
{
    /**
     *  Singleton class variable.
     *
     *  @access     protected static
     *  @var        object
     */
    protected static $instance = NULL;

    /**
     *  Actual Doctrine connection object.
     *
     *  @access     protected
     *  @var        object
     */
    protected $connection = NULL;

    /**
     *  Request object, this is used to fetch user id and other
     *  meta data for queries and error handling.
     *
     *  @access     protected
     *  @var        object
     */
    protected $request = NULL;

    /**#@+
     *  Used select query types
     *
     *  @access     public
     *  @type       static
     *  @var        integer
     */
    const SELECT_ROWS      = 1;
    const SELECT_COLUMN    = 2;
    const SELECT_ROW       = 3;
    const SELECT_COLUMNS   = 4;
    const SELECT_OBJECT    = 5;
    const SELECT_STMT      = 6;
    /**#@-*/

    /**#@+
     *  Used select query types
     */
    const PARAM_DEBUG   = 'debug';
    const PARAM_THROW   = 'throw';
    const PARAM_HISTORY = 'history';
    /**#@-*/


    /**
     *  __construct()
     *
     *  Construction of class.
     *
     *  @access     protected
     *
     *  @uses       \DB\Connection::getConnection()
     *  @uses       \Util\Request::
     *
     *  @return     void
     */
    protected function __construct()
    {
        // Create database connection
        $this->connection = Connection::getConnection();

        // Create request object
        $this->request = new \Util\Request();
    }


    /**#@+
     *  Start of static -methods.
     *
     *  @access     public
     */

    /**
     *  getInstance()
     *
     *  Instance getter method.
     *
     *  @access     public static
     *
     *  @throws     \DB\Exception
     *
     *  @uses       \DB\DBH::__construct()
     *
     *  @return     object                  Instance of DBH class.
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof DBH)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *  End of static -methods
     */
    /**#@-*/



    /**#@+
     *  Start of public -methods.
     *
     *  @access     public
     */

    /**
     *  getSchema()
     *
     *  Method returns Doctrine schema object.
     *
     *  @access     public
     *
     *  @see        \Doctrine\DBAL\Schema\AbstractSchemaManager()
     *
     *  @uses       \DB\Schema::getInstance()
     *
     *  @return     object      Doctrine schema object
     */
    public function getSchema()
    {
        return Schema::getInstance();
    }


    /**
     *  getTable()
     *
     *  Method returns Doctrine table object.
     *
     *  @access     public
     *
     *  @see        \Doctrine\DBAL\Schema\Table
     *
     *  @uses       \DB\Table::getInstance()
     *
     *  @param      string      $table      Name of the database table.
     *
     *  @return     object                  Doctrine table object
     */
    public function getTable($table)
    {
        return Table::getInstance($table);
    }


    /**
     *  getTablePrimaryKey()
     *
     *  Method returns specified table primary key columns. Note that return
     *  value varies if table contains more than one (1) primary key columns.
     *
     *  @access     public
     *
     *  @uses       \DB\Table::getInstance()
     *  @uses       \Doctrine\DBAL\Schema\Table::getPrimaryKey()
     *  @uses       \Doctrine\DBAL\Schema\Index::getColumns()
     *
     *  @param      string      $table      Table specification.
     *
     *  @return     mixed                   String or array which contains table
     *                                      primary key column names.
     */
    public function getTablePrimaryKey($table)
    {
        // Determine table primary key columns
        $columns = Table::getInstance($table)->getPrimaryKey()->getColumns();

        return (count($columns) === 1) ? current($columns) : $columns;
    }


    /**
     *  query()
     *
     *  Method makes custom SQL query with defined bindings to database. This
     *  will always return PDO statement IF the specified query was executed
     *  successfully.
     *
     *  Method accepts following extra parameters, which must be given as an
     *  array
     *
     *   -  DBH::PARAM_DEBUG (boolean)
     *   -  DBH::PARAM_THROW (boolean)
     *
     *  @access     public
     *
     *  @throws     \DB\Exception (If throw parameter is setted to true)
     *
     *  @uses       \DB\DBH::getParameterValue()
     *  @uses       \DB\DBH::determineBindsAndTypes()
     *  @uses       \DB\DBH::handleException()
     *  @uses       \Doctrine\DBAL\Connection::executeQuery()
     *
     *  @param      string      $query      SQL query to execute
     *  @param      array       $binds      Used query bindings
     *  @param      array       $params     Extra parameters
     *
     *  @return     mixed                   PDO statement object, if error
     *                                      boolean false.
     */
    public function query($query, $binds = array(), $params = array())
    {
        // Determine used extra parameters
        $debug = $this->getParameterValue(DBH::PARAM_DEBUG, $params);
        $throw = $this->getParameterValue(DBH::PARAM_THROW, $params);

        try
        {
            // Determine used query bindings and binding types
            list($_binds, $_types) = $this->determineBindsAndTypes($binds, $debug);

            // Execute actual query.
            $stmt = $this->connection->executeQuery($query, $_binds, $_types);
        }

        catch (\Exception $error)
        {
            $this->handleException($error, $throw, $debug);

            $stmt = false;
        }

        return $stmt;
    }


    /**
     *  select()
     *
     *  Method makes generic SELECT sql query with specified data. This method
     *  is very usefully when you need to fetch data from single table.
     *
     *  Method accepts following extra parameters, which must be given as an
     *  array
     *
     *   -  DBH::PARAM_DEBUG (boolean)
     *   -  DBH::PARAM_THROW (boolean)
     *
     *  @access     public
     *
     *  @throws     \DB\Exception (If throw parameter is setted to true)
     *
     *  @uses       \DB\DBH::getParameterValue()
     *  @uses       \DB\DBH::makeQuerySelect()
     *  @uses       \DB\DBH::handleException()
     *  @uses       \Doctrine\DBAL\Connection::executeQuery()
     *
     *  @param      string      $query      SQL query to execute
     *  @param      mixed       $columns    Columns to select this may be:
     *                                       NULL   = all columns
     *                                       string = single column
     *                                       array  = specified columns
     *  @param      constan     $type       Select return type, one the
     *                                      DBH::SELECT_* -constants
     *  @param      array       $params     Extra parameters
     *
     *  @return     mixed                   Return value depends on specified
     *                                      $type -variable.
     */
    public function select($table, $columns = NULL, $conds = array(), $type = DBH::SELECT_ROWS, $params = array())
    {
        // Determine used extra parameters
        $debug = $this->getParameterValue(DBH::PARAM_DEBUG, $params);
        $throw = $this->getParameterValue(DBH::PARAM_THROW, $params);

        try
        {
            // Generate actual select clause, used bindings and types.
            list($_query, $_binds, $_types) = $this->makeQuerySelect($table, $columns, $conds, $debug);

            // Execute actual query
            $stmt = $this->connection->executeQuery($_query, $_binds, $_types);

            // Determine desired output format.
            switch ($type)
            {
                case DBH::SELECT_ROWS:
                    $output = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    break;

                case DBH::SELECT_ROW:
                    $output = $stmt->fetch(\PDO::FETCH_ASSOC);
                    break;

                case DBH::SELECT_COLUMNS:
                    $output = $stmt->fetchAll(\PDO::FETCH_COLUMN);
                    break;

                case DBH::SELECT_COLUMN:
                    $output = $stmt->fetchColumn();
                    break;

                case DBH::SELECT_OBJECT:
                    $output = $stmt->fetchAll(\PDO::FETCH_OBJ);
                    break;

                case DBH::SELECT_STMT:
                    $output = $stmt;
                    break;

                default:
                    throw new Exception("Unknown query type '". $type ."'.");
                    break;
            }

            $stmt->closeCursor();
            $stmt = NULL;
        }

        catch (\Exception $error)
        {
            $this->handleException($error, $throw, $debug);

            $output = false;
        }

        return $output;
    }


    /**
     *  insert()
     *
     *  Generic INSERT method. With this you can easily insert specified data
     *  to the desired database table.
     *
     *  Method accepts following extra parameters, which must be given as an
     *  array.
     *
     *   -  DBH::PARAM_DEBUG (boolean)
     *   -  DBH::PARAM_THROW (boolean)
     *   -  DBH::PARAM_HISTORY (boolean)
     *
     *  @access     public
     *
     *  @throws     \DB\Exception (If throw parameter is setted to true)
     *
     *  @uses       \DB\DBH::getParameterValue()
     *  @uses       \DB\DBH::makeQueryInsert()
     *  @uses       \DB\DBH::handleException()
     *  @uses       \Util\Request::getSession()
     *  @uses       \Doctrine\DBAL\Connection::executeUpdate()
     *  @uses       \Doctrine\DBAL\Connection::lastInsertId()
     *
     *  @param      string      $table      Database table name
     *  @param      array       $data       Data to insert
     *  @param      array       $params     Extra parameters
     *
     *  @return     mixed                   Inserted id if all was ok, if error
     *                                      boolean false.
     */
    public function insert($table, $data, $params = array())
    {
        // Determine used extra parameters
        $debug = $this->getParameterValue(DBH::PARAM_DEBUG, $params);
        $throw = $this->getParameterValue(DBH::PARAM_THROW, $params);
        $history = $this->getParameterValue(DBH::PARAM_HISTORY, $params);

        // We wanna write history data, this is default way to do this.
        if ($history === true)
        {
            $temp = array(
                        'Stamp_Add'     =>  new \DateTime(),
                        'Stamp_Mod'     =>  new \DateTime(),
                        'User_ID_Add'   =>  $this->request->getSession(array('User', 'ID')),
                        'User_ID_Mod'   =>  $this->request->getSession(array('User', 'ID')),
                        );

            $data = array_merge($temp, $data);
        }

        try
        {
            // Generate actual insert clause, used bindings and types.
            list($_query, $_binds, $_types) = $this->makeQueryInsert($table, $data, $debug);

            // Insert were not succesfully
            if ($this->connection->executeUpdate($_query, $_binds, $_types) !== 1)
            {
                $message = "Couldn't insert data to database, please exam logs.";

                throw new Exception($message);
            }

            // Get last inserted id value
            $id = (int)$this->connection->lastInsertId();
        }

        catch (\Exception $error)
        {
            $this->handleException($error, $throw, $debug);

            $id = false;
        }

        return $id;
    }


    /**
     *  update()
     *
     *  Generic UPDATE method. With this you can easily update specified data
     *  to the desired database table with specified conditions.
     *
     *  Method accepts following extra parameters, which must be given as an
     *  array.
     *
     *   -  DBH::PARAM_DEBUG (boolean)
     *   -  DBH::PARAM_THROW (boolean)
     *   -  DBH::PARAM_HISTORY (boolean)
     *
     *  @access     public
     *
     *  @throws     \DB\Exception (If throw parameter is setted to true)
     *
     *  @uses       \DB\DBH::getParameterValue()
     *  @uses       \DB\DBH::makeQueryUpdate()
     *  @uses       \DB\DBH::handleException()
     *  @uses       \Util\Request::getSession()
     *  @uses       \Doctrine\DBAL\Connection::executeUpdate()
     *
     *  @param      string      $table      Database table name
     *  @param      array       $data       Data to update
     *  @param      array       $conds      Conditions for update
     *  @param      array       $params     Extra parameters
     *
     *  @return     mixed                   Updated row count if all was ok, if
     *                                      error boolean false.
     */
    public function update($table, $data, $conds, $params = array())
    {
        // Determine used extra parameters
        $debug = $this->getParameterValue(DBH::PARAM_DEBUG, $params);
        $throw = $this->getParameterValue(DBH::PARAM_THROW, $params);
        $history = $this->getParameterValue(DBH::PARAM_HISTORY, $params);

        // We wanna write history data, this is default way to do this.
        if ($history === true)
        {
            $temp = array(
                        'Stamp_Mod'     =>  new \DateTime(),
                        'User_ID_Mod'   =>  $this->request->getSession(array('User', 'ID')),
                        );

            $data = array_merge($temp, $data);
        }

        try
        {
            // Generate actual update clause, used bindings and types.
            list($_query, $_binds, $_types) = $this->makeQueryUpdate($table, $data, $conds, $debug);

            // Make actual update query to database
            $rows = $this->connection->executeUpdate($_query, $_binds, $_types);
        }

        catch (\Exception $error)
        {
            $this->handleException($error, $throw, $debug);

            $rows = false;
        }

        return $rows;
    }


    /**
     *  delete()
     *
     *  Generic DELETE method. With this you can easily delete specified table
     *  rows from database with desired conditions.
     *
     *  Method accepts following extra parameters, which must be given as an
     *  array.
     *
     *   -  DBH::PARAM_DEBUG (boolean)
     *   -  DBH::PARAM_THROW (boolean)
     *
     *  @access     public
     *
     *  @throws     \DB\Exception (If throw parameter is setted to true)
     *
     *  @uses       \DB\DBH::getParameterValue()
     *  @uses       \DB\DBH::makeQueryDelete()
     *  @uses       \DB\DBH::handleException()
     *  @uses       \Doctrine\DBAL\Connection::executeUpdate()
     *
     *  @param      string      $table      Database table name
     *  @param      array       $conds      Conditions for delete
     *  @param      array       $params     Extra parameters
     *
     *  @return     mixed                   Updated row count if all was ok, if
     *                                      error boolean false.
     */
    public function delete($table, $conds, $params = array())
    {
        // Determine used extra parameters
        $debug = $this->getParameterValue(DBH::PARAM_DEBUG, $params);
        $throw = $this->getParameterValue(DBH::PARAM_THROW, $params);

        try
        {
            // Generate actual delete clause, used bindings and types.
            list($_query, $_binds, $_types) = $this->makeQueryDelete($table, $conds, $debug);

            // Make actual DELETE to database
            $rows = $this->connection->executeUpdate($_query, $_binds, $_types);
        }

        catch (\Exception $error)
        {
            $this->handleException($error, $throw);

            $rows = false;
        }

        return $rows;
    }

    /**
     *  End of public -methods
     */
    /**#@-*/



    /**#@+
     *  Start of protected -methods.
     *
     *  @access     protected
     */

    /**
     *  getParameterValue()
     *
     *  Method returns defined constant parameter value according to given
     *  parameters. If asked parameter is not present in reference array method
     *  will return parameter default value.
     *
     *  @access     protected
     *
     *  @uses       \DB\DBH::getParamDefaultValue()
     *
     *  @param      constant    $constant   Constant parameter.
     *  @param      array       $params     Reference to passed parameters.
     *
     *  @return     mixed                   Parameter value.
     */
    protected function getParameterValue($constant, &$params = array())
    {
        // Asked parameter exists, so return it
        if ((is_numeric($constant) || is_string($constant))
            && is_array($params)
            && array_key_exists($constant, $params))
        {
            $output = $params[$constant];
        }

        // Otherwise return parameter default value
        else
        {
            $output = $this->getParameterValueDefault($constant);
        }

        return $output;
    }


    /**
     *  getParameterValueDefault()
     *
     *  Method returns defined constant parameter default value.
     *
     *  @access     protected
     *
     *  @throws     \DB\Exception
     *
     *  @param      constant    $constant   Constant parameter.
     *
     *  @return     mixed                   Parameter default value.
     */
    protected function getParameterValueDefault(&$constant)
    {
        switch($constant)
        {
            case DBH::PARAM_DEBUG:
                $output = false;
                break;

            case DBH::PARAM_THROW:
                $output = false;
                break;

            case DBH::PARAM_HISTORY:
                $output = true;
                break;

            default:
                throw new Exception("Unknown parameter definition.");
                break;
        }

        return $output;
    }


    /**
     *  makeQueryInsert()
     *
     *  Method generates INSERT query, bindings and used binding types to
     *  specified database table and data.
     *
     *  @access     protected
     *
     *  @throws     \DB\Exception
     *
     *  @uses       \DB\DBH::filterTableColumns()
     *  @uses       \DB\DBH::determineBindsAndTypes()
     *
     *  @param      string      $table      Name of the table
     *  @param      array       $data       Insert data
     *  @param      boolean     $debug
     *
     *  @return     array                   Array which contains following data:
     *                                       -  INSERT query, string
     *                                       -  Used query bindings, array
     *                                       -  Binding types, array
     */
    protected function makeQueryInsert(&$table, &$data, &$debug)
    {
        // Filter table columns
        $this->filterTableColumns($table, $data, $debug);

        // No column data for insert
        if (empty($data))
        {
            $message = sprintf(
                            "No valid column data for insert clause, in other
                            words defined data is not valid against '%1\$s' -table",
                            $table
                            );

            throw new Exception("No valid column data for insert.");
        }

        // Specify used columns
        $columns = array_keys($data);

        // Create actual insert query
        $query = sprintf("
                    INSERT INTO
                        `%1\$s`
                        (`%2\$s`)
                    VALUES
                        (:%3\$s)
                    ",
                    $table,
                    implode('`, `', $columns),
                    implode(', :', $columns)
                    );

        // Determine used binding values and types
        list($binds, $types) = $this->determineBindsAndTypes($data, $debug);

        return array($query, $binds, $types);
    }


    /**
     *  makeQueryUpdate()
     *
     *  Method generates UPDATE query, bindings and used binding types to
     *  specified database table, update data and conditions.
     *
     *  @access     protected
     *
     *  @throws     \DB\Exception
     *
     *  @uses       \DB\DBH::determineUpdateClause()
     *  @uses       \DB\DBH::determineWhereClause()
     *  @uses       \DB\DBH::determineBindsAndTypes()
     *
     *  @param      string      $table      Name of the table
     *  @param      array       $data       Update data
     *  @param      array       $conds      Used update conditions
     *  @param      boolean     $debug
     *
     *  @return     array                   Array which contains following data:
     *                                       -  UPDATE query, string
     *                                       -  Used query bindings, array
     *                                       -  Binding types, array
     */
    protected function makeQueryUpdate(&$table, &$data, &$conds, &$debug)
    {
        // Make update SQL clause and bindings
        list($clauseUpdate, $bindsUpdate) = $this->determineUpdateClause($table, $data, $debug);

        // Make where SQL clause and bindings
        list($clauseWhere, $bindsWhere) = $this->determineWhereClause($table, $conds, true, $debug);

        // Create used query bindings
        $_binds = $bindsUpdate + $bindsWhere;

        // Create actual update query
        $query = sprintf("
                    UPDATE
                        `%1\$s`
                    SET
                        %2\$s
                    WHERE
                        (1 = 1)
                        %3\$s
                    ",
                    $table,
                    $clauseUpdate,
                    $clauseWhere
                    );

        // Determine used binding values and types
        list($binds, $types) = $this->determineBindsAndTypes($_binds, $debug);

        return array($query, $binds, $types);
    }


    /**
     *  makeQueryDelete()
     *
     *  Method generates DELETE query, bindings and used binding types to
     *  specified database table and conditions.
     *
     *  @access     protected
     *
     *  @throws     \DB\Exception
     *
     *  @uses       \DB\DBH::determineWhereClause()
     *  @uses       \DB\DBH::determineBindsAndTypes()
     *
     *  @param      string      $table      Name of the table
     *  @param      array       $conds      Used delete conditions
     *  @param      boolean     $debug
     *
     *  @return     array                   Array which contains following data:
     *                                       -  DELETE query, string
     *                                       -  Used query bindings, array
     *                                       -  Binding types, array
     */
    protected function makeQueryDelete(&$table, &$conds, &$debug)
    {
        // Make where SQL clause and bindings
        list($_where, $_binds) = $this->determineWhereClause($table, $conds, true, $debug);

        // Create actual update query
        $query = sprintf("
                    DELETE FROM
                        `%1\$s`
                    WHERE
                        (1 = 1)
                        %2\$s
                    ",
                    $table,
                    $_where
                    );

        // Determine used binding values and types
        list($binds, $types) = $this->determineBindsAndTypes($_binds, $debug);

        return array($query, $binds, $types);
    }


    /**
     *  makeQuerySelect()
     *
     *  Method generates generic SELECT query, bindings and used binding types
     *  to specified database table, columns and conditions.
     *
     *  @access     protected
     *
     *  @throws     \DB\Exception
     *
     *  @uses       \DB\DBH::determineWhereClause()
     *  @uses       \DB\DBH::determineSelectColumns()
     *  @uses       \DB\DBH::determineBindsAndTypes()
     *
     *  @param      string      $table      Name of the table
     *  @param      array       $columns    Select columns
     *  @param      array       $conds      Used select conditions
     *  @param      boolean     $debug
     *
     *  @return     array                   Array which contains following data:
     *                                       -  SELECT query, string
     *                                       -  Used query bindings, array
     *                                       -  Binding types, array
     */
    protected function makeQuerySelect(&$table, &$columns, &$conds, &$debug)
    {
        // Make where SQL clause and bindings
        list($_where, $_binds) = $this->determineWhereClause($table, $conds, false, $debug);

        // Specify select columns
        $_columns = $this->determineSelectColumns($table, $columns, $debug);

        // Make actual query
        $query = sprintf("
                    SELECT
                        %1\$s
                    FROM
                        `%2\$s`
                    WHERE
                        (1 = 1)
                        %3\$s
                    ",
                    $_columns,
                    $table,
                    $_where
                    );


        // Determine used binding values and types
        list($binds, $types) = $this->determineBindsAndTypes($_binds, $debug);

        return array($query, $binds, $types);
    }

    /**
     *  End of protected -methods
     */
    /**#@-*/



    /**#@+
     *  Start of private -methods.
     *
     *  @access     private
     */

    /**
     *  determineBindsAndTypes()
     *
     *  Method makes arrays for query bindings and used binding types and
     *  returns them as an array. Method is widely used in this class.
     *
     *  TODO        This method needs to be completed, there is too much
     *              to do at once and to few beers to implement them all...
     *
     *  @access     private
     *
     *  @throws     \DB\Exception
     *
     *  @param      array       $binds      Query bindings
     *  @param      boolean     $debug
     *
     *  @return     array                   Array which contains following data:
     *                                       -  Used query bindings, array
     *                                       -  Binding types, array
     */
    private function determineBindsAndTypes(&$binds, &$debug)
    {
        // Reset used variables
        $_binds = $_types = array();

        // Iterate specified bindings
        foreach($binds as $_bind => $_value)
        {
            // Default binding type is NULL
            $_type = NULL;

            /**
             *  Binding value is defined as an object this means that this
             *  value has special binding.
             *
             *  TODO: Implement other object handling here
             */
            if (is_object($_value))
            {
                // DateTime object, Doctrine will handle conversion to db format
                if ($_value instanceof \DateTime)
                {
                    $_type = \Doctrine\DBAL\Types\Type::DATETIME;
                }

                else
                {
                    throw new Exception("Couldn't determine binding type of this object.");
                }
            }

            /**
             *  Bindings are defined as an array, in this case we must
             *  do some specified stuff...
             *
             *  TODO: Do we need anything else here?
             */
            elseif (is_array($_value))
            {
                // Assoc array, assign value and type from it
                if (!is_int(key($_value)))
                {
                    $data = $_value;

                    $_value = isset($data['value']) ? $data['value'] : NULL;
                    $_type = isset($data['type']) ? $data['type'] : NULL;
                }

                // Value and Type are defined as single dimensional array
                elseif (count($_value) === 2)
                {
                    list($_value, $_type) = $_value;
                }

                else
                {
                    throw new Exception("Couldn't determine binding from array.");
                }
            }

            // Add bind value and type to return values
            $_binds[$_bind] = $_value;
            $_types[$_bind] = $_type;
        }

        return array($_binds, $_types);
    }


    /**
     *  determineSelectColumns()
     *
     *  Method determines columns for generic SELECT clause.
     *
     *  @access     private
     *
     *  @throws     \DB\Exception
     *
     *  @param      string      $table      Table definition
     *  @param      array       $columns    Select columns
     *  @param      boolean     $debug
     *
     *  @return     string                  Select columns as string
     */
    private function determineSelectColumns(&$table, &$columns, &$debug)
    {
        if (empty($columns))
        {
            return '*';
        }

        elseif (!is_array($columns))
        {
            $columns = array((string)$columns);
        }

        // Filter select columns
        $this->filterTableColumns($table, $columns, $debug);

        if (empty($columns))
        {
            $message = sprintf("No valid select columns for '%s' -table.", $table);

            throw new Exception($message);
        }

        return "`". implode("`, `", $columns) ."`";
    }


    /**
     *  determineUpdateClause()
     *
     *  Method determines update clause and used bindings for it.
     *
     *  @access     private
     *
     *  @throws     \DB\Exception
     *
     *  @uses       \DB\DBH::filterTableColumns()
     *
     *  @param      string      $table      Table definition
     *  @param      array       $data       Update data
     *  @param      boolean     $debug
     *
     *  @return     array                   Array which contains following data
     *                                       - Update clause, string
     *                                       - Update bindings, array
     */
    private function determineUpdateClause(&$table, &$data, &$debug)
    {
        // Filter table data columns
        $this->filterTableColumns($table, $data, $debug);

        // No column data for update clause
        if (empty($data))
        {
            $message = sprintf(
                            "No valid column data for update clause, in other
                            words defined data is not valid against '%1\$s' -table",
                            $table
                            );

            throw new Exception($message);
        }

        // Reset used variables.
        $binds = $clause = array();

        // Iterate update fields
        foreach ($data as $column => $value)
        {
            $binding = 'SET__'. $column;

            $clause[] = "`". $column ."` = :". $binding;

            $binds[$binding] = $value;
        }

        return array(
                implode(', ', $clause),
                $binds
                );
    }


    /**
     *  determineWhereClause()
     *
     *  Method determines where clause and used bindings for it.
     *
     *  @access     private
     *
     *  @throws     \DB\Exception
     *
     *  @uses       \DB\DBH::getTablePrimaryKey()
     *  @uses       \DB\DBH::filterTableColumns()
     *
     *  @param      string      $table      Table definition
     *  @param      array       $data       Update data
     *  @param      boolean     $required   Is conditions required or not
     *  @param      boolean     $debug
     *
     *  @return     array                   Array which contains following data
     *                                       - Update clause, string
     *                                       - Update bindings, array
     */
    private function determineWhereClause(&$table, &$conds, $required = true, &$debug)
    {
        // No conditions at all
        if (empty($conds))
        {
            // Conditions are required in update() and delete() -methods
            if ($required)
            {
                $message = sprintf("No WHERE conditions specified, cannot continue.");

                throw new Exception($message);
            }

            // Otherwise return empty values.
            return array(
                    '',
                    array()
                    );
        }

        /**
         *  Conditions aren't array. In this case we can assume that given
         *  condition must be targeted to table primary key(s).
         */
        if (!is_array($conds))
        {
            // Get table primary key(s)
            $primaryKey = $this->getTablePrimaryKey($table);

            // Primary key not defined => error
            if (empty($primaryKey))
            {
                $message = sprintf("Cannot define WHERE clause '%1\$s' -table
                                doesn't contain Primary Key (PK) column.",
                                $table
                                );

                throw new Exception($message);
            }

            // Multiple primary keys
            elseif (is_array($primaryKey))
            {
                // Condition string doesn't contain separator
                if (mb_strpos($conds, '-') === false)
                {
                    $message = sprintf("Cannot define WHERE clause '%1\$s' -table.
                                Multiple primary keys and given value is not valid.
                                Given value was '%s'.",
                                $table,
                                $conds
                                );

                    throw new Exception($message);
                }

                // Determine used values for primary keys
                $pkValues = explode('-', $conds);

                // Check that value count matches with primary key count
                if (count($pkValues) !== count($primaryKey))
                {
                    $message = sprintf("Cannot define WHERE clause '%1\$s' -table.
                                Multiple primary keys and value count doesn't match
                                with it. Primary keys: %d, values: %d",
                                $table,
                                count($pkValues),
                                count($primaryKey)
                                );

                    throw new Exception($message);
                }

                // Reset condition array
                $conds = array();

                // Iterate primary keys and generate actual conditions array
                foreach ($primaryKey as $idx => $column)
                {
                    $conds[$column] = $pkValues[$idx];
                }
            }

            // Single primary key
            else
            {
                $conds = array(
                            $primaryKey => $conds,
                            );
            }
        }

        // Filter setted conditions
        $this->filterTableColumns($table, $conds, $debug);

        // No valid column data for where clause
        if (empty($conds))
        {
            $message = sprintf(
                            "No valid column data for where clause, in other
                            words defined data is not valid against '%1\$s' -table.",
                            $table
                            );

            throw new Exception($message);
        }

        // Reset used variables.
        $binds = $clause = array();

        // Iterate where conditions
        foreach ($conds as $column => $value)
        {
            $binding = 'WHERE__'. $column;

            $clause[] = "AND (`". $column ."` = :". $binding .")";

            $binds[$binding] = $value;
        }

        return array(
                implode(' ', $clause),
                $binds
                );
    }


    /**
     *  filterTableColumns()
     *
     *  Method filters out columns that doesn't exists in specified database
     *  table.
     *
     *  @access     private
     *
     *  @uses       \DB\Table::getInstance()
     *
     *  @param      string      $table      Table definition
     *  @param      array       $columns    Reference to columns array
     *  @param      boolean     $debug
     *
     *  @return     void
     */
    private function filterTableColumns(&$table, &$columns, &$debug)
    {
        // Fetch table object, from cache or create new one if first run
        $tableObj = Table::getInstance($table);

        // Iterate specified input columns
        foreach ($columns as $column => $data)
        {
            if ((is_int($column) && $tableObj->hasColumn($data))
               || $tableObj->hasColumn($column)
                )
            {
                continue;
            }

            // Determine actual column name
            $column = is_int($column) ? $data : $column;

            // Table doesn't have this column, so remove it
            unset($columns[$column]);
        }
    }


    /**
     *  handleException()
     *
     *  Method Handles all exception which have been thrown in this class.
     *
     *  @access     private
     *
     *  @uses       \Util\Logger::logErrorQuery()
     *  @uses       \UI\Message::setError()
     *
     *  @param      object      $error      Exception object
     *  @param      boolean     $throw      Will exception to be thrown forward
     *  @param      boolean     $debug
     *
     *  @return     void
     */
    private function handleException(&$error, &$throw, &$debug)
    {
        // Write error log.
        \Util\Logger::logErrorQuery($error);

        if ($throw)
        {
            throw new Exception($error->getMessage());
        }

        else
        {
            // Set error message
            \UI\Message::setError("SQL error occured. Please check details from query error log.");
        }
    }

    /**
     *  End of private -methods
     */
    /**#@-*/
}

?>
