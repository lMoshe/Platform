/**
 * Autogenerated base class representing sent rows
 * in the Streams database.
 *
 * Don't change this file, since it can be overwritten.
 * Instead, change the Streams/Sent.js file.
 *
 * @module Streams
 */

var Q = require('Q');
var Db = Q.require('Db');
var Streams = Q.require('Streams');
var Row = Q.require('Db/Row');

/**
 * Base class representing 'Sent' rows in the 'Streams' database
 * @namespace Base.Streams
 * @class Sent
 * @extends Db.Row
 * @constructor
 * @param {object} [fields={}] The fields values to initialize table row as 
 * an associative array of `{column: value}` pairs
 */
function Base (fields) {
	Base.constructors.apply(this, arguments);
}

Q.mixin(Base, Row);

/**
 * @property {String}
 * @type publisherId
 */
/**
 * @property {String}
 * @type streamName
 */
/**
 * @property {String|Db.Expression}
 * @type insertedTime
 */
/**
 * @property {String|Db.Expression}
 * @type sentTime
 */
/**
 * @property {String}
 * @type byUserId
 */
/**
 * @property {String}
 * @type comment
 */
/**
 * @property {String}
 * @type instructions
 */
/**
 * @property {String}
 * @type chatPublisherId
 */
/**
 * @property {String}
 * @type chatStreamName
 */

/**
 * This method calls Db.connect() using information stored in the configuration.
 * If this has already been called, then the same db object is returned.
 * @method db
 * @return {Db} The database connection
 */
Base.db = function () {
	return Streams.db();
};

/**
 * Retrieve the table name to use in SQL statements
 * @method table
 * @param {boolean} [withoutDbName=false] Indicates wheather table name should contain the database name
 * @return {String|Db.Expression} The table name as string optionally without database name if no table sharding was started
 * or Db.Expression object with prefix and database name templates is table was sharded
 */
Base.table = function (withoutDbName) {
	if (Q.Config.get(['Db', 'connections', 'Streams', 'indexes', 'Sent'], false)) {
		return new Db.Expression((withoutDbName ? '' : '{$dbname}.')+'{$prefix}sent');
	} else {
		var conn = Db.getConnection('Streams');
		var prefix = conn.prefix || '';
		var tableName = prefix + 'sent';
		var dbname = Base.table.dbname;
		if (!dbname) {
			var dsn = Db.parseDsnString(conn['dsn']);
			dbname = Base.table.dbname = dsn.dbname;
		}
		return withoutDbName ? tableName : dbname + '.' + tableName;
	}
};

/**
 * The connection name for the class
 * @method connectionName
 * @return {string} The name of the connection
 */
Base.connectionName = function() {
	return 'Streams';
};

/**
 * Create SELECT query to the class table
 * @method SELECT
 * @param {String|Object} [fields='*'] The fields as strings, or object of {alias:field} pairs
 * @param {String|Object} [alias=null] The tables as strings, or object of {alias:table} pairs
 * @return {Db.Query.Mysql} The generated query
 */
Base.SELECT = function(fields, alias) {
	fields = fields || '*';
	var q = Base.db().SELECT(fields, Base.table()+(alias ? ' '+alias : ''));
	q.className = 'Streams_Sent';
	return q;
};

/**
 * Create UPDATE query to the class table. Use Db.Query.Mysql.set() method to define SET clause
 * @method UPDATE
 * @param {string} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.UPDATE = function(alias) {
	var q = Base.db().UPDATE(Base.table()+(alias ? ' '+alias : ''));
	q.className = 'Streams_Sent';
	return q;
};

/**
 * Create DELETE query to the class table
 * @method DELETE
 * @param {object}[table_using=null] If set, adds a USING clause with this table
 * @param {string} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.DELETE = function(table_using, alias) {
	var q = Base.db().DELETE(Base.table()+(alias ? ' '+alias : ''), table_using);
	q.className = 'Streams_Sent';
	return q;
};

/**
 * Create INSERT query to the class table
 * @method INSERT
 * @param {object} [fields={}] The fields as an associative array of `{column: value}` pairs
 * @param {string} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.INSERT = function(fields, alias) {
	var q = Base.db().INSERT(Base.table()+(alias ? ' '+alias : ''), fields || {});
	q.className = 'Streams_Sent';
	return q;
};

/**
 * The name of the class
 * @property className
 * @type string
 */
Base.prototype.className = "Streams_Sent";

// Instance methods

/**
 * Create INSERT query to the class table
 * @method INSERT
 * @param {object} [fields={}] The fields as an associative array of `{column: value}` pairs
 * @param {string} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.prototype.setUp = function() {
	// does nothing for now
};

/**
 * Create INSERT query to the class table
 * @method INSERT
 * @param {object} [fields={}] The fields as an associative array of `{column: value}` pairs
 * @param {string} [alias=null] Table alias
 * @return {Db.Query.Mysql} The generated query
 */
Base.prototype.db = function () {
	return Base.db();
};

/**
 * Retrieve the table name to use in SQL statements
 * @method table
 * @param {boolean} [withoutDbName=false] Indicates wheather table name should contain the database name
 * @return {String|Db.Expression} The table name as string optionally without database name if no table sharding was started
 * or Db.Expression object with prefix and database name templates is table was sharded
 */
Base.prototype.table = function () {
	return Base.table();
};

