<?php

class Connection 
{
	
	public function __construct($dbHost, $dbUser, $dbPass, $dbName)
	{
		
		//Prepare the variables
		$this->dbHost = $dbHost;
		$this->dbUser = $dbUser;
		$this->dbPass = $dbPass;
		$this->dbName = $dbName;
		
		//Call the connection
		$this->connect();
		
	}
	
	public function connect()
	{
		
		//Open the database connection
		$this->openConnection();
		
		//Select the database
		$this->selectDatabase();
		
	}
	
	public function openConnection()
	{
	
		//Create the connection
		$this->connection = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass) or die(mysql_error());	
		
	}
	
	public function selectDatabase()
	{
	
		//Select the database
		$this->selection = mysql_select_db($this->dbName) or die(mysql_error());
		
	}
	
	public function query($query)
	{
		
		//Run the query and return the result
		$this->result = mysql_query($query) or die(mysql_error());
		return $this->result;
		
	}
	
	public function delete($table, $conditions)
	{
		
		//Run a delete query
		//Params
		//table (varchar)
		//conditions (anytext)
		//echo 'DELETE FROM '.$table.'  '.$conditions.'';
		$this->query('DELETE FROM '.$table.'  '.$conditions.'');
	
	}
	
	public function update($parameters)
	{
	
		//Run an update query
		//Params (Pass through the array below when calling the update method)
		//parameters (array)
		//Formatting the array : array('table' => 'tablenamehere', 'fieldsAndValues' => array('field' => 'newFieldValue', 'field2' => 'newFieldValue2'), 'conditions' => 'WHERE ID = "70600"')
	
		//Prepare the variables
		$this->updateParameters = $parameters;
		$this->fieldsAndValues = '';
	
		//Count how many items in the array
		$this->totalFields = count($this->updateParameters['fieldsAndValues']);
		$this->increment = 1;
		
		//Loop through the array that contains the fields to update with their mapped values
		while(list($key, $val) = @each($this->updateParameters['fieldsAndValues']))
		{
		
			//Set the update string container the fields mapped with the new values
			$this->fieldsAndValues .= $key.' = "'.mysql_real_escape_string($val).'"'; 
			
			//If the current increment is less than the total fields add the separating comma
			if($this->increment < $this->totalFields)
			{
			
				$this->fieldsAndValues .= ', ';
			
			}
			
			$this->increment++;
		
		}
	
		//Run the query
		$this->query('
		UPDATE '.$this->updateParameters['table'].'
		SET '.$this->fieldsAndValues.'
		'.$this->updateParameters['conditions'].'
		');
	
	}
	
	public function insert($parameters)
	{
	
		//Run a delete query
		//Params  (Pass through the array below when calling the insert method)
		//parameters (array)
		//Formatting the array : array('table' => 'tablenamehere', 'fieldsAndValues' => array('field' => 'newFieldValue', 'field2' => 'newFieldValue2'))
	
		//Prepare the variables
		$this->insertParameters = $parameters;
		
		$this->fields = '(';
		$this->values = '(';
	
		//Count how many items in the array
		$this->totalFields = count($this->insertParameters['fieldsAndValues']);
		$this->increment = 1;
		
		//Loop through the array that contains the fields to update with their mapped values
		while(list($key, $val) = @each($this->insertParameters['fieldsAndValues']))
		{
		
			//Set the update string container the fields mapped with the new values
			$this->fields .= $key;
			$this->values .= '"'.mysql_real_escape_string($val).'"';
			
			//If the current increment is less than the total fields add the separating comma
			if($this->increment < $this->totalFields)
			{
			
				$this->fields .= ', ';
				$this->values .= ', ';
			
			}
			
			$this->increment++;
		
		}
		
	
		$this->fields .= ')';
		$this->values .= ')';
		
		$this->query('
		INSERT INTO '.$this->insertParameters['table'].'
		'.$this->fields.'
		VALUES 
		'.$this->values.'
		');
	
	}
	
	public function close()
	{
		
		return mysql_close();
			
	}
	
}

?>