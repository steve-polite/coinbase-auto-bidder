@extends('coinbase.layout.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col mt-3">
                <h1>{{ $title }}</h1>
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
                                {{ $last_order->created_at->toDatetimeString() }}
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
