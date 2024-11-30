fetch('menu.json')
  .then((response) => response.json())
  .then((data) => {
    const menuContainer = document.getElementById('menu-container');

    const enlacesPago = [
      "https://donate.stripe.com/test_14k9BA2Aa6hq3gA4gl", 
      "https://donate.stripe.com/test_eVacNM1w635e04o6ou", 
      "https://donate.stripe.com/test_28o9BAcaK6hqbN628f",
      "https://donate.stripe.com/test_dR6010caKbBK6sM14c", 
      "https://donate.stripe.com/test_9AQbJI6Qq49iaJ2cMV",
      "https://donate.stripe.com/test_00gbJIeiSgW46sM3cm",
      "https://donate.stripe.com/test_5kA9BA4Ii8py6sM8wH",
      "https://donate.stripe.com/test_8wM9BAeiSaxGaJ214g",
      "https://donate.stripe.com/test_aEU0105MmfS09EYbIV",
      "https://donate.stripe.com/test_5kAaFEcaK8py2cw6oC",
      "https://donate.stripe.com/test_bIYfZYb6G0X65oI7sH",
      "https://donate.stripe.com/test_6oE6pocaK6hqaJ28wM"
    ];

    data.forEach((item, index) => {
      const menuItem = document.createElement('div');
      menuItem.classList.add('col', 'd-flex');

      menuItem.innerHTML = `
        <div class="card" style="border: 4px solid white">
          <img src="${item.imagen}" alt="${item.titulo}" class="card-img-top">
          <div class="card-body">
            <h5 class="card-title">${item.titulo}</h5>
            <p class="card-text small">
              <strong>Ingredientes:</strong> ${item.ingredientes}
            </p>
            <p class="card-text"><strong>Precio:</strong> $${item.precio}</p>
            <a href="#" onclick="comprar('${enlacesPago[index]}')" class="btn btn-comprar">Comprar</a>
          </div>
        </div>
      `;
      menuContainer.appendChild(menuItem);
    });
  })
  .catch((error) => console.error('Error al cargar el menú:', error));

function comprar(enlacePago) {
  // Cerrar la ventana actual
  window.close();

  // Redirigir a la página de Stripe
  window.location.href = enlacePago;
}
