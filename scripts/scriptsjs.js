// Despliega el la parte donde se postea el contenido de un foro
function topicPostMenuToggle() {
    const content = document.querySelector('.MenuToggle'); // usamos querySelector
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
    } else {
        content.style.display = 'none';
    }
}