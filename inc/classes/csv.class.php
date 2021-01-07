<?php

class MAPI_CSV
{
  public $terminator = "\n";
  public $separator = ",";
  public $enclosed = '"';
  public $escaped = "\\";
  public $mimeType = "text/csv";

  private $filename;
  protected $headerColumns = array();
  protected $rows = array();

  public function __construct($filename = "file")
  {
    $this->filename = $filename . '.csv';
  }

  /******************
  * getFilename
  * @return $this->filename
  ******************/
  public function getFilename()
  {
    return $this->filename;
  }

  /******************
  * headerColumns
  * if $columns provided, sets headerColumns
  * else returns the headerColumns array
  * @param $columns = and array of columns
  * @return = array of header columns (if $columns is false)
  ******************/
  public function headerColumns($columns = false)
  {

    if ($columns)
    {
      //START: set headerColumns
      if ($this->colCheckMismatch($columns))
      {
        echo 'Unable to add header columns - row column mismatch!';
      }
      else
      {
        if (is_array($columns))
        {
          foreach($columns as $column) :
            $this->headerColumns[] = $column;
          endforeach;
        }
        else
        {
          $this->headerColumns[0] = $columns;
        }
      }
      //END: set headerColumns
    }
    else
    {
      return $this->headerColumns;
    }

  }

  /******************
  * addRow
  * adds a row to csv
  * @param $row = and array of values to add to CSV
  ******************/
  public function addRow($row)
  {

    if ($this->colCheckMismatch($row))
    {
      echo 'Unable to insert row into CSV - header column mismatch!';
    }
    else
    {
      if (is_array($row))
      {
        $this->rows[] = $row;
      }
      else
      {
        $this->rows[][0] = $row;
      }
    }

  }

  /******************
  * colCheckMismatch
  * checks if the header columns match
  * the number of rows, or vice versa
  * @param $row = the inserting array to check
  * @return = TRUE for mismatch, FALSE for no mismatch
  ******************/
  private function colCheckMismatch($row)
  {

    if ($this->headerColumns)
    {
      if (count($this->headerColumns) != count($row)) return true;
    }
    elseif (!$this->headerColumns && $this->rows)
    {
      if (count($this->rows[0]) != count($row)) return true;
    }

    return false;

  }

  /******************
  * export
  * exports the CSV
  ******************/
  public function export()
  {

    $schema_insert = '';
    $out = '';

    if ($this->headerColumns)
    {
      //START create header row
      foreach($this->headerColumns as $column_number => $column) :
        $l = $this->enclosed . str_replace($this->enclosed, $this->escaped . $this->enclosed,
             stripslashes($column)) . $this->enclosed;
        $schema_insert .= $l;
        $schema_insert .= $this->separator;
      endforeach;
      //END create header row

      $out .= trim(substr($schema_insert, 0, -1));
      $out .= $this->terminator;
    }

    if ($this->rows)
    {
      //START build rows
      foreach($this->rows as $row) :
        foreach($row as $column => $value) :

          $schema_insert = '';

          if (isset($value))
          {

            if ($this->enclosed == '')
            {
              $schema_insert .= $value;
            }
            else
            {
              $schema_insert .= $this->enclosed .
					                      str_replace($this->enclosed, $this->escaped . $this->enclosed, $value) .
                                $this->enclosed;
            }
          }
          else
          {
            $schema_insert .= '';
          }

          if ($column < count($row) - 1)
          {
            $schema_insert .= $this->separator;
          }

          $out .= $schema_insert;

        endforeach;

        $out .= $this->terminator;

      endforeach;
      //END build rows
    }
    return $out;

  }

