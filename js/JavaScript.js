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

//search
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-agent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-form').classList.remove('hidden');
    document.getElementById('edit-agent-form').classList.add('hidden');
    document.getElementById('delete-agent-form').classList.add('hidden');
    document.getElementById('search-agent-form').classList.add('hidden');
  });

  document.getElementById('edit-agent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-form').classList.add('hidden');
    document.getElementById('edit-agent-form').classList.remove('hidden');
    document.getElementById('delete-agent-form').classList.add('hidden');
    document.getElementById('search-agent-form').classList.add('hidden');
  });

  document.getElementById('delete-agent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-form').classList.add('hidden');
    document.getElementById('edit-agent-form').classList.add('hidden');
    document.getElementById('delete-agent-form').classList.remove('hidden');
    document.getElementById('search-agent-form').classList.add('hidden');
  });

  document.getElementById('search-agent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-form').classList.add('hidden');
    document.getElementById('edit-agent-form').classList.add('hidden');
    document.getElementById('delete-agent-form').classList.add('hidden');
    document.getElementById('search-agent-form').classList.remove('hidden');
  });
});

//features
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-feature-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-feature-form').classList.remove('hidden');
    document.getElementById('edit-feature-form').classList.add('hidden');
    document.getElementById('delete-feature-form').classList.add('hidden');
    document.getElementById('search-feature-form').classList.add('hidden');
  });

  document.getElementById('edit-feature-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-feature-form').classList.add('hidden');
    document.getElementById('edit-feature-form').classList.remove('hidden');
    document.getElementById('delete-feature-form').classList.add('hidden');
    document.getElementById('search-feature-form').classList.add('hidden');
  });

  document.getElementById('delete-feature-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-feature-form').classList.add('hidden');
    document.getElementById('edit-feature-form').classList.add('hidden');
    document.getElementById('delete-feature-form').classList.remove('hidden');
    document.getElementById('search-feature-form').classList.add('hidden');
  });

  document.getElementById('search-feature-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-feature-form').classList.add('hidden');
    document.getElementById('edit-feature-form').classList.add('hidden');
    document.getElementById('delete-feature-form').classList.add('hidden');
    document.getElementById('search-feature-form').classList.remove('hidden');
  });
});

//commissions
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-commission-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-commission-form').classList.remove('hidden');
    document.getElementById('edit-commission-form').classList.add('hidden');
    document.getElementById('delete-commission-form').classList.add('hidden');
    document.getElementById('search-commission-form').classList.add('hidden');
  });

  document.getElementById('edit-commission-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-commission-form').classList.add('hidden');
    document.getElementById('edit-commission-form').classList.remove('hidden');
    document.getElementById('delete-commission-form').classList.add('hidden');
    document.getElementById('search-commission-form').classList.add('hidden');
  });

  document.getElementById('delete-commission-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-commission-form').classList.add('hidden');
    document.getElementById('edit-commission-form').classList.add('hidden');
    document.getElementById('delete-commission-form').classList.remove('hidden');
    document.getElementById('search-commission-form').classList.add('hidden');
  });

  document.getElementById('search-commission-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-commission-form').classList.add('hidden');
    document.getElementById('edit-commission-form').classList.add('hidden');
    document.getElementById('delete-commission-form').classList.add('hidden');
    document.getElementById('search-commission-form').classList.remove('hidden');
  });
});

//rent
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-rent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-rent-form').classList.remove('hidden');
    document.getElementById('edit-rent-form').classList.add('hidden');
    document.getElementById('delete-rent-form').classList.add('hidden');
    document.getElementById('search-rent-form').classList.add('hidden');
  });

  document.getElementById('edit-rent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-rent-form').classList.add('hidden');
    document.getElementById('edit-rent-form').classList.remove('hidden');
    document.getElementById('delete-rent-form').classList.add('hidden');
    document.getElementById('search-rent-form').classList.add('hidden');
  });

  document.getElementById('delete-rent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-rent-form').classList.add('hidden');
    document.getElementById('edit-rent-form').classList.add('hidden');
    document.getElementById('delete-rent-form').classList.remove('hidden');
    document.getElementById('search-rent-form').classList.add('hidden');
  });

  document.getElementById('search-rent-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-rent-form').classList.add('hidden');
    document.getElementById('edit-rent-form').classList.add('hidden');
    document.getElementById('delete-rent-form').classList.add('hidden');
    document.getElementById('search-rent-form').classList.remove('hidden');
  });
});