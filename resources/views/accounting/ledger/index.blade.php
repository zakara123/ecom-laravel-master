<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                                  aria-current="page">All Ledgers</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Ledgers</h1>
        </div>
    </x-slot>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
                <form class="sm:pr-3 mb-4 sm:mb-0" id="form_search" action="javascript:void(0)"
                      data-action="{{ route('search-ledgers') }}" method="GET">
                    <div class="input-group relative flex flex-wrap items-stretch w-full">
                        <input id="search_input" type="text" name="s" onkeyup="searchLedger();"
                               onchange="searchLedger();" value="{{ $ss }}"
                               class="form-control relative flex-auto min-w-0 block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-cyan-600 focus:outline-none"
                               placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                    </div>
                </form>
                <div class="flex items-center sm:justify-end w-full">
                    <div class="hidden md:flex pl-2 space-x-1">
                        <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#"
                           class="text-gray-500 hover:text-gray-900 cursor-pointer p-1 hover:bg-gray-100 rounded inline-flex justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <a href="{{ route('import-ledger-view')}}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Import Ledger
                    </a>
                    <a href="{{ route('ledger.create')}}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Add Ledger
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto" id="item_field">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Ledger ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Name
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Parent Category
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Created_At
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($ledgers as $ledger)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $ledger->id }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $ledger->name }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $ledger->ledger_group }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($ledger->created_at)) }}
                                </td>

                                <td class="p-4 whitespace-nowrap flex gap-2 flex-wrap">
                                    <a href="{{ route('ledger-details', $ledger->id) }}"
                                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg class="text-white" width="20" height="20" x="0px" y="0px" viewBox="0 0 1000 1000" fill="currentColor" stroke="currentColor">
                                            <g><path d="M944.1,913.4H55.9c-25.4,0-45.9-20.6-45.9-45.9v-735c0-25.4,20.5-45.9,45.9-45.9c25.3,0,45.9,20.6,45.9,45.9v581.9v107.2h842.2c25.3,0,45.9,20.6,45.9,45.9C990,892.9,969.4,913.4,944.1,913.4 M836.8,775.6H745c-25.3,0-45.9-20.6-45.9-45.9V408.1c0-25.4,20.6-45.9,45.9-45.9h91.9c25.4,0,45.9,20.6,45.9,45.9v321.5C882.8,755.1,862.3,775.6,836.8,775.6 M576.5,775.6h-91.9c-25.4,0-45.9-20.6-45.9-45.9V224.4c0-25.4,20.6-45.9,45.9-45.9h91.9c25.4,0,45.9,20.6,45.9,45.9v505.3C622.5,755.1,601.9,775.6,576.5,775.6 M316.2,775.6h-91.9c-25.4,0-45.9-20.6-45.9-45.9v-91.9c0-25.4,20.5-45.9,45.9-45.9h91.9c25.4,0,45.9,20.6,45.9,45.9v91.9C362.2,755.1,341.6,775.6,316.2,775.6"/></g>
                                        </svg>
                                    </a>
                                    <a href="{{ route('ledger.edit', $ledger->id) }}"
                                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                            </path>
                                            <path fill-rule="evenodd"
                                                  d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                  clip-rule="evenodd"></path>
                                        </svg>

                                    </a>
                                    <form action="{{ route('ledger.destroy',$ledger->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');" style="margin:0">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center align-center">
                        {{ $ledgers->links("pagination::tailwind") }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function searchLedger(page) {
            var form = $('#form_search');
            var actionUrl = form.data('action');
            var search = $('#search_input').val();
            var page_url = '?s=' + search;
            setTimeout(function () {
                $.ajax({
                    type: "GET",
                    url: actionUrl + page_url,
                    beforeSend: function () {
                        $('.overlay').removeClass('is-hidden');
                        $('#loader_ajax_filter').removeClass('is-hidden');
                    },
                    success: function (data) {
                        $('#item_field').html(data);
                        // show response from the php script.
                    }, error: function () {
                        console.log('Error');
                    },
                    complete: function () {
                        $('.overlay').addClass('is-hidden');
                        $('#loader_ajax_filter').addClass('is-hidden');
                    }
                });
            }, 500);
        }
        </script>
</x-app-layout>
