@extends('layout.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col mt-3">
                <h1>{{ $title }}</h1>
            </div>
        </div>

        {{-- Recaps --}}
        <div class="row mt-5">
            <div class="col-3">
                @include('layout.components.info-card', [
                    'card_title' => __('coinbase.wallet_value'),
                    'card_value' => $total_wallet_value . config('app.main_currency_symbol')
                ])
            </div>
            <div class="col-3">
                @include('layout.components.info-card', [
                    'card_title' => __('coinbase.deposits'),
                    'card_text' => "<strong>Note:</strong> this is an example value",
                    'card_value' => $total_transfers . "€"
                ])
            </div>
            <div class="col-3">
                @include('layout.components.info-card', [
                    'card_title' => __('coinbase.withdrawals'),
                    'card_text' => "<strong>Note:</strong> this is an example value",
                    'card_value' => $total_withdrawals . "€"
                ])
            </div>
            <div class="col-3">
                @include('layout.components.info-card', [
                    'card_title' => __('coinbase.fees'),
                    'card_value' => $total_fees . config('app.main_currency_symbol')
                ])
            </div>
        </div>

        {{-- Last orders --}}
        <div class="row">
            <div class="col mt-5">
                <h3>{{ __('coinbase.orders.last_orders') }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('coinbase.date') }}</th>
                            <th>{{ __('coinbase.orders.product') }}</th>
                            <th>{{ __('coinbase.orders.sides.title') }}</th>
                            <th>{{ __('coinbase.orders.status.title') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($last_orders as $last_order)
                        <tr>
                            <td>
                                {{
                                    $last_order->created_at
                                        ->setTimezone(config('app.display_timezone'))
                                        ->format(config('app.datetime_format'))
                                }}
                            </td>
                            <td>
                                <strong>{{ $last_order->product_id }}</strong>
                            </td>
                            <td>
                                <strong>{{ __('coinbase.orders.sides.'.$last_order->side) }}</strong>
                            </td>
                            <td>
                                <span class="badge @if($last_order->done_reason == 'filled') bg-success @elseif($last_order->done_reason == 'cancelled') bd-danger @else bg-warning @endif">
                                    {{ __('coinbase.orders.status.'.$last_order->done_reason) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
