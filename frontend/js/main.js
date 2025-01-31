// Elementos del DOM
const btnAgregarEstudiante = document.getElementById('btnAgregarEstudiante');
const btnAgregarDocente = document.getElementById('btnAgregarDocente');
const estudianteForm = document.getElementById('estudiante-form');
const docenteForm = document.getElementById('docente-form');
const estudiantesTable = document.getElementById('estudiantes-table').getElementsByTagName('tbody')[0];
const docentesTable = document.getElementById('docentes-table').getElementsByTagName('tbody')[0];

// Mostrar formularios de agregar
btnAgregarEstudiante.addEventListener('click', () => {
    estudianteForm.reset(); // Limpiar formulario
    estudianteForm.id.value = ''; // Limpiar campo ID
    estudianteForm.style.display = 'block'; // Mostrar formulario de estudiante
    docenteForm.style.display = 'none'; // Ocultar formulario de docente
});

btnAgregarDocente.addEventListener('click', () => {
    docenteForm.reset(); // Limpiar formulario
    docenteForm.id.value = ''; // Limpiar campo ID
    docenteForm.style.display = 'block'; // Mostrar formulario de docente
    estudianteForm.style.display = 'none'; // Ocultar formulario de estudiante
});

// Cargar datos al iniciar
document.addEventListener('DOMContentLoaded', () => {
    obtenerEstudiantes();
    obtenerDocentes();
    estudianteForm.style.display = 'none'; // Iniciar sin mostrar formularios
    docenteForm.style.display = 'none'; // Iniciar sin mostrar formularios
    estudianteForm.addEventListener('submit', crearActualizarEstudiante);
    docenteForm.addEventListener('submit', crearActualizarDocente);
});

// Obtener Estudiantes desde la API
function obtenerEstudiantes() {
    fetch('http://localhost/Registro/backend/api/estudiantes/read.php')
        .then(response => response.json())
        .then(data => {
            estudiantesTable.innerHTML = '';
            data.records.forEach(estudiante => {
                const row = estudiantesTable.insertRow();
                row.insertCell(0).innerText = estudiante.nombre;
                row.insertCell(1).innerText = estudiante.apellido;
                row.insertCell(2).innerText = estudiante.email;
                const actionsCell = row.insertCell(3);
                actionsCell.innerHTML = `
                    <button onclick="editarEstudiante(${estudiante.id}, '${estudiante.nombre}', '${estudiante.apellido}', '${estudiante.email}')">Editar</button>
                    <button onclick="eliminarEstudiante(${estudiante.id})">Eliminar</button>
                `;
            });
        })
        .catch(error => console.error('Error al obtener estudiantes:', error));
}

// Obtener Docentes desde la API
function obtenerDocentes() {
    fetch('http://localhost/Registro/backend/api/docentes/read.php')
        .then(response => response.json())
        .then(data => {
            docentesTable.innerHTML = '';
            data.forEach(docente => {
                const row = docentesTable.insertRow();
                row.insertCell(0).innerText = docente.nombre;
                row.insertCell(1).innerText = docente.apellido;
                row.insertCell(2).innerText = docente.email;
                row.insertCell(3).innerText = docente.departamento;
                const actionsCell = row.insertCell(4);
                actionsCell.innerHTML = `
                    <button onclick="editarDocente(${docente.id}, '${docente.nombre}', '${docente.apellido}', '${docente.email}', '${docente.departamento}')">Editar</button>
                    <button onclick="eliminarDocente(${docente.id})">Eliminar</button>
                `;
            });
        })
        .catch(error => console.error('Error al obtener docentes:', error));
}

// Crear o Actualizar Estudiante
function crearActualizarEstudiante(e) {
    e.preventDefault();
    const estudianteData = new FormData(estudianteForm);
    const id = estudianteForm.id.value;
    const url = id ? `http://localhost/Registro/backend/api/estudiantes/update.php` : `http://localhost/Registro/backend/api/estudiantes/create.php`;
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: id,
            nombre: estudianteData.get('nombre'),
            apellido: estudianteData.get('apellido'),
            email: estudianteData.get('email')
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        estudianteForm.style.display = 'none'; // Ocultar formulario
        obtenerEstudiantes(); // Recargar estudiantes
    })
    .catch(error => console.error('Error al crear o actualizar estudiante:', error));
}

// Crear o Actualizar Docente
function crearActualizarDocente(e) {
    e.preventDefault();
    const docenteData = new FormData(docenteForm);
    const id = docenteForm.id.value;
    const url = id ? `http://localhost/Registro/backend/api/docentes/update.php` : `http://localhost/Registro/backend/api/docentes/create.php`;
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: id,
            nombre: docenteData.get('nombre'),
            apellido: docenteData.get('apellido'),
            email: docenteData.get('email'),
            departamento: docenteData.get('departamento')
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        docenteForm.style.display = 'none'; // Ocultar formulario
        obtenerDocentes(); // Recargar docentes
    })
    .catch(error => console.error('Error al crear o actualizar docente:', error));
}

// Editar Estudiante (cargar datos en el formulario)
function editarEstudiante(id, nombre, apellido, email) {
    estudianteForm.id.value = id;
    estudianteForm.nombre.value = nombre;
    estudianteForm.apellido.value = apellido;
    estudianteForm.email.value = email;
    estudianteForm.style.display = 'block'; // Mostrar formulario de estudiante
    docenteForm.style.display = 'none'; // Ocultar formulario de docente
}

// Editar Docente (cargar datos en el formulario)
function editarDocente(id, nombre, apellido, email, departamento) {
    docenteForm.id.value = id;
    docenteForm.nombre.value = nombre;
    docenteForm.apellido.value = apellido;
    docenteForm.email.value = email;
    docenteForm.departamento.value = departamento;
    docenteForm.style.display = 'block'; // Mostrar formulario de docente
    estudianteForm.style.display = 'none'; // Ocultar formulario de estudiante
}

// Eliminar Estudiante
function eliminarEstudiante(id) {
    if (confirm('¿Estás seguro de eliminar este estudiante?')) {
        fetch(`http://localhost/Registro/backend/api/estudiantes/delete.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            obtenerEstudiantes(); // Recargar estudiantes
        })
        .catch(error => console.error('Error al eliminar estudiante:', error));
    }
}

// Eliminar Docente
function eliminarDocente(id) {
    if (confirm('¿Estás seguro de eliminar este docente?')) {
        fetch(`http://localhost/Registro/backend/api/docentes/delete.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            obtenerDocentes(); // Recargar docentes
        })
        .catch(error => console.error('Error al eliminar docente:', error));
    }
}
