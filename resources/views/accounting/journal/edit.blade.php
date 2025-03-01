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
                            <a href="{{ url('journal') }}"
                               class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium">Journals</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Update Journal</h1>
        </div>
    </x-slot>

    <div class="font-sans antialiased">
        <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full overflow-hidden bg-white">
                <div class="w-full px-6 py-4 bg-white rounded shadow-md ring-1 ring-gray-900/10">
                    <form id="upload_form" method="POST" action="{{ route('journal.update', $journal->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                        <input type="hidden" id="journal_id_debit" name="journal_id_debit" value="{{ $journal->debit_id }}">
                        <input type="hidden" id="journal_id_credit" name="journal_id_credit" value="{{ $journal->credit_id }}">
                    <!-- Name -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="company_name">
                                Name
                            </label>

                            <input required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   type="text" name="name" placeholder="Name" value="{{old('name',$journal->name)}}">
                            @error('name')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="company_name">
                                    Date
                                </label>
                                <div class="relative block">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input name="date" required
                                           datepicker=""
                                           datepicker-format="dd/mm/yyyy"
                                           datepicker-autohide
                                           type="text"
                                           value="{{old('date',date('d/m/Y', strtotime($journal->date)))}}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                </div>
                            </div>
                            @error('date')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-6 group">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="company_name">
                                        Debit :
                                    </label>

                                    <select name="debit"  @if($journal->debit_id) required @else disabled @endif
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Debit" value="{{old('debit', $journal->debit_c)}}">
                                        <option value="">No debit</option>
                                        @foreach($ledgers as $lg)
                                            <option value="{{ $lg->id }}" @if($journal->debit_c == $lg->id) selected @endif>{{ $lg->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('debit')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="company_name">
                                        Credit :
                                    </label>

                                    <select name="credit" @if($journal->credit_id) required @else disabled @endif
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Credit" value="{{old('credit',$journal->credit_c)}}">
                                        <option value="">No credit</option>
                                        @foreach($ledgers as $lg)
                                            <option value="{{ $lg->id }}" @if($journal->credit_c == $lg->id) selected @endif>{{ $lg->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('credit')
                                    <span class="text-red-600 text-sm">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="company_name">
                                Amount
                            </label>

                            <input
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="number" name="amount" placeholder="Amount" value="{{old('name',$journal->amount)}}">
                            @error('amount')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <!-- Description -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="description">
                                Description
                            </label>
                            <textarea name="description"
                                      rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Your description..." > {{old('description',$journal->description)}}</textarea>

                            @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</span></p>
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
    </div>
</x-app-layout>
