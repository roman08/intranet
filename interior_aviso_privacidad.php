<!-- aviso privacidad -->
	<article id="avisoPrivacidad">
		<h3 class="TitBloque">AVISO DE PRIVACIDAD</h3>
		<div class="contInfo">
			<div class="seccionInt">
				<?php
				$texto=FetchArray(ProcesaQuery("SELECT *
				FROM intranet_aviso_privacidad
				WHERE id='1';"));
				echo $texto['texto'];
				 ?>

			</div>
		</div>
	</article>
