<?php 
	
	class DbOperations{

		private $con;

		function __construct(){
			require_once dirname(__FILE__).'/DbConnect.php';
			$db = new DbConnect();
			$this->con = $db->connect();
		}

		/* CRUD -> C -> CREATE */ 

		public function createUser($username,$pass){
			if($this->isUserExist($username)){
				return 0;
			}else{
				$password = md5($pass);
				$stmt = $this->con->prepare("INSERT INTO `users` (`id`, `username`, `password`) VALUES (NULL, ?, ?);");
				$stmt->bind_param("ss",$username,$password);

				if($stmt->execute()){
					return 1;
				}else{
					return 2;
				}
			}
		}


		public function addStudent($name,$std_id,$dept,$section){
			if($this->isStudentExist($std_id)){
				return 0;
			}else{
				$stmt = $this->con->prepare("INSERT INTO students (id, name, std_id, dept,section) VALUES (NULL, ?, ?, ?, ?);");
				$stmt->bind_param("ssss",$name,$std_id,$dept,$section);

				if($stmt->execute()){
					return 1;
				}else{
					return 2;
				}
			}
		}

		/* CRUD -> R -> READ */

		public function userLogin($username,$pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		public function getAllStudents(){
			$sql = "SELECT * FROM students";
			$result = $this->con->query($sql);

			$students = array();

			while($row = $result->fetch_assoc()) {
		        array_push($students, $row);
		    }

		    return $students;
		}

		public function getUserByUsername($username){
			$stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		private function isUserExist($username){
			$stmt = $this->con->prepare("SELECT id FROM users WHERE username = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		private function isStudentExist($std_id){
			$stmt = $this->con->prepare("SELECT id FROM students WHERE std_id = ?");
			$stmt->bind_param("s",$std_id);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
	}
 ?>