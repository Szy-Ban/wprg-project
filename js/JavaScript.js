function toggleButton(buttonId) { //funkcja zmiany koloru przycisku, ich klasy  oraz ustawienia odpowiedniego typu
  var buyButton = document.getElementById('buyButton');
  var rentButton = document.getElementById('rentButton');
  var type = document.getElementById('type');
  var searchContainer = document.getElementById('searchContainer');

  if (buttonId === 'buyButton') {
      buyButton.classList.add('active');
      rentButton.classList.remove('active');
      type.value = "0"; //typ wyszukiwania, zakup czy wynajem
      searchContainer.classList.remove('search-container-rent');
      searchContainer.classList.add('search-container-sale');
  } else {
      rentButton.classList.add('active');
      buyButton.classList.remove('active');
      type.value = "1";
      searchContainer.classList.remove('search-container-sale');
      searchContainer.classList.add('search-container-rent');
  }
}

window.onload = function() { //aby przycisk pozostal zaznaczony po wyszukaniu
  var url = new URL(window.location.href);
  var type = url.searchParams.get("type");
  if (type !== null) {
    if (type === '0') {
        document.getElementById('buyButton').classList.add('active');
        document.getElementById('rentButton').classList.remove('active');
        document.getElementById('type').value = "0";
        document.getElementById('searchContainer').classList.remove('search-container-rent');
        document.getElementById('searchContainer').classList.add('search-container-sale');
    } else {
        document.getElementById('rentButton').classList.add('active');
        document.getElementById('buyButton').classList.remove('active');
        document.getElementById('type').value = "1";
        document.getElementById('searchContainer').classList.remove('search-container-sale');
        document.getElementById('searchContainer').classList.add('search-container-rent');
    }
  }
};

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

//sale
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-sale-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-sale-form').classList.remove('hidden');
    document.getElementById('edit-sale-form').classList.add('hidden');
    document.getElementById('delete-sale-form').classList.add('hidden');
    document.getElementById('search-sale-form').classList.add('hidden');
  });

  document.getElementById('edit-sale-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-sale-form').classList.add('hidden');
    document.getElementById('edit-sale-form').classList.remove('hidden');
    document.getElementById('delete-sale-form').classList.add('hidden');
    document.getElementById('search-sale-form').classList.add('hidden');
  });

  document.getElementById('delete-sale-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-sale-form').classList.add('hidden');
    document.getElementById('edit-sale-form').classList.add('hidden');
    document.getElementById('delete-sale-form').classList.remove('hidden');
    document.getElementById('search-sale-form').classList.add('hidden');
  });

  document.getElementById('search-sale-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-sale-form').classList.add('hidden');
    document.getElementById('edit-sale-form').classList.add('hidden');
    document.getElementById('delete-sale-form').classList.add('hidden');
    document.getElementById('search-sale-form').classList.remove('hidden');
  });
});

//property
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-property-form').classList.remove('hidden');
    document.getElementById('edit-property-form').classList.add('hidden');
    document.getElementById('delete-property-form').classList.add('hidden');
    document.getElementById('search-property-form').classList.add('hidden');
  });

  document.getElementById('edit-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-property-form').classList.add('hidden');
    document.getElementById('edit-property-form').classList.remove('hidden');
    document.getElementById('delete-property-form').classList.add('hidden');
    document.getElementById('search-property-form').classList.add('hidden');
  });

  document.getElementById('delete-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-property-form').classList.add('hidden');
    document.getElementById('edit-property-form').classList.add('hidden');
    document.getElementById('delete-property-form').classList.remove('hidden');
    document.getElementById('search-property-form').classList.add('hidden');
  });

  document.getElementById('search-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-property-form').classList.add('hidden');
    document.getElementById('edit-property-form').classList.add('hidden');
    document.getElementById('delete-property-form').classList.add('hidden');
    document.getElementById('search-property-form').classList.remove('hidden');
  });
});

