<?php

	include "userController.php";
	$userController = new userController();

	$users = $userController->get();
	//echo json_encode($users);
?>

<!DOCTYPE html>
<html>
  <head>
 
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">

   <meta charset="UTF-8">
   <title>Bootstrap</title>
  </head>
  <body>

  	<div id="wrapper">
  		
	<div class="container">

  		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="#">TACOS</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="#">Inicio</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Link</a>
		      </li>
		      
		    </ul>
		    <form class="form-inline my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
		      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
		    </form>
		  </div>
		</nav>

		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">Home</li>
		  </ol>
		</nav>

		<?php if (isset($_SESSION['status']) && $_SESSION['status'] == "success"): ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
		  <strong>Correcto</strong> <?= $_SESSION['message'] ?>.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php unset($_SESSION['status']); ?>
		<?php endif ?>

		<?php if (isset($_SESSION['status']) && $_SESSION['status'] == "error"): ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <strong>Error!</strong> <?= $_SESSION['message'] ?>.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php unset($_SESSION['status']); ?>
		<?php endif ?>

		<div class="row">
			<div class="col-12">
				<div class="card mb-4">
				  <div class="card-header">
				    Lista de usuarios registrados
				    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary float-right" onclick="add()">Añadir usuario</button>
				  </div>
				  <div class="card-body">
				    <table class="table table-bordered table-striped">
					  <thead class="thead-dark">
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Nombre</th>
					      <th scope="col">Correo electronico</th>
					      <th scope="col">Estatus</th>
					      <th scope="col">Acciones</th>
					    </tr>
					  </thead>
					  <tbody>

					  	<?php if (isset($users) && count($users)>0):?>
					  	<?php foreach ($users as $users):?>

					    <tr>
					      <th scope="row">
					      	<?= $users['id'] ?>
					      </th>
					      <td>
					      	<?= $users['name'] ?>
					      </td>
					      <td>
					      	<a href="mailto:<?= $users['email'] ?>">
					      		<?= $users['email'] ?>
					      	</a>
					      </td>
					      <td>
					      	
					      	<?php if ($users['status']): ?>

					      		<span class="badge badge-success">
					      		Activo
					      		</span>

					      	<?php else: ?>
					      		<span class="badge badge-warning">
					      			Inactivo
					      		</span>

					      	<?php endif ?>
					      </td>
					      <td>
					      	<button data-info='<?= json_encode($users)?>' data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-warning" onclick="editar(this)">
					      		<i type="" class="fa fa-pencil" name=""> Editar</i>
					      	</button>
					      	<button type="button" onclick="remove(1)" class="btn btn-danger">
					      		<i class="fa fa-trash"> Eliminar</i>
					      	</button>
					      	
					      </td>
					    </tr>

						<?php endforeach?>
					  	<?php endif?>					    
					 
					  </tbody>
					</table>
				  </div>
				</div>
			</div>
		</div>
  	</div>
  	
  	</div>

  	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	  	    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Agregar usuario</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		     <form method="POST" action="userController.php" id="myForm" onsubmit="return validateRegister()">
	     		<div class="modal-body">
	       			<div class="form-group">
					    <label for="name">Nombre completo</label>
					    <div class="input-group mb-3">
  							<div class="input-group-prepend">
    						<span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i>
    						</span>
  							</div>
  						<input type="text" class="form-control" id="name" placeholder="usuario" aria-label="Username" aria-describedby="basic-addon1" required="" name="name">
						</div>
					  </div>
					  <div class="form-group">
					    <label for="name">Correo Electronico</label>
					    <div class="input-group mb-3">
  							<div class="input-group-prepend">
    						<span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i>
    						</span>
  							</div>
  						<input type="text" class="form-control" id="email" placeholder="usuario@hotmail.com" aria-label="correo" aria-describedby="basic-addon1" required="" name="email">
						</div>
					  </div>
					  <div class="form-group">
					    <label for="name">Contraseña</label>
					    <div class="input-group mb-3">
  							<div class="input-group-prepend">
    						<span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i>
    						</span>
  							</div>
  						<input type="password" class="form-control" id="password1"placeholder="*********" aria-label="password1" aria-describedby="basic-addon1" required="" name="password">
						</div>
					  </div>
					   <div class="form-group">
					    <label for="name">Confirmar contraseña</label>
					    <div class="input-group mb-3">
  							<div class="input-group-prepend">
    						<span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i>
    						</span>
  							</div>
  						<input type="password" class="form-control" id="password2"placeholder="*********" aria-label="password2" aria-describedby="basic-addon1" required="">
						</div>
					  </div>		 
	      		</div>
	     		<div class="modal-footer">
	       			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	      			<button type="submit" class="btn btn-primary">Guardar</button>
	      			<input type="hidden" name="action" id="action" value="store">
	      			<input type="hidden" name="id" id="id">
	     		</div>
    		</form>	
		     
		    </div>
   	  </div>
	</div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script type="text/javascript">
		function validateRegister(){
			if($("#password1").val() == $("#password2").val()){
				return true;
			}else{
				$("#password1").addClass('is-invalid');
				$("#password2").addClass('is-invalid');
				swal("Contraseña erronea", "Vuelva a escribir su contraseña", "error");

				return false;
			}
		}

		function remove(id){
			swal({
				  title: "",
				  text: "¿Desea eliminar el usuario?",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				  buttons: ["Cancelar", "Eliminar"]

				})
				.then((willDelete) => {
				  if (willDelete) {
				    swal("Usuario eliminado", {
				      icon: "success",
				    });
				  } else {
				    //swal("Your imaginary file is safe!");
				  }
				});
		}

		function editar(target){
			var info = $(target).data('info');

			$("#name").val(info.name)
			$("#email").val(info.email)
			$("#password1").val(info.password)
			$("#password2").val(info.password)
			$("#id").val(info.id)

			$("#action").val('update')

			//console.log($(target).data('info'));
			
		}

		function add(){
			$("#action").val('store')
			document.getElementById("myForm").reset();
		}
	</script>

  </body>
</html>