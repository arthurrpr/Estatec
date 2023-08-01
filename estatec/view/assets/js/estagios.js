// Adiciona um listener de click para cada linha da tabela
document.querySelectorAll('tr[data-id]').forEach(row => {
    const id = row.getAttribute('data-id');
    row.addEventListener('click', () => {
      window.location.href = `estagio.php?id=${id}`;
    });
  
    // Adiciona a animação de ampliação ao passar o mouse sobre a linha
    row.addEventListener('mouseover', () => {
      row.style.transform = 'scale(1.017)';
      row.style.transition = 'transform 0.3s ease';
    });
  
    // Remove a animação ao remover o mouse da linha
    row.addEventListener('mouseout', () => {
      row.style.transform = 'scale(1)';
    });
  
    // Altera o ponteiro do mouse para "pointer"
    row.style.cursor = 'pointer';
  });
  