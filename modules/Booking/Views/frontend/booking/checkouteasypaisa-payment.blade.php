<div id="easypaisa-payment-container" style="display:none; margin-top: 15px;">
    <h5>{{ __('EasyPaisa Payment Details') }}</h5>

    {{-- EasyPaisa usually doesn’t require card input like Stripe, but you can add fields if needed --}}

    <div class="form-group">
        <label for="easypaisa_phone">{{ __('Phone Number (registered with EasyPaisa)') }} <span class="required">*</span></label>
        <input type="text" id="easypaisa_phone" name="easypaisa_phone" class="form-control" placeholder="{{ __('Enter your EasyPaisa registered phone') }}" value="{{ old('easypaisa_phone') }}">
    </div>

    {{-- You can add other EasyPaisa-specific fields here if needed --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function toggleEasyPaisaFields() {
            const selected = document.querySelector('input[name="payment_gateway"]:checked').value;
            const easypaisaContainer = document.getElementById('easypaisa-payment-container');
            if (selected === 'easypaisa') {
                easypaisaContainer.style.display = 'block';
            } else {
                easypaisaContainer.style.display = 'none';
            }
        }
        toggleEasyPaisaFields();

        document.querySelectorAll('input[name="payment_gateway"]').forEach(function(radio){
            radio.addEventListener('change', toggleEasyPaisaFields);
        });
    });
</script>
