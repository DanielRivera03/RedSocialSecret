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

<!--
<h2>¿Deseas probar la demo en vivo:</h2>
<p>Se ha habilitado un espacio dentro de un hosting gratuito para efectuar pruebas de este sistema, por favor tome en cuenta que la velocidad de respuesta así como su ancho de banda y cantidad de usuarios se ve limitada al ser un hosting gratuito. Puede acceder a la demo en el siguiente enlace: https://secretsocial.helioho.st/IniciarSesion/inicio A continación se detalla el ingreso del perfil de pruebas para ingresar<br><br>
<br>
<ul>
  <li>correo: jp@correo.com | clave: 123456789</li>
</ul>

-->

![Captura de pantalla 2023-04-06 183300](https://user-images.githubusercontent.com/44457989/230517288-a8c47f9a-2fb2-4fd7-b21d-d2cbb14b6d30.png)



<p>Para la subida de archivos multimedia, por favor tome nota que únicamente puede subir archivos hasta un máximo de 8MB. Además de tomar las diferentes restricciones dentro de la plataforma. NO existen roles de usuario estrictamente asignados.</p>


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

---

<h1 align="center">🔄 Actualización Mayor — Modificación 2026</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Versión-2026.1-blue?style=for-the-badge" alt="Versión 2026.1">
  <img src="https://img.shields.io/badge/Estado-Producción-brightgreen?style=for-the-badge" alt="Estado Producción">
  <img src="https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge&logo=php" alt="PHP 8+">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL 8">
</p>

<p>En el año 2026 se llevó a cabo una refactorización y expansión significativa de la plataforma <strong>Secret Social</strong>. El objetivo principal fue modernizar la experiencia de usuario, introducir funcionalidades de tiempo real, corregir deudas técnicas acumuladas y elevar el estándar visual y de interacción al nivel de las redes sociales comerciales contemporáneas. A continuación se detalla el alcance completo de dichas modificaciones.</p>

---

<h2>🎯 Objetivos de la Modificación 2026</h2>

<ul>
  <li>Eliminar por completo la dependencia de recargas completas de página (<em>full page reloads</em>) durante las interacciones del usuario.</li>
  <li>Implementar un sistema de notificaciones y actualizaciones en tiempo real mediante sondeo AJAX (<em>long polling</em>).</li>
  <li>Introducir nuevas secciones y funcionalidades de alto impacto visual: <strong>Historias efímeras estilo Instagram</strong>, <strong>Secret Reels</strong> (vídeos verticales), <strong>Notas de Música</strong> y <strong>Marketplace</strong>.</li>
  <li>Rediseñar la interfaz de usuario con un sistema de diseño <em>premium</em>, incluyendo soporte de modo oscuro, glassmorfismo, animaciones de micro-interacción y tipografías modernas de Google Fonts.</li>
  <li>Corregir bugs críticos en los flujos de confirmación de SweetAlert2 que bloqueaban el UI tras interacciones de gestión de amistades.</li>
  <li>Fortalecer el esquema de base de datos con nuevas tablas, columnas y vistas para soportar las nuevas funcionalidades.</li>
</ul>

---

<h2>🏗️ Cambios de Arquitectura y Base de Datos</h2>

<h3>Nuevas Tablas Incorporadas</h3>

<table>
  <thead>
    <tr>
      <th>Tabla</th>
      <th>Propósito</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>historias</code></td>
      <td>Almacena las historias efímeras publicadas por los usuarios (imagen + texto, duración de 24 horas).</td>
    </tr>
    <tr>
      <td><code>historia_vistas</code></td>
      <td>Registra qué usuarios han visualizado cada historia, permitiendo mostrar el conteo de espectadores al autor.</td>
    </tr>
    <tr>
      <td><code>historia_megusta</code></td>
      <td>Gestiona las reacciones (<em>likes</em>) sobre las historias efímeras, con detección de estado previo para toggle.</td>
    </tr>
    <tr>
      <td><code>notas_musica</code></td>
      <td>Almacena las notas musicales publicadas por usuario (canción asociada desde iTunes API, texto libre).</td>
    </tr>
    <tr>
      <td><code>videos</code></td>
      <td>Tabla extendida para el módulo <em>Secret Reels</em>, con soporte de vídeo vertical MP4/WebM y sistema de likes por vídeo.</td>
    </tr>
    <tr>
      <td><code>video_likes</code></td>
      <td>Tabla de reacciones sobre los Reels, con lógica de toggle y conteo en tiempo real.</td>
    </tr>
    <tr>
      <td><code>marketplace_productos</code></td>
      <td>Repositorio de productos publicados en el Marketplace integrado de la plataforma.</td>
    </tr>
    <tr>
      <td><code>llamadas</code></td>
      <td>Infraestructura de soporte para el módulo experimental de llamadas entre usuarios.</td>
    </tr>
  </tbody>
</table>

<h3>Modificaciones al Esquema Existente</h3>

<ul>
  <li>Columna <code>fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP</code> añadida a la tabla <code>solicitudamistad</code> para ordenamiento cronológico en el sistema de notificaciones unificado.</li>
  <li>Columna <code>typing_at</code> añadida al módulo de mensajería para soporte de indicador "<em>escribiendo...</em>" en tiempo real.</li>
  <li>Vista <code>vista_solicitudesamistad</code> recreada para exponer el campo <code>usuario</code> (username único), permitiendo enlaces directos al perfil del solicitante desde la campana de notificaciones.</li>
  <li>Vista <code>vista_notificacionesamigos</code> recreada con el mismo propósito de enrutamiento por username.</li>
</ul>

---

<h2>✨ Nuevas Funcionalidades</h2>

<h3>📖 Historias Efímeras (Stories)</h3>
<p>Se implementó un sistema de historias efímeras con una experiencia de usuario completamente fiel a la de Instagram y Facebook. Las historias duran 24 horas desde su publicación y desaparecen automáticamente. Las funcionalidades incluyen:</p>
<ul>
  <li>Barra de historias tipo carrusel horizontal en el feed principal, con burbujas de avatar con anillo degradado para historias no vistas.</li>
  <li>Visor de historias a pantalla completa con barras de progreso animadas por <code>requestAnimationFrame</code>, navegación por toque/clic en zonas izquierda/derecha, y pausa automática al enfocarse en el campo de respuesta.</li>
  <li>Sistema de respuesta directa a historias integrado con la mensajería privada.</li>
  <li>Panel de espectadores visible únicamente para el autor de la historia, con conteo de vistas y likes.</li>
  <li>Botón de like (❤️) con animación de latido para usuarios espectadores.</li>
  <li>Modal de creación de historias con soporte de texto libre y carga de imagen, accesible desde el avatar del usuario en la barra de historias.</li>
  <li>Actualización en tiempo real de la barra de historias sin recarga de página.</li>
</ul>

<h3>🎬 Secret Reels (Vídeos Verticales)</h3>
<p>Se creó una sección dedicada de Reels, accesible desde la barra lateral de navegación. Esta funcionalidad es análoga a Instagram Reels y TikTok:</p>
<ul>
  <li>Reproductor de vídeo vertical en pantalla completa con desplazamiento snap-scroll (una tarjeta por vista).</li>
  <li>Reproducción automática al entrar en el viewport mediante la API <code>IntersectionObserver</code>.</li>
  <li>Control de silencio/sonido global persistente entre tarjetas.</li>
  <li>Sistema de likes por Reel con toggle instantáneo vía AJAX y animación de corazón flotante al hacer doble clic.</li>
  <li>Indicador animado de reproducción/pausa al hacer clic simple.</li>
  <li>Botón flotante de acción para subir nuevos Reels con validación de tamaño de archivo del lado cliente y servidor.</li>
  <li>Estado vacío (<em>empty state</em>) ilustrado cuando no hay Reels publicados.</li>
</ul>

<h3>🎵 Notas de Música</h3>
<p>Sistema de "notas musicales" similar al de Instagram, donde los usuarios publican la canción que están escuchando actualmente:</p>
<ul>
  <li>Búsqueda de canciones en tiempo real integrada con la <strong>iTunes Search API</strong> de Apple.</li>
  <li>Visualización en el feed de las burbujas musicales de los contactos del usuario.</li>
  <li>Tooltip interactivo al pasar el cursor sobre la nota de un contacto para ver el título y artista.</li>
  <li>Gestión de nota propia (crear, actualizar, eliminar) con UX de un solo clic.</li>
</ul>

<h3>🛒 Marketplace Integrado</h3>
<p>Se integró un módulo de Marketplace dentro de la plataforma que permite a los usuarios publicar y explorar productos:</p>
<ul>
  <li>Publicación de productos con nombre, descripción, precio y fotografía.</li>
  <li>Vista de catálogo en tarjetas con filtrado dinámico.</li>
  <li>Soporte para múltiples imágenes por producto.</li>
  <li>Panel de administración de los propios listados.</li>
</ul>

<h3>🔔 Sistema de Notificaciones Unificado en Tiempo Real</h3>
<p>El sistema de notificaciones fue completamente rediseñado para soportar todos los tipos de eventos en una única vista consolidada:</p>
<ul>
  <li>Las últimas <strong>15 notificaciones</strong> de todos los tipos se muestran en el dropdown de la campana (🔔), ordenadas cronológicamente de más reciente a más antigua.</li>
  <li>Tipos de notificaciones soportados: <em>solicitudes de amistad pendientes</em>, <em>amistades aceptadas</em>, <em>comentarios en publicaciones</em>, <em>reacciones (Me Gusta) en publicaciones</em>, <em>reacciones en historias</em> y <em>mensajes privados nuevos</em>.</li>
  <li>Sondeo automático (<em>polling</em>) cada <strong>10 segundos</strong> mediante <code>setInterval</code> + AJAX al endpoint <code>live-notifications</code>.</li>
  <li>Toasts de notificación <em>push</em> de tipo glassmorfismo que aparecen automáticamente al detectar una nueva notificación, sin acción del usuario.</li>
  <li>El dropdown de solicitudes de amistad se reconstruye dinámicamente en el DOM, sin requerir recarga de página, mostrando los botones "Confirmar" y "Rechazar" funcionales desde el propio header.</li>
  <li>Los contadores y puntos indicadores (badge rojo) en el ícono de campana y de amigos se actualizan en tiempo real.</li>
</ul>

---

<h2>🐛 Correcciones de Bugs Críticos</h2>

<table>
  <thead>
    <tr>
      <th>Archivo</th>
      <th>Bug Corregido</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>alerta-solicitudesaceptadas.js</code></td>
      <td>El executor de la promesa <code>preConfirm</code> de SweetAlert2 no invocaba <code>resolve()</code>, dejando el modal en un estado de carga infinita al confirmar una solicitud de amistad.</td>
    </tr>
    <tr>
      <td><code>alerta-eliminarsolicitudamistad.js</code></td>
      <td>Mismo bug de promesa no resuelta al rechazar solicitudes de amistad.</td>
    </tr>
    <tr>
      <td><code>alerta-eliminaramigos.js</code></td>
      <td>La eliminación de amigos recargaba la página completa en lugar de hacer un fade-out dinámico de la tarjeta.</td>
    </tr>
    <tr>
      <td><code>alerta-eliminarnotificacionesamigos.js</code></td>
      <td>Las notificaciones eliminadas requerían recarga de página para desaparecer del listado.</td>
    </tr>
    <tr>
      <td><code>alerta-eliminarnotificacionescomentarios.js</code></td>
      <td>Idéntico al anterior para el tipo comentario.</td>
    </tr>
    <tr>
      <td><code>alerta_eliminarhistorias.js</code></td>
      <td>La eliminación de publicaciones del feed causaba una recarga completa en lugar de una animación de desvanecimiento (<em>fadeOut</em>) de la tarjeta específica.</td>
    </tr>
    <tr>
      <td><code>alerta_publicaciones.js</code></td>
      <td>Al publicar una nueva historia, el modal no se cerraba y el feed se recargaba completamente en lugar de insertar el nuevo elemento dinámicamente.</td>
    </tr>
  </tbody>
</table>

---

<h2>🚀 Eliminación de Recargas de Página (No-Reload Architecture)</h2>

<p>Uno de los cambios arquitectónicos más importantes de la actualización 2026 fue la eliminación sistemática de todos los <code>window.location.reload()</code> e <code>header('Location: ...')</code> del flujo de usuario. Se adoptó el siguiente patrón:</p>

<ol>
  <li><strong>Creación de publicaciones:</strong> El modal se cierra, el formulario se limpia y el feed se reinicia dinámicamente llamando a <code>window.FeedInfinito.reset()</code>, que borra el DOM actual y carga la primera página de publicaciones fresca desde el servidor.</li>
  <li><strong>Eliminación de publicaciones/amigos/notificaciones:</strong> La tarjeta correspondiente realiza una animación <code>fadeOut(400)</code> y es removida del DOM sin afectar el resto de la página.</li>
  <li><strong>Confirmación/rechazo de solicitudes de amistad:</strong> Se actualiza el badge de conteo, se oculta el punto indicador si el contador llega a cero, y se muestra un toast de confirmación premium.</li>
  <li><strong>Feed Infinito:</strong> Se implementó el objeto público <code>window.FeedInfinito</code> con un método <code>reset()</code> accesible globalmente, que permite a cualquier módulo de la aplicación reiniciar el feed sin comunicación entre páginas.</li>
</ol>

---

<h2>🎨 Mejoras de UI/UX y Sistema de Diseño</h2>

<ul>
  <li><strong>Modo Oscuro (<em>Dark Mode</em>):</strong> Toggle de tema oscuro/claro persistido en <code>localStorage</code>, con transiciones CSS suaves y soporte completo en todos los componentes de la interfaz.</li>
  <li><strong>Navegación lateral premium:</strong> Rediseño del sidebar con iconografía mejorada, estados activos por sección y menú colapsable en dispositivos móviles.</li>
  <li><strong>Buscador estilo Facebook en el header:</strong> Búsqueda AJAX en tiempo real con debounce de 300ms que muestra resultados de usuarios y publicaciones en un dropdown con scroll, sin requerir envío del formulario.</li>
  <li><strong>Toasts de notificación Premium:</strong> Sistema <code>window.SN</code> (<em>Secret Notifications</em>) con tarjetas flotantes de glassmorfismo, soporte de íconos por tipo, botón de acción directo y auto-descarte con animación de deslizamiento.</li>
  <li><strong>Tipografía:</strong> Migración a <strong>Montserrat</strong> y <strong>Poppins</strong> de Google Fonts en toda la plataforma, con jerarquía tipográfica clara y consistente.</li>
  <li><strong>Animaciones de micro-interacción:</strong> Efectos hover, transformaciones <code>scale</code>, transiciones <code>cubic-bezier</code> y animaciones <code>@keyframes</code> en botones, tarjetas, modales y elementos interactivos.</li>
  <li><strong>Selector de fondo degradado en publicaciones:</strong> Al crear una publicación, el usuario puede seleccionar entre 5 fondos de degradado predefinidos (Atardecer, Océano, Fuego, Neón, Mágico) para personalizar el fondo de su post.</li>
  <li><strong>Selector de sentimientos en publicaciones:</strong> Campo de estado emocional con emojis integrado en el formulario de nueva publicación.</li>
  <li><strong>Carga de múltiples imágenes con collage:</strong> Soporte para subir hasta 5 imágenes por publicación con previsualización de collage antes de publicar y soporte de arrastrar y soltar (<em>drag and drop</em>).</li>
</ul>

---

<h2>🔒 Mejoras de Seguridad y Estabilidad</h2>

<ul>
  <li>Todas las respuestas AJAX ahora incluyen una extracción robusta del JSON desde la respuesta del servidor, manejando prefijos de texto/advertencias PHP con un índice del primer <code>[</code> o <code>{</code>.</li>
  <li>Validación de tamaño de archivo multimedia en cliente y servidor para uploads de Reels, con mensajes de error específicos (<code>LIMITE_EXCEDIDO</code>, <code>FORMATO_INVALIDO</code>, <code>CAMPOS_VACIOS</code>, <code>ERROR_UPLOAD</code>).</li>
  <li>Las conexiones a base de datos en <code>premium_topnav.php</code> se cierran explícitamente antes del renderizado del contenido para evitar el error <em>"Commands out of sync"</em> de MySQLi en páginas con múltiples conjuntos de consultas.</li>
  <li>Todas las sesiones verifican <code>session_status() === PHP_SESSION_NONE</code> antes de invocar <code>session_start()</code> para prevenir errores de sesión duplicada en includes.</li>
  <li>Control de acceso reforzado en todas las páginas nuevas: redirección inmediata a la página de acceso denegado si el usuario no tiene sesión activa.</li>
</ul>

---

<h2>📊 Estado Técnico Actualizado (2026)</h2>

<p>Después de las modificaciones 2026, el sistema se distribuye de la siguiente manera:</p>

<table>
  <thead>
    <tr>
      <th>Componente</th>
      <th>Original (2021)</th>
      <th>Actualizado (2026)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Tablas de Base de Datos</td>
      <td>13</td>
      <td>21+</td>
    </tr>
    <tr>
      <td>Procedimientos Almacenados</td>
      <td>63</td>
      <td>80+</td>
    </tr>
    <tr>
      <td>Vistas SQL</td>
      <td>18</td>
      <td>22+</td>
    </tr>
    <tr>
      <td>Disparadores (<em>Triggers</em>)</td>
      <td>8</td>
      <td>8</td>
    </tr>
    <tr>
      <td>Archivos JavaScript</td>
      <td>~15</td>
      <td>25+</td>
    </tr>
    <tr>
      <td>Módulos del Sistema</td>
      <td>9</td>
      <td>14</td>
    </tr>
    <tr>
      <td>Vistas PHP (páginas)</td>
      <td>~12</td>
      <td>18</td>
    </tr>
  </tbody>
</table>

<h3>Stack Tecnológico (2026)</h3>

<ul>
  <li>🐘 <strong>Backend:</strong> PHP 8+ — Patrón MVC estricto, sin ORM, 100% Procedimientos Almacenados.</li>
  <li>🗃️ <strong>Base de Datos:</strong> MySQL 8 con uso intensivo de vistas, triggers, stored procedures y transacciones.</li>
  <li>⚡ <strong>Frontend:</strong> JavaScript ES6+, jQuery 3, Bootstrap 4, AJAX asíncrono con manejo de errores robusto.</li>
  <li>🎨 <strong>CSS:</strong> Vanilla CSS con variables CSS custom properties, complementado con Bootstrap. Glassmorfismo, dark mode, animaciones CSS3.</li>
  <li>🔤 <strong>Tipografía:</strong> Google Fonts — Montserrat + Poppins.</li>
  <li>🔔 <strong>Íconos:</strong> Remix Icons 2.x + Line Awesome.</li>
  <li>💬 <strong>Alertas:</strong> SweetAlert2 v10 con integración de promesas asíncronas.</li>
  <li>🎵 <strong>API Externa:</strong> iTunes Search API (búsqueda de canciones para Notas de Música).</li>
</ul>

---

<h2>📁 Nuevos Archivos Incorporados</h2>

<table>
  <thead>
    <tr>
      <th>Archivo</th>
      <th>Tipo</th>
      <th>Descripción</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>vista/reels.php</code></td>
      <td>Vista</td>
      <td>Página de Secret Reels con reproductor de vídeo vertical snap-scroll.</td>
    </tr>
    <tr>
      <td><code>vista/marketplace.php</code></td>
      <td>Vista</td>
      <td>Módulo de Marketplace para compra y venta entre usuarios.</td>
    </tr>
    <tr>
      <td><code>vista/stories_viewer.php</code></td>
      <td>Vista/Componente</td>
      <td>Visor de historias efímeras embebible, compatible con el feed y el perfil.</td>
    </tr>
    <tr>
      <td><code>vista/premium_sidebar.php</code></td>
      <td>Vista/Componente</td>
      <td>Barra lateral de navegación rediseñada, incluida como componente PHP reutilizable.</td>
    </tr>
    <tr>
      <td><code>vista/premium_topnav.php</code></td>
      <td>Vista/Componente</td>
      <td>Barra de navegación superior premium con buscador AJAX, dropdowns de notificaciones y solicitudes en tiempo real.</td>
    </tr>
    <tr>
      <td><code>vista/js/historias_envivo.js</code></td>
      <td>JavaScript</td>
      <td>Módulo completo del sistema de historias efímeras: carga, renderizado, reproducción, interacciones.</td>
    </tr>
    <tr>
      <td><code>vista/js/notas_musica.js</code></td>
      <td>JavaScript</td>
      <td>Módulo de Notas de Música con integración de iTunes API.</td>
    </tr>
    <tr>
      <td><code>vista/js/push_notifications.js</code></td>
      <td>JavaScript</td>
      <td>Sistema de polling de notificaciones en tiempo real, reconstrucción dinámica de dropdowns y push toasts.</td>
    </tr>
    <tr>
      <td><code>vista/js/notificaciones-premium.js</code></td>
      <td>JavaScript</td>
      <td>Librería <code>window.SN</code> para mostrar toasts premium de glassmorfismo.</td>
    </tr>
    <tr>
      <td><code>vista/js/feed-infinito.js</code></td>
      <td>JavaScript</td>
      <td>Feed de publicaciones con paginación infinita por <code>IntersectionObserver</code> y método público <code>reset()</code>.</td>
    </tr>
    <tr>
      <td><code>controlador/cHistorias.php</code></td>
      <td>Controlador</td>
      <td>Controlador backend de historias efímeras: listar, crear, registrar vistas, dar/quitar like, responder, listar espectadores.</td>
    </tr>
    <tr>
      <td><code>controlador/cNotasMusica.php</code></td>
      <td>Controlador</td>
      <td>Controlador backend de notas musicales: CRUD y proxy de búsqueda a iTunes API.</td>
    </tr>
  </tbody>
</table>

---

<h2>🙏 Agradecimientos y Créditos de Actualización</h2>

<p>La actualización 2026 fue realizada con el objetivo de demostrar que una aplicación PHP MVC nativa puede alcanzar el nivel de interactividad y experiencia de usuario de las redes sociales comerciales modernas, sin necesidad de frameworks frontend reactivos como React o Vue. Todos los efectos en tiempo real, las animaciones y la gestión dinámica del DOM se lograron exclusivamente con <strong>JavaScript vanilla y jQuery</strong>, manteniendo la filosofía original del proyecto.</p>

<blockquote>
  <p><em>"No es la herramienta lo que hace al artesano, sino el conocimiento y la dedicación con que la emplea."</em></p>
</blockquote>

<h4>*** Fecha de Modificación 2026: Junio 2026 ***</h4>
