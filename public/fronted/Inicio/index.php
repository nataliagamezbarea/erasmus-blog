<?php
session_start(); // Iniciar sesión para acceder a los datos de la sesión
include '../../backend/blog/publicaciones/obtener_paises.php'; 
include '../../backend/obtener_estadisticas.php'; 

?>
<!-- /*
* Template Name: Tour
* Template Author: Untree.co
* Tempalte URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="./images/logo.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">


	<link rel="stylesheet" href="/fronted/Inicio/css/bootstrap.min.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/owl.carousel.min.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/jquery.fancybox.min.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/icomoon/style.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/daterangepicker.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/aos.css">
	<link rel="stylesheet" href="/fronted/Inicio/css/style.css">

	<title>Blog Erasmus</title>
</head>



<body>


	<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

	<nav class="site-nav">
		<div class="container">
			<div class="site-navigation">
				<a href="/fronted/blog/publicaciones/mostrar_publicaciones.php?pais=Todos" class="logo m-0">Blog Erasmus <span class="text-primary">--an></a>

				<ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
					<li class="active"><a href="index.php">Inicio</a></li>
					<li class="has-children">
						<a href="/fronted/blog/publicaciones/mostrar_publicaciones.php?pais=Todos" class="d-flex align-items-center">
							Blog
							<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-caret-down-fill ms-3" viewBox="0 0 16 16">
								<path d="M7.247 11.14l-4.796-5.481C1.451 5.174 1.76 4 2.596 4h10.808c.836 0 1.145 1.174.145 1.659l-4.796 5.481a1 1 0 0 1-1.516 0z" />
							</svg>
						</a>


						<ul class="dropdown">
							<li class="has-children">
								<a href="#">Países</a>
								<ul class="dropdown">
									<!-- Opción "Todos" -->
									<li>
										<a href="/fronted/blog/publicaciones/mostrar_publicaciones.php?pais=Todos">Todos</a>
									</li>

									<!-- Países dinámicos -->
									<?php foreach ($paises as $pais):
										$url = "../blog/publicaciones/mostrar_publicaciones.php?pais=" . urlencode($pais);
									?>
										<li>
											<a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>">
												<?= htmlspecialchars($pais, ENT_QUOTES, 'UTF-8') ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</li>

							<!-- Comentarios -->
							<li><a href="../blog/comentarios.php">Comentarios</a></li>
						</ul>

					</li>

					<li><a href="#servicios">Servicios</a></li>
					<li><a href="#nosotros">Sobre nosotros</a></li>
					<li><a href="#contacto">Contacto</a></li>
					<li><a style="background-color: white; color: black;" href="../Registro_y_inicio_sesion/inicio_sesion.php">Iniciar sesión</a></li>
					<li><a style="background-color: white; color: black;" href="../Registro_y_inicio_sesion/registro.php">Registro</a></li>

				</ul>



				<a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
					<span></span>
				</a>

			</div>
		</div>
	</nav>


	<div class="hero">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7">
					<div class="intro-wrap">


					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="untree_co-section" id="servicios">
		<div class="container">
			<div class="row mb-5 justify-content-center">
				<div class="col-lg-6 text-center">
					<h2 class="section-title text-center mb-3">NUESTROS SERVICIOS</h2>
				</div>
			</div>
			<div class="row align-items-stretch">
				<div class="col-lg-4 order-lg-1">
					<div class="h-100">
						<div class="frame h-100">
							<div class="feature-img-bg h-100" style="background-image: url('images/Poster.jpg');"></div>
						</div>
					</div>
				</div>

				<div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-1">

					<div class="feature-1 d-md-flex">
						<div class="align-self-center">
							<span class="flaticon-house display-4 text-primary"></span>
							<h3>Publicaciones inmediatas</h3>
							<p class="mb-0">¡Nuestras recomendaciones clave para manejar correspondencia y comunicaciones durante tu Erasmus! </p>
							</p>
						</div>
					</div>

					<div class="feature-1 ">
						<div class="align-self-center">
							<span class="flaticon-restaurant display-4 text-primary"> </span>

							</i>
							<h3>Orientación cultural</h3>
							<p class="mb-0">Descubre la riqueza cultural que te rodea mientras te sumerges en nuevas tradiciones, festivales y expresiones artísticas durante tu experiencia Erasmus.</p>
						</div>
					</div>

				</div>

				<div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-3">

					<div class="feature-1 d-md-flex">
						<div class="align-self-center">
							<span class="flaticon-mail display-4 text-primary"></span>
							<h3>Comunicación durante estancias</h3>
							<p class="mb-0">Nuestras mejores recomendaciones para gestionar la correspondencia y comunicaciones.</p>
						</div>
					</div>

					<div class="feature-1 d-md-flex">
						<div class="align-self-center">
							<span class="flaticon-phone-call display-4 text-primary"></span>
							<h3>Soporte 24/7
							</h3>
							<p class="mb-0">Estamos aquí las 24 horas para ayudarte con consultas y brindarte asistencia instantánea.</p>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
	<div class="untree_co-section count-numbers py-5">
		<div class="container">
			<div class="row">
				<div class="col-6 col-sm-6 col-md-6 col-lg-3">
					<div class="counter-wrap">
						<div class="counter">
							<span class="total-publicaciones" data-number="<?= $totalPublicaciones ?>">0</span>
						</div>
						<span class="caption">Número total publicaciones</span>
					</div>

				</div>

				<div class="col-6 col-sm-6 col-md-6 col-lg-3">
					<div class="counter-wrap">
						<div class="counter">
							<span class="total-usuarios" data-number="<?= $totalUsuarios ?>"><?= $totalUsuarios ?></span>
						</div>
						<span class="caption">Número total de cuentas</span>
					</div>
				</div>

				<div class="col-6 col-sm-6 col-md-6 col-lg-3">
					<div class="counter-wrap">
						<div class="counter">
							<span class="total-paises" data-number="<?= $totalPaises ?>"><?= $totalPaises ?></span>
						</div>
						<span class="caption">Número países</span>
					</div>
				</div>

				<div class="col-6 col-sm-6 col-md-6 col-lg-3">
					<div class="counter-wrap">
						<div class="counter">
							<span class="max-likes" data-number="<?= $totalLikes ?>"><?= $totalLikes ?></span>
						</div>
						<span class="caption">Número de likes</span>
					</div>
				</div>

			</div>
		</div>
	</div>


	<div class="untree_co-section">
		<div class="container">
			<div class="row text-center justify-content-center mb-5">
				<div class="col-lg-7">
					<h2 class="section-title text-center">PAISES</h2>
				</div>
			</div>

			<div class="owl-carousel owl-3-slider">

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Dinamarca.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Dinamarca</h3>
							<span class="location">Copenhague</span>
						</div>
						<img src="images/Dinamarca.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Finlandia.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Finlandia</h3>
							<span class="location">Helsinki</span>
						</div>
						<img src="images/Finlandia.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Paris.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Francia</h3>
							<span class="location">París</span>
						</div>
						<img src="images/Paris.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Venecia.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Italia</h3>
							<span class="location">Roma</span>
						</div>
						<img src="images/Venecia.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Portugal.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Portugal</h3>
							<span class="location">Lisboa</span>
						</div>
						<img src="images/Portugal.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Irlanda.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Irlanda</h3>
							<span class="location">Dublín</span>
						</div>
						<img src="images/Irlanda.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Malta.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Malta</h3>
							<span class="location">La Valeta</span>
						</div>
						<img src="images/Malta.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Republica-Checa.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Republica Checa</h3>
							<span class="location">Praga</span>
						</div>
						<img src="images/Republica-Checa.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Polonia.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Polonia</h3>
							<span class="location">Varsovia</span>
						</div>
						<img src="images/Polonia.jpg" alt="Image" class="img-fluid">
					</a>
				</div>

				<div class="item">
					<a class="media-thumb" href="/fronted/Inicio/Estonia.jpg" data-fancybox="gallery">
						<div class="media-text">
							<h3>Estonia</h3>
							<span class="location">Tallin</span>
						</div>
						<img src="images/Estonia.jpg" alt="Image" class="img-fluid">
					</a>
				</div>



			</div>

		</div>
	</div>


	<div class="untree_co-section" id="nosotros">
		<div class="container">
			<div class="row text-center justify-content-center mb-5">
				<div class="col-lg-7">
					<h2 class="section-title text-center">NOSOTROS</h2>
				</div>
			</div>


			<div class="untree_co-section">
				<div class="container">
					<div class="row">
						<div class="col-lg-8">
							<div style="max-height: 600px; overflow: hidden;">
								<img src="images/erasmus.png" alt="">
							</div>
						</div>
						<div class="col-lg-4">
							<h1>Propósitos</h1>
							<p class="texto">Nuestra misión es transformar vidas a través de la educación internacional, fomentando la comprensión y la cooperación entre culturas. Nos dedicamos a ofrecer experiencias que no solo enriquecen académicamente, sino que también expanden horizontes personales y profesionales.</p>
						</div>
					</div>
				</div>
			</div>


			<div class="untree_co-section">
				<div class="container">
					<div class="row">
						<div class="col-lg-8">
							<div style="max-height: 600px; overflow: hidden;">
								<img src="images/erasmus_2.jpg" alt="">
							</div>
						</div>
						<div class="col-lg-4">
							<h1>Visión</h1>
							<p class="texto">Aspiramos a ser el programa Erasmus de referencia, reconocido por su excelencia en la creación de oportunidades de intercambio que promueven la diversidad, la inclusión y el desarrollo sostenible.</p>
						</div>
					</div>
				</div>
			</div>



			<div class="untree_co-section">
				<div class="container">
					<div class="row">
						<div class="col-lg-8">
							<div style="max-height: 600px; overflow: hidden;">
								<img src="images/erasmus_3.jpg" alt="">
							</div>
						</div>
						<div class="col-lg-4">
							<h1>El Rincón de las Anécdotas</h1>
							<p class="texto">Comparte historias divertidas, emotivas o inusuales vividas por estudiantes Erasmus durante sus intercambios. Desde perderse en una ciudad desconocida hasta descubrir una pasión por la cocina local, estas anécdotas pueden dar vida a la sección.</p>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="untree_co-section">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<div style="max-height: 600px; overflow: hidden;">
							<img src="images/erasmus_4.jpg" alt="">
						</div>
					</div>
					<div class="col-lg-4">
						<h1>La Galería de Fotos del Corazón</h1>
						<p class="texto">Invita a los participantes a enviar sus fotos más significativas tomadas durante su experiencia Erasmus. Desde paisajes impresionantes hasta selfies con amigos internacionales, esta galería visual captura momentos inolvidables.</p>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="untree_co-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div style="max-height: 600px; overflow: hidden;">
						<img src="images/erasmus_5.jpg" alt="">
					</div>
				</div>
				<div class="col-lg-4">
					<h1>El Viaje de los Cinco Sentidos</h1>
					<p class="texto">Sumérgete en una narrativa sensorial que describe cómo los participantes de Erasmus experimentan cada uno de los cinco sentidos durante su estancia. Desde el aroma de las especias en un mercado local hasta la sensación de la arena bajo los pies en una playa extranjera, esta sección teje una historia multisensorial.</p>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>



	<!-- Sección de contacto -->
	<div class="untree_co-section" id="contacto">
		<div class="container">
			<div class="row text-center justify-content-center mb-5">
				<div class="col-lg-7">
					<h2 class="section-title text-center">CONTACTO</h2>
				</div>
			</div>

			<!-- Mostrar mensaje de éxito o error -->
			<div class="row">
				<div class="col-lg-12 text-center">
					<?php if (isset($_SESSION['mensaje'])): ?>
						<div class="alert alert-<?= $_SESSION['mensaje']['tipo']; ?>">
							<?= $_SESSION['mensaje']['texto']; ?>
						</div>
						<?php unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo 
						?>
					<?php endif; ?>
				</div>
			</div>

			<!-- Formulario de contacto -->
			<div class="untree_co-section">
				<div class="container">
					<div class="row">
						<div class="col-lg-8">
							<div style="max-height: 600px; overflow: hidden;">
								<iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
							</div>
						</div>

						<div class="col-lg-4">
							<!-- Formulario de contacto -->
							<form class="contact-form" method="post" action="/backend/Inicio/contactar.php" data-aos="fade-up" data-aos-delay="200">
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<label class="text-black" for="fname">Nombre</label>
											<input type="text" class="form-control" id="fname" name="fname" value="<?= $_SESSION['contacto']['nombre'] ?? ''; ?>">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label class="text-black" for="lname">Apellidos</label>
											<input type="text" class="form-control" id="lname" name="lname" value="<?= $_SESSION['contacto']['apellidos'] ?? ''; ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="text-black" for="email">Email</label>
									<input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['contacto']['correo'] ?? ''; ?>">
								</div>

								<div class="form-group">
									<label class="text-black" for="date">Fecha</label>
									<input type="date" class="form-control" id="date" name="date" value="<?= $_SESSION['contacto']['fecha'] ?? ''; ?>">
								</div>

								<div class="form-group">
									<label class="text-black" for="message">Mensaje</label>
									<textarea name="message" class="form-control" id="message" cols="30" rows="5"><?= $_SESSION['contacto']['mensaje'] ?? ''; ?></textarea>
								</div>

								<button type="submit" class="btn btn-primary">Enviar mensaje</button>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>


	<script src="/fronted/Inicio/js/jquery-3.4.1.min.js"></script>
	<script src="/fronted/Inicio/js/popper.min.js"></script>
	<script src="/fronted/Inicio/js/bootstrap.min.js"></script>
	<script src="/fronted/Inicio/js/owl.carousel.min.js"></script>
	<script src="/fronted/Inicio/js/jquery.animateNumber.min.js"></script>
	<script src="/fronted/Inicio/js/jquery.waypoints.min.js"></script>
	<script src="/fronted/Inicio/js/jquery.fancybox.min.js"></script>
	<script src="/fronted/Inicio/js/aos.js"></script>
	<script src="/fronted/Inicio/js/moment.min.js"></script>
	<script src="/fronted/Inicio/js/daterangepicker.js"></script>

	<script src="/fronted/Inicio/js/typed.js"></script>


	<script src="/fronted/Inicio/js/custom.js"></script>


</body>

</html>