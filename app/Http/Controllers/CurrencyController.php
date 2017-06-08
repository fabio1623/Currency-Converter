<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Currency;

class CurrencyController extends Controller
{
    //
    public function index()
    {
      $view = view('Currency.Rate');
      return $view;
    }

    public function rate(Request $request)
    {
      $search_iso_code = strtolower($request->iso_code);

      // Transform XML file into ARRAY
      $xml = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
      $currencies = $xml->Cube->Cube->Cube;

      $found_currency = null;

      $found_currency = CurrencyController::findCurrency($currencies, $request->iso_code);

      $view = view('Currency.Rate', ['currency' => $found_currency]);
      return $view;
    }

    public function convertPage()
    {
      // Transform XML file into ARRAY
      $xml = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
      $currencies = $xml->Cube->Cube->Cube;

      $view = view('Currency.EuroConvert', ['currencies' => $currencies]);
      return $view;
    }

    public function convert(Request $request)
    {
      // Transform XML file into ARRAY
      $xml = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
      $currencies = $xml->Cube->Cube->Cube;

      $found_currency = CurrencyController::findCurrency($currencies, $request->iso_code);

      $euro_amount = null;

      if ($found_currency != null) {
        // Convert requested amount
        $euro_amount = (float)$request->amount / (float)$found_currency['rate'];
        $euro_amount = number_format((float)$euro_amount, 4, '.', '');
      }

      $view = view('Currency.EuroConvert', ['currencies' => $currencies, 'euro_amount' => $euro_amount, 'requested_amount' => $request->amount, 'iso_code' => $request->iso_code]);
      return $view;
    }

    public function findCurrency($currencies, $iso_code)
    {
      $found_currency = null;
      foreach ($currencies as $c) {
        if (strtolower($c['currency']) == strtolower($iso_code)) {
          $found_currency = $c;
          break;
        }
      }

      return $found_currency;
    }

    public function activeUsers()
    {
      // A query that shows the total amount of money in Euro for each active customer
      $amount_per_customer = DB::table('customers')
                              ->leftJoin('transactions', 'customers.customer_id', '=', 'transactions.customer_id')
                              ->leftJoin('currencies', 'transactions.currency_id', '=', 'currencies.currency_id')
                              ->select(DB::raw('customers.customer_name, SUM(transactions.amount_of_money / currencies.rate) as total_amount'))
                              ->where('customers.is_active', '=', 'yes')
                              ->groupBy('customers.customer_id')
                              ->groupBy('customers.customer_name')
                              ->get();

      dd($amount_per_customer);

      $view = view('Currency.Rate');
      return $view;
    }

    public function earnings()
    {
      // A query that returns the total amount in Euro that has been earned in 2014
      $earnings = DB::table('transactions')
                    ->leftJoin('currencies', 'transactions.currency_id', '=', 'currencies.currency_id')
                    ->select(DB::raw('SUM(transactions.amount_of_money / currencies.rate) total_amount_2014'))
                    ->where(DB::raw("FROM_UNIXTIME(transactions.datetime, '%Y') = 2014"))
                    ->get();
      dd($earnings);
    }
}
