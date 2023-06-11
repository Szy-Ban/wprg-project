function toggleButton(buttonId) { //funkcja zmiany koloru przycisku, ich klasy  oraz ustawienia odpowiedniego typu
  var buyButton = document.getElementById('buyButton');
  var rentButton = document.getElementById('rentButton');
  var type = document.getElementById('type');

  if (buttonId === 'buyButton') {
      buyButton.classList.add('active');
      rentButton.classList.remove('active');
      type.value = "0"; //typ wyszukiwania, zakup czy wynajem
  } else {
      rentButton.classList.add('active');
      buyButton.classList.remove('active');
      type.value = "1";
  }
}
