<?php
class Student
{
    // Connection
    private $conn;
    // Table
    private $db_table = "Dataorg";
    // Columns
    public $id;
    public $nama;
    public $nim;
    public $jabatan;
    public $nama_himpunan;
    public $usia;
    public $created;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // GET ALL
    public function getStudent()
    {
        $sqlQuery = "SELECT id, nama, nim, jabatan, nama_himpunan, usia, created FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createStudent()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        nama = :nama, 
                        nim = :nim, 
                        jabatan = :jabatan, 
                        nama_himpunan = :nama_himpunan, 
                        usia = :usia, 
                        created = :created";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->nim = htmlspecialchars(strip_tags($this->nim));
        $this->jabatan = htmlspecialchars(strip_tags($this->jabatan));
        $this->nama_himpunan = htmlspecialchars(strip_tags($this->nama_himpunan));
        $this->usia = htmlspecialchars(strip_tags($this->usia));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // bind data
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":nim", $this->nim);
        $stmt->bindParam(":jabatan", $this->jabatan);
        $stmt->bindParam(":nama_himpunan", $this->nama_himpunan);
        $stmt->bindParam(":usia", $this->usia);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleStudent()
    {
        $sqlQuery = "SELECT
                        id, 
                        nama, 
                        nim, 
                        jabatan, 
                        nama_himpunan, 
                        usia, 
                        created
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nama = $dataRow['nama'];
        $this->nim = $dataRow['nim'];
        $this->jabatan = $dataRow['jabatan'];
        $this->nama_himpunan = $dataRow['nama_himpunan'];
        $this->usia = $dataRow['usia'];
        $this->created = $dataRow['created'];
    }
    // UPDATE
    public function updateStudent()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        nama = :nama, 
                        nim = :nim, 
                        jabatan = :jabatan, 
                        nama_himpunan = :nama_himpunan, 
                        usia = :usia, 
                        created = :created
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->nim = htmlspecialchars(strip_tags($this->nim));
        $this->jabatan = htmlspecialchars(strip_tags($this->jabatan));
        $this->nama_himpunan = htmlspecialchars(strip_tags($this->nama_himpunan));
        $this->usia = htmlspecialchars(strip_tags($this->usia));
        $this->created = htmlspecialchars(strip_tags($this->created));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":nim", $this->nim);
        $stmt->bindParam(":jabatan", $this->jabatan);
        $stmt->bindParam(":nama_himpunan", $this->nama_himpunan);
        $stmt->bindParam(":usia", $this->usia);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // DELETE
    function deleteStudent()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>