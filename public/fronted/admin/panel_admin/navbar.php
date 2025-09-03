<div class="dlabnav">
	<div class="dlabnav-scroll">
		<ul class="metismenu" id="menu">
			<!-- Perfil de usuario -->
			<li class="dropdown header-profile">
				<a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
					<img src="../images/ion/man (1).png" width="20" alt="Perfil Usuario" />
					<div class="header-info ms-3">
						<span class="font-w600">
							Hola, <b id="nombre_usuario"><?= htmlspecialchars($nombre_usuario_actual, ENT_QUOTES, 'UTF-8') ?></b>
						</span>
						<small class="text-end font-w400" id="email"><?= htmlspecialchars($email_usuario_actual, ENT_QUOTES, 'UTF-8') ?></small>
					</div>
				</a>
			</li>

			<!-- Menú dinámico -->
			<?php
			// Array de secciones para simplificar el menú
			$menu_items = [
				'inicio' => [
					'icon' => 'flaticon-025-dashboard',
					'label' => 'Inicio',
					'url' => '?seccion=inicio'
				],
				'informacion' => [
					'icon' => 'flaticon-050-info',
					'label' => 'Información',
					'url' => '?seccion=informacion'
				],
				'publicaciones' => [
					'icon' => 'flaticon-086-star',
					'label' => 'Publicaciones',
					'url' => '/fronted/blog/publicaciones/mostrar_publicaciones.php?pais=Todos'
				],
				'comentarios' => [
					'icon' => 'flaticon-045-heart',
					'label' => 'Comentarios',
					'url' => '../../blog/comentarios.php'
				],
				'likes' => [
					'icon' => 'flaticon-013-checkmark',
					'label' => 'Likes',
					'url' => '?seccion=likes'
				],
				'usuarios' => [
					'icon' => 'flaticon-043-menu',
					'label' => 'Gestionar usuarios',
					'url' => '?seccion=usuarios'
				]
			];

			foreach ($menu_items as $key => $item): ?>
				<li>
					<a href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>" class="<?= ($seccion === $key) ? 'mm-active' : '' ?>" aria-expanded="false">
						<i class="<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
						<span class="nav-text"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
					</a>
				</li>
			<?php endforeach; ?>

			<!-- Logout -->
			<?php
			// Uso de __DIR__ para rutas absolutas desde el archivo actual
			include __DIR__ . '/../../Registro_y_inicio_sesion/logout.php';
			?>
		</ul>
	</div>
</div>