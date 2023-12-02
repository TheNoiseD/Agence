
document.addEventListener('DOMContentLoaded', function() {
    getOptions(type);
});

grafico.addEventListener('click', (e) => {
    const divpie = document.getElementById('chartPie');
    divpie.classList.toggle('d-none');
})

pizza.addEventListener('click', (e) => {
    const divbar = document.getElementById('chartBar');
    divpie.classList.toggle('d-none');
})

function formatearNumero(numero) {
    // retornar numero formateado de 15157.25 a R$ 15.157,25
    return 'R$ '+numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

async function getQueryByType(type) {
    console.log(type)
    let datos
    await axios({
        method: 'get',
        url: baseUrl + '/comercial/relatorio/',
        params: {
            type
        }
    }).then((response) => {
        datos = response.data;

    }).catch((error) => {
        console.log(error);
    })
    return datos;
}

function getOptions(type){
    Promise.all([getQueryByType(type)]).then((query) => {
        const searchList = document.querySelector('[name="search_list"]');
        const search = document.querySelector('[name="search"]');
        search.innerHTML = '';
        searchList.innerHTML = '';
        query[0].forEach((item) => {
            searchList.innerHTML += `<option value="${item.co_usuario}">${item.no_usuario}</option>`;
        });
    });
}

queryTypes.forEach((queryType) => {
    queryType.addEventListener('click', (e) => {
        const type = e.target.dataset.type;
        document.querySelector('#type_rel').innerHTML = type;
        Promise.all([getQueryByType(type)]).then((query) => {
            const searchList = document.querySelector('[name="search_list"]');
            const search = document.querySelector('[name="search"]');
            search.innerHTML = '';
            searchList.innerHTML = '';
            query[0].forEach((item) => {
                searchList.innerHTML += `<option value="${item.co_usuario}">${item.no_usuario}</option>`;
            });
        });
    });
});

moveTo.addEventListener('click', (e) => {
    const searchList = document.querySelector('[name="search_list"]');
    const search = document.querySelector('[name="search"]');
    const selecteds = searchList.selectedOptions;
    console.log(selecteds)
    for (let i = selecteds.length - 1; i >= 0; i--) {
        search.innerHTML += `<option value="${selecteds[i].value}">${selecteds[i].text}</option>`;
        searchList.remove(selecteds[i].index);
    }
    for (let i = 0; i < selecteds.length; i++) {
        searchList.remove(selecteds[i].index);
    }
});

removeTo.addEventListener('click', (e) => {
    const searchList = document.querySelector('[name="search_list"]');
    const search = document.querySelector('[name="search"]');
    const selecteds = search.selectedOptions;

    for (let i = selecteds.length - 1; i >= 0; i--) {
        searchList.innerHTML += `<option value="${selecteds[i].value}">${selecteds[i].text}</option>`;
        search.remove(selecteds[i].index);
    }
    for (let i = 0; i < selecteds.length; i++) {
        search.remove(selecteds[i].index);
    }
});

relatorio.addEventListener('click',async (e) => {
    const search = document.querySelector('[name="search"]');
    // todos los ids de todas los options del select search
    const users = [...search.options].map((option) => option.value);
    const periodoInicio = document.getElementById('periodoInicio').value;
    const periodoFin = document.getElementById('periodoFin').value;
    const type = document.querySelector('#type_rel').innerHTML;

    await axios({
        method: 'get',
        url: baseUrl + '/comercial/relatorio',
        params: {
            users,
            periodoInicio,
            periodoFin,
            type
        }
    }).then((response) => {
        let tablaDatos = response.data.tablaDatos;
        pizzaChart = response.data.tablaPizza;
        MixedChart = response.data.tablaBar;
        if (myPieChart) {
            myPieChart.destroy();
        }
        if(myMixedChart){
            myMixedChart.destroy();
        }
        drawPie(pizzaChart)
        drawMixed(MixedChart)
        const contenedorTablas = document.getElementById('content-table');
        contenedorTablas.innerHTML = '';

        for (const persona in tablaDatos) {
            if (tablaDatos.hasOwnProperty(persona)) {
                // Crear una tabla y encabezados
                const tabla = document.createElement('table');
                tabla.classList.add('styled-table');
                tabla.classList.add('my-2');

                // Agregar fila con el nombre de la persona
                const nombreRow = document.createElement('tr');
                const nombreCell = document.createElement('td');
                nombreCell.colSpan = 5; // O el número de columnas que tenga la tabla
                nombreRow.style.textAlignLast = 'left';
                // agregar al tr bgcolor="#efefef"
                nombreRow.setAttribute('bgcolor', '#efefef');
                nombreCell.textContent = persona;
                nombreRow.appendChild(nombreCell);
                tabla.appendChild(nombreRow);

                const encabezados = ['Período', 'Receita Líquida', 'Custo Fixo', 'Comissão', 'Lucro'];
                const encabezadoRow = document.createElement('tr');

                encabezados.forEach(encabezado => {
                    const th = document.createElement('th');
                    th.textContent = encabezado;
                    encabezadoRow.appendChild(th);
                });

                tabla.appendChild(encabezadoRow);

                // Agregar filas de datos
                let sumaMontos = ['SALDO', 0, 0, 0, 0]; // Inicializar array para sumas

                tablaDatos[persona].forEach(fila => {
                    const filaRow = document.createElement('tr');

                    for (const [index, key] of Object.keys(fila).entries()) {
                        if (fila.hasOwnProperty(key)) {
                            const td = document.createElement('td');
                            td.textContent =typeof fila[key] == 'string' ? fila[key] : formatearNumero(fila[key]);

                            // Agregar clases según el valor para el formato específico
                            if (key === 'Período') {
                                td.setAttribute('nowrap', 'true');
                            } else if (key === 'Lucro' && parseFloat(fila[key]) < 0) {
                                td.classList.add('negative');
                            } else if (key === 'Lucro' && parseFloat(fila[key]) >= 0) {
                                td.classList.add('positive');
                            }

                            filaRow.appendChild(td);

                            // Calcular sumas
                            if (!isNaN(parseFloat(fila[key]))) {
                                sumaMontos[index] += parseFloat(fila[key]);
                            }
                        }
                    }

                    tabla.appendChild(filaRow);
                });

                // Agregar fila de totales
                const totalesRow = document.createElement('tr');
                totalesRow.classList.add('saldo-row');

                for (const suma of sumaMontos) {
                    const td = document.createElement('td');
                    td.textContent = typeof suma === 'string' ? suma : formatearNumero(suma.toFixed(2)); // Ajustar el formato decimal si es necesario
                    totalesRow.appendChild(td);
                }

                tabla.appendChild(totalesRow);

                // Agregar la tabla al contenedor
                contenedorTablas.appendChild(tabla);

                // Añadir un espacio entre las tablas
                document.querySelector('.tables').classList.remove('d-none');
            }
        }

    }).catch((error) => {
        console.log(error);
        alertify.error(`Debes seleccionar un periodo valido, y almenos un elemento de la lista de ${type}`);
    })
});


function getLabels(pizzaChart) {
    let labels = [];
    let data = [];
    let colors = [];
    pizzaChart.forEach((item) => {
        labels.push(item.name)
        data.push(item.receita_liquida)
    })
    // crear un color aleatorio por cada item
    for (let i = 0; i < labels.length; i++) {
        colors.push('#'+(Math.random()*0xFFFFFF<<0).toString(16));
    }

    return {labels, data}
}

function drawPie(pizzaChart){
    var ctx = document.getElementById('myPieChart').getContext('2d');
    let info = getLabels(pizzaChart)
    myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: info.labels,
            datasets: [{
                data: info.data,
                backgroundColor: info.colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function drawMixed(barChart){
    let ctx = document.getElementById('myMixedChart').getContext('2d');
    myMixedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Ventas',
                data: [50, 30, 40, 20, 25],
                backgroundColor: 'blue',
                order: 2 // Establece el orden de las barras
            }, {
                label: 'Gastos',
                data: [20, 10, 30, 15, 25],
                backgroundColor: 'red',
                order: 2 // Establece el orden de las barras
            }, {
                type: 'line',
                label: 'Beneficio',
                data: [30, 20, 10, 5, 0],
                borderColor: 'green',
                fill: false,
                order: 1 // Establece el orden de la línea
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
