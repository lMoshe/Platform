<?php

/**
 * Autogenerated base class representing stream rows
 * in the Streams database.
 *
 * Don't change this file, since it can be overwritten.
 * Instead, change the Streams_Stream.php file.
 *
 * @module Streams
 */
/**
 * Base class representing 'Stream' rows in the 'Streams' database
 * @class Base_Streams_Stream
 * @extends Db_Row
 *
 * @param {array} [$fields=array()] The fields values to initialize table row as 
 * an associative array of $column => $value pairs
 * @param {string} [$fields.publisherId] defaults to ""
 * @param {string} [$fields.name] defaults to ""
 * @param {string|Db_Expression} [$fields.insertedTime] defaults to new Db_Expression("CURRENT_TIMESTAMP")
 * @param {string|Db_Expression} [$fields.updatedTime] defaults to null
 * @param {string} [$fields.type] defaults to ""
 * @param {string} [$fields.title] defaults to ""
 * @param {string} [$fields.icon] defaults to "default"
 * @param {string} [$fields.content] defaults to ""
 * @param {string} [$fields.attributes] defaults to null
 * @param {integer} [$fields.readLevel] defaults to 40
 * @param {integer} [$fields.writeLevel] defaults to 10
 * @param {integer} [$fields.adminLevel] defaults to 20
 * @param {string} [$fields.permissions] defaults to null
 * @param {string} [$fields.inheritAccess] defaults to null
 * @param {integer} [$fields.messageCount] defaults to 0
 * @param {integer} [$fields.invitedCount] defaults to 0
 * @param {integer} [$fields.participatingCount] defaults to 0
 * @param {integer} [$fields.leftCount] defaults to 0
 * @param {string|Db_Expression} [$fields.closedTime] defaults to null
 */
abstract class Base_Streams_Stream extends Db_Row
{
	/**
	 * @property $publisherId
	 * @type string
	 * @default ""
	 * id of user that publishes the stream
	 */
	/**
	 * @property $name
	 * @type string
	 * @default ""
	 * the name of the stream
	 */
	/**
	 * @property $insertedTime
	 * @type string|Db_Expression
	 * @default new Db_Expression("CURRENT_TIMESTAMP")
	 * saved on shard of publisherId
	 */
	/**
	 * @property $updatedTime
	 * @type string|Db_Expression
	 * @default null
	 * the time that this stream row has last changed for whatever reason
	 */
	/**
	 * @property $type
	 * @type string
	 * @default ""
	 * mimetypes plus more types of the form a/b and a/b/c . Can also be "group" or "chat"
	 */
	/**
	 * @property $title
	 * @type string
	 * @default ""
	 * human-readable title of the stream
	 */
	/**
	 * @property $icon
	 * @type string
	 * @default "default"
	 * relative path to stream's icon folder, containing 48.png, 32.png and 16.png
	 */
	/**
	 * @property $content
	 * @type string
	 * @default ""
	 * This content can be indexable
	 */
	/**
	 * @property $attributes
	 * @type string
	 * @default null
	 * attributes are stored as JSON
	 */
	/**
	 * @property $readLevel
	 * @type integer
	 * @default 40
	 * 10='see', 20='content', 30='participants', 40='messages'
	 */
	/**
	 * @property $writeLevel
	 * @type integer
	 * @default 10
	 * 0=self, 10=join, 13=vote, 15=postPending, 20=post, 23=relate, 25=suggest, 30=edit, 40=close
	 */
	/**
	 * @property $adminLevel
	 * @type integer
	 * @default 20
	 * 10='publish', 20='invite', 30='manage', 40='own'
	 */
	/**
	 * @property $permissions
	 * @type string
	 * @default null
	 * JSON array of permission names
	 */
	/**
	 * @property $inheritAccess
	 * @type string
	 * @default null
	 * JSON array of [[publisherId, streamName],...] to inherit access from
	 */
	/**
	 * @property $messageCount
	 * @type integer
	 * @default 0
	 * 
	 */
	/**
	 * @property $invitedCount
	 * @type integer
	 * @default 0
	 * number of users invited
	 */
	/**
	 * @property $participatingCount
	 * @type integer
	 * @default 0
	 * number of users participating
	 */
	/**
	 * @property $leftCount
	 * @type integer
	 * @default 0
	 * number of users who left after participating
	 */
	/**
	 * @property $closedTime
	 * @type string|Db_Expression
	 * @default null
	 * this records the time, if any, that the stream was last closed for updates
	 */
	/**
	 * The setUp() method is called the first time
	 * an object of this class is constructed.
	 * @method setUp
	 */
	function setUp()
	{
		$this->setDb(self::db());
		$this->setTable(self::table());
		$this->setPrimaryKey(
			array (
			  0 => 'publisherId',
			  1 => 'name',
			)
		);
	}

