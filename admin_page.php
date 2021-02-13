<div id="wpcontent" class="wrap" style="overflow: hidden;">
	<div id="custom-admin-section" class="hide-element">
	

	<div class="postbox ">
<div class="hndle p">
<div class="d6">
	<h2>Página principal <small>(Contenido de Landing page)</small></h2>
</div>
<div class="d6">
	<button id="agregar_campo" class="page-title-action ri m" onclick="recuadro('abrir')">Agregar</button>
</div> 
<div class="c">.</div>
</div>

<!----Editar campos---------------------------------->

<?php /*Traer campos desde la base de datos*/
	$result = get_full_data();
	/*Inicia bucle*/
	foreach ( $result as $page )
	{
?>
 <form class="p" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 	<label class="title_data_front d3" for="">
 		<div id="funcion<?php echo $page->kFront; ?>" class="inline">get_data("<?php echo $page->sTitulo; ?>")</div>
 		<small class="inline" onclick="copiar('funcion<?php echo $page->kFront; ?>')">copiar</small>
 	</label>
 	
 <?php if($page->sTipo==='texto'){?>
  	<textarea name="sContenido" class="d7"  rows="3"><?php echo $page->sContenido;?></textarea>
 <?php }else{ ?>
 	<input class="d7" type="input" name="sContenido" value="<?php echo $page->sContenido;?>">
 <?php } ?>
  	<input type="hidden" name="formsubmitupdate" value="<?php echo $page->kFront; ?>" />
    <button class="page-title-action del_data_front ri" type="submit">
	 	Guardar
	 </button>
	<a class="page-title-action del_data_front ri" href="javascript:confirm_del('<?php echo $page->kFront; ?>')" >Eliminar</a>
	<div class="c">.</div>
</form>
<?php
	}
	/*Termina bucle*/
?>

<!-------------------------------------------------->
<div class="p">
<small>
*Para obtener el contenido es nesecario pegar la función get_data("título"); en donde deseé mostrarlo
</small>
</div>
<div class="c">.</div>
	
	</div>
 	</div>
 </div>

 <!--add field -->

<div id="recuadro">
		<div class="formulario sh p">
			<button id="cerrar-recuadro" class="ri" onclick="recuadro('cerrar')">X</button>
			<div class="c">.</div>
<!----Agregar campos---------------------------------->
 <form class="p" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 	<label class="d3" for="">Título</label>
 	<input class="d8" type="input" name="sTitulo" required="required" value="" placeholder="Escriba el identificador de su campo sin acentos">
 	 	<div class="br">.</div>
 	<label class="d3" for="">Tipo</label>
 	<select class="d8"  name="sTipo" onchange="textOrFile(this.value)">
	    <option value="texto">Texto</option>
	    <option value="url">Url</option>
  	</select>
 	<div class="br">.</div>
 	<label class="d3" for="">Contenido</label>
 	<textarea id="contenido-txt" class="d8" type="input" name="sContenidoTxt" value="" rows="4" cols="50"></textarea>
 	<input id="contenido-url" type="input" class="d8 hide-element" name="sContenidoUrl" value="">
 	<input type="hidden" name="formsubmitadd" value="1" />
 	<div class="br">.</div>
 <div class="max">
	 <button class="page-title-action" type="submit">
	 	Guardar
	 </button>
 </div>
</form>
<!-------------------------------------------------->
		</div>
</div>


 <?php 
// Check if the edit form was submitted.
$formsubmit = ( isset( $_POST['formsubmitupdate'] ) ) ? true : false;
if ( $formsubmit ) {
	$sContenido  = sanitize_text_field( $_POST['sContenido'] );
	$kFront  = sanitize_text_field( $_POST['formsubmitupdate'] );
	update_data_front($kFront,$sContenido);
}

/*Check if add form was submitted*/
$formsubmitadd = ( isset( $_POST['formsubmitadd'] ) ) ? true : false;
if ( $formsubmitadd ) {
	$sTitulo  = str_replace(' ', '_', strtolower(sanitize_text_field( $_POST['sTitulo'] )));
	$sTipo  = sanitize_text_field( $_POST['sTipo'] );
		if($sTipo=="texto"){
			$contenido_tipo=$_POST['sContenidoTxt'];
		} else if($sTipo=="url"){
			$contenido_tipo=$_POST['sContenidoUrl'];

		}
	$contenido  = sanitize_text_field($contenido_tipo);
	save_new_field($sTitulo,$contenido,$sTipo);

}
// Check if the delet button was form was submitted.
$formsubmitdel = ( isset( $_GET['formsubmitdel'] ) ) ? true : false;
if ( $formsubmitdel ) {
	delete_data_front( $_GET['formsubmitdel']);
}
?>