<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-rows grid-flow-col gap-4 lg:pb-8">
                    <div class="col-span-2 mx-auto  lg:pt-8">
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
                                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-2 py-1 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Edit
                                        </button>
                                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-2 py-1 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
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
</x-app-layout>
