<div class="card">
    <div class="card-body">
        @if(isset($card_title))
        <h5 class="card-title">{{ $card_title ?? '' }}</h5>
        @endif

        @if(isset($card_subtitle))
        <h6 class="card-subtitle mb-2 text-muted">{{ $card_subtitle ?? '' }}</h6>
        @endif

        @if(isset($card_value))
        <h1>{{ $card_value }}</h1>
        @endif

        @if(isset($card_text))
        <p class="card-text">{!! $card_text !!}</p>
        @endif

        @if(isset($card_link))
        <a href="{{ $card_link }}" class="card-link">{{ $card_link_text }}</a>
        @endif
    </div>
  </div>
