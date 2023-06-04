function toggleButton(buttonId) {
    var buyButton = document.getElementById('buyButton');
    var rentButton = document.getElementById('rentButton');
  
    if (buttonId === 'buyButton') {
      buyButton.classList.add('active');
      rentButton.classList.remove('active');
    } else {
      rentButton.classList.add('active');
      buyButton.classList.remove('active');
    }
  }