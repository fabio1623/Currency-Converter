@extends('Currency.NavBar')

@section('body')

<form action="{{ action('CurrencyController@rate') }}" method="POST">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <label for="iso_code">ISO Code</label>
    <input type="text" class="form-control" id="iso_code" name="iso_code" value="{{ isset($currency['currency']) ? $currency['currency'] : '' }}" placeholder="USD">
  </div>
  <div class="form-group">
    <label>1 Euro equals</label>
    <p class="form-control-static">{!! isset($currency['rate']) ? '<strong>' .$currency['rate']. ' ' .$currency['currency']. '</strong>' : '' !!}</p>
  </div>
  <button type="submit" class="btn btn-default">Check</button>
</form>

@endsection
