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
                                  aria-current="page">Petty Cash</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Petty Cash</h1>
        </div>
    </x-slot>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 w-full">
            <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
                <div class="mt-1 relative flex gap-2 sm:w-64 xl:w-96">
                    <div class="flex justify-center">
                        <div class="mb-3 xl:w-96">
                            <form class="sm:pr-3 mb-4 sm:mb-0" id="form_search" action="javascript:void(0)"
                                  data-action="{{ route('search-pettycash') }}" method="GET">
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
                    <button data-modal-toggle="add-money-out"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        New Account Payable (Money Out)
                    </button>

                    <button data-modal-toggle="add-money-in"
                            class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                        <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        New Transaction (Money In)
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col" id="item_field">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Transaction ID
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Date
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Ledger/Account
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Description
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Money In
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Money Out
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Amount
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Balance
                            </th>
                            <th scope="col" class="p-4 text-center text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pettycashs as $pettycash)
                            <tr class="hover:bg-gray-100">
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ $pettycash->id }}
                                </td>
                                <td class="p-4  text-center font-medium text-gray-900">
                                    {{ date('d/m/Y H:i', strtotime($pettycash->date)) }}
                                </td>
                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    @if(isset($pettycash->ledger_name )) {{ $pettycash->ledger_name }} @endif
                                </td>
                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    {{ $pettycash->description }}
                                </td>

                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    {{ number_format($pettycash->debit,2,".",",") }}
                                </td>
                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    {{ number_format($pettycash->credit,2,".",",") }}
                                </td>
                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    {{ number_format($pettycash->amount,2,".",",") }}
                                </td>
                                <td class="p-4 whitespace-wrap text-center font-medium text-gray-900">
                                    {{ number_format($pettycash->balance,2,".",",") }}
                                </td>

                                <td class="p-4 whitespace-wrap space-x-2">
                                    <a href="{{ route('petty_cash.edit', $pettycash->id) }}"
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
                                    <form action="{{ route('petty_cash.destroy',$pettycash->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('You will delete, do you confirm?') }}');"
                                          style="margin:0">
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
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="row">

                        <div class="col-md-12">

                            {{ $pettycashs->links('pagination::tailwind') }}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-money-out" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-full">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add new account payable
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="add-money-out">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" id="upload_form_create" class="p-5" action="{{ route('petty_cash.index') }}" enctype="multipart/form-data">
                @csrf
                <!-- Name -->
                    <input type="hidden" name="moneyOut" value="moneyOut">
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
                                Ledger/Account :
                            </label>

                            <select name="ledger_account" required id="ledger_account" style="width: 100%"
                                    class="ledger_account bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Ledger account" value="{{old('ledger_account')}}">
                                @foreach($ledgers as $lg)
                                    <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        @error('ledger_account')
                        <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                   for="supplier">
                                Supplier :
                            </label>

                            <select name="supplier" required id="supplier" style="width: 100%"
                                    class="supplier bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Supplier" value="{{old('supplier')}}">
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        @error('supplier')
                        <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>

                    <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_bills">
                                Upload Bill files
                            </label>

                        
                            <input id="filepond" class="filepond" type="file" name="file_bills[]" accept="image/*" multiple />
                            @error('file_bills')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
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
                               for="company_name">
                            Amount
                        </label>

                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            type="number" name="amount" min="0" step=".01" placeholder="Amount" value="">
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
    <div
        class="overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full hidden"
        id="add-money-in" aria-hidden="true">
        <div class="relative w-full max-w-2xl px-4 h-full md:h-auto">

            <div class="bg-white rounded-lg shadow relative">

                <div class="flex items-start justify-between p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Add new Transaction
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                            data-modal-toggle="add-money-in">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" class="p-5" action="{{ route('petty_cash.index') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="moneyIn" value="moneyIn">
                    <div class="mb-6">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="date">
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
                                   for="ledger_account_t">
                                Ledger/Account :
                            </label>

                            <select name="ledger_account_t" required id="ledger_account_t" style="width: 100%"
                                    class="ledger_account_t bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Ledger account" value="{{old('ledger_account')}}">
                                @foreach($ledgers as $lg)
                                    <option value="{{ $lg->id }}">{{ $lg->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        @error('ledger_account')
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
                               for="company_name">
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
     <script>
        FilePond.parse(document.body);
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            const inputElement = document.querySelector('.filepond');
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['image/*'],
            allowMultiple: true,
            allowFileTypeValidation:true,
            allowFileEncode: true,
            instantUpload: false,
            allowProcess: false
        });
            $("#upload_form_create").submit(function (e) {
            e.preventDefault();
            var fd = new FormData(this);
            // append files array into the form data
            pondFiles = pond.getFiles();
            for (var i = 0; i < pondFiles.length; i++) {
                fd.append('file_bills[]', pondFiles[i].file);
            }
            $.ajax({
                    url: "{{ route('petty_cash.index') }}",
                    type: 'POST',
                    data: fd,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        //    todo the logic
                        // remove the files from filepond, etc
                        window.location.href = data.reload;
                    },
                    error: function (data) {
                        /// do nothing
                    }
                }
            );
        });

        /// select 2
        $('#supplier').select2({
            placeholder: 'Select a Supplier',
            dropdownAutoWidth: false,
            width: '100%',
            allowClear: true
        });
                
                $('.ledger_account').select2({
                placeholder: 'Select ledger account',
                dropdownAutoWidth: false,
                allowClear: true,
                language: {
                    noResults: function (term, tag) {
                        var nome = $('.select2-search__field').val();
                        new_value = '';
                        new_value = nome;
                        return '<a id="no-results-btn-debit-l" class="btn btn-success" href="javascript:void(0)" onclick="add_account_payable_ledger()">Add New</a>';
                    },
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                closeOnSelect: true,
            });
            $('.ledger_account_t').select2({
                placeholder: 'Select ledger account',
                dropdownAutoWidth: false,
                allowClear: true,
                language: {
                    noResults: function (term, tag) {
                        var nome = $('.select2-search__field').val();
                        new_value = '';
                        new_value = nome;
                        return '<a id="no-results-btn-debit-l" class="btn btn-success" href="javascript:void(0)" onclick="add_account_payable_ledger()">Add New</a>';
                    },
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                closeOnSelect: true,
            });
            $(document).on('select2:open', function (e) {
                document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
            });
        });

        function add_account_payable_ledger() {
            let ledger_name = new_value;
            if (ledger_name != '') {

                $.ajax({
                    url: '{{ route('petty-cash-ledger-ajax') }}' + '?name=' + ledger_name + '&_token={{ csrf_token() }}',
                    type: 'GET',
                    success: function (data, statut) {
                        console.log(data);
                        let id_l = $(data).attr('value');
                        let new_option = data;

                        $(".ledger_account").append(new_option);
                        $(".ledger_account_t").append(new_option);
                        $('.ledger_account').val(id_l).trigger('change');
                        $('.ledger_account_t').val(id_l).trigger('change');
                        $('#no-results-btn-debit-l').hide();
                        $(".ledger_account").trigger('select2:close');
                        $(".ledger_account_t").trigger('select2:close');
                        $('span.select2.select2-container--open').removeClass('select2-container--open');
                        $('span.select2.select2-container--open').addClass('select2-container--focus');
                        $('span.select2-container--default.select2-container--open').remove();

                    },
                    error: function (data, statut, erreur) {
                        alert("Something going wrong\n" + JSON.stringify(data));
                    }
                });
            }
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
                        console.log(data);
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
        });
    </script>

</x-app-layout>
