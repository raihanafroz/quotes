<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 py-10 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-rows grid-flow-col gap-4">
                    <div class="col-span-2 mx-4 pl-15 lg:pt-8">
                        <div class="mx-auto">
                            @if(session()->has('status_add'))
                                {!! session()->get('status_add') !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="grid grid-rows grid-flow-col gap-4 px-16">
                    <form action="{{ route('quote.add') }}" method="post">
                        @csrf
                        <div class="row-span-3">
                            <x-jet-label for="quoteText" value="{{ __('Quote Text') }}"/>
                            <div class="grid grid-rows grid-flow-col">
                                <textarea name="text" id="quoteText" placeholder="write text" rows="3"
                                          class="mt-1 form-textarea block"></textarea>
                            </div>
                            <x-jet-input-error for="quoteText" class="mt-2"/>
                            <x-jet-button class="my-4" type="submit">
                                {{ __('Share') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
                <div class="grid grid-rows grid-flow-col gap-4 lg:pb-8">
                    <div class="col-span-2 mx-auto pl-5 lg:pt-8">
                        <div class="mx-auto">
                            @if(session()->has('status'))
                                {!! session()->get('status') !!}
                            @endif
                        </div>
                        <table class="table-fixed">
                            <thead>
                            <tr>
                                <th class="border border-emerald-800 px-4 py-2 text-emerald-700">Serial</th>
                                <th class="border border-emerald-800 px-4 py-2 text-emerald-700">Text</th>
                                <th class="border border-emerald-800 px-4 py-2 text-emerald-700">Created At</th>
                                <th class="border border-emerald-800 px-4 py-2 text-emerald-700">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(auth()->user()->quotes as $quote)
                                <tr>
                                    <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $loop->iteration  }}</td>
                                    <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ (strlen($quote->text) > 75) ? substr($quote->text, 0, 75).'...' : $quote->text }}</td>
                                    <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ date('F d, Y h:i A', strtotime($quote->created_at)) }}</td>
                                    <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">
                                        <button type="button" class="w-full inline-flex justify-center rounded-md border
                                        border-transparent shadow-sm px-2 py-1 bg-green-600 text-base font-medium text-white
                                        hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                                        sm:ml-3 sm:w-auto sm:text-sm quote-edit-btn" data-id="{{ $quote->id }}"
                                                data-text="{{ $quote->text }}">
                                            Edit
                                        </button>
                                        <button type="button" class="w-full inline-flex justify-center rounded-md border
                                        border-transparent shadow-sm    px-2 py-1 bg-red-600 text-base font-medium text-white
                                        hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                        sm:ml-3 sm:w-auto sm:text-sm quote-delete-btn" data-id="{{ $quote->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="quoteEditModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form method="post" id="quoteEditForm">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                    Edit Quote
                                </h3>
                                <div class="mt-2">
                                    <div class="grid grid-rows grid-flow-col gap-4 lg:pb-8">
                                        <div class="col-span-2 mx-auto  lg:pt-8">
                                            <textarea name="text" id="quoteEditModalText" rows="10"
                                                      class="mt-1 form-textarea block"
                                                      style="min-width: 27rem"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button type="button" id="quoteEditCancelBtn"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function () {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $('#quoteEditCancelBtn').click(function () {
          $('#quoteEditModal').addClass('hidden')
        });
        $(document).on('click', '.quote-edit-btn', function () {
          var pid = $(this).data('id');
          var text = $(this).data('text');
          var url = "{{ url('quote/edit') }}" + "/" + pid;
          $('#quoteEditForm').attr('action', url);
          $('#quoteEditModalText').val(text);
          $('#quoteEditModal').removeClass('hidden')
        })
        $(document).on('click', '.quote-delete-btn', function () {
          var pid = $(this).data('id');
          const $this = $(this);
          $.ajax({
            url: "{{ route('quote.delete') }}",
            method: "delete",
            dataType: "html",
            data: {id: pid},
            success: function (data) {
              if (data === "success") {
                $this.closest('tr').css('background-color', 'red').fadeOut();
              }
            }
          });
        });
      })
    </script>
</x-app-layout>
