<?php
include_once("db.php"); // Include the file with the Database class


class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO students(student_number, first_name, middle_name, last_name, gender, birthday) VALUES(:student_number, :first_name, :middle_name, :last_name, :gender, :birthday);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_number', $data['student_number']);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':middle_name', $data['middle_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':birthday', $data['birthday']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
             
            if($stmt->rowCount() > 0)
            {
                return $this->db->getConnection()->lastInsertId();
            }

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
        
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT 
            s.id AS id,
            s.student_number,
            s.first_name,
            s.middle_name,
            s.last_name,
            s.gender,
            s.birthday,
            sd.contact_number,
            sd.street,
            tc.id AS town_city,
            p.id AS province,
            sd.zip_code
            FROM 
                students s
            JOIN 
                student_details sd ON s.id = sd.student_id
            JOIN 
                town_city tc ON sd.town_city = tc.id
            JOIN 
                province p ON sd.province = p.id
            WHERE 
                s.id = :id;";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $studentData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE students s
                    JOIN student_details sd ON s.id = sd.student_id
                    SET
                    s.student_number = :student_number,
                    s.first_name = :first_name,
                    s.middle_name = :middle_name,
                    s.last_name = :last_name,
                    s.gender = :gender,
                    s.birthday = :birthday,
                    sd.contact_number = :contact_number,
                    sd.street = :street,
                    sd.town_city = :town_city, -- Use town_city_id (assuming it's the town/city ID)
                    sd.province = :province,
                    sd.zip_code = :zip_code
                    WHERE s.id = :id";
    
            $stmt = $this->db->getConnection()->prepare($sql);
    
            // Bind parameters
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':student_number', $data['student_number']);
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':middle_name', $data['middle_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':birthday', $data['birthday']);
            $stmt->bindValue(':contact_number', $data['contact_number']);
            $stmt->bindValue(':street', $data['street']);
            $stmt->bindValue(':town_city', $data['town_city']);  // Assuming town_city_id is the correct field
            $stmt->bindValue(':province', $data['province']);
            $stmt->bindValue(':zip_code', $data['zip_code']);
    
            // Execute the query
            $stmt->execute();
    
            // Return the updated data
            return $this->read($id);
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function delete($id) {
        try {
            $this->db->getConnection()->beginTransaction();
    
            // Delete related records in student_details
            $sqlDetails = "DELETE FROM student_details WHERE student_id = :id";
            $stmtDetails = $this->db->getConnection()->prepare($sqlDetails);
            $stmtDetails->bindValue(':id', $id);
            $stmtDetails->execute();
    
            // Now delete the student
            $sqlStudent = "DELETE FROM students WHERE id = :id";
            $stmtStudent = $this->db->getConnection()->prepare($sqlStudent);
            $stmtStudent->bindValue(':id', $id);
            $stmtStudent->execute();
    
            $this->db->getConnection()->commit();
    
            // Check if any rows were affected (student deleted)
            if ($stmtStudent->rowCount() > 0) {
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
    
    public function displayAll(){
    try {

        $sql = "SELECT 
        s.id, 
        s.student_number, 
        s.first_name, 
        s.last_name, 
        s.middle_name,
        s.gender, 
        s.birthday, 
        sd.contact_number, 
        sd.street,
        tc.name as town_city, 
        p.name as province, 
        sd.zip_code
    FROM students s
    JOIN student_details sd ON s.id = sd.student_id
    JOIN town_city tc ON sd.town_city = tc.id
    JOIN province p ON sd.province = p.id;";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
 
    /*
        sample simple tests
    */
    public function testCreateStudent() {
        $data = [
            'student_number' => 'S12345',
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'gender' => '1',
            'birthday' => '1990-01-15',
        ];

        $student_id = $this->create($data);

        if ($student_id !== null) {
            echo "Test passed. Student created with ID: " . $student_id . PHP_EOL;
            return $student_id;
        } else {
            echo "Test failed. Student creation unsuccessful." . PHP_EOL;
        }
    }

    public function testReadStudent($id) {
        $studentData = $this->read($id);

        if ($studentData !== false) {
            echo "Test passed. Student data read successfully: " . PHP_EOL;
            print_r($studentData);
        } else {
            echo "Test failed. Unable to read student data." . PHP_EOL;
        }
    }

    public function testUpdateStudent($id, $data) {
        $success = $this->update($id, $data);

        if ($success) {
            echo "Test passed. Student data updated successfully." . PHP_EOL;
        } else {
            echo "Test failed. Unable to update student data." . PHP_EOL;
        }
    }

    public function testDeleteStudent($id) {
        $deleted = $this->delete($id);

        if ($deleted) {
            echo "Test passed. Student data deleted successfully." . PHP_EOL;
        } else {
            echo "Test failed. Unable to delete student data." . PHP_EOL;
        }
    }
}


$student = new Student(new Database());

// // Test the create method
// $student_id = $student->testCreateStudent();

// // Test the read method with the created student ID
// $student->testReadStudent($student_id);

// // Test the update method with the created student ID and updated data
// $update_data = [
//     'id' => $student_id,
//     'student_number' => 'S67890',
//     'first_name' => 'Alice',
//     'middle_name' => 'Jane',
//     'last_name' => 'Doe',
//     'gender' => '0',
//     'birthday' => '1995-05-20',
// ];
// $student->testUpdateStudent($student_id, $update_data);

// // Test the delete method with the created student ID
// $student->testDeleteStudent($student_id);

?>