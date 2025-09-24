@if($translation->content)
    <div class="g-overview">
        <div class="description">
            {!! clean($translation->content) !!}
        </div>
    </div>
@endif
