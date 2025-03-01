function createToast(message, type) {
    let bgColor, iconColor, buttonColor, hoverColor, iconPath;

    switch(type) {
        case 'success':
            bgColor = 'bg-green-500';
            iconColor = 'bg-green-700';
            buttonColor = 'bg-green-500';
            hoverColor = 'bg-green-600';
            iconPath = 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z';
            break;
        case 'warning':
            bgColor = 'bg-orange-500';
            iconColor = 'bg-orange-200';
            buttonColor = 'bg-orange-500';
            hoverColor = 'bg-orange-600';
            iconPath = 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z';
            break;
        case 'danger':
            bgColor = 'bg-red-500';
            iconColor = 'bg-red-700';
            buttonColor = 'bg-red-500';
            hoverColor = 'bg-red-600';
            iconPath = 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z';
            break;
        default:
            console.error('Invalid type');
            return;
    }

    const toastHTML = `
        <div id="toast-top-right" class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-white rounded-lg shadow top-5 right-5 ${bgColor}" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-white rounded-lg ${iconColor}">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="${iconPath}"/>
                </svg>
                <span class="sr-only">Icon</span>
            </div>
            <div class="ms-3 text-sm font-normal flex-grow">${message}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 ${buttonColor} hover:${hoverColor} rounded-lg focus:ring-2 focus:ring-opacity-30 p-1.5 inline-flex items-center justify-center h-8 w-8 dark:text-white dark:hover:bg-opacity-40" data-dismiss-target="#toast-top-right" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    `;

    // Append the toast to the body
    document.body.insertAdjacentHTML('beforeend', toastHTML);

    // Optionally, remove the toast after a certain time
    setTimeout(() => {
        document.querySelector('#toast-top-right').remove();
    }, 5000); // Adjust time as needed
}

function createSweetAlert(message, type) {
    if(type === 'success'){
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            customClass: {
                confirmButton: 'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'
            }
        }).then(() => {
            window.location.reload();
        });
    }
    if(type === 'danger'){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            customClass: {
                confirmButton: 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'
            }
        });
    }
}

function createAlertMessage(message, type, reloadPage=false, removeAlert=true) {
    let bgColor, iconColor, buttonColor, hoverColor, iconPath;

    switch(type) {
        case 'success':
            bgColor = 'text-green-700 bg-green-100';
            break;
        case 'warning':
            bgColor = 'text-orange-700 bg-orange-100';
            break;
        case 'danger':
            bgColor = 'text-red-700 bg-red-100';
            break;
        default:
            console.error('Invalid type');
            return;
    }

    let alertMsgHTML = `<div id="alertMsgDiv" class="p-4 mb-4 mx-5 text-sm ${bgColor} rounded-lg" role="alert"> ${message} </div>`;

    // Append the toast to the body
    document.getElementById('alert-Box').innerHTML = alertMsgHTML;

    if(removeAlert){
        // Optionally, remove the toast after a certain time
        setTimeout(() => {
            document.getElementById('alert-Box').innerHTML = "";
            if (reloadPage){
                window.location.reload();
            }
        }, 15000); // Adjust time as needed
    }
}
