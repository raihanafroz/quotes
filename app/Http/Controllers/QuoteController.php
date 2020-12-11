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
          $status = '<div x-data="{ show: true }" x-show="show" class="w-12/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-green-500">
              <div class="grid grid-rows grid-flow-col flex items-center py-4">
                  <div class="row-span-11 ml-5">
                      <h1 class="text-lg font-bold text-gray-200">Congratulations!</h1>
                      <p class="text-gray-300 my-0">You successfully added New Quote.</p>
                  </div>
                  <div class="row-span-1 text-right">
                      <button type="button"  @click="show = false"  class=" text-yellow-100">
                          <span class="text-2xl">&times;</span>
                      </button>
                  </div>
              </div>
          </div>';
          return redirect()->route('dashboard')->with('status_add', $status);
        }
        $status = '<div x-data="{ show: true }" x-show="show" class="w-12/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-yellow-400">
            <div class="grid grid-rows grid-flow-col flex items-center py-4">
                
                <div class="row-span-11 ml-5">
                    <h1 class="font-bold text-gray-800 text-lg">Warning !!!</h1>
                    <p class="text-gray-800 my-0 ">Quote adding not possible.</p>
                </div>
                <div class="row-span-1 text-right">
                    <button type="button" @click="show = false"  class=" text-yellow-100">
                        <span class="text-2xl text-gray-800">&times;</span>
                    </button>
                </div>
            </div>
        </div>';
        return redirect()->back()->withInput()->with('status_add', $status);
      } catch (QueryException $e) {
        $status = '<div x-data="{ show: true }" x-show="show" class="w-12/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-yellow-400">
            <div class="grid grid-rows grid-flow-col flex items-center py-4">
                
                <div class="row-span-11 ml-5">
                    <h1 class="font-bold text-gray-800 text-lg">Warning !!!</h1>
                    <p class="text-gray-800 my-0 ">Something went wrong.</p>
                </div>
                <div class="row-span-1 text-right">
                    <button type="button" @click="show = false"  class=" text-yellow-100">
                        <span class="text-2xl text-gray-800">&times;</span>
                    </button>
                </div>
            </div>
        </div>';
        return redirect()->back()->withInput()->with('status_add', $status);
      }
    }
  }

  public function quote_edit(Request $request, $id = null)
  {
    $quote = Quote::find($id);
    if(isset($quote) && $quote->author_id === auth()->id()) {
      if ($request->isMethod('POST')) {
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
          if ($quote->update(['text'=>$data['text']])) {
            $status = '<div x-data="{ show: true }" x-show="show" class="w-12/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-green-500">
              <div class="grid grid-rows grid-flow-col items-center py-4">
                  <div class="row-span-11 ml-5">
                      <h1 class="text-lg font-bold text-gray-200">Congratulations!</h1>
                      <p class="text-gray-300 my-0">You successfully updated your Quote.</p>
                  </div>
                  <div class="row-span-1 text-right">
                      <button type="button"  @click="show = false"  class=" text-yellow-100">
                          <span class="text-2xl">&times;</span>
                      </button>
                  </div>
              </div>
          </div>';
            return redirect()->route('dashboard')->with('status', $status);
          }
          $status = '<div x-data="{ show: true }" x-show="show" class="w-12/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-yellow-400">
            <div class="grid grid-rows grid-flow-col flex items-center py-4">
                <div class="row-span-11 ml-5">
                    <h1 class="font-bold text-gray-800 text-lg">Warning !!!</h1>
                    <p class="text-gray-800 my-0 ">Quote adding not possible.</p>
                </div>
                <div class="row-span-1 text-right">
                    <button type="button" @click="show = false"  class=" text-yellow-100">
                        <span class="text-2xl text-gray-800">&times;</span>
                    </button>
                </div>
            </div>
        </div>';
          return redirect()->back()->withInput()->with('status', $status);
        } catch (QueryException $e) {
          $status = '<div x-data="{ show: true }" x-show="show" class="w-12/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-yellow-400">
            <div class="grid grid-rows grid-flow-col flex items-center py-4">
                
                <div class="row-span-11 ml-5">
                    <h1 class="font-bold text-gray-800 text-lg">Warning !!!</h1>
                    <p class="text-gray-800 my-0 ">Something went wrong.</p>
                </div>
                <div class="row-span-1 text-right">
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
    $status = '<div x-data="{ show: true }" x-show="show" class="w-12/12 md:w-3/5 bg-white my-2 rounded-r-md px-6 border-l-4 -ml-4 border-gray-100 bg-yellow-400">
            <div class="grid grid-rows grid-flow-col flex items-center py-4">
                
                <div class="row-span-11 ml-5">
                    <h1 class="font-bold text-gray-800 text-lg">Warning !!!</h1>
                    <p class="text-gray-800 my-0 ">Quote not found.</p>
                </div>
                <div class="row-span-1 text-right">
                    <button type="button" @click="show = false"  class=" text-yellow-100">
                        <span class="text-2xl text-gray-800">&times;</span>
                    </button>
                </div>
            </div>
        </div>';
    return redirect()->back()->with('status', $status);
  }



  public function quote_delete(Request $request)
  {
    if ($request->isMethod('DELETE')) {
      $id = $request->post('id');
      $quote = Quote::find($id);
      if ($quote->delete()) {
        return 'success';
      }
    }
  }
}
