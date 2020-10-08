<?php

	include_once "config.php";
	include_once "connection.php";

	if (isset($_POST) && isset($_POST['action'])) {

		$userController = new userController();

		switch ($_POST['action']) {
			case 'store':
				$name = strip_tags($_POST['name']);
				$email = strip_tags($_POST['email']);
				$pass = strip_tags($_POST['password']);

				$userController->store($name,$email,$pass);
				
			break;

			case 'update':
				$name = strip_tags($_POST['name']);
				$email = strip_tags($_POST['email']);
				$pass = strip_tags($_POST['password']);
				$id = strip_tags($_POST['id']);

				$userController->update($name,$email,$pass,$id);
				
			break;
		}
	}

	Class userController
	{
		function get()
		{
			$conn = connect();
			if (!$conn->connect_error) {
				
				$query = "select * from users";
				$prepared_query = $conn->prepare($query);
				$prepared_query->execute();

				$results = $prepared_query->get_result();
				$users = $results->fetch_all(MYSQLI_ASSOC);

				if ($users) {
					return $users;
				}else{
					return array();
				}
			}else{
				return array();
			}
		}

		public function store($name, $email, $password)
		{
			$conn = connect();
			if (!$conn->connect_error) {

				if ($name!="" && $email!="" && $password!="") {
					$query = "insert into users (name,email,password) values (?,?,?)";
					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sss',$name,$email,$password);
					if ($prepared_query->execute()) {

						$_SESSION['status'] = "success";
						$_SESSION['message'] = "El registro se ha guardado correctamente";

						header('Location: '. $_SERVER['HTTP_REFERER']);
					}else{

						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El registro no ha guardado";

						header('Location: '. $_SERVER['HTTP_REFERER']);
					}

				}else{

						$_SESSION['status'] = "error";
						$_SESSION['message'] = "Verifique la información enviada";

				header('Location: '. $_SERVER['HTTP_REFERER']);
				}
			}else{

				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error durante la conexión";

				header('Location: '. $_SERVER['HTTP_REFERER']);
			}
		}

		public function update($name, $email, $password, $id)
		{
			$conn = connect();
			if (!$conn->connect_error) {

				if ($name!="" && $email!="" && $password!="") {
					$query = "update users set name = ?,email = ?,password = ? where id = ?";
					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sssi', $name, $email, $password, $id);
					if ($prepared_query->execute()) {

						//var_dump($_POST);

						$_SESSION['status'] = "success";
						$_SESSION['message'] = "El registro se ha actualizado correctamente";

						header('Location: '. $_SERVER['HTTP_REFERER']);
					}else{

						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El registro no ha actualizado";

						header('Location: '. $_SERVER['HTTP_REFERER']);
					}

				}else{

						$_SESSION['status'] = "error";
						$_SESSION['message'] = "Verifique la información enviada";

				header('Location: '. $_SERVER['HTTP_REFERER']);
				}
			}else{

				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error durante la conexión";

				header('Location: '. $_SERVER['HTTP_REFERER']);
			}
		}
	}

?>