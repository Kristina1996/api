<?php
	class User{
	
		private $conn;
		private $table_name = "users";
	 
		public $id;
		public $name;
		public $surname;
		public $age;
		public $address;
		public $position;
		public $salary;
		public $inn;
	 
		// Конструктор соединения с бд
		public function __construct($db) {
			$this->conn = $db;
		}
		
		// Получение всех пользователей
		function read() {
			$query = "SELECT
						p.id, p.name, p.surname, p.age, p.address, p.position, p.salary, p.inn
					FROM
						" . $this->table_name . " p";
		 
			// Подготовка запроса
			$stmt = $this->conn->prepare($query);
		 
			// Выполнение запроса
			$stmt->execute();
			return $stmt;
		}
		
		// с подгрузкой
		public function readPaging($from_record_num, $records_per_page) {
		 
			$query = "SELECT
						p.id, p.name, p.surname, p.age, p.address, p.position, p.salary, p.inn
					FROM
						" . $this->table_name . " p
					LIMIT ?, ?";
		
			$stmt = $this->conn->prepare( $query );
			
			$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt;
		}
		
		// Получение одного пользователя
		function readOne() {
			$query = "SELECT
						p.id, p.name, p.surname, p.age, p.address, p.position, p.salary, p.inn
					FROM
						" . $this->table_name . " p
					WHERE
						p.id = ?
					LIMIT
						0,1";
		 
			$stmt = $this->conn->prepare( $query );
		 
			// Привязка id к обновлению
			$stmt->bindParam(1, $this->id);
		 
			$stmt->execute();
		 
			// Получение данных
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		 
			$this->name = $row['name'];
			$this->surname = $row['surname'];
			$this->age = $row['age'];
			$this->address = $row['address'];
			$this->position = $row['position'];
			$this->salary = $row['salary'];
			$this->inn = $row['inn'];
		}
		
		// Обновление пользователя
		function update($data) {
			
			$host = "localhost";
			$db_name = "api_db";
			$username = "root";
			$password = "";
			
			$con = mysqli_connect($host, $username, $password, $db_name);
			
			$query = "UPDATE users SET name='".$data->name."', surname='".$data->surname."',
							position='".$data->position."',
							age='".$data->age."',
							inn='".$data->inn."'WHERE id='".$data->id."' ";
			
			if (mysqli_query($con, $query)) {
				return true;
			} else { return false; }
			
			mysqli_close($con);
		}
	}
?>