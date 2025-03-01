<x-app-layout>
    <x-slot name="header">
        <div class="mx-4 my-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">{{ __('Dashboard') }} {{-- DB::connection()->getDatabaseName() --}}</h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="px-4 md:px-10 mx-auto w-full -m-24">
            <div class="">

                <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-6  2xl:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-start flex-1 text-green-500 text-base font-bold">
                                <form action="{{ route('export-stat') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <input name="start" required datepicker="" datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                                        </div>
                                        <span class="mx-4 text-gray-500">to</span>
                                        <div class="relative">
                                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <input name="end" type="text" datepicker="" datepicker-autohide class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                                        </div>
                                        <span class="mx-4 text-gray-500"> </span>
                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Export</button>
                                    </div>

                                </form>
                            </div>
                            <div class="flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                {{ $check_aug }}%
                            </div>
                        </div>
                        <div id="main-chart-sales" style="min-height: 435px;">
                            {!! $chartSale->container() !!}
                        </div>
                    </div>
                    <div class="bg-white shadow rounded-lg p-2 sm:p-4 xl:p-6 ">

                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Latest Transactions</h3>
                                <span class="text-base font-normal text-gray-500">This is a list of latest transactions</span>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ url('sales') }}" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2">View all</a>
                            </div>
                        </div>

                        <div class="flex flex-col mt-8">
                            <div class="overflow-x-auto rounded-lg">
                                <div class="align-middle inline-block min-w-full">
                                    <div class="shadow overflow-hidden sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="p-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Transaction
                                                </th>
                                                <th scope="col" class="p-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Date &amp; Time
                                                </th>
                                                <th scope="col" class="p-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Amount
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                            @foreach($last_transaction_payement as $ltp)
                                            <tr>
                                                <td class="p-2 whitespace-nowrap text-sm font-normal text-gray-900">
                                                    Payment Order #{{ $ltp->id }} from <span class="font-semibold">{{ $ltp->name }}</span>
                                                </td>
                                                <td class="p-2 whitespace-nowrap text-sm font-normal text-gray-500">
                                                    {{ date('M d , Y', strtotime($ltp->payment_date)) }}
                                                </td>
                                                <td class="p-2 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                    Rs {{ number_format($ltp->amount,2,".",",") }}
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ $chartSale->cdn() }}"></script>
{{ $chartSale->script() }}
</script>
