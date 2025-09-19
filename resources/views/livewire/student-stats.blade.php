<div>
    
    <div class="container-fluid">

    <div class="row mb-5">
            <div class="col d-flex justify-content-center">
            <div class="col-4">
                
                <form wire:submit.prevent="save">

                    <select id="year_id" class="form-control d-inline w-50" wire:model="year_selected" required>                        
                            @foreach ($years as $year)
                                <option value="{{$year->number}}">{{ $year->number }}</option>
                            @endforeach
                    </select>                           
                
                    <button type="submit" class="btn btn-dark mb-1" id="btn_watch_stats" >Ver estadísticas</button>
                </form>
            </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-end">
                <button id="downloadPdf" class="btn btn-warning">Descargar Gráficas en PDF</button>
            </div>
        </div>
    



        <div class="row">
            
            <div class="col-4">                
                <canvas id="myChart" class="w-100"></canvas>
            </div>
            <div class="col-4">
                <canvas id="myChart2" class="w-100"></canvas>
            </div>
            <div class="col-4">                
                <canvas id="myChart3" class="w-100"></canvas>                
            </div>
            
        </div>
        
        <div class="row">
            
            <div class="col-12">
                <canvas id="myChart4" class="w-100"></canvas>
            </div>
            
        </div>

        <div class="row">
            
            <div class="col-12">
                <canvas id="myChart5" class="w-100"></canvas>
            </div>
            
        </div>
                    
    </div>


   
    



</div>


@livewireScripts
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    


<script>

var downloadButton = document.getElementById('downloadPdf');
downloadButton.style.display = "none";
var btn_watch_stats = document.getElementById('btn_watch_stats');
var hasData = false;






function toggleDownloadButton(visible) {        
    downloadButton.style.display = visible ? 'block' : 'none';       
}

function clearCharts() {
    const chartContainer = document.getElementById('chartContainer');
    chartContainer.innerHTML = ''; // Limpia las gráficas
    toggleDownloadButton(false);    
}

