<ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0 w-72 ml-2 mt-2">
    <li>
        <a href="{{route('detail-appointment.presenting-complaints',$appointmentData->id)}}" class="inline-flex items-center px-4 py-3 rounded-lg w-full {{ $activeMenu == 'presenting-complaints' ? 'active text-white bg-blue-700 dark:bg-blue-600' : 'hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}" aria-current="page">
            Presenting Complaints
            <svg class="w-4 h-4 ml-auto {{ $activeMenu == 'presenting-complaints'?'text-white':'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" />
            </svg>
        </a>
    </li>
    <li>
        <a href="{{route('detail-appointment.vitals',$appointmentData->id)}}" class="inline-flex items-center px-4 py-3 rounded-lg w-full {{ $activeMenu == 'vitals' ? 'active text-white bg-blue-700 dark:bg-blue-600' : 'hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Vitals
            <svg class="w-4 h-4 ml-auto {{ $activeMenu == 'vitals'?'text-white':'text-gray-500 dark:text-gray-400' }} text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" />
            </svg>
        </a>
    </li>
    <li>
        <a href="{{route('detail-appointment.physical-examination',$appointmentData->id)}}" class="inline-flex items-center px-4 py-3 rounded-lg w-full {{ $activeMenu == 'physical-examination' ? 'active text-white bg-blue-700 dark:bg-blue-600' : 'hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Physical Examination
            <svg class="w-4 h-4 ml-auto {{ $activeMenu == 'physical-examination'?'text-white':'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" />
            </svg>
        </a>
    </li>
    <li>
        <a href="{{route('detail-appointment.diagnosis',$appointmentData->id)}}" class="inline-flex items-center px-4 py-3 rounded-lg w-full {{ $activeMenu == 'diagnosis' ? 'text-white bg-blue-700 dark:bg-blue-600' : 'hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Diagnosis
            <svg class="w-4 h-4 ml-auto {{ $activeMenu == 'diagnosis'?'text-white':'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" />
            </svg>
        </a>
    </li>
    <li>
        <a href="{{route('detail-appointment.medical-advice',$appointmentData->id)}}" class="inline-flex items-center px-4 py-3 rounded-lg w-full {{ $activeMenu == 'medical-advice' ? 'text-white bg-blue-700 dark:bg-blue-600' : 'hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Medical Advice
            <svg class="w-4 h-4 ml-auto {{ $activeMenu == 'medical-advice'?'text-white':'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" />
            </svg>
        </a>
    </li>
    <li>
        <a href="{{route('detail-appointment.medvigilance',$appointmentData->id)}}" class="inline-flex items-center px-4 py-3 rounded-lg w-full {{ $activeMenu == 'medvigilance' ? 'text-white bg-blue-700 dark:bg-blue-600' : 'hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            MedVigilance
            <svg class="w-4 h-4 ml-auto {{ $activeMenu == 'medvigilance'?'text-white':'text-gray-500 dark:text-gray-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" />
            </svg>
        </a>
    </li>
</ul>
