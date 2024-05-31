/**
 * Funciones auxiliares de javascripts 
 */
function confirmarBorrar(nombre,codigo){
  if (confirm("¿Quieres eliminar la pelicula:  "+nombre+"?"))
  {
   document.location.href="?orden=Borrar&codigo="+codigo;
  }
}



