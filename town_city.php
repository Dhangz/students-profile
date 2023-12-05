<?php
include_once("db.php"); // Include the Database class file

class TownCity {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function create($data) {
        try {
            // Check if 'name' is set in the data and is not empty
            if (!isset($data['name']) || empty($data['name'])) {
                throw new Exception("Name cannot be empty.");
            }
    
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO town_city(name) VALUES(:name);";
            $stmt = $this->db->getConnection()->prepare($sql);
    
            // Bind values to placeholders
            $stmt->bindParam(':name', $data['name']);
    
            // Execute the INSERT query
            $stmt->execute();
    
            // Check if the insert was successful
            if ($stmt->rowCount() > 0) {
                return $this->db->getConnection()->lastInsertId();
            }
    
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        } catch (Exception $e) {
            // Handle the specific exception for empty 'name'
            echo "Error: " . $e->getMessage();
            // You might want to log this or handle it in a way suitable for your application
        }
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM town_city WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $town_cityData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $town_cityData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function delete($id) {
        try {
            $this->db->getConnection()->beginTransaction();
    
            // Delete related records in student_details
            $sqltown_city = "DELETE FROM town_city WHERE id = :id";
            $stmttown_city = $this->db->getConnection()->prepare($sqltown_city);
            $stmttown_city->bindValue(':id', $id);
            $stmttown_city->execute();
    
    
            $this->db->getConnection()->commit();
    
            // Check if any rows were affected (student deleted)
            if ($stmttown_city->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; // No records were deleted (student_id not found)
            }
        } catch (PDOException $e) {
            $this->db->getConnection()->rollBack();
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }


    public function update($id, $data) {
        try {
            $sql = "UPDATE town_city SET   
                    name = :name
                    WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindValue(':id', $data['id']);
            $stmt->bindValue(':name', $data['name']);
            
            // Execute the query
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function displayAll() {
        try {
            $sql = "SELECT * FROM town_city";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors (log or display)
            throw $e; // Re-throw the exception for higher-level handling
        }
    }


}
?>