  /******************
  * readCSV
  * reads a csv file and stores it in $this->file
  * @param $file = the path to the file to read
  * @param $headers = true or false
  ******************/
  public function readCSV($file, $headers = false)
  {

    if (version_compare(phpversion(), '5.3.0', '<='))
    {
      $this->readCSVOldPHP($file, $headers);
      return false;
    }

    $row = 0;

	  if (($handle = fopen($file, "r")) !== FALSE)
    {

      //loop through rows
      while (($data = fgetcsv($handle, 0, $this->separator, $this->enclosed, $this->escaped)) !== FALSE)
      {

        $num = count($data);

        //error check, make sure the number of columns is consistent
        if ($row == 0)
        {
          $first_row_columns = $num;

          if ($headers)
          {
            //loop through columns
            $headerRow = array();
            for ($c=0; $c < $num; $c++)
            {
              $headerRow[$c] = $data[$c];
            }
            $this->headerColumns($headerRow);
          }
          else
          {
            //loop through columns
            for ($c=0; $c < $num; $c++)
            {
              $this->rows[$row][$c] = $data[$c];
            }
          }

        }
        else
        {
          if ($num != $first_row_columns)
          {
            echo 'The number of columns in row '.$row.' does not match the number of columns in row 0';
            fclose($handle);
            return false;
          }

          if ($headers)
          {
            //loop through columns
            for ($c=0; $c < $num; $c++)
            {
              $this->rows[$row-1][$c] = $data[$c];
            }
          }
          else
          {
            //loop through columns
            for ($c=0; $c < $num; $c++)
            {
              $this->rows[$row][$c] = $data[$c];
            }
          }
        }

        $row++;

      }
      fclose($handle);
    }

  }

  /******************
  * readCSVOldPHP (for versions less than 5.3.0)
  * reads a csv file and stores it in $this->file
  * @param $file = the path to the file to read
  * @param $headers = true or false
  ******************/
  public function readCSVOldPHP($file, $headers = false)
  {

    $row = 0;

	  if (($handle = fopen($file, "r")) !== FALSE)
    {

      //loop through rows
      while (($data = fgetcsv($handle, 0, $this->separator, $this->enclosed)) !== FALSE)
      {

        $num = count($data);

        //error check, make sure the number of columns is consistent
        if ($row == 0)
        {
          $first_row_columns = $num;

          if ($headers)
          {
            //loop through columns
            $headerRow = array();
            for ($c=0; $c < $num; $c++)
            {
              $headerRow[$c] = $data[$c];
            }
            $this->headerColumns($headerRow);
          }
          else
          {
            //loop through columns
            for ($c=0; $c < $num; $c++)
            {
              $this->rows[$row][$c] = $data[$c];
            }
          }

        }
        else
        {
          if ($num != $first_row_columns)
          {
            echo 'The number of columns in row '.$row.' does not match the number of columns in row 0';
            fclose($handle);
            return false;
          }

          if ($headers)
          {
            //loop through columns
            for ($c=0; $c < $num; $c++)
            {
              $this->rows[$row-1][$c] = $data[$c];
            }
          }
          else
          {
            //loop through columns
            for ($c=0; $c < $num; $c++)
            {
              $this->rows[$row][$c] = $data[$c];
            }
          }
        }

        $row++;

      }
      fclose($handle);
    }

  }

  /******************
  * getRow
  * @param $row = the row number to return
  * @return = an array with all the row's columns
  ******************/
  public function getRow($row)
  {
    return $this->rows[$row];
  }

  /******************
  * getRowCol
  * @param $row = the row number to return
  * @param $col = the col number to return
  * @return = value of a specific row/column
  ******************/
  public function getRowCol($row, $col)
  {
    return $this->rows[$row][$col];
  }

  /******************
  * getHeaderIndex
  * @param $header = header data to look for
  * @return = column index, FALSE for not found
  ******************/
  public function getHeaderIndex($header)
  {

    if ($this->headerColumns)
    {
      return array_search($header, $this->headerColumns);
    }

    return false;
  }

  /******************
  * getRowIndex
  * @param $col = column to check for data
  * @param $data = data to look for
  * @return = array of row indexes that match, FALSE for not found
  ******************/
  public function getRowIndex($col, $data)
  {

    if ($col && $this->rows)
    {

      $matchingRows = array();
      foreach($this->rows as $row => $rowData) :
        foreach($rowData as $column => $value) :
          if ($value == $data) $matchingRows[] = $row;
        endforeach;
      endforeach;

      return $matchingRows;
    }

    return false;
  }

  /******************
  * totalRows
  * @return total number of rows (excluding headers)
  ******************/
  public function totalRows()
  {
    return count($this->rows);
  }

  /******************
  * totalCols
  * @return total number of columns
  ******************/
  public function totalCols()
  {
    if ($this->headerColumns)
    {
      return count($this->headerColumns);
    }
    elseif (!$this->headerColumns && $this->rows)
    {
      return count($this->rows[0]);
    }

    return 0;
  }

}