	/**
	 * Connects to database
	 * @method db
	 * @static
	 * @return {iDb} The database object
	 */
	static function db()
	{
		return Db::connect('Streams');
	}

	/**
	 * Retrieve the table name to use in SQL statement
	 * @method table
	 * @static
	 * @param {boolean} [$with_db_name=true] Indicates wheather table name should contain the database name
 	 * @return {string|Db_Expression} The table name as string optionally without database name if no table sharding
	 * was started or Db_Expression class with prefix and database name templates is table was sharded
	 */
	static function table($with_db_name = true)
	{
		if (Q_Config::get('Db', 'connections', 'Streams', 'indexes', 'Stream', false)) {
			return new Db_Expression(($with_db_name ? '{$dbname}.' : '').'{$prefix}'.'stream');
		} else {
			$conn = Db::getConnection('Streams');
  			$prefix = empty($conn['prefix']) ? '' : $conn['prefix'];
  			$table_name = $prefix . 'stream';
  			if (!$with_db_name)
  				return $table_name;
  			$db = Db::connect('Streams');
  			return $db->dbName().'.'.$table_name;
		}
	}
	/**
	 * The connection name for the class
	 * @method connectionName
	 * @static
	 * @return {string} The name of the connection
	 */
	static function connectionName()
	{
		return 'Streams';
	}

	/**
	 * Create SELECT query to the class table
	 * @method select
	 * @static
	 * @param {string|array} [$fields='*'] The fields as strings, or array of alias=>field
	 * @param {string|array} [$alias=null] The tables as strings, or array of alias=>table
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function select($fields, $alias = null)
	{
		if (!isset($alias)) $alias = '';
		$q = self::db()->select($fields, self::table().' '.$alias);
		$q->className = 'Streams_Stream';
		return $q;
	}

	/**
	 * Create UPDATE query to the class table
	 * @method update
	 * @static
	 * @param {string} [$alias=null] Table alias
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function update($alias = null)
	{
		if (!isset($alias)) $alias = '';
		$q = self::db()->update(self::table().' '.$alias);
		$q->className = 'Streams_Stream';
		return $q;
	}

	/**
	 * Create DELETE query to the class table
	 * @method delete
	 * @static
	 * @param {object} [$table_using=null] If set, adds a USING clause with this table
	 * @param {string} [$alias=null] Table alias
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function delete($table_using = null, $alias = null)
	{
		if (!isset($alias)) $alias = '';
		$q = self::db()->delete(self::table().' '.$alias, $table_using);
		$q->className = 'Streams_Stream';
		return $q;
	}

	/**
	 * Create INSERT query to the class table
	 * @method insert
	 * @static
	 * @param {object} [$fields=array()] The fields as an associative array of column => value pairs
	 * @param {string} [$alias=null] Table alias
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function insert($fields = array(), $alias = null)
	{
		if (!isset($alias)) $alias = '';
		$q = self::db()->insert(self::table().' '.$alias, $fields);
		$q->className = 'Streams_Stream';
		return $q;
	}
	
	/**
	 * Inserts multiple rows into a single table, preparing the statement only once,
	 * and executes all the queries.
	 * @method insertManyAndExecute
	 * @static
	 * @param {array} [$rows=array()] The array of rows to insert. 
	 * (The field names for the prepared statement are taken from the first row.)
	 * You cannot use Db_Expression objects here, because the function binds all parameters with PDO.
	 * @param {array} [$options=array()]
	 *   An associative array of options, including:
	 *
	 * * "chunkSize" {integer} The number of rows to insert at a time. defaults to 20.<br/>
	 * * "onDuplicateKeyUpdate" {array} You can put an array of fieldname => value pairs here,
	 * 		which will add an ON DUPLICATE KEY UPDATE clause to the query.
	 *
	 */
	static function insertManyAndExecute($rows = array(), $options = array())
	{
		self::db()->insertManyAndExecute(
			self::table(), $rows,
			array_merge($options, array('className' => 'Streams_Stream'))
		);
	}
	
