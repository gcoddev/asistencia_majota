// function formatDateToDDMMYYYY(dateString) {
//     if (!dateString) return '';

//     const date = new Date(dateString);

//     const day = String(date.getDate()).padStart(2, '0');
//     const month = String(date.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11
//     const year = date.getFullYear();

//     return `${day}/${month}/${year}`;
// }

function formatDateToDDMMYYYY(dateString) {
    if (!dateString) return '';

    const [year, month, day] = dateString.split('-'); // Extraer partes

    return `${day}/${month}/${year}`;
}