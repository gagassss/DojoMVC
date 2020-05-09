<?php
class Database
{
  protected $conn,
            $stmt,
            $query_result,
            $select   = null,
            $orderBy  = null,
            $limit    = null,
            $where    = null;
  public function get_data($table, $select = null, $orderBy = null, $limit = null, $query_result = 'assoc_array')
  {
    if (!$select == null)
    {
      $this->select($select);
    }

    if ($this->select == null)
    {
      if ($this->where == null)
      {
        $this->stmt = "SELECT * FROM $table";
      }
      else
      {
        $this->stmt = "SELECT * FROM $table WHERE $this->where";
      }
    }
    
    else
    {
      if ($this->where == null)
      {
        $this->stmt = "SELECT $this->select FROM $table";
      }
      else
      {
        $this->stmt = "SELECT $this->select FROM $table WHERE $this->where";
      }
    }

    if(!$orderBy == null || !$limit == null || !$this->orderBy == null || !$this->limit == null)
    {
      if (!$orderBy == null)
      {
        $this->stmt .= " ORDER BY $orderBy ";
      }

      if(!$this->orderBy == null)
      {
        $this->stmt .= " ORDER BY $this->orderBy ";
      }
  
      if(!$limit == null)
      {
        $this->stmt .= " LIMIT $limit ";
      }
      if(!$this->limit == null)
      {
        $this->stmt .= " LIMIT $this->limit ";
      }
    }
    $this->stmt = $this->conn->query($this->stmt);
    $this->query_result = $query_result;
    return $this->$query_result();

  }

  public function get_where($table, $cond, $select = null, $orderBy = null, $limit = null, $query_result = 'assoc_array')
  {
    $this->where($cond);
    if (!$select == null)
    {
      $this->select($select);
    }
    
    if ($this->select == null)
    {
      $this->stmt = "SELECT * FROM $table WHERE $this->where";
    }
    
    else
    {
      $this->stmt = "SELECT $this->select FROM $table WHERE $this->where";
    }
    if(!$orderBy == null || !$limit == null || !$this->orderBy == null || !$this->limit == null)
    {
      if (!$orderBy == null)
      {
        $this->stmt .= " ORDER BY $orderBy ";
      }

      if(!$this->orderBy == null)
      {
        $this->stmt .= " ORDER BY $this->orderBy ";
      }
  
      if(!$limit == null)
      {
        $this->stmt .= " LIMIT $limit ";
      }
      if(!$this->limit == null)
      {
        $this->stmt .= " LIMIT $this->limit ";
      }
    }
    $this->stmt = $this->conn->query($this->stmt);
    $this->query_result = $query_result;
    return $this->$query_result();
  }

  public function insert_data($table, $data)
  {
    $keys = array_keys($data);
    $values = array_values($data);
    $str = '(';
    for($i = 0; $i < count($keys); $i++)
    {
      if($i < count($keys))
      {
        $str .= $keys[$i];
      }
      if($i < count($keys)-1)
      {
        $str .= ', ';
      }
    }
    $str .= ')';
    for ($j = 0; $j < count($values); $j++) 
    {
      if($j === 0)
      {
        $str2 = " (";
      }
      $str2 .= "'$values[$j]'";
      if ($j < count($values)-1)
      { 
        $str2 .=  ", ";
      }
    }
    $str2 .= ')';

    $query =  "INSERT INTO $table $str VALUES $str2";
    $this->stmt = $this->conn->query($query);
    return $this->conn->affected_rows;
  }

  public function delete_data($table, $cond = null)
  {
    if ($this->where == null && $cond == null)
    {
      $this->stmt = $this->conn->query ("DELETE FROM $table");      
    }

    if (!$this->where == null)
    {
      $this->stmt = $this->conn->query ("DELETE FROM $table WHERE $this->where");
    }
    else
    {
      $key = implode(array_keys($cond));
      $value = implode(array_values($cond));
      if ($key <= 1)
      {
        $this->stmt = $this->conn->query ("DELETE FROM $table WHERE $key = '$value'");
      }
      else
      {
       $this->where($cond);
        $this->stmt = $this->conn->query ("DELETE FROM $table WHERE $this->where");
      }
    }
    return $this->conn->affected_rows;
  }

  public function update_data($table, $data, $cond = null)
  {
    $keys = array_keys($data);
    $values = array_values($data);
    if (!$cond == null)
    {
      $this->where($cond);
      $str = '';
      for($i = 0; $i < count($keys); $i++)
      {
        $str .= $keys[$i] . " = " . "'$values[$i]'"; 
        if ($i < count($keys)-1)
        { 
          $str .=  ", ";
        }
      }
      $str .= " WHERE  $this->where";
      $this->stmt = $this->conn->query("UPDATE $table SET $str");
    }

    else
    {
      $str = '';
      for($i = 0; $i < count($keys); $i++)
      {
        $str .= $keys[$i] . " = " . "'$values[$i]'"; 
        if ($i < count($keys)-1)
        { 
          $str .=  ", ";
        }
      }
      $str .= "WHERE $this->where";
      $this->stmt = $this->conn->query("UPDATE $table SET $str");
    }
    return $this->conn->affected_rows;
  }

  public function order_by($field)
  {
    if (is_string($field))
    {
      $this->orderBy = $field;
    }
    else
    {
      $this->orderBy = implode(', ', $field);
    }
  }
  public function limit($limit)
  {
    $this->limit = $limit;
  }

  public function where($cond)
  {
    $this->where = $cond;
    $keys = array_keys($cond);
    $values = array_values($cond);
    $str = '';
    $type = strtoupper('or');
    

    if(count($cond) > 1)
    {
      if (array_key_exists('type', $cond))
      {
        $type = strtoupper(end(array_values($cond)));
        $type = end($values);
      }
      for ($i = 0; $i < count($this->where)-1; $i++)
      {
        $str .= "$keys[$i] = '$values[$i]'";
        if ($i < count($cond)-2)
        {
          $str .= " $type ";
        }
      }
    }
    else
    {
      for ($i = 0; $i < count($this->where); $i++)
      {
        $str .= "$keys[$i] = '$values[$i]'";
        if ($i < count($cond)-1)
        {
          $str .= " $type ";
        }
      }
    }

    $this->where = $str; 
  }
  public function select($select)
  {
    $str ='';
    for ($i = 0; $i < count($select); $i ++)
    {

      if ($i < count($select)-1)
      {
        $str .= "$select[$i]" . ', ';
      }
      else 
      {        
        $str .= "$select[$i]";
      }
    }
    $this->select = $str;
  }

  public function assoc_array()
  {
    if (!is_object($this->stmt))
    {
      return null;
    }
    $data = [];
    foreach($this->stmt as $rows)
    {
      $data[] = $rows;
    }
    return $data;
  }

  public function self_query($query)
  {
    $this->stmt = $query;
    $this->stmt = $this->conn->query($this->stmt);
    $data = [];
    foreach($this->stmt as $rows)
    {
      $data[] = $rows;
    }
    return $data;
  }

}

class connect_db extends database
{
  public function __construct()
  {
    global $database;
    $this->conn = new mysqli($database['hostname'], $database['username'], $database['password'], $database['database']);
  }
}