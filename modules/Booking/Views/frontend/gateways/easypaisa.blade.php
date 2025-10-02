<div class="card_stripe">
    <form action="{{ $form_action }}" method="POST" id="easypaisaForm">
        @foreach($post_data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div class="card-body p-3">   
            <h2>Pay With EasyPaisa</h2>
            <div class="text-center mb-3">
                <img src="{{ asset('images/easypaisa-logo.png') }}" alt="EasyPaisa" style="max-height: 50px;" onerror="this.style.display='none'">
            </div>
            <div class="text-right">
                <a href="{{ route('booking.checkout') }}" class="btn btn-secondary py-2">Back</a> 
                <input type="submit" class="btn btn-success py-2" value="Proceed to EasyPaisa Payment">
            </div>
        </div>
    </form>
</div>

<script>
    // Auto-submit form after 2 seconds
    setTimeout(function() {
        document.getElementById('easypaisaForm').submit();
    }, 2000);
</script>