<!DOCTYPE html>
<html>
<head>
	<title>Attachment of Order ID #{{$sales->id}}</title>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"  media="all">

  <link rel="preconnect" href="https://fonts.googleapis.com"  media="all">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin  media="all">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"  media="all"> 
<link rel="icon" type="image/x-icon" href="{{url('img/logo.PNG')}}">
<style type="text/css">
	@page { 
		size: landscape; 
		-webkit-transform: rotate(-90deg); -moz-transform:rotate(-90deg);
		filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
	}

	body{
		font-family: 'Montserrat', sans-serif;
		/*width: 2480px;
		height: 3508px*/;
	}
	
	.right_arrow {
		right: -16.7rem;
	}

	.border_arrow {
	content: "";
	position: absolute;
	bottom: 5px;
	left: 0;
	width: 1.4rem;
	height: 1px;
	background: black;
}
.border_arrow2 {
	content: "";
	position: absolute;
	bottom: 5px;
	right: 0;
	width: 1.4rem;
	height: 1px;
	background: black;
}

.writhing_mode{
		writing-mode: vertical-rl; 
	}
	.first_pages {
	width: 55%;
}
.Second_pages {
	width: 45%;
}
.delivl{
	width: 47%;
}
.delivr{
	width: 53%;
}
.delivl2{
	width: 45%;
}
.delivr2{
	width: 55%;
}
.text-xxs {
	font-size: .55rem;
	line-height: 1rem;
}
@media print {
  body {
    zoom: 89%;
  }
}
</style>
</head>
<body onload="setTimeout(function(){jQuery('#printJS-form').print()}, 300)">
	<div class="flex" id="printJS-form" style="max-width: 100%;max-height: 100%;">
		<div class="first_pages p-4">
			<div class=" w-full  border border-black">
				<div class="p-3">
					<div class="text-right">
						<h2 class="font-semibold leading-3 text-xs leading-3">MPL 160A</h2>
						<H4 class="text-xs leading-3">Revised 2014</H4>
					</div>
					<div class="">
						<div class="text-center w-full">	
						  <h2 class="font-bold text-sm">THE MAURITIUS POST LTD</h2>
						  <h4 class="text-sm">Advice and delivery of an Express Article</h4>
						</div>
						<div class="form flex p-4 gap-4 w-full">
							<div class="w-3/4">
								<div class=" flex gap-2 mb-2">
				                    <label class="w-56 text-xs font-medium text-gray-700 leading-4">To the Postmaster of</label>
				                    <input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
			                	</div>
								<div class=" flex gap-2 ">
				                    <label class="w-56 text-xs font-medium text-gray-700 leading-4">Herewith Express*</label>
				                    <input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
			                	</div>
								<div class="text-xs my-3"><p>*State Whether letter, printed matter, newspaper or parcel</p></div>
								<h1 class="font-bold text-sm">Recipient</h1>
								<div class=" flex gap-2 my-2">
				                    <label class="w-56 text-xs font-medium text-gray-700 leading-4">Name: Mr/Mrs/Miss:</label>
				                    <input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" value="{{$sales->customer_firstname}} {{$sales->customer_lastname}} (Order ID #{{$sales->id}})" placeholder="">
			                	</div>
			                	<div class=" flex gap-2 mb-3">
				                    <label class="w-56 text-xs font-medium text-gray-700 leading-4">Address:</label>
				                    <input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" value="{{$sales->customer_address}}, {{$sales->customer_city}}" placeholder="">
			                	</div>
			                	<h1 class="font-bold text-sm mb-3">Sender</h1>
								<div class=" flex gap-2 mb-2">
				                    <label class="w-56 text-xs font-medium text-gray-700 leading-4">Name: Mr/Mrs/Miss:</label>
				                    <input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" value="{{@$company->company_name}}" placeholder="">
			                	</div>
			                	<div class=" flex gap-2">
				                    <label class="w-56 text-xs font-medium text-gray-700 leading-4">Address:</label>
				                    <input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" value="{{$company->company_address}}" placeholder="">
			                	</div>
							</div>
							<div class="w-1/4 ">
								<div class="w-full border border-black h-28 "></div>
								<h2 class="text-center text-xs">Date Stamp Accepting office</h2>
								<div class="w-full border border-black h-28 p-2 text-center mt-8 ">
									<h3 class="text-xs">Signature</h3>
									<h3 class="text-xs">Accepting Officer</h3>
									<h5 class="w-full h-5 border-t border-b border-black mt-8"></h5>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="border-t border-b border-black text-center py-2">
					<h2 class="font-bold text-xs">Delivery Particulars</h2>
					<h3 class="font-bold text-xs">Please do not omit to record date and time of delivery</h3>
				</div>
				<div class="w-full flex">

					<div class="delivl  box-sizing  ">
						<div class="w-full flex items-center justify-center h-full">
							<h2 class="w-6 writhing_mode rotate-180 transform-gpu  text-xs">To<span class="text-white">_</span>be<span class="text-white">_</span>filled_in<span class="text-white">_</span>by<span class="text-white">_</span>recipient</h2>
							<div class="w-72 border-l border-r border-black p-2  relative h-full box-sizing pr-0 box-border">
								<h1 class="font-semibold mb-3 text-xs">Delivery Particulars</h1>
				            	<div class=" flex gap-4 mb-2">
				                    <label class=" text-xs font-medium text-gray-900 leading-4">Date</label>
				                    <input class="w-40 text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4 " type="text" placeholder="">
				            	</div>
				            	<div class=" flex gap-4 mb-5">
				                    <label class=" text-xs font-medium text-gray-900 leading-4">Time</label>
				                    <input class="w-40 text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
				            	</div>
				            	<input class=" text-sm py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
				            	<h3 class="text-sm">Signature of Recipient</h3>
				            	<div class="mt-5">
				            		<input class=" text-sm py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
				            		<h3 class="text-sm">Name of Signatory</h3>
				            	</div>
							</div>
							<h2 class="writhing_mode rotate-180 transform-gpu w-6 text-xs ">To<span class="text-white">_</span>be<span class="text-white">_</span>filled_in<span class="text-white">_</span>by<span class="text-white">_</span>recipient</h2>
							
						</div>
					</div>	

					<div class="delivr gap-4 border-l border-black relative p-2 box-sizing">
						
						<div class="flex gap-3">
							<div class="delivr2 " >
								<h1 class="mb-3 text-xs font-semibold">OFFICE USE</h1>
				            	<div class=" flex gap-2 my-3">
				                    <label class=" text-xs font-medium text-gray-900 leading-4 w-20">Serial No</label>
				                    <input class="w-full text-xs py-0 border-b border-dotted border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
				            	</div>
				            	<div class="w-full flex gap-2 pb-3 justify-center items-center">
				            		<div class="w-3/6">
				            			<h3 class="text-xxs">Time sent out</h3>
				            			<h4 class=" relative text-center text-xs w-16 flex gap-1"><input class="py-0 border-b border-gray-900 focus:outline-none focus:border-indigo-500 h-2 w-5" type="text"> hr <input class="py-0 border-b  border-gray-900 focus:outline-none focus:border-indigo-500 h-2 w-5" type="text"></h4>
				            			
				            		</div>
				            		<div class="w-3/6">
				            			<h3 class="text-xxs">Time Returned</h3>
				            			<h4 class=" relative text-center text-xs w-16 flex gap-1"><input class="py-0 border-b border-gray-900 focus:outline-none focus:border-indigo-500 h-2 w-5" type="text"> hr <input class="py-0 border-b  border-gray-900 focus:outline-none focus:border-indigo-500 h-2 w-5" type="text"></h4>
				            		</div>
				            	</div>
				            	<input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
				            	<h3 class="text-xs">Signature of Postman / Asst. Postman</h3>
				            	<div class="mt-3">
				            		<input class="w-full text-xs py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-4" type="text" placeholder="">
				            	<h3 class="text-xs">Name of Postman / Asst. Postman</h3>
				            	</div>
				            	
				            	
							</div>
							<div class="delivl2 pr-8">
								.
								<div class="w-32 border border-black h-28 "></div>
								<h2 class="text-center text-xs">Date Stamp Delivery office</h2>
							</div>
							
						</div>
						<input class="w-72 text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6  mx-auto block" type="text" placeholder="">
						<h3 class=" text-center w-72 mx-auto text-sm">Signature of Controlling Office</h3>
					</div>	

				</div>

			</div>
		</div>
		<div class="Second_pages">
			<div class="w-full py-5">
		<div class="text-center w-full relative ">	
		  <h2 class=" font-bold text-sm">THE MAURITIUS POST LTD</h2>
		  <img class="absolute right-0 top-0 w-20" src="{{url('img/logo.PNG')}}">
		 </div>
		 <div class="flex justify-between items-end mt-5 text-center leading-5">
		 	<h2 class="font-semibold text-sm">PARCEL DECLARATION (Inland / Inter Island)</h2>
		 	<h5 class="text-xs ">MPL / 70 </br> (REV 2021) </h5>
		 </div>
		 <div class="border-dashed border-2 border-black pr-2">
		 	<h3 class="pl-6 text-xs">A false declaration is a criminal offence</h3>
		 	<div class="flex items-start">
			 	<h2 class="writhing_mode rotate-180 transform-gpu font-semibold text-xs ">ADDRESSED<span class="text-white">_</span>TO</h2>
			 	

		 		<table class="border-collapse border border-slate-400 w-full text-center">

							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs semibold ">NAME</th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600" value="{{$sales->customer_firstname}} {{$sales->customer_lastname}}"></td>
							    </tr>
							  </thead>
							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs semibold ">ADDRESS</th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600" value="{{$sales->customer_address}}, {{$sales->customer_city}}"><input type="text" class="border-dotted border-t-2 border-black w-full h-full p-1 rounded outline-none focus:border-gray-600 "></td>
							    </tr>
							  </thead>

							  <thead>
								    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-xs semibold ">TEL. NO.</th>
							      <td class="px-2 text-center border border-black w-full flex"><label for="">(H)</label><input type="text" class=" p-1 rounded outline-none focus:border-gray-600 w-full"><label for="">(M)</label><input type="text" value="{{$sales->customer_phone}}" class="w-full h-full p-1 rounded outline-none focus:border-gray-600"><label for="">(O)</label><input type="text" class="w-full  p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							 	<thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-xs semibold ">E-MAIL :</th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" value="{{$sales->customer_email}}" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
						</table>
		 	</div>
		 	<div class="flex gap-2">
		 		<div class="w-3/6 ">
		 			<div class="flex w-full mt-5">
			 			<h2 class="writhing_mode rotate-180 transform-gpu font-semibold text-md invisible">A</h2>
			 			<h3 class="font-semibold text-center text-sm border border-black border-b-0 w-full">Content/s Declaration</h3>
		 				
		 			</div>
		 			<div class="flex">
			 			<h2 class="writhing_mode rotate-180 transform-gpu font-semibold text-md invisible">ADDRESSED TO</h2>
					 	<table class="border-collapse border border-slate-400 w-full text-center">

							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-center text-xs semibold">Qty</th>
							      <td class="px-2 text-center border border-black w-4/5">Content/s detail</td>
							    </tr>
							  </thead>
							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-center"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-center"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-center"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-center"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-center"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></th>
							      <td class="px-2 text-center border border-black w-4/5 text-center"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
						</table>
		 			</div>
		 		</div>
		 		<div class="w-3/6"><h2 class="font-semibold text-center text-xs">TICK</h2>
		 			<div class="flex gap-2">
		 				<div class="">
				 			<table class="border-collapse border border-slate-400 w-full">
							  <thead>
							    <tr>
							      <th class="border border-black text-left pl-2 w-4/5 text-xs semibold">Ordinary</th>
							      <td class="border border-black w-1/5 "><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							  <thead>
							    <tr>
							      <th class="border border-black text-left pl-2 w-4/5 text-xs semibold">Express</th>
							      <td class="border border-black w-1/5 "><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							  <thead>
							    <tr>
							      <th class="border border-black text-left pl-2 w-4/5 text-xs semibold">A/R</th>
							      <td class="border border-black w-1/5 "><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							  
								</table>
		 					
		 				</div>
							<div class="">
								<h3 class="font-semibold text-center text-xs border border-black border-b-0">Weight</h3>
								<table class="border-collapse border border-slate-400 w-full ">
							  <thead>
							    <tr>
							      <th class="border border-black text-left pl-2 w-3/6 text-center text-xs">KG</th>
							      <th class="border border-black text-left pl-2 w-3/6 text-center text-xs">Gm</th>
							      
							    </tr>
							  </thead>
							  <thead>
							    <tr>
							      <th class="border border-black text-left pl-2 w-3/6"><input type="text" class="text-center w-full h-full p-1 rounded outline-none focus:border-gray-600"></th>
							      <th class="border border-black text-left pl-2 w-3/6"><input type="text" class="text-center w-full h-full p-1 rounded outline-none focus:border-gray-600"></th>
							      
							    </tr>
							  </thead>

							 <thead>
							    <tr>
							      <th class="border border-black text-left pl-2 w-3/6 text-center text-xs ">Value Rs</th>
							      <th class="border border-black text-left pl-2 w-3/6"><input type="text" class=" text-center w-full h-full p-1 rounded outline-none focus:border-gray-600"></th>
							      
							    </tr>
							  </thead>
							  
								</table>
								
							</div>
		 				
		 			</div>
		 			<textarea id="message" rows="4" class="border-dashed h-16 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-2 border-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Barcode No./Item No."></textarea>
		 		</div>
		 	</div>
		 <div class="flex my-5 items-start">
			 	<h2 class="writhing_mode rotate-180 transform-gpu font-semibold text-md inline-block">SENDER</h2>
			 	
			 	<table class="border-collapse border border-slate-400 w-full">
					  <thead>
					    <tr>
					      <th class="border border-black text-left pl-2 w-1/5 text-xs">NAME</th>
					      <td class="border border-black w-4/5"><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600" value="{{@$company->company_name}}"></td>
					    </tr>
					  </thead>
					  <thead>
					    <tr>
					      <th class="border border-black text-left pl-2 w-1/5 text-xs">ADDRESS</th>
					      <td class="border border-black w-4/5"><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600" value="{{$company->company_address}}"></td>
					    </tr>
					  </thead>
					  <thead>
					    <tr>
					      <th class="border border-black text-left pl-2 w-1/5 text-xs">TEL. NO.</th>

					      <td class="border border-black  w-full flex border-t-0 border-l-0"><input type="text" class="w-full h-full p-1 mr-2 outline-none focus:border-gray-600 border-r rounded-none border-black" value="{{$company->company_phone}}"><label class="w-36 leading-5" for="">Email :</label><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600" value="{{$company->company_email}}"></td>
					    </tr>
					  </thead>
				</table>

		 		
		 	</div>
		 	<div class="form flex  gap-2 w-full p-2">
					<div class="w-3/4">
						<h3>I certify that the particulars given in the declaration are correct.</h3>
						<div class=" flex gap-4  mt-5">
	                    <label class=" text-sm font-medium text-gray-700 leading-8 w-64">Sender's Signature :</label>
	                    <input class="w-full text-lg py-0 border-b-2 border-gray-600 focus:outline-none focus:border-indigo-500 h-6 border-dotted" type="text" placeholder="">
	            	</div>
					</div>
					<div class="w-1/4 ">
						<div class="w-full border-2 border-black h-28 flex items-end justify-center border-dotted"><h2 class="text-center text-xs">Date Stamp </h2></div>
						
						
					</div>
				</div>
		 </div>
	</div>
		</div>
	</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{url('js/jQuery.print.js')}}"></script>
</body>
</html>