/**
 * Retrieves primary key fields names for class table
 * @method primaryKey
 * @return {string[]} An array of field names
 */
Base.prototype.primaryKey = function () {
	return [
		
	];
};

/**
 * Retrieves field names for class table
 * @method fieldNames
 * @return {array} An array of field names
 */
Base.prototype.fieldNames = function () {
	return [
		"publisherId",
		"streamName",
		"insertedTime",
		"sentTime",
		"byUserId",
		"comment",
		"instructions",
		"chatPublisherId",
		"chatStreamName"
	];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_publisherId
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_publisherId = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a string to '+this.table()+".publisherId");
		if (typeof value === "string" && value.length > 31)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".publisherId");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the publisherId field
	 * @return {integer}
	 */
Base.prototype.maxSize_publisherId = function () {

		return 31;
};

	/**
	 * Returns schema information for publisherId column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_publisherId = function () {

return [["varchar","31","",false],false,"MUL",""];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_streamName
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_streamName = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a string to '+this.table()+".streamName");
		if (typeof value === "string" && value.length > 255)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".streamName");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the streamName field
	 * @return {integer}
	 */
Base.prototype.maxSize_streamName = function () {

		return 255;
};

	/**
	 * Returns schema information for streamName column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_streamName = function () {

return [["varchar","255","",false],false,"",null];
};

/**
 * Method is called before setting the field
 * @method beforeSet_insertedTime
 * @param {String} value
 * @return {Date|Db.Expression} If 'value' is not Db.Expression the current date is returned
 */
Base.prototype.beforeSet_insertedTime = function (value) {
		if (value instanceof Db.Expression) return value;
		value = (value instanceof Date) ? Base.db().toDateTime(value) : value;
		return value;
};

	/**
	 * Returns schema information for insertedTime column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_insertedTime = function () {

return [["timestamp","255","",false],false,"MUL","CURRENT_TIMESTAMP"];
};

/**
 * Method is called before setting the field
 * @method beforeSet_sentTime
 * @param {String} value
 * @return {Date|Db.Expression} If 'value' is not Db.Expression the current date is returned
 */
Base.prototype.beforeSet_sentTime = function (value) {
		if (value == undefined) return value;
		if (value instanceof Db.Expression) return value;
		value = (value instanceof Date) ? Base.db().toDateTime(value) : value;
		return value;
};

	/**
	 * Returns schema information for sentTime column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_sentTime = function () {

return [["timestamp","255","",false],true,"MUL",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_byUserId
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_byUserId = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a string to '+this.table()+".byUserId");
		if (typeof value === "string" && value.length > 31)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".byUserId");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the byUserId field
	 * @return {integer}
	 */
Base.prototype.maxSize_byUserId = function () {

		return 31;
};

	/**
	 * Returns schema information for byUserId column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_byUserId = function () {

return [["varchar","31","",false],false,"MUL",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_comment
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_comment = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a string to '+this.table()+".comment");
		if (typeof value === "string" && value.length > 255)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".comment");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the comment field
	 * @return {integer}
	 */
Base.prototype.maxSize_comment = function () {

		return 255;
};

	/**
	 * Returns schema information for comment column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_comment = function () {

return [["varchar","255","",false],false,"",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_instructions
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_instructions = function (value) {
		if (value == undefined) return value;
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a string to '+this.table()+".instructions");
		if (typeof value === "string" && value.length > 4092)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".instructions");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the instructions field
	 * @return {integer}
	 */
Base.prototype.maxSize_instructions = function () {

		return 4092;
};

	/**
	 * Returns schema information for instructions column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_instructions = function () {

return [["varchar","4092","",false],true,"",null];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_chatPublisherId
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_chatPublisherId = function (value) {
		if (value == null) {
			value='';
		}
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a string to '+this.table()+".chatPublisherId");
		if (typeof value === "string" && value.length > 31)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".chatPublisherId");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the chatPublisherId field
	 * @return {integer}
	 */
Base.prototype.maxSize_chatPublisherId = function () {

		return 31;
};

	/**
	 * Returns schema information for chatPublisherId column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_chatPublisherId = function () {

return [["varchar","31","",false],false,"",""];
};

/**
 * Method is called before setting the field and verifies if value is string of length within acceptable limit.
 * Optionally accept numeric value which is converted to string
 * @method beforeSet_chatStreamName
 * @param {string} value
 * @return {string} The value
 * @throws {Error} An exception is thrown if 'value' is not string or is exceedingly long
 */
Base.prototype.beforeSet_chatStreamName = function (value) {
		if (value == undefined) return value;
		if (value instanceof Db.Expression) return value;
		if (typeof value !== "string" && typeof value !== "number")
			throw new Error('Must pass a string to '+this.table()+".chatStreamName");
		if (typeof value === "string" && value.length > 255)
			throw new Error('Exceedingly long value being assigned to '+this.table()+".chatStreamName");
		return value;
};

	/**
	 * Returns the maximum string length that can be assigned to the chatStreamName field
	 * @return {integer}
	 */
Base.prototype.maxSize_chatStreamName = function () {

		return 255;
};

	/**
	 * Returns schema information for chatStreamName column
	 * @return {array} [[typeName, displayRange, modifiers, unsigned], isNull, key, default]
	 */
Base.column_chatStreamName = function () {

return [["varchar","255","",false],true,"",null];
};

module.exports = Base;