//clients
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-client-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-form').classList.remove('hidden');
    document.getElementById('edit-client-form').classList.add('hidden');
    document.getElementById('delete-client-form').classList.add('hidden');
    document.getElementById('search-client-form').classList.add('hidden');
  });

  document.getElementById('edit-client-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-form').classList.add('hidden');
    document.getElementById('edit-client-form').classList.remove('hidden');
    document.getElementById('delete-client-form').classList.add('hidden');
    document.getElementById('search-client-form').classList.add('hidden');
  });

  document.getElementById('delete-client-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-form').classList.add('hidden');
    document.getElementById('edit-client-form').classList.add('hidden');
    document.getElementById('delete-client-form').classList.remove('hidden');
    document.getElementById('search-client-form').classList.add('hidden');
  });

  document.getElementById('search-client-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-form').classList.add('hidden');
    document.getElementById('edit-client-form').classList.add('hidden');
    document.getElementById('delete-client-form').classList.add('hidden');
    document.getElementById('search-client-form').classList.remove('hidden');
  });
});

//agent-property
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-agent-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-property-form').classList.remove('hidden');
    document.getElementById('edit-agent-property-form').classList.add('hidden');
    document.getElementById('delete-agent-property-form').classList.add('hidden');
    document.getElementById('search-agent-property-form').classList.add('hidden');
  });

  document.getElementById('edit-agent-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-property-form').classList.add('hidden');
    document.getElementById('edit-agent-property-form').classList.remove('hidden');
    document.getElementById('delete-agent-property-form').classList.add('hidden');
    document.getElementById('search-agent-property-form').classList.add('hidden');
  });

  document.getElementById('delete-agent-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-property-form').classList.add('hidden');
    document.getElementById('edit-agent-property-form').classList.add('hidden');
    document.getElementById('delete-agent-property-form').classList.remove('hidden');
    document.getElementById('search-agent-property-form').classList.add('hidden');
  });

  document.getElementById('search-agent-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-agent-property-form').classList.add('hidden');
    document.getElementById('edit-agent-property-form').classList.add('hidden');
    document.getElementById('delete-agent-property-form').classList.add('hidden');
    document.getElementById('search-agent-property-form').classList.remove('hidden');
  });
});

//client-property
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-client-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-property-form').classList.remove('hidden');
    document.getElementById('edit-client-property-form').classList.add('hidden');
    document.getElementById('delete-client-property-form').classList.add('hidden');
    document.getElementById('search-client-property-form').classList.add('hidden');
  });

  document.getElementById('edit-client-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-property-form').classList.add('hidden');
    document.getElementById('edit-client-property-form').classList.remove('hidden');
    document.getElementById('delete-client-property-form').classList.add('hidden');
    document.getElementById('search-client-property-form').classList.add('hidden');
  });

  document.getElementById('delete-client-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-property-form').classList.add('hidden');
    document.getElementById('edit-client-property-form').classList.add('hidden');
    document.getElementById('delete-client-property-form').classList.remove('hidden');
    document.getElementById('search-client-property-form').classList.add('hidden');
  });

  document.getElementById('search-client-property-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-client-property-form').classList.add('hidden');
    document.getElementById('edit-client-property-form').classList.add('hidden');
    document.getElementById('delete-client-property-form').classList.add('hidden');
    document.getElementById('search-client-property-form').classList.remove('hidden');
  });
});

//features-description
document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('add-features-description-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-features-description-form').classList.remove('hidden');
    document.getElementById('edit-features-description-form').classList.add('hidden');
    document.getElementById('delete-features-description-form').classList.add('hidden');
    document.getElementById('search-features-description-form').classList.add('hidden');
  });

  document.getElementById('edit-features-description-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-features-description-form').classList.add('hidden');
    document.getElementById('edit-features-description-form').classList.remove('hidden');
    document.getElementById('delete-features-description-form').classList.add('hidden');
    document.getElementById('search-features-description-form').classList.add('hidden');
  });

  document.getElementById('delete-features-description-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-features-description-form').classList.add('hidden');
    document.getElementById('edit-features-description-form').classList.add('hidden');
    document.getElementById('delete-features-description-form').classList.remove('hidden');
    document.getElementById('search-features-description-form').classList.add('hidden');
  });

  document.getElementById('search-features-description-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('add-features-description-form').classList.add('hidden');
    document.getElementById('edit-features-description-form').classList.add('hidden');
    document.getElementById('delete-features-description-form').classList.add('hidden');
    document.getElementById('search-features-description-form').classList.remove('hidden');
  });
});