<style>
  .form-section {
    background: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    max-width: 500px;
    margin: 20px auto;
  }

  .form-section h4 {
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
    font-size: 1.5rem;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
  }

  #card-element {
    background: white;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 12px;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }
  #card-element:focus-within {
    border-color: #007bff;
    box-shadow: 0 0 4px #007bffaa;
  }

  #card-errors {
    color: #dc3545; /* bootstrap danger red */
    margin-top: 10px;
    font-weight: 500;
    min-height: 24px;
    font-size: 0.9rem;
  }

  /* Optional: style the hidden input for payment gateway */
  input[name="payment_gateway"] {
    display: none;
  }

  /* Responsive tweaks */
  @media (max-width: 600px) {
    .form-section {
      padding: 15px;
      max-width: 100%;
    }
  }
</style>

<div class="form-section">
  <h4>{{ __('Credit Card Payment') }}</h4>

  <div id="card-element"><!-- Stripe.js will insert card input here --></div>
  <div id="card-errors" role="alert"></div>

  <input type="hidden" name="payment_gateway" value="stripe">
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const stripe = Stripe('{{ env("STRIPE_KEY") }}');
  const elements = stripe.elements();
  const card = elements.create('card', {
    style: {
      base: {
        fontSize: '16px',
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        '::placeholder': { color: '#aab7c4' }
      },
      invalid: {
        color: '#dc3545',
        iconColor: '#dc3545'
      }
    }
  });
  card.mount('#card-element');

  card.on('change', (event) => {
    const displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

document.getElementById('form-checkout').addEventListener('submit', async (event) => {
  event.preventDefault();

  const cardErrorsDiv = document.getElementById('card-errors');
  cardErrorsDiv.textContent = '';

  const { error, paymentMethod } = await stripe.createPaymentMethod({
    type: 'card',
    card: card,
    billing_details: {
      name: document.querySelector('[name="first_name"]').value + ' ' + document.querySelector('[name="last_name"]').value,
      email: document.querySelector('[name="email"]').value,
    },
  });

  if (error) {
    cardErrorsDiv.textContent = error.message;
    return;
  }

  // Remove old payment_method_id input if exists
  const oldInput = document.querySelector('input[name="payment_method_id"]');
  if (oldInput) oldInput.remove();

  // Append new payment_method_id
  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'payment_method_id';
  input.value = paymentMethod.id;
  event.target.appendChild(input);

  // Prepare form data for AJAX submission
  const formData = new FormData(event.target);

  try {
    const response = await fetch(event.target.action, {
      method: event.target.method,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
      },
      body: formData,
    });

    const data = await response.json();

    if (data.success) {
      // Redirect on success
      window.location.href = data.redirect_url;
    } else if (data.requires_action) {
      // Handle additional 3D Secure or similar action
      const result = await stripe.confirmCardPayment(data.payment_intent_client_secret);
      if (result.error) {
        cardErrorsDiv.textContent = result.error.message;
      } else if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
        window.location.href = data.redirect_url || window.location.href;
      }
    } else {
      cardErrorsDiv.textContent = data.message || 'Payment failed. Please try again.';
    }
  } catch (err) {
    cardErrorsDiv.textContent = 'An error occurred. Please try again.';
  }
});
  });

</script>