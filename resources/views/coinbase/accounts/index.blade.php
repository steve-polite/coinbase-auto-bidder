@extends('coinbase.layout.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col mt-3">
                <h1>{{ $title }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $account->currency}}</td>
                                <td>{{ $account->balance }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
