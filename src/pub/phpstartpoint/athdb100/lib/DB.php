<?php
class DB
    {

        public function __construct()
        {
            /*
             * The file db.conf should look similar to:-
             *
				db=yourdbname
				dbpw=yourdbpassword
				dbuser=adbusername
				host=localhost
             */
            $config = parse_ini_file('/srv/ath/src/pub/phpstartpoint/athdb100/etc/db.conf');
            $this->user = $config['dbuser'];
            $this->password = $config['dbpw'];
            $this->database = $config['db'];
            $this->host = $config['host'];
            // Connect to the database
            $this->db = $this->connect();
        }

        protected function connect()
        {
            return new mysqli($this->host, $this->user, $this->password, $this->database);
        }

        public function query($query)
        {
            $result = $this->db->query($query);
            //echo $query ."\n";
            #$results[] = array();
            while ($row = $result->fetch_object()) {
                $results[] = $row;
            }
            return $results;
        }

        public function insert($table, $data, $format)
        {
            // Check for $table or $data not set
            if (empty($table) || empty($data)) {
                return false;
            }
            
            // Cast $data to array
            $data = (array) $data;
            
            list ($fields, $placeholders, $values) = $this->prep_query($data);
            
            // Prepend $format onto $values
            array_unshift($values, $format);
            
            // Prepary our query for binding
            $stmt = $this->db->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");
            
            // Dynamically bind values
            call_user_func_array(array(
                $stmt,
                'bind_param'
            ), $this->ref_values($values));
            
            // Execute the query
            $stmt->execute();
            
            // Check for successful insertion
            if ($stmt->affected_rows) {
                return $this->db->insert_id;
            }
            
            return false;
        }

        public function update($table, $data, $format, $where, $where_format, $limit=1)
        {
            // Check for $table or $data not set
            if (empty($table) || empty($data)) {
                return false;
            }
            
            // Cast $data to array
            $data = (array) $data;
            
            // Build format string
            $format .= $where_format;
            
            list ($fields, $placeholders, $values) = $this->prep_query($data, 'update');
            
            // Format where clause
            $where_clause = '';
            $where_values = '';
            $count = 0;
            
            foreach ($where as $field => $value) {
                if ($count > 0) {
                    $where_clause .= ' AND ';
                }
                
                $where_clause .= $field . '=?';
                $where_values[] = $value;
                
                $count ++;
            }
            
            // Prepend $format onto $values
            array_unshift($values, $format);
            $values = array_merge($values, $where_values);
            
            // Prepary our query for binding
            $stmt = $this->db->prepare("UPDATE {$table} SET {$placeholders} WHERE {$where_clause} LIMIT {$limit}");
            // echo "UPDATE {$table} SET {$placeholders} WHERE {$where_clause}";exit;
            // Dynamically bind values
            call_user_func_array(array(
                $stmt,
                'bind_param'
            ), $this->ref_values($values));
            
            // Execute the query
            $stmt->execute();
            
            // Check for successful insertion
            if ($stmt->affected_rows) {
                return true;
            }
            
            return false;
        }

        public function select($query, $data, $format)
        {
            
            // Prepare our query for binding
            $stmt = $this->db->prepare($query);
            
            // Prepend $format onto $values
            array_unshift($data, $format);
            
            // Dynamically bind values
            call_user_func_array(array(
                $stmt,
                'bind_param'
            ), $this->ref_values($data));
            echo $this->db->error;
            // Execute the query
            $stmt->execute();
            
            // Fetch results
            $result = $stmt->get_result();
            
            
            // Create results object
            while ($row = $result->fetch_object()) {
                $results[] = $row;
            }
            
            if(!isset($results)){
            	return false;
            }
            
            return $results;
        }

        public function delete($table, $id, $idField, $limit=1)
        {
            
            // Prepary our query for binding
            $stmt = $this->db->prepare("DELETE FROM {$table} WHERE {$idField} = ? LIMIT {$limit}");
            
            // Dynamically bind values
            $stmt->bind_param('d', $id);
            
            // Execute the query
            $stmt->execute();
            
            // Check for successful insertion
            if ($stmt->affected_rows) {
                return true;
            }
        }

        private function prep_query($data, $type = 'insert')
        {
            // Instantiate $fields and $placeholders for looping
            $fields = '';
            $placeholders = '';
            $values = array();
            
            // Loop through $data and build $fields, $placeholders, and $values
            foreach ($data as $field => $value) {
                $fields .= "{$field},";
                $values[] = $value;
                
                if ($type == 'update') {
                    $placeholders .= $field . '=?,';
                } else {
                    $placeholders .= '?,';
                }
            }
            
            // Normalize $fields and $placeholders for inserting
            $fields = substr($fields, 0, - 1);
            $placeholders = substr($placeholders, 0, - 1);
            
            return array(
                $fields,
                $placeholders,
                $values
            );
        }

        private function ref_values($array)
        {
            $refs = array();
            
            foreach ($array as $key => $value) {
                $refs[$key] = &$array[$key];
            }
            
            return $refs;
        }
    }

?>

