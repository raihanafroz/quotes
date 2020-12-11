<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
  public function quote_add(Request $request)
  {
    if($request->isMethod('POST')){
      $data = $request->all();
      $validator = Validator::make($data, [
        'text' => 'required|string',
      ]);
      if ($validator->fails()) {
        return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      }
      try {
        $quote = new Quote();
        $quote->author_id = auth()->id();
        $quote->text = $data['text'];
        if ($quote->save()) {
          $status = '<div x-data="{ show: true }" x-show="show" class="w-11/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-green-500">
              <div class="flex items-center py-4">
                  <i class="fas fa-check border-2 border-gray-200 px-2 rounded-full fill-current text-4xl font-light text-gray-200"></i>
                  <div class="ml-5">
                      <h1 class="text-lg font-bold text-gray-200">Congratulations!</h1>
                      <p class="text-gray-300 my-0">You successfully added New Quote.</p>
                  </div>
                  <div>
                      <button type="button"  @click="show = false"  class=" text-yellow-100">
                          <span class="text-2xl">&times;</span>
                      </button>
                  </div>
              </div>
          </div>';
          return redirect()->route('dashboard')->with('status', $status);
        }
        $status = '<div x-data="{ show: true }" x-show="show" class="w-11/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-yellow-400">
            <div class="flex items-center py-4">
                <i class="fas fa-exclamation-circle rounded-full fill-current text-4xl text-gray-800"></i>
                <div class="ml-5">
                    <h1 class="font-bold text-gray-800 text-lg">Warning !!!</h1>
                    <p class="text-gray-800 my-0 ">Quote adding not possible.</p>
                </div>
                <div>
                    <button type="button" @click="show = false"  class=" text-yellow-100">
                        <span class="text-2xl text-gray-800">&times;</span>
                    </button>
                </div>
            </div>
        </div>';
        return redirect()->back()->withInput()->with('status', $status);
      } catch (QueryException $e) {
        $status = '<div x-data="{ show: true }" x-show="show" class="w-11/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-yellow-400">
            <div class="flex items-center py-4">
                <i class="fas fa-exclamation-circle rounded-full fill-current text-4xl text-gray-800"></i>
                <div class="ml-5">
                    <h1 class="font-bold text-gray-800 text-lg">Warning !!!</h1>
                    <p class="text-gray-800 my-0 ">Something went wrong.</p>
                </div>
                <div>
                    <button type="button" @click="show = false"  class=" text-yellow-100">
                        <span class="text-2xl text-gray-800">&times;</span>
                    </button>
                </div>
            </div>
        </div>';
        return redirect()->back()->withInput()->with('status', $status);
      }
    }
  }
}