	/**
	 * Create raw query with begin clause
	 * You'll have to specify shards yourself when calling execute().
	 * @method begin
	 * @static
	 * @param {string} [$lockType=null] First parameter to pass to query->begin() function
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function begin($lockType = null)
	{
		$q = self::db()->rawQuery('')->begin($lockType);
		$q->className = 'Streams_Stream';
		return $q;
	}
	
	/**
	 * Create raw query with commit clause
	 * You'll have to specify shards yourself when calling execute().
	 * @method commit
	 * @static
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function commit()
	{
		$q = self::db()->rawQuery('')->commit();
		$q->className = 'Streams_Stream';
		return $q;
	}
	
	/**
	 * Create raw query with rollback clause
	 * @method rollback
	 * @static
	 * @param {array} $criteria Can be used to target the rollback to some shards.
	 *  Otherwise you'll have to specify shards yourself when calling execute().
	 * @return {Db_Query_Mysql} The generated query
	 */
	static function rollback()
	{
		$q = self::db()->rawQuery('')->rollback();
		$q->className = 'Streams_Stream';
		return $q;
	}
	
	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_publisherId
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_publisherId($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('publisherId', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".publisherId");
		if (strlen($value) > 31)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".publisherId");
		return array('publisherId', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the publisherId field
	 * @return {integer}
	 */
	function maxSize_publisherId()
	{

		return 31;			
	}

	/**
	 * Returns schema information for publisherId column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_publisherId()
	{

return array (
  0 => 
  array (
    0 => 'varbinary',
    1 => '31',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => 'PRI',
  3 => '',
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_name
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_name($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('name', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".name");
		if (strlen($value) > 255)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".name");
		return array('name', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the name field
	 * @return {integer}
	 */
	function maxSize_name()
	{

		return 255;			
	}

	/**
	 * Returns schema information for name column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_name()
	{

return array (
  0 => 
  array (
    0 => 'varbinary',
    1 => '255',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => 'PRI',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and normalize the DateTime string
	 * @method beforeSet_insertedTime
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value does not represent valid DateTime
	 */
	function beforeSet_insertedTime($value)
	{
		if ($value instanceof Db_Expression) {
			return array('insertedTime', $value);
		}
		if ($value instanceof DateTime) {
			$value = $value->getTimestamp();
		}
		if (is_numeric($value)) {
			$newDateTime = new DateTime();
			$datetime = $newDateTime->setTimestamp($value);
		} else {
			$datetime = new DateTime($value);
		}
		$value = $datetime->format("Y-m-d h:i:s");
		return array('insertedTime', $value);			
	}

	/**
	 * Returns schema information for insertedTime column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_insertedTime()
	{

return array (
  0 => 
  array (
    0 => 'timestamp',
    1 => '255',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => 'CURRENT_TIMESTAMP',
);			
	}

	/**
	 * Method is called before setting the field and normalize the DateTime string
	 * @method beforeSet_updatedTime
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value does not represent valid DateTime
	 */
	function beforeSet_updatedTime($value)
	{
		if (!isset($value)) {
			return array('updatedTime', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('updatedTime', $value);
		}
		if ($value instanceof DateTime) {
			$value = $value->getTimestamp();
		}
		if (is_numeric($value)) {
			$newDateTime = new DateTime();
			$datetime = $newDateTime->setTimestamp($value);
		} else {
			$datetime = new DateTime($value);
		}
		$value = $datetime->format("Y-m-d h:i:s");
		return array('updatedTime', $value);			
	}

	/**
	 * Returns schema information for updatedTime column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_updatedTime()
	{

return array (
  0 => 
  array (
    0 => 'timestamp',
    1 => '255',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_type
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_type($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('type', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".type");
		if (strlen($value) > 63)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".type");
		return array('type', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the type field
	 * @return {integer}
	 */
	function maxSize_type()
	{

		return 63;			
	}

	/**
	 * Returns schema information for type column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_type()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '63',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_title
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_title($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('title', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".title");
		if (strlen($value) > 255)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".title");
		return array('title', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the title field
	 * @return {integer}
	 */
	function maxSize_title()
	{

		return 255;			
	}

	/**
	 * Returns schema information for title column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_title()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '255',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_icon
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_icon($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('icon', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".icon");
		if (strlen($value) > 255)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".icon");
		return array('icon', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the icon field
	 * @return {integer}
	 */
	function maxSize_icon()
	{

		return 255;			
	}

	/**
	 * Returns schema information for icon column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_icon()
	{

return array (
  0 => 
  array (
    0 => 'varbinary',
    1 => '255',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => 'default',
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_content
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_content($value)
	{
		if (!isset($value)) {
			$value='';
		}
		if ($value instanceof Db_Expression) {
			return array('content', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".content");
		if (strlen($value) > 1023)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".content");
		return array('content', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the content field
	 * @return {integer}
	 */
	function maxSize_content()
	{

		return 1023;			
	}

	/**
	 * Returns schema information for content column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_content()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '1023',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_attributes
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_attributes($value)
	{
		if (!isset($value)) {
			return array('attributes', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('attributes', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".attributes");
		if (strlen($value) > 1023)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".attributes");
		return array('attributes', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the attributes field
	 * @return {integer}
	 */
	function maxSize_attributes()
	{

		return 1023;			
	}

	/**
	 * Returns schema information for attributes column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_attributes()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '1023',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if integer value falls within allowed limits
	 * @method beforeSet_readLevel
	 * @param {integer} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not integer or does not fit in allowed range
	 */
	function beforeSet_readLevel($value)
	{
		if ($value instanceof Db_Expression) {
			return array('readLevel', $value);
		}
		if (!is_numeric($value) or floor($value) != $value)
			throw new Exception('Non-integer value being assigned to '.$this->getTable().".readLevel");
		$value = intval($value);
		if ($value < -2147483648 or $value > 2147483647) {
			$json = json_encode($value);
			throw new Exception("Out-of-range value $json being assigned to ".$this->getTable().".readLevel");
		}
		return array('readLevel', $value);			
	}

	/**
	 * @method maxSize_readLevel
	 * Returns the maximum integer that can be assigned to the readLevel field
	 * @return {integer}
	 */
	function maxSize_readLevel()
	{

		return 2147483647;			
	}

	/**
	 * Returns schema information for readLevel column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_readLevel()
	{

return array (
  0 => 
  array (
    0 => 'int',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '40',
);			
	}

	/**
	 * Method is called before setting the field and verifies if integer value falls within allowed limits
	 * @method beforeSet_writeLevel
	 * @param {integer} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not integer or does not fit in allowed range
	 */
	function beforeSet_writeLevel($value)
	{
		if ($value instanceof Db_Expression) {
			return array('writeLevel', $value);
		}
		if (!is_numeric($value) or floor($value) != $value)
			throw new Exception('Non-integer value being assigned to '.$this->getTable().".writeLevel");
		$value = intval($value);
		if ($value < -2147483648 or $value > 2147483647) {
			$json = json_encode($value);
			throw new Exception("Out-of-range value $json being assigned to ".$this->getTable().".writeLevel");
		}
		return array('writeLevel', $value);			
	}

	/**
	 * @method maxSize_writeLevel
	 * Returns the maximum integer that can be assigned to the writeLevel field
	 * @return {integer}
	 */
	function maxSize_writeLevel()
	{

		return 2147483647;			
	}

	/**
	 * Returns schema information for writeLevel column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_writeLevel()
	{

return array (
  0 => 
  array (
    0 => 'int',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '10',
);			
	}

	/**
	 * Method is called before setting the field and verifies if integer value falls within allowed limits
	 * @method beforeSet_adminLevel
	 * @param {integer} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not integer or does not fit in allowed range
	 */
	function beforeSet_adminLevel($value)
	{
		if ($value instanceof Db_Expression) {
			return array('adminLevel', $value);
		}
		if (!is_numeric($value) or floor($value) != $value)
			throw new Exception('Non-integer value being assigned to '.$this->getTable().".adminLevel");
		$value = intval($value);
		if ($value < -2147483648 or $value > 2147483647) {
			$json = json_encode($value);
			throw new Exception("Out-of-range value $json being assigned to ".$this->getTable().".adminLevel");
		}
		return array('adminLevel', $value);			
	}

	/**
	 * @method maxSize_adminLevel
	 * Returns the maximum integer that can be assigned to the adminLevel field
	 * @return {integer}
	 */
	function maxSize_adminLevel()
	{

		return 2147483647;			
	}

	/**
	 * Returns schema information for adminLevel column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_adminLevel()
	{

return array (
  0 => 
  array (
    0 => 'int',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '20',
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_permissions
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_permissions($value)
	{
		if (!isset($value)) {
			return array('permissions', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('permissions', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".permissions");
		if (strlen($value) > 255)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".permissions");
		return array('permissions', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the permissions field
	 * @return {integer}
	 */
	function maxSize_permissions()
	{

		return 255;			
	}

	/**
	 * Returns schema information for permissions column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_permissions()
	{

return array (
  0 => 
  array (
    0 => 'varchar',
    1 => '255',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
	 * Optionally accept numeric value which is converted to string
	 * @method beforeSet_inheritAccess
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not string or is exceedingly long
	 */
	function beforeSet_inheritAccess($value)
	{
		if (!isset($value)) {
			return array('inheritAccess', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('inheritAccess', $value);
		}
		if (!is_string($value) and !is_numeric($value))
			throw new Exception('Must pass a string to '.$this->getTable().".inheritAccess");
		if (strlen($value) > 255)
			throw new Exception('Exceedingly long value being assigned to '.$this->getTable().".inheritAccess");
		return array('inheritAccess', $value);			
	}

	/**
	 * Returns the maximum string length that can be assigned to the inheritAccess field
	 * @return {integer}
	 */
	function maxSize_inheritAccess()
	{

		return 255;			
	}

	/**
	 * Returns schema information for inheritAccess column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_inheritAccess()
	{

return array (
  0 => 
  array (
    0 => 'varbinary',
    1 => '255',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Method is called before setting the field and verifies if integer value falls within allowed limits
	 * @method beforeSet_messageCount
	 * @param {integer} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not integer or does not fit in allowed range
	 */
	function beforeSet_messageCount($value)
	{
		if ($value instanceof Db_Expression) {
			return array('messageCount', $value);
		}
		if (!is_numeric($value) or floor($value) != $value)
			throw new Exception('Non-integer value being assigned to '.$this->getTable().".messageCount");
		$value = intval($value);
		if ($value < -2147483648 or $value > 2147483647) {
			$json = json_encode($value);
			throw new Exception("Out-of-range value $json being assigned to ".$this->getTable().".messageCount");
		}
		return array('messageCount', $value);			
	}

	/**
	 * @method maxSize_messageCount
	 * Returns the maximum integer that can be assigned to the messageCount field
	 * @return {integer}
	 */
	function maxSize_messageCount()
	{

		return 2147483647;			
	}

	/**
	 * Returns schema information for messageCount column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_messageCount()
	{

return array (
  0 => 
  array (
    0 => 'int',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '0',
);			
	}

	/**
	 * Method is called before setting the field and verifies if integer value falls within allowed limits
	 * @method beforeSet_invitedCount
	 * @param {integer} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not integer or does not fit in allowed range
	 */
	function beforeSet_invitedCount($value)
	{
		if ($value instanceof Db_Expression) {
			return array('invitedCount', $value);
		}
		if (!is_numeric($value) or floor($value) != $value)
			throw new Exception('Non-integer value being assigned to '.$this->getTable().".invitedCount");
		$value = intval($value);
		if ($value < -2147483648 or $value > 2147483647) {
			$json = json_encode($value);
			throw new Exception("Out-of-range value $json being assigned to ".$this->getTable().".invitedCount");
		}
		return array('invitedCount', $value);			
	}

	/**
	 * @method maxSize_invitedCount
	 * Returns the maximum integer that can be assigned to the invitedCount field
	 * @return {integer}
	 */
	function maxSize_invitedCount()
	{

		return 2147483647;			
	}

	/**
	 * Returns schema information for invitedCount column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_invitedCount()
	{

return array (
  0 => 
  array (
    0 => 'int',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '0',
);			
	}

	/**
	 * Method is called before setting the field and verifies if integer value falls within allowed limits
	 * @method beforeSet_participatingCount
	 * @param {integer} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not integer or does not fit in allowed range
	 */
	function beforeSet_participatingCount($value)
	{
		if ($value instanceof Db_Expression) {
			return array('participatingCount', $value);
		}
		if (!is_numeric($value) or floor($value) != $value)
			throw new Exception('Non-integer value being assigned to '.$this->getTable().".participatingCount");
		$value = intval($value);
		if ($value < -2147483648 or $value > 2147483647) {
			$json = json_encode($value);
			throw new Exception("Out-of-range value $json being assigned to ".$this->getTable().".participatingCount");
		}
		return array('participatingCount', $value);			
	}

	/**
	 * @method maxSize_participatingCount
	 * Returns the maximum integer that can be assigned to the participatingCount field
	 * @return {integer}
	 */
	function maxSize_participatingCount()
	{

		return 2147483647;			
	}

	/**
	 * Returns schema information for participatingCount column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_participatingCount()
	{

return array (
  0 => 
  array (
    0 => 'int',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '0',
);			
	}

	/**
	 * Method is called before setting the field and verifies if integer value falls within allowed limits
	 * @method beforeSet_leftCount
	 * @param {integer} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value is not integer or does not fit in allowed range
	 */
	function beforeSet_leftCount($value)
	{
		if ($value instanceof Db_Expression) {
			return array('leftCount', $value);
		}
		if (!is_numeric($value) or floor($value) != $value)
			throw new Exception('Non-integer value being assigned to '.$this->getTable().".leftCount");
		$value = intval($value);
		if ($value < -2147483648 or $value > 2147483647) {
			$json = json_encode($value);
			throw new Exception("Out-of-range value $json being assigned to ".$this->getTable().".leftCount");
		}
		return array('leftCount', $value);			
	}

	/**
	 * @method maxSize_leftCount
	 * Returns the maximum integer that can be assigned to the leftCount field
	 * @return {integer}
	 */
	function maxSize_leftCount()
	{

		return 2147483647;			
	}

	/**
	 * Returns schema information for leftCount column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_leftCount()
	{

return array (
  0 => 
  array (
    0 => 'int',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => false,
  2 => '',
  3 => '0',
);			
	}

	/**
	 * Method is called before setting the field and normalize the DateTime string
	 * @method beforeSet_closedTime
	 * @param {string} $value
	 * @return {array} An array of field name and value
	 * @throws {Exception} An exception is thrown if $value does not represent valid DateTime
	 */
	function beforeSet_closedTime($value)
	{
		if (!isset($value)) {
			return array('closedTime', $value);
		}
		if ($value instanceof Db_Expression) {
			return array('closedTime', $value);
		}
		if ($value instanceof DateTime) {
			$value = $value->getTimestamp();
		}
		if (is_numeric($value)) {
			$newDateTime = new DateTime();
			$datetime = $newDateTime->setTimestamp($value);
		} else {
			$datetime = new DateTime($value);
		}
		$value = $datetime->format("Y-m-d h:i:s");
		return array('closedTime', $value);			
	}

	/**
	 * Returns schema information for closedTime column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
	static function column_closedTime()
	{

return array (
  0 => 
  array (
    0 => 'timestamp',
    1 => '11',
    2 => '',
    3 => false,
  ),
  1 => true,
  2 => '',
  3 => NULL,
);			
	}

	/**
	 * Check if mandatory fields are set and updates 'magic fields' with appropriate values
	 * @method beforeSave
	 * @param {array} $value The array of fields
	 * @return {array}
	 * @throws {Exception} If mandatory field is not set
	 */
	function beforeSave($value)
	{
		if (!$this->retrieved) {
			$table = $this->getTable();
			foreach (array('name') as $name) {
				if (!isset($value[$name])) {
					throw new Exception("the field $table.$name needs a value, because it is NOT NULL, not auto_increment, and lacks a default value.");
				}
			}
		}						
		// convention: we'll have updatedTime = insertedTime if just created.
		$this->updatedTime = $value['updatedTime'] = new Db_Expression('CURRENT_TIMESTAMP');
		return $value;			
	}

	/**
	 * Retrieves field names for class table
	 * @method fieldNames
	 * @static
	 * @param {string} [$table_alias=null] If set, the alieas is added to each field
	 * @param {string} [$field_alias_prefix=null] If set, the method returns associative array of ('prefixed field' => 'field') pairs
	 * @return {array} An array of field names
	 */
	static function fieldNames($table_alias = null, $field_alias_prefix = null)
	{
		$field_names = array('publisherId', 'name', 'insertedTime', 'updatedTime', 'type', 'title', 'icon', 'content', 'attributes', 'readLevel', 'writeLevel', 'adminLevel', 'permissions', 'inheritAccess', 'messageCount', 'invitedCount', 'participatingCount', 'leftCount', 'closedTime');
		$result = $field_names;
		if (!empty($table_alias)) {
			$temp = array();
			foreach ($result as $field_name)
				$temp[] = $table_alias . '.' . $field_name;
			$result = $temp;
		} 
		if (!empty($field_alias_prefix)) {
			$temp = array();
			reset($field_names);
			foreach ($result as $field_name) {
				$temp[$field_alias_prefix . current($field_names)] = $field_name;
				next($field_names);
			}
			$result = $temp;
		}
		return $result;			
	}
};