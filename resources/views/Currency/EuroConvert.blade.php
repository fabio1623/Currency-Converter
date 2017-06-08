@extends('Currency.NavBar')

@section('body')

<form action="{{ action('CurrencyController@convert') }}" method="POST">
  <?php echo csrf_field(); ?>
  <div class="form-group">
    <label for="iso_code">ISO Code</label>
    <select id="iso_code" name="iso_code" class="form-control">
      <option value=""></option>
      @if (isset($iso_code))
        @foreach ($currencies as $c)
          <option value="{{ $c['currency'] }}" {{ $iso_code == $c['currency'] ? 'selected' : '' }}>{{ $c['currency'] }}</option>
        @endforeach
      @else
        @foreach ($currencies as $c)
          <option value="{{ $c['currency'] }}">{{ $c['currency'] }}</option>
        @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="amount">Amount</label>
    <input id="amount" name="amount" type="number" class="form-control" value="{{ isset($requested_amount) ? $requested_amount : '' }}" placeholder="Insert your amount">
  </div>
  <div class="form-group">
    <label>Result</label>
    <p class="form-control-static">{!! isset($euro_amount) && $euro_amount != 0 ? '<strong>' .$requested_amount. ' ' .$iso_code. '</strong> equals <strong>' .$euro_amount. ' Eur</strong> !' : '' !!}</p>
  </div>
  <button type="submit" class="btn btn-default">Convert</button>
</form>

@endsection
