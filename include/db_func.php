<?php

/**
 * Return MySQL resource for connection
 * 
 * @global resource $db_conn
 * @return resource
 */
function get_db_conn()
{
  global $db_conn;
  return $db_conn;
}

$db_res = null;

/**
 * Execute given sql $query and return resource if success,
 * and false otherwise.
 * 
 * @param  string  $query      SQL query (msyql)
 * @param  boolean $unbuffered
 * @return resrouce|false
 */
 
function _QExec($query, $unbuffered = false)
{
  global $db_res;
  $db_res = $unbuffered == true ? @mysql_unbuffered_query($query, get_db_conn()) : @mysql_query($query,
          get_db_conn());
  return $db_res;
}

/**
 * Return a list of rows for previously executed query if type is 'array'.
 * If type is 'column', then return list of one specified $column.
 * 
 * @param  string  $type
 * @param  integer $column
 * @return array
 */
function _QAssoc($type = 'array', $column = 0)
{
  global $db_res;

  $list = array();
  if (empty($db_res))
    return $list;

  switch ($type) {
    case 'array':
      while (false !== ($row = @mysql_fetch_assoc($db_res))) {
        $list[] = $row;
      }
      break;

    case 'column':
      while (false !== ($row = @mysql_fetch_row($db_res))) {
        if (!isset($row[$column]))
          continue;
        $list[] = $row[$column];
      }
      break;
  }
  return $list;
}

/**
 * Return one row from the previously executed query.
 * 
 * @param  array  $Default
 * @return array
 */
function _QElem($Default = array())
{
  global $db_res;
  $row = @mysql_fetch_assoc($db_res);
  if ($row === false)
    $row = $Default;
  return $row;
}

/**
 * Return ID for previously executed insert query, or false otherwise.
 * 
 * @return int|false
 */
function _QID()
{
  global $db_res;
  return $db_res == false ? false : @mysql_insert_id(get_db_conn());
}

/**
 * Return one column from the next row specified by $pos.
 * Return $default value if no more rows.
 * 
 * @param  integer $pos     Column to fetch
 * @param  string  $default Default value
 * @return mixed
 */
function _QVal($pos = 0, $default = '')
{
  global $db_res;
  $res = $default;
  if ($db_res !== false) {
    $row = @mysql_fetch_row($db_res);
    if ($row !== false && isset($row[$pos]))
      $res = $row[0];
  }
  return $res;
}

/**
 * Escapes special characters in a string for use in an SQL statement
 * 
 * @param  string $str
 * @return string
 */
function _QString($str)
{
  return mysql_real_escape_string($str, get_db_conn());
}

/**
 * Return value from the site_params table specified by $name.
 * Return $default value if not found a row.
 * 
 * @param  string $Name    
 * @param  string $Default 
 * @return mixed
 */
function _getSValue($Name, $Default = '')
{
  $qName = _QString($Name);
  _QExec("SELECT Value FROM site_params WHERE Name = '{$qName}'");
  return _QVal(0, $Default);
}

/**
 * Update $value for the given $name parameter in the site_params table.
 * 
 * @param string $Name
 * @param string $Value
 */
function _setSValue($Name, $Value)
{
  $qName = _QString($Name);
  $qValue = _QString($Value);
  _QExec("SELECT count(*) FROM site_params WHERE Name = '{$qName}'");
  $count = _QVal(0, false);
  $query = $count == false ? "INSERT INTO site_params (Name, Value) VALUES ('{$qName}', '{$qValue}')" :
      "UPDATE site_params SET Value = '{$qValue}' WHERE Name = '{$qName}'";
  _QExec($query);
}

/**
 * Return prepared part for the insert query.
 * 
 * @param  array $ar  List of key-value pairs
 * @return string
 */
function _QInsert($ar)
{
  $keys = '';
  $vals = '';
  foreach ($ar as $key => $val) {
    if ($keys != '') {
      $keys .= ', ';
      $vals .= ', ';
    }
    $keys .= "`{$key}`";
    $vals .= _QData($val);
  }
  return "({$keys}) VALUES ({$vals})";
}

/**
 * Return prepared part for the update query.
 * @param  [type] $ar [description]
 * @return [type]     [description]
 */
function _QUpdate($ar)
{
  $ct = '';
  foreach ($ar as $key => $val) {
    if ($ct != '')
      $ct .= ', ';
    $val = _QData($val);
    $ct .= "`{$key}` = {$val}";
  }
  return $ct;
}

/**
 * Escape given $val for the sql query.
 * 
 * @param  mixed $val
 * @return mixed
 */
function _QData($val)
{
  $ct = $val;
  if (is_bool($val)) {
    $ct = $val ? 'true' : 'false';
  } elseif (is_null($val)) {
    $ct = 'null';
  } elseif (is_string($val)) {
    $ct = "'" . _QString($val) . "'";
  }
  return $ct;
}

/**
 * Produce ID for given value, or FALSE if not found.
 *
 * @param string  $Name     Value of the name for a given $Table
 * @param string  $Table    Table name for search $Name
 * @param boolean $add      If TRUE then add $Name if it's not in a $Table
 * @return int|boolean      ID for the given $Name or FALSE otherwise
 */
function _TValue($Name, $Table, $add = true)
{
  $qName = _QString($Name);
  $query = "SELECT ID FROM {$Table} WHERE Name = '{$qName}'";

  _QExec($query);
  $id = _QVal(0, false);

  if ($id === false && $add == true) {
    _QExec("INSERT INTO {$Table} (Name) VALUES ('{$qName}')");
    $id = _QID();
  }
  return $id;
}

/**
 * Return value associated with the given $id in the $table.
 * 
 * @param  int $ID
 * @param  string $Table
 * @return mixed
 */
function _PValue($ID, $Table)
{
  _QExec("SELECT Name FROM {$Table} WHERE ID = {$ID}");
  return _QVal();
}
