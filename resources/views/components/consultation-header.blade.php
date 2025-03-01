<div class="grid gap-2 mb-6 md:grid-cols-2">
    <div class="border-white rounded-md shadow px-3 py-3 bg-white grid md:grid-cols-2">
        <div>
            <h3 class="font-semibold text-xl text-center mb-3">Appointment Info</h3>
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium">Appointment Date: {{ date('d/m/Y', strtotime($appointmentData->appointment_date)) }}</label>
            </div>
            <div class="grid gap-6 md:grid-cols-2 mb-2">
                <div>
                    <label class="block mb-2 mt-1 text-sm font-medium">Appointment Time: {{ date('H:i', strtotime($appointmentData->appointment_time)) }}</label>
                </div>
            </div>
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium">Date Created: {{ date('d/m/Y H:i', strtotime($appointmentData->created_at)) }}</label>
            </div>
        </div>
        @if(empty($appointmentData->consultation_end_time))
            <div class="flex justify-end items-center">
                <!-- End Consultation Button -->
                {{--            {{ route('detail-appointment.end-consultation', $appointmentData->id) }}--}}
                <a href="" class="end-consultation-btn flex justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stop-fill" viewBox="0 0 16 16">
                        <path d="M5.5 4.5h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5a1 1 0 0 1 1-1z"/>
                    </svg>
                    End Consultation
                </a>
            </div>
        @endif
    </div>
    <div class="border-white rounded-md shadow px-3 py-3 bg-white">
        <div class="flex items-center w-full">
            <div class="flex-shrink-0">&nbsp;</div>
            <div class="flex-1 text-center">
                <h3 class="font-semibold text-xl mb-3">Patient Info</h3>
            </div>
        </div>
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium">Patient Name:
                <a href="{{ route('patient-details', ['id' => $appointmentData->customer_id]) }}"
                   class="no-underline hover:underline">
                    {{$appointmentData->patient_firstname}} {{$appointmentData->patient_lastname}}</a></label>
        </div>
        @if(!empty($appointmentData->consultation_place_address))
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium">Patient Address: {{ $appointmentData->consultation_place_address }}</label>
            </div>
        @endif
        @if(!empty($appointmentData->patient_email))
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium">Email: {{ $appointmentData->patient_email }}</label>
            </div>
        @endif
        @if(!empty($appointmentData->patient_phone))
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium">Phone: {{ $appointmentData->patient_phone }}</label>
            </div>
        @endif
        @if(!empty($customer->mobile_no))
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium">Mobile: {{ $customer->mobile_no }}</label>
            </div>
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.end-consultation-btn', function (e)
    {
        e.preventDefault();
        Swal.fire({
            title: 'End Consultation',
            html: `
        <div class="mb-4 text-left">
            <label for="start_consultation_date" class="block text-sm font-medium text-gray-700 mb-2">Start Consultation Date</label>
            <input type="datetime-local" value="{{$appointmentData->appointment_date_time}}" id="start_consultation_date" style="width: 100%" class="swal2-input ml-0 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="mb-4 text-left">
            <label for="consultation_comments" class="block text-sm font-medium text-gray-700 mb-2">Comments</label>
            <textarea id="consultation_comments" style="width: 100%" class="swal2-textarea ml-0 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" rows="4" placeholder="Add your comments"></textarea>
        </div>
    `,
            showCancelButton: true,
            confirmButtonText: '<span class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save</span>',
            cancelButtonText: '<span class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400">Cancel</span>',
            focusConfirm: false,
            customClass: {
                popup: 'swal2-popup-custom',
                actions: 'swal2-actions-right'
            },
            preConfirm: () => {
                const startConsultationDate = document.getElementById('start_consultation_date').value;
                const comments = document.getElementById('consultation_comments').value;

                if (!startConsultationDate) {
                    Swal.showValidationMessage('Start consultation date is required');
                    return false;
                }
                return {
                    start_consultation_date: startConsultationDate,
                    consultation_comments: comments
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("appointment.end-consultation") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        appointment_id: '{{ $appointmentData->id }}',
                        start_consultation_date: result.value.start_consultation_date,
                        consultation_comments: result.value.consultation_comments
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Consultation Ended!',
                                text: response.message,
                                icon: 'info',
                                customClass: {
                                    confirmButton: 'bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300'
                                },
                                buttonsStyling: false
                            }).then(() => {
                                window.location.href='{{ route("detail-appointment", $appointmentData->id) }}';
                            });

                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                    }
                });
            }
        });

    });
</script>
<style>
    /* Prevent bottom scrollbar and center the popup content */
    .swal2-popup-custom {
        overflow: visible !important;
        height: auto !important;
    }

    /* Align action buttons (Save, Cancel) to the right */
    .swal2-actions-right {
        justify-content: flex-end !important;
    }
    #swal2-html-container{
        overflow: hidden;
    }

</style>

