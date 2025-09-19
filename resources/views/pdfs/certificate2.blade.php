<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        @page {
            size: 8.5in 11in; /* Cambiar a tamaño carta */
            margin: 0; /* Eliminar márgenes de la página para impresión */
        }


        body {
            font-family: Calibri, sans-serif;
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bodyinside{
            text-align: center;
        }

        .container {
            
            
            padding: 20px;
            text-align: center;
            position: relative;
            background-image: url('vendor/adminlte/dist/img/fondocertificadoformacioncontinua.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            
            padding:0px;
            margin-top:50px;
            margin-left:0px;
            margin-right:0px;
        }

        .header img {
            height: 100px;            
        }

        .certificate-title {
            font-size: 3em;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
            color: #2a2a2a;
        }

        .body {
            margin-top: 30px !important;
            line-height: 1.0;
            margin-left: 18px;
            margin-right: 18px;
            text-align: justify;

        }

        .body p {
            font-size: 1.1em;
            line-height: 6pt;
        }

        .highlight {
            font-size: 1.6em;
            font-weight: bold;
            color: #000;
        }

        .footer {
    
    width: 100%;
    margin-top:70px;
    
}

.footer > div {
    display: inline-block;  /* Esto hará que los divs estén uno al lado del otro */
    width: 100%;  /* Ajusta el tamaño de los divs si es necesario */
    vertical-align: top;  /* Alinea los divs en la parte superior */
    padding: 0 0px; /* Añadir espacio entre los divs */
}



.footer img {
    height: 70px; /* Tamaño de las imágenes en el footer (si las hay) */
}



.signature {
    margin-top: 50px;
    padding-top: 5px;
    font-size: 1em;    
    /*border-top: 3px solid #000;*/
    width: 100%; /* Asegura que ocupe todo el ancho disponible */
    text-align: center; /* Para centrar el texto en cada columna */    
    display:inline;
}


        .bold {
            font-weight: bold;
        }

        .certificado{
            font-size: 80px;
            margin: 0px !important;
            padding: 0px !important;  
                
        }

        .letterbig{
            font-size: 30px;
            margin: 0px;
            padding:0px;   
            text-align: right;
            padding-right: 50px;
        }
        
        
        .contenedor{
            display: flex;
            align-items: center;
            justify-content: center;
            
        }
        .contenedor>img{
            margin-right:20px !important;
            margin-bottom:80px !important;
        }

        .derecha{
            text-align: right !important;
            margin-top: 0px;
            margin-right: 0px;
            
        }

        .claveunica{
            margin-top:15px;
            font-size: 16px;
            margin: 0px;
            padding:0px;   
            text-align: right;
            padding-right: 50px;
        }

        .claveunicaNombreEstudiante{
            margin-top:15px;
            font-size: 30px;
            margin: 0px;
            padding:0px;   
            text-align: right;
            padding-right: 20px;
            color:#1F4E79;
            
            white-space: normal; /* Permite que el texto fluya y no quede en una sola línea */
        }

        .claveunicafinal{
            margin-top:0px;
            font-size: 18px;
            text-align: center;
            color:#1F4E79;
            
        }

        .curso{
            white-space: nowrap;
        }
        .colorazul{
            color:#1F4E79;
        }
        .sinpadding{
            padding:0px;
            margin:0px;            
        }

        p{
            word-wrap: break-word;
            overflow-wrap: break-word;            
        }
        .imgqr{
            margin-top:15px;
        }
        .puesto {
            margin-top:4px;
            margin-left:10px;
            margin-right:10px;
            padding:0px;
            font-size: 0.9em; /* Puedes ajustar el tamaño del texto */
            text-align: center;
           
            max-width: 100%; /* Evita que el texto de 'puesto' sobrepase el contenedor */
        }
        .bodyinside2{
            margin-top:310px;
        }
        .texto {
            max-width: 600px; /* Limita el ancho del texto */
            text-align: center; /* Centra el texto */
        }
        .firma {
            border-top: 3px solid #000; /* Línea superior */
            margin-bottom: 20px; /* Espacio entre la línea y el texto del puesto */
            padding-top: 10px; /* Espacio entre la línea y el nombre */
            width: 60% !important; /* Asegura que la línea abarque todo el bloque */
            align:center;
        }

        
  
    </style>
</head>
<body  class="container">
    <div>
        <!-- Encabezado 240px en imagen de calea.png-->
         
        <div class="header">
            <img src="vendor/adminlte/dist/img/gobiernodemichoacan.png" style="width:160px;" alt="Logo Gobierno" />
            <img src="vendor/adminlte/dist/img/sesesp.png" alt="Logo Gobierno" />
            
            
            
            <img src="vendor/adminlte/dist/img/calea.png" style="width:240px;visibility:hidden;" alt="Logo Gobierno" />
            
            {{--
            <img src="vendor/adminlte/dist/img/calea.png" alt="Logo Gobierno" style="width:45px,heigth:45px;" class="izquierda"/>                
            --}}



            <img src="vendor/adminlte/dist/img/secretariadoejecutivomichoacantransparente.png" alt="Logo Gobierno" />
            <img src="vendor/adminlte/dist/img/secretariadoejecutivo.png" alt="Logo Gobierno" />
            
        </div>
        

        <!-- Cuerpo del certificado -->
        <div class="body">
            {{--
            <div class="bodyinside">
                <span>El Gobierno del Estado de Michoacán de Ocampo, a través</span>
                <span>del Instituto Estatal de Estudios Superiores en Seguridad y</span>
                <span>Profesionalización Policial del Estado de Michoacán</span>            
                <h2 class="sinpadding">Otorga el presente</h2>
                <h1 class="certificado">CERTIFICADO</h1>                
            </div>
            --}}
            <div class="bodyinside2">
                <h2 class="claveunicaNombreEstudiante">A: {{ $name }}</h2>                
                <h2 class="claveunicafinal">CUIP: {{$cuip}}</h2>
                <span class="curso">Por haber concluido satisfactoriamente el curso denominado:</span>
                <span><span class="bold colorazul">{{ $course }}</span>,</span>
                <span> durante el periodo que comprende del periodo del</span>
                <span>{{ $textoFinalFecha }}</span>
                <span>con una duración de <span class="bold colorazul">{{ $textoFinalHorasCurso }}</span></span>
                <span>Lo anterior de conformidad con lo establecido en los artículos 21 de la Constitución Política de los Estados Unidos Mexicanos; artículo 1, 2, 3, 4, 5 fracción, </span>
                <span>I, 7 fracción XVI,  8 y 47 de la Ley General del Sistema Nacional de Seguridad Pública; artículo 157 de la Ley del Sistema</span>
                <span>Estatal de Seguridad Pública de Michoacán de Ocampo; artículos 6 y 7 del Decreto del Instituto Estatal de Estudios</span>
                <span>Superiores en Seguridad y Profesionalización Policial del Estado de Michoacán; y, artículos 7, 8, 9 y 10 del Reglamento</span>
                <span>Interior del Instituto Estatal de Estudios Superiores en Seguridad y Profesionalización Policial del Estado de Michoacán.</span>    
            </div>
            <h4 class="colorazul bold derecha">{{$lugar}}</h4>

        </div>

        <div>
            <p style="visibility:hidden;">Lorem ipsum dolor sit amet</p>
        </div>
 

{{--
        <div class="izquierda">
            <img src="vendor/adminlte/dist/img/calea.png" alt="Logo Gobierno" style="width:60px;" class="izquierda"/>                
        </div>
        
        <div class="footer contenedor">            
            <div class="texto">
                <p class="signature bold">DRA. MARIBEL JULISA SUÁREZ BUCIO</p>
                <p class="puesto">DIRECTORA GENERAL DEL INSTITUTO ESTATAL DE ESTUDIOS SUPERIORES EN SEGURIDAD Y PROFESIONALIZACIÓN POLICIAL DEL ESTADO DE MICHOACÁN.</p>
            </div>
        </div>
--}}


        <div class="footer contenedor">
            
            <img src="vendor/adminlte/dist/img/calea.png" alt="Logo Gobierno" style="width:60px,heigth:60px;" class="izquierda"/>                
            
            <div class="texto firma">                
                <p class="signature bold">DRA. MARIBEL JULISA SUÁREZ BUCIO</p>                
                <p class="puesto">DIRECTORA GENERAL DEL INSTITUTO ESTATAL DE ESTUDIOS SUPERIORES EN SEGURIDAD Y PROFESIONALIZACIÓN POLICIAL DEL ESTADO DE MICHOACÁN.</p>
            </div>
    </div>

    </div>
</body>
</html>



@section('css')
    <!-- Aquí puedes agregar otros estilos si es necesario -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@stop