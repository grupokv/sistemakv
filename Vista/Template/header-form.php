<style type="text/css">
	@media (max-width: 720px){
		.icono{
			display: none;
		}
	}
</style>
<!--Header Formulario-->
<div class="col-12 header-form">
    <h2 class="title">
        <i class="<?php echo $icono ?> icono"></i> 
        <?php if ($id == '') {
        	echo $titulo ;
        }else{
        	echo $titulo . ' - ' . $id;
        }
        ?>
    </h2>
</div>