Livewire.on('updateCharts', (data) => {   
    Chart.register(ChartDataLabels);    
    //const downloadButton = document.getElementById('downloadPdf');
    //downloadButton.style.display = 'block';

    

    
    if (window.chartInstance1) {
        window.chartInstance1.destroy();  // Esto destruye el gráfico previo
    }
    if (window.chartInstance2) {
        window.chartInstance2.destroy();  // Esto destruye el gráfico previo
    }
    if (window.chartInstance3) {
        window.chartInstance3.destroy();  // Esto destruye el gráfico previo
    }
    if (window.chartInstance4) {
        window.chartInstance4.destroy();  // Esto destruye el gráfico previo
    }
    
    if (window.chartInstance5) {
        window.chartInstance5.destroy();  // Esto destruye el gráfico previo
    }

    
    
    //TABLA 4    
    const nuevaData = data[4]; // El objeto recibido
    if (typeof nuevaData !== 'object' || Array.isArray(nuevaData)) {
        //downloadButton.style.display = "none";
        console.error("nuevaData no es un objeto válido:"+ nuevaData);
        
        return; // Sal de la función si no es un objeto
    }

    

    // Convertir el objeto en un arreglo de objetos con clave-valor
    const dataArray = Object.entries(nuevaData).map(([anio, total]) => ({
        anio: parseInt(anio), // Convertir la clave en número
        total: total
    }));
    
    // Extraer años y totales
    const añosc4 = dataArray.map(item => item.anio);
    const totalesc4 = dataArray.map(item => item.total);
    
    console.log("Años para gráfico 4:", añosc4);
    console.log("Totales para gráfico 4:", totalesc4);

    // Crear nuevo gráfico 
    const ctx4 = document.getElementById('myChart4');
    // Crea el nuevo gráfico
    window.chartInstance1 = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: añosc4,
            datasets: [{
                label: 'Edades de los estudiantes',
                data: totalesc4,  // Usar variables JavaScript
                borderWidth: 1,                

            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
            
        }
    });

        

    console.log("data5",data[5]);
    const ctx5 = document.getElementById('myChart5');
    //TABLA 5    
    window.chartInstance5 = new Chart(ctx5, {
                type: 'bar',
                data: {
                    labels: data[5], // Nombres de los municipios
                    datasets: [{
                        label: 'Número de estudiantes por municipio',
                        data: data[6], // Totales por municipio
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                    }
                    }
                },
                //plugins: [ChartDataLabels] // Activa el plugin

            });

























    console.log(data);

    //TABLA 3
    const totalAlumnos = data[3]; // Este es el arreglo que contiene anio y total_alumnos
    // Filtramos el arreglo para eliminar el objeto con 'anio' igual a 2000
    const filteredTotalAlumnos = totalAlumnos.filter(item => item.anio !== 2000);
    // Ahora, filteredTotalAlumnos contendrá los datos sin el año 2000
    console.log("Datos filtrados:", filteredTotalAlumnos);
    // Si necesitas trabajar con los años y los totales de alumnos
    const años = filteredTotalAlumnos.map(item => item.anio);
    const alumnosPorAño = filteredTotalAlumnos.map(item => item.total_alumnos);
    // Muestra los años y los totales de alumnos para asegurarte de que el filtro funciona
    console.log("Años:", años);
    console.log("Total de alumnos:", alumnosPorAño);

    //TABLA 3
    const years = data[2];
    const ctx3 = document.getElementById('myChart3').getContext('2d');
        if (window.chartInstance4) {
            window.chartInstance4.destroy();  // Esto destruye el gráfico previo
        } 
        window.chartInstance4 = new Chart(ctx3, {    
            type: 'line',
            data: {
                labels: 
                years
                ,
                datasets: [{
                    label: 'Número de estudiantes a través del tiempo en el IEESSPP',
                    data: alumnosPorAño,
                    fill: false,              
                hoverOffset: 4
            }]
            }
        });



    //TABLA 1    

    const hombres = data[0]['Hombres'];
    const mujeres = data[0]['Mujeres'];
    const ctx1 = document.getElementById('myChart');
    // Si ya existe un gráfico, destrúyelo antes de crear uno nuevo
    if (window.chartInstance3) {
        window.chartInstance3.destroy();  // Esto destruye el gráfico previo
    }
    // Crea el nuevo gráfico
    window.chartInstance3 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Hombres', 'Mujeres'],
            datasets: [{
                label: 'Número de estudiantes por sexo',
                data: [hombres, mujeres],  // Usar variables JavaScript
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  



    //TABLA 2        
    const niveles =  data[1];
    //console.log("niveles",niveles);
    const nivelesString = ['Kinder','Primaria', 'Secundaria', 'Preparatoria','Universidad','Maestria','Doctorado'];        
    const totales = Object.keys(niveles) // Obtenemos las claves del objeto
    .filter(key => !isNaN(niveles[key])) // Filtramos solo las que tienen valores numéricos
    .map(key => niveles[key]); // Obtenemos los valores correspondientes
    const ctx2 = document.getElementById('myChart2').getContext('2d');
    if (window.chartInstance2) {
        window.chartInstance2.destroy();  // Esto destruye el gráfico previo
    } 
    window.chartInstance2 = new Chart(ctx2, {    
        type: 'bar',
        data: {
            labels: nivelesString,  // Nombres de los niveles de escolaridad
            datasets: [{
                label: 'Número de estudiantes por escolaridad',
                data: totales,  // Cantidad de estudiantes en cada nivel
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                    ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });




    







 



//setTimeout(() => {
/*
Livewire.on('updateCharts', (totalGeneros) => {
    console.log("hombres",totalGeneros[0]['Hombres']);
    console.log("mujeres",totalGeneros[0]['Mujeres']);
    let myChart = null; // Asegúrate de que esta variable se define fuera de Livewire.on para que sea accesible en todo el contexto.
        //Tabla 1
        //const hombres = @json($hombres);  // Convertir variable PHP a JavaScript
        //const mujeres = @json($mujeres);  // Convertir variable PHP a JavaScript
        
        var hombres = totalGeneros[0]['Hombres'];
        var mujeres = totalGeneros[0]['Mujeres'];

        const ctx = document.getElementById('myChart').getContext('2d');
        if (ctx) {
            //myChart.destroy(); // Destruir el gráfico anterior
            console.log("Gráfico destruido");
        }

        //ctx.style.height = '105px'; // Establecer el tamaño directamente
        //ctx.style.width = '211px'; // Establecer el tamaño directamente
        ctx.height = 105; // Definir también la propiedad height
        ctx.width = 211; // Definir también la propiedad width


            // Si el gráfico ya existe, destrúyelo antes de crear uno nuevo
     

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hombres', 'Mujeres'],
                datasets: [{
                    label: 'Número de estudiantes por sexo',
                    data: [hombres, mujeres],  // Usar variables JavaScript
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


/*
        //Tabla 2
        // Variables de PHP a JavaScript
        //const niveles = @json($niveles);  // ['Primaria', 'Secundaria', 'Preparatoria']
        //const totales = @json($totales);  // [30, 25, 18]

        // Crear gráfica con Chart.js
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: "niveles",  // Nombres de los niveles de escolaridad
                datasets: [{
                    label: 'Número de estudiantes por escolaridad',
                    data: totales,  // Cantidad de estudiantes en cada nivel
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        //Tabla 3
        //const niveles = @json($niveles);  // ['Primaria', 'Secundaria', 'Preparatoria']
        //const totales = @json($totales);  // [30, 25, 18]

        // Crear gráfica con Chart.js
        //const edades = @json($edades);  // []
        //const totales2 = @json($totales2);  // []

        const data = {
            labels: edades,
            datasets: [{
                label: 'Número de estudiantes',
                data: totales2,
                /*
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
             
                hoverOffset: 4
            }]
        };
        const ctx3 = document.getElementById('myChart3').getContext('2d');
        new Chart(ctx3, {
            type: 'pie',
            data: data
        });






     

           





















        


        

        
























        
        

        const data2 = {
            labels: [
                '2022',
                '2023',
                '2024',                
            ],
            datasets: [{
                label: 'Estudiantes en el IEESSPP',
                data: [560,590,720],
                fill: false,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
            }]
        };
        const ctx4 = document.getElementById('myChart4').getContext('2d');
        new Chart(ctx4, {
            type: 'line',
            data: data2
        });
















          //Tabla 2
        // Variables de PHP a JavaScript
        //const edades = @json($edades);  // []
        //const totales2 = @json($totales2);  // []

        // Crear gráfica con Chart.js
/*        
        const edades = @json($edades);  // []
        const totales2 = @json($totales2);  // []

        const ctx10 = document.getElementById('myChart6').getContext('2d');
        new Chart(ctx10, {
            type: 'bar',
            data: {
                labels: edades,  // Nombres de los niveles de escolaridad
                datasets: [{
                    label: 'Número de estudiantes por edades',
                    data: totales2,  // Cantidad de estudiantes en cada nivel
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
*/

//});
//}, 1000);
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>

document.getElementById('downloadPdf').addEventListener('click', async () => {    
    //Chart.register(ChartDataLabels);
    //alert("clic");
    const { jsPDF } = window.jspdf;

    // Crear un nuevo documento PDF
    const pdf = new jsPDF();

    // Seleccionar las gráficas que quieres incluir
    const charts = document.querySelectorAll('canvas');

    for (let i = 0; i < charts.length; i++) {
        const canvas = charts[i];

        // Convertir la gráfica en una imagen usando html2canvas
        const canvasImage = canvas.toDataURL('image/png');

        

        // Agregar la imagen al PDF
        const imgProps = pdf.getImageProperties(canvasImage);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        // Si no es la primera gráfica, añade una nueva página
        if (i > 0) pdf.addPage();

        pdf.addImage(canvasImage, 'PNG', 0, 10, pdfWidth, pdfHeight);
    }

    // Guardar el PDF
    pdf.save('graficas.pdf');
});




</script>
    @endpush