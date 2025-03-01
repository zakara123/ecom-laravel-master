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
                                  aria-current="page">Banking</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Bankings</h1>
        </div>
    </x-slot>

    <div class="mx-1 my-4 w-full">
        @if (session()->has('message'))
            <div class="p-2 rounded bg-green-500 text-green-100 my-2" id="message_banking">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="grid gap-2 mb-6 md:grid-cols-3">
        <div class="  px-3 py-3 bg-white">
        </div>
        <div class="border-white rounded-md shadow px-3 py-3 bg-white">
            <h3 class="font-semibold text-xl text-center mb-3">Banking Informations</h3>

            <div class="grid gap-6  mb-2">
                <div>
                    <label class="block mb-2 mt-1 text-sm font-medium"><strong>Balance</strong> :
                        Rs {{ number_format($total,2,".",",") }}</label>
                </div>
            </div>

        </div>
        <div class=" px-3 py-3 bg-white"></div>
    </div>

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
                <div class="mt-1 relative flex gap-2 sm:w-64 xl:w-96">
                    <div class="flex justify-center">
                        <div class="mb-3 xl:w-96">
                            <form class="sm:pr-3 mb-4 sm:mb-0" id="form_search" action="javascript:void(0)"
                                  data-action="{{ route('search-bankings') }}" method="GET">
                                <div class="input-group relative flex flex-wrap items-stretch w-full">
                                    <input id="search_input" type="text" name="s" onkeyup="searchItem();"
                                           onchange="searchItem();" value="{{ $ss }}"
                                           class="form-control relative flex-auto min-w-0 block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-cyan-600 focus:outline-none"
                                           placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                    <a href="{{ route('delete-all-banking') }}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        Delete All
                    </a>
                    <a href="{{ route('export-banking') }}"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Export
                    </a>

                    <button data-modal-toggle="add-banking"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Add Banking
                    </button>

                    <button data-modal-toggle="import-Banking"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Import
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="flex flex-col relative" id="item_field">
        <div class="bg-gray-100">
            <div class="align-middle inline-block relative bg-gray-100 overflow-x-auto max-w-full" >
                <div class="shadow bg-gray-100" id="over_flowing" >
                    <table class="table-fixed min-w-full w-full divide-y divide-gray-200" >
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Transaction ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Reference
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Description
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Debit
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Credit
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Balance
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Matching status
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($bankings as $banking)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $banking->id }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($banking->date)) }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $banking->reference }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $banking->description }}
                                </td>

                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ number_format($banking->debit,2,".",",") }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ number_format($banking->credit,2,".",",") }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ number_format($banking->balance,2,".",",") }}
                                </td>

                                <td class="p-4  text-center font-medium text-gray-900">
                                    @if($banking->matching_status == 2)
                                        Matched
                                    @elseif($banking->matching_status == 1)
                                        Partial
                                    @else
                                        Unmatched
                                    @endif
                                </td>

                                <td class="p-4 space-x-2">
                                    <div class="flex gap-2">
                                        <form action="{{ route('banking-petty-cash',$banking->id) }}" method="POST"
                                              onsubmit="return confirm('{{ trans('You will matching on petty cash, do you confirm?') }}');"
                                              style="margin:0; display: inline-block">

                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="date" value="{{$banking->date }}">
                                            <input type="hidden" name="debit" value="{{$banking->debit }}">
                                            <input type="hidden" name="credit" value="{{$banking->credit }}">
                                            <input type="hidden" name="description" value="{{$banking->description }}">
                                            <input type="hidden" name="reference" value="{{$banking->reference }}">
                                            <input type="hidden" name="amount" value="{{$banking->amount }}">

                                            <button type="submit" @if($banking->matching_status == 2) disabled @endif
                                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                                                </svg>

                                            </button>
                                        </form>
                                        <button type="button" data-drawer-target="drawer-right-view-matching"
                                                data-drawer-show="drawer-right-view-matching"
                                                data-drawer-placement="right" aria-controls="drawer-right-view-matching"
                                                onclick="viewMatching('{{ $banking->id }}')"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                        <button data-modal-toggle="edit-banking"
                                                onclick="updateBanking('{{ $banking->id }}','{{ date('d/m/Y', strtotime($banking->date)) }}','{{ $banking->debit }}','{{ $banking->credit }}','{{ $banking->amount }}','{{ $banking->reference }}','{{ $banking->description }}')"
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

                                        </button>
                                    </div>
                                    <div class="flex gap-2 pt-4">
                                        <form action="{{ route('banking.destroy',$banking->id) }}" method="POST"
                                              onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                              style="margin:0; display: inline-block">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <button type="submit"
                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <button data-modal-toggle="matching-Banking" @if($banking->matching_status == 2) disabled @endif
                                                onclick="matchBanking('{{ $banking->id }}','{{ date('d/m/Y', strtotime($banking->date)) }}','{{ $banking->debit }}','{{ $banking->credit }}','{{ $banking->amount }}','{{ $banking->reference }}','{{ $banking->description }}')"
                                                class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                            Match
                                        </button>
                                    </div>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-md-12">

                            {{ $bankings->links('pagination::tailwind') }}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- drawer component -->
    <div id="drawer-right-view-matching"
         class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-auto dark:bg-gray-800"
         tabindex="-1" aria-labelledby="drawer-right-view-matching-label">
        <h5 id="drawer-right-view-matching-label"
            class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
            Matching lists
        </h5>
        <button type="button" data-drawer-hide="drawer-right-view-matching" aria-controls="drawer-right-view-matching"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <div id="matching-content-view" class="grid">
            <div class="overflow-x-auto">
                <p class="p-4 text-gray-900">Matched Rs {{ number_format(0,2,".",",") }} out of
                    Rs {{ number_format(0,2,".",",") }}</p>
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden">
                        <table class="table-fixed min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Item Matched
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Ordered
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Amount
                                </th>
                                <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-banking" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add new banking
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="add-banking">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" class="p-5" action="{{ route('banking.index') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="company_name">
                                Date
                            </label>
                            <div class="relative block">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input name="date" required datepicker="" datepicker-format="dd/mm/yyyy"
                                       datepicker-autohide type="text"
                                       class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Select date">
                            </div>
                        </div>
                        @error('date')
                        <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="ledger_account">
                                Reference :
                            </label>

                            <input required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   type="text" name="reference" placeholder="Reference" value="">

                        </div>
                        @error('reference')
                        <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="ledger_account">
                                Type :
                            </label>

                            <select id="type_banking" name="type_banking"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option value="Debit">Debit</option>
                                <option value="Credit">Credit</option>
                            </select>

                        </div>
                        @error('type_banking')
                        <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>
                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="description">
                            Description
                        </label>
                        <textarea name="description"
                                  rows="4"
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="Your description..."> {{old('description')}}</textarea>

                        @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="amount">
                            Amount
                        </label>

                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            type="number" name="amount" placeholder="Amount" min="0" step=".01" value="">
                        @error('amount')
                        <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-start mt-4">
                        <button type="submit"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="edit-banking" aria-hidden="true">
        <div class="relative w-full max-w-2xl m-auto px-4 h-full md:h-auto">
            <div class="bg-white rounded-lg shadow relative">
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Update Banking
                    </h3>
                    <button type="button" id="close_edit_banking"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="edit-banking">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" class="p-5" action="{{ route('update-banking') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="banking_id" id="banking_id">
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="company_name">
                                Date
                            </label>
                            <div class="relative block">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input id="banking_date_edit" name="date" required datepicker=""
                                       datepicker-format="dd/mm/yyyy" datepicker-autohide type="text"
                                       class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Select date">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="ledger_account">
                                Reference :
                            </label>

                            <input required id="banking_reference_edit"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   type="text" name="reference" placeholder="Reference" value="">

                        </div>
                        @error('reference')
                        <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="ledger_account">
                                Type :
                            </label>

                            <select id="type_banking_edit" name="type_banking"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option value="Debit">Debit</option>
                                <option value="Credit">Credit</option>
                            </select>

                        </div>
                        @error('type_banking')
                        <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>
                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="description">
                            Description
                        </label>
                        <textarea name="description" id="description_banking_edit"
                                  rows="4"
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="Your description..."> {{old('description')}}</textarea>

                        @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="company_name">
                            Amount
                        </label>

                        <input id="amount_edit"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               type="number" name="amount" placeholder="Amount" min="0" step=".01" value="">
                        @error('amount')
                        <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-start mt-4">
                        <button type="submit"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="import-Banking" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
            <div class="bg-white rounded-lg shadow relative">
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Import Banking
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="import-Banking">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" class="p-5" action="{{ route('import-banking') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="ledger_account">
                                Select bank file format
                            </label>
                            <select id="file_format" required name="file_format"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option value=""></option>
                                <option value="MCB PDF Converted to XLS">MCB PDF Converted to XLS</option>
                                {{--                                <option value="MCB PDF to XLS">MCB PDF to XLS</option>--}}
                                {{--                                <option value="SBM XLS">SBM XLS</option>--}}
                                {{--                                <option value="Manual File">Manual XLS File</option>--}}
                            </select>
                        </div>
                        @error('file_format')
                        <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="company_name">
                            File Banking
                        </label>

                        <input id="file" accept=".xlsx, .xls, .csv"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               type="file" name="file">

                        @error('file')
                        <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-start mt-4">
                        <button type="submit"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            Import
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="matching-Banking" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">
            <div class="bg-white rounded-lg shadow relative">
                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Match Cash <span id="reference_matching_cash"></span>, Amount Rs <span
                            id="amount_matching_cash"></span>
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="matching-Banking">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" class="p-5" action="{{ route('matching-banking') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id_matching_banking" id="id_matching_banking" value="">
                    <input type="hidden" name="date_matching_banking" id="date_matching_banking" value="">
                    <input type="hidden" name="reference_matching_banking" id="reference_matching_banking" value="">
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="ledger_banking">
                            </label>
                            <select id="match_bank_select" name="match_bank_select" required
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option value=""></option>
                                <option value="Accounts Receivable">Accounts Receivable</option>
                                <option value="Accounts Payable">Accounts Payable</option>
                                <!--
                                     <option value="Bank charge">Bank charge</option>
                                     <option value="Cost of goods Sold">Cost of goods Sold</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="mb-6 hidden is_account_receivable" id="is_type_account_recivable">
                        <label class="block text-sm font-medium text-gray-700" for="type_account_receivable"></label>
                        <div
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <input name="type_sales_receivable" type="radio" checked id="existing_sales_receivable"
                                   class=""
                                   value="Existing Sale">
                            <label class="custom-control-label" for="existing_sales_receivable">Existing Sale</label>
                        </div>
                        <div
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <input name="type_sales_receivable" type="radio" id="new_sales_receivable"
                                   class=""
                                   value="New Sale">
                            <label class="custom-control-label" for="new_sales_receivable">New Sale</label>
                        </div>
                    </div>
                    <div class="mb-6 hidden is_account_payable" id="is_type_account_payable">
                        <label class="block text-sm font-medium text-gray-700" for="type_account_payable"></label>
                        <div
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <input name="type_bill_payable" type="radio" checked id="existing_bills_payable"
                                   class=""
                                   value="Existing Bill">
                            <label class="custom-control-label" for="existing_bills_payable">Existing Bill</label>
                        </div>
                        <div
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <input name="type_bill_payable" type="radio" id="new_bills_payable"
                                   class=""
                                   value="New Bill">
                            <label class="custom-control-label" for="new_bill_payable">New Bill</label>
                        </div>
                    </div>
                    <div class="mb-6 hidden is_account_receivable" id="is_customer_banking">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="customer_matching_select">
                                Customer
                            </label>
                            <select id="customer_matching_select" name="customer_matching_select" style="width: 100%"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option value=""></option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"> {{ $customer->firstname }} {{ $customer->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-6 hidden is_account_payable" id="is_supplier_banking">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="supplier_matching_select">
                                Supplier
                            </label>
                            <select id="supplier_matching_select" name="supplier_matching_select" style="width: 100%"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option value=""></option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"> @if(!empty($supplier->name)) {{ $supplier->name }} @else {{ $supplier->name_person }}  @endif </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="block hidden is_newsale" id="block_new_sales">
                        <div class="mb-6" id="is_comment_newsale">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="description">
                                Comment
                            </label>
                            <textarea name="description_sale"
                                      rows="4"
                                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Your comment..."> {{old('description_sale')}}</textarea>

                        </div>
                    </div>
                    <div class="block hidden is_newbill" id="block_new_bill">
                        <div class="mb-6" id="is_date_newbill">
                            <div class="">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                       for="date_matching_new_bill">
                                    Date Due
                                </label>
                                <div class="relative block">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                  clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date_new_bill_due" datepicker="" datepicker-format="dd/mm/yyyy" id=""
                                           datepicker-autohide type="text"
                                           class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="Select date">
                                </div>
                            </div>
                        </div>
                        <div class="mb-6" id="is_comment_newbill">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="description">
                                Comment
                            </label>
                            <textarea name="description_bill"
                                      rows="4"
                                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Your comment..."> {{old('description_bill')}}</textarea>

                        </div>
                    </div>
                    <div class="block hidden is_existing_sales">
                        <div class="mb-6 hidden is_account_receivable" id="is_sales_banking">
                            <div class="">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                       for="sales_matching_select">
                                    Sales
                                </label>
                                <select id="sales_matching_select" name="sales_matching_select"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">

                                </select>
                            </div>
                        </div>
                        <div class="mb-6 hidden is_account_receivable " id="is_payment_method_banking">
                            <div class="">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                       for="match_payement_method_select">
                                    Payment Method
                                </label>
                                <select id="match_payement_method_select" name="match_payement_method_select"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value=""></option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Credit Card">Credit Card</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="block hidden is_existing_bills">
                        <div class="mb-6 hidden is_account_payable" id="is_bills_banking">
                            <div class="">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                       for="bills_matching_select">
                                    Bills
                                </label>
                                <select id="bills_matching_select" name="bills_matching_select"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">

                                </select>
                            </div>
                        </div>
                        <div class="mb-6 hidden is_account_payable" id="is_payment_method_banking_bill">
                            <div class="">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                       for="match_payement_method_select_bill">
                                    Payment Method
                                </label>
                                <select id="match_payement_method_select_bill" name="match_payement_method_select_bill"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                    <option value=""></option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Credit Card">Credit Card</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                               for="amount_matching">
                            Amount
                        </label>

                        <input id="amount_matching" required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               type="number" name="amount" placeholder="Amount" min="0" step=".01" value="">
                    </div>
                    <div class="flex items-center justify-start mt-4">
                        <button type="submit"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            Validate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#customer_matching_select').select2({
                placeholder: 'Select customer',
                dropdownAutoWidth: false,
                allowClear: true
            });
            $('#supplier_matching_select').select2({
                placeholder: 'Select supplier',
                dropdownAutoWidth: false,
                allowClear: true
            });

            $(document).on('select2:open', function(e) {
                document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
            });
        });
    </script>

    <script type="text/javascript">

        function updateBanking(id, date, debit, credit, amount, reference, description) {
            $('#banking_id').val(id);
            $('#banking_date_edit').val(date);
            $('#banking_reference_edit').val(reference);
            $('#description_banking_edit').text(description);
            $('#amount_edit').val(amount);
            $('#type_banking_edit option').attr('selected', false);

            $('#type_banking_edit option').each(function () {
                let option_value = $(this).attr('value');
                if (parseInt(debit)) {
                    if (option_value == 'Debit') $(this).attr('selected', true)
                }

                if (parseInt(credit)) {
                    if (option_value == 'Credit') $(this).attr('selected', true)
                }
            });
        }

        function matchBanking(id, date, debit, credit, amount, reference, description) {
            $('#reference_matching_cash').text(reference);
            $('#amount_matching_cash').text(amount);
            // $('#amount_matching').val(amount);
            $('#amount_matching').attr('max',amount);
            $('#id_matching_banking').val(id);
            $('#date_matching_banking').val(date);
            $('#reference_matching_banking').val(reference);

        }

    </script>

    <script type="text/javascript">
        function searchItem(page) {
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

        function viewMatching(id_banking) {
            // alert(id_banking);

            var actionUrl = '{{ route('banking-view') }}' + '?id=' + id_banking;
            setTimeout(function () {
                $.ajax({
                    type: "GET",
                    url: actionUrl,
                    beforeSend: function () {
                        $('.overlay').removeClass('is-hidden');
                        $('#loader_ajax_filter').removeClass('is-hidden');
                    },
                    success: function (data) {
                        $('#matching-content-view').html(data);
                        // show response from the php script.
                    }, error: function () {
                        console.log('Error');
                    },
                    complete: function () {
                        $('.overlay').addClass('is-hidden');
                        $('#loader_ajax_filter').addClass('is-hidden');
                    }
                });
            }, 100);
        }

        function getSales(id_customer) {
            // alert(id_banking);

            var actionUrl = '{{ route('get-sales-customer-ajax') }}' + '?id=' + id_customer;
            setTimeout(function () {
                $.ajax({
                    type: "GET",
                    url: actionUrl,
                    beforeSend: function () {
                    },
                    success: function (data) {
                        $('#sales_matching_select').html(data);
                        $('#sales_matching_select').select2({
                            placeholder: 'Select supplier',
                            dropdownAutoWidth: false,
                            allowClear: true
                        });

                    }, error: function () {
                        console.log('Error');
                    },
                    complete: function () {
                    }
                });
            }, 100);
        }

        function getBills(id_supplier) {
            // alert(id_banking);

            var actionUrl = '{{ route('get-bills-supplier-ajax') }}' + '?id=' + id_supplier;
            setTimeout(function () {
                $.ajax({
                    type: "GET",
                    url: actionUrl,
                    beforeSend: function () {
                    },
                    success: function (data) {
                        $('#bills_matching_select').html(data);
                        $('#bills_matching_select').select2({
                            placeholder: 'Select supplier',
                            dropdownAutoWidth: false,
                            allowClear: true
                        });

                    }, error: function () {
                        console.log('Error');
                    },
                    complete: function () {
                    }
                });
            }, 100);
        }


        $(document).ready(function () {
            $('.search_pagination .pagination li a').click(function (e) {
                e.preventDefault();
                var actionUrl = $(this).attr('href');
                var page_url = '&s=' + $('#search_input').val();
                $.ajax({
                    type: "GET",
                    url: actionUrl + page_url,// serializes the form's elements.
                    beforeSend: function () {
                        $('.overlay').removeClass('is-hidden');
                        $('#loader_ajax_filter').removeClass('is-hidden');
                    },
                    success: function (data) {
                        $('#item_field').html(data);
                    }, error: function () {
                        console.log('Error');
                    },
                    complete: function () {
                        $('.overlay').addClass('is-hidden');
                        $('#loader_ajax_filter').addClass('is-hidden');
                    }
                });
            });
            // matching banking fonctionnality
            $('#match_bank_select').change(function (){
                let val_select = $(this).val();
                if (val_select == "Accounts Receivable"){
                    $('.is_account_receivable').removeClass('hidden');
                    $('.is_account_payable').addClass('hidden');
                    $('.block_new_bills').addClass('hidden');
                } else {
                    $('.is_account_receivable').addClass('hidden');
                    $('.is_account_payable').removeClass('hidden');
                    $('.block_new_sales').addClass('hidden');
                }
            });
            $('#existing_sales_receivable').click(function () {
                $('.is_newsale').addClass('hidden');
                $('.is_existing_sales').removeClass('hidden');
            });
            $('#new_sales_receivable').click(function () {
                $('.is_newsale').removeClass('hidden');
                $('.is_existing_sales').addClass('hidden');
            });

            $('#customer_matching_select').change(function (){
                if( $('#existing_sales_receivable').is(':checked') ){
                    $('.is_existing_sales').removeClass('hidden');
                    $('.is_newsale').addClass('hidden');
                }
                else if($('#new_sales_receivable').is(':checked')) {
                    $('.is_existing_sales').addClass('hidden');
                    $('.is_newsale').removeClass('hidden');
                }
                let id_customer = $(this).val();
                getSales(id_customer);
            });

            $('#existing_bills_payable').click(function () {
                $('.is_newbill').addClass('hidden');
                $('.is_existing_bills').removeClass('hidden');
            });
            $('#new_bills_payable').click(function () {
                $('.is_newbill').removeClass('hidden');
                $('.is_existing_bills').addClass('hidden');
            });

            $('#supplier_matching_select').change(function (){
                if( $('#existing_bills_payable').is(':checked') ){
                    $('.is_existing_bills').removeClass('hidden');
                    $('.is_newbill').addClass('hidden');
                }
                else if($('#new_bills_payable').is(':checked')) {
                    $('.is_existing_bills').addClass('hidden');
                    $('.is_newbill').removeClass('hidden');
                }
                let id_supplier = $(this).val();
                getBills(id_supplier);
            });
            //
        });

    </script>

</x-app-layout>
