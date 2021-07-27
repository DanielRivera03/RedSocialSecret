# Red Social PHP Nativo (Versión 8) - MVC
![PortadaRedSocial](https://user-images.githubusercontent.com/44457989/107601909-9c61ac00-6bed-11eb-849a-b061955f0089.png)
<h2>🛑 Por favor antes de iniciar, tomar en cuenta:</h2>
<p>Este sistema ha sido desarrollado bajo el lenguaje de programación PHP en su versión más reciente 8. Versiones anteriores a 7.3 no han sido testeadas y por lo que no garantizo el funcionamiento pleno en versiones abajo a 7.3.<br><br>Si usted no ha modificado su archivo .ini de apache la sugerencia es modificarlo y cambiar el valor de tamaño máximo de archivos de subida. Usted decide el valor que considere necesario. Idealmente establecerlo mayor a los 40MB.<br><br>Si piensa montar este proyecto en un hosting gratuito, <b>la sugerencia es no hacerlo, ya que la mayoría son demasiado limitados y la exigencia de este proyecto es alta con respecto a conexiones. Se realizaron las correcciones pertinentes y pruebas reutilizando y acortando las mismas, pero aún así presentan inestabilidades y en algunos casos, los procesos simplemente no se muestran o realizan. Mientras usted no tenga un hosting premium o servidor dedicado lo ideal es que lo maneje de manera local. Para asi evitar molestias innecesarias.</b><br><br>😉 Gracias por tomar en cuenta las indicaciones respectivas, ahora vamos a lo que interesa, información técnica de este proyecto:</p>
<h2>Descripción General:</h2>
<p>Este sistema se encuentra desarrollado bajo el lenguaje de programación PHP, utilizando el patrón <b>MVC (Modelo, Vista, Controlador)</b>. SGBD MySQL y todas las gestiones y procesos bajo AJAX - JQuery, complementos JQuery y Javascript. La finalidad de este proyecto es representar en un rango básico - medianamente avanzado el funcionamiento de algunas de las redes sociales tradicionales. No se pretende competir o hacer alusión que el funcionamiento de este proyecto es empíricamente estricto a las más reconocidas, simplemente es una demostración y poner en práctica nuevos conocimientos.</p>
<h2>¿Qué se puede hacer dentro de esta red social?</h2>
<p><ul>
  <li>Publicar imágenes con una descripción haciendo referencia a una "historia".</li>
  <li>Seguir a otros usuarios registrados. <b>Es de aclarar que dentro de este sistema se ha ocupado el término "Amigos", pero la lógica aplicada son solicitudes de seguimiento, cada usuario decide a quién seguir.</b></li>
  <li>Comentar publicaciones de otros usuarios, interactuar <b>(Puedes introducir emojis en los comentarios)</b>. Inclusive reaccionar a las publicaciones <b>Dar Me Gusta - Like.</b></li>
  <li>Participar en el chat general y compartir ideas o pensamientos momentáneos con todos los usuarios registrados.</li>
  <li>Publicar vídeos musicales a la vista de todos los usuarios.</li>
  <li>Visitar y ver los perfiles de otros usuarios registrados <b>(siempre y cuando cumplan con los requisitos establecidos dentro de la plataforma).</b></li>
  <li>Ver absolutamente a todos los usuarios registrados sin excepción con la posibilidad de ser "Amigos".</li>
  <li>Ver y registrar nuevos eventos sociales <b>Según tu país de registro</b>.</li>
  <li>Si tu sigues a otros usuarios, podrás ver el listado en tu inicio de cumpleañeros del día.</li>
  <li>Cambiar foto de perfil y portada (solo perfil, o ambas cosas).</li>
  <li>Registrar detalles más específicos sobre tí.</li>
  <li>Puedes hacer uso de tu cámara web para subir tu fotografía instántanea en editar perfil o completar perfil de usuarios.</li>
</ul>Son algunas de las funciones más principales e importantes que tú puedes realizar dentro de esta plataforma.</p>

<h2>Estructura interna:</h2>
<img src="https://user-images.githubusercontent.com/44457989/107603446-5f4be880-6bf2-11eb-806e-20975986eaf4.PNG" align="left">
<p align="left"><b>Inicio:</b> Puedes consultar publicaciones recientes de tus "Amigos", ver lista de eventos disponibles en tu localidad, ver lista de cumpleañeros del día</p>
<p align="left"><b>Mi Perfil:</b> Puedes consultar todas tus historias publicadas en esta red social, ver tus detalles de usuarios, ver tus "Amigos" y ver el listado completo de fotografías que hacen alusión a tus historias publicadas.</p>
<p align="left"><b>Mis Amigos:</b> Listado completo de todos tus "Amigos" aceptados. Además de gestionarlos y ver sus perfiles de usuario.</p>
<p align="left"><b>Explorar Amigos:</b> Listado completo de todos los usuarios registrados en esta red social, en dónde puedes enviar solicitudes de amistad y ver sus perfiles de usuarios.</p>
<p align="left"><b>Mis Notificaciones:</b> Consulta completa de todas las interacciones que otros usuarios hacen en tus publicaciones, y solicitudes de amistad aceptadas. <b>No es posible ver tu misma actividad.</b></p>
<p align="left"><b>Registrar Eventos:</b> Formulario de registro de nuevos eventos sociales según tu localidad (país).</p>
<p align="left"><b>Ver Eventos:</b> Listado completo registrados por todos los usuarios de esta red social de eventos sociales disponibles según tu localidad (país).</p>
<p align="left"><b>Mensajes:</b> Consulta de chat general de esta aplicación, puedes interactuar con todos los usuarios, además de gestionar tus mensajes. <b>La mensajería privada no está disponible.</b></p>
<p align="left"><b>Multimedia:</b> Puedes consultar los vídeos musicales registrados por otros usuarios, además de publicar nuevos vídeos <b>Según la capacidad de tu servidor</b> y gestionarlos.</p>
<p align="left"><b>Editar Perfil:</b> Puedes editar tu información personal, cambiar contraseña, foto de perfil, foto de portada y detalles sobre tu usuario.</p>
<br><br><p>Este sistema a nivel de código y base de datos se encuentra distribuido de la siguiente manera:<ul><li>Base de Datos:</li><ul><li>13 Tablas.</li><li>63 Procedimientos Almacenados.</li><li>18 Vistas.</li><li>8 Disparadores.</li></ul></ul><ul><li>Sistema:</li><ul><li>Lenguaje de Programación PHP.</li><li>Versión 8.</li><li>Patrón MVC (Modelo, Vista, Controlador).</li><li>Gestiones AJAX, JQuery.</li><li>Complementos JQuery, Javascript</li><li>Plantilla Bootstrap.</li></ul></ul></p>
<p><b>Es importante mencionar que dentro del código del sistema no existen llamadas directas en código SQL, sino únicamente los llamados a los procedimientos almacenados declarados en la base de datos, con su pase de parámetros respectivos.</b></p>

![CapturaModelo](https://user-images.githubusercontent.com/44457989/107604778-bf448e00-6bf6-11eb-992e-a9ace832ab0b.PNG)

<h2>Consideraciones Especiales:</h2>
<p>1. Al momento de registrarte, es de estricta obligación completar tu perfil de usuario, de lo contrario no podrás hacer uso de la aplicación. Si deseas cancelar el registro. Solamente tienes que dirigirte al formulario  <b>"Cancelar Registro" y explicar los motivos de tu cancelación, una vez procesado no hay vuelta atrás y pierdes el acceso a la plataforma, así como la posibilidad de usar ese mismo correo.</b></p>
<p>* Completar Perfil de Usuarios Nuevos</p>



![CompletarPerfil](https://user-images.githubusercontent.com/44457989/107605055-a12b5d80-6bf7-11eb-8a89-98df7d831a88.png)



<p>* Formulario Cancelar Registro</p>


![CancelarRegistro](https://user-images.githubusercontent.com/44457989/107605140-ed769d80-6bf7-11eb-979a-62b9c3a092b0.png)


<p>2. El sistema está validado para uso exclusivo a personas mayores o igual a 18 años.</p>
<p>3. Tienes límites de subidas de fotos y vídeos, por favor atender las indicaciones respectivas en los formularios en cuestión.</p>
<p>4. Está red social es privada, ningún usuario sin iniciar sesión o registrarse puede consultar los detalles de otros usuarios.</p>
<p>5. No es obligatorio completar los detalles <b>Sobre Mí</b> de tu perfil de usuario; sin embargo al no hacerlo, los demás usuarios de esta red social no podrán visualizar tu perfil de usuario, además de no poder consultar tú mismo tus detalles de usuario. En su lugar te aparecerá un mensaje de advertencia citando lo anteriormente descrito.</p>
<p>6. Puedes hacer uso de la cámara web <b>Solo de manera local en tu servidor, o en un hosting que cuente con certificado SSL vigente.</b></p>

<h2>Algunas Capturas:</h2>



![CapturaInicio](https://user-images.githubusercontent.com/44457989/107605673-7c37ea00-6bf9-11eb-89d3-f9cb2beabddf.PNG)

![CapturaPerfil4](https://user-images.githubusercontent.com/44457989/107605760-b6a18700-6bf9-11eb-9780-15d0d03f3c9d.PNG)

![CapturaPerfil3](https://user-images.githubusercontent.com/44457989/107605961-45160880-6bfa-11eb-8eb3-74bdd13a8a6f.PNG)

![CapturaPerfil2](https://user-images.githubusercontent.com/44457989/107605979-4f380700-6bfa-11eb-9425-aa38c64e129e.PNG)

![CapturaVideos](https://user-images.githubusercontent.com/44457989/107606027-71318980-6bfa-11eb-95bf-1cac9f67a5e7.PNG)


<h2>Modelo Entidad Relación - Base de Datos</h2>

![DiagramaER_SecretDB](https://user-images.githubusercontent.com/44457989/127075209-6783e205-9d81-4483-a12e-8e40521cb8fc.png)



<h2>Muchas gracias por obtener este repositorio hecho con muchas tazas de café ☕ ❤️</h2>



![poster_5dfe44fc8738c205dc24cc919a7de3fd](https://user-images.githubusercontent.com/44457989/84722426-6d047d80-af40-11ea-8a6d-31b4466c1c08.png)




<h4>*** Fecha de Subida: 11 febrero 2021 ***</h4>


