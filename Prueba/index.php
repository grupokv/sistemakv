<!DOCTYPE html>
<html>
	<head>
		<title>PHPMailer enviar email adjunto archivos</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script><link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12" style="margin:0 auto; float:none;">
					<br />
					<h4>PHPMailer enviar email adjunto archivos</h4>
                    <hr>
                    <div class="card">
  <h5 class="card-header">Enviar informe</h5>
  <div class="card-body">
	<form action="enviar.php" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-5">
								<div class="mb-3">
									<label>Codigo cliente</label>
									<input type="text" name="codigo" placeholder="Ingrese código" class="form-control" required />
								</div>
								<div class="mb-3">
									<label>Nombre</label>
									<input type="text" name="nombre" placeholder="Ingrese nombre" class="form-control" required>
								</div>
								<div class="mb-3">
									<label>Email</label>
									<input type="email" name="email" class="form-control" placeholder="Ingrese Email" required />
								</div>
								
							</div>
						<div class="col-md-7">
                           <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3 files color">
                                <label> Seleccione: Imagen, PDF  </label>
                                <input type="file" class="form-control" name="resume" accept="image/*, .pdf" required>
                           
                                </div>
                            </div>
                            </div>
                        </div>
						</div>
                        <hr>
						<div class="mb-3" align="center">
							<button name="submit" value="" class="btn btn-primary">Enviar informe</button>
						</div>
					</form>
  </div>
</div>
				</div>
			</div>
		</div>
	</body>
</html>