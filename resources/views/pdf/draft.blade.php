<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="preconnect" href="https://fonts.googleapis.com" media="all">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin media="all">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" media="all"> 
<style type="text/css" media="all">
body{
		font-family: 'Montserrat', sans-serif;
		/*width: 2480px;
		height: 3508px*/;
	}
	.rotate-180 {
	rotate: 180deg;
}
.transform-gpu {
	translate-x: 0;
	translate-y: 0;
	rotate: 0;
	skew-x: 0;
	skew-y: 0;
	scale-x: 1;
	scale-y: 1;
	transform: translate3d(var(translate-x),var(translate-y),0) rotate(var(rotate)) skewX(var(skew-x)) skewY(var(skew-y)) scaleX(var(scale-x)) scaleY(var(scale-y));
}
	h1, h2, h3, h4, h5, h6 {
	font-size: inherit;
	font-weight: inherit;
}
blockquote, dd, dl, figure, h1, h2, h3, h4, h5, h6, hr, p, pre {
	margin: 0;
}
table {
	text-indent: 0;
	border-color: inherit;
}
.text-left {
	text-align: left;
}
button, input, optgroup, select, textarea {
	padding: 0;
	line-height: inherit;
	color: inherit;
}
img, video {
	max-width: 100%;
	height: auto;
}
button, input, optgroup, select, textarea {
	font-family: inherit;
	margin: 0;
}
*, ::after, ::before {
	ring-inset: var(empty, );
	ring-offset-width: 0px;
	ring-offset-color: #fff;
	ring-color: rgba(59, 130, 246, 0.5);
	ring-offset-shadow: 0 0 #0000;
	ring-shadow: 0 0 #0000;
}
*, ::after, ::before {
	shadow: 0 0 #0000;
}
*, ::after, ::before {
	box-sizing: border-box;
	border-width: 0;
	border-style: solid;
	border-color: currentColor;
}
	.right_arrow {
		right: -16.7rem;
	}
	.border_arrow::after {
	content: "";
	position: absolute;
	bottom: 5px;
	left: 0;
	width: 2rem;
	height: 1px;
	background: black;
}
.border_arrow::before {
	content: "";
	position: absolute;
	bottom: 5px;
	right: 0;
	width: 2rem;
	height: 1px;
	background: black;
}
.items-center {
	align-items: center;
}
.writhing_mode{
		writing-mode: vertical-rl; 
	}
	.first_pages {
		width: 55%;
		padding: 1rem; /* 16px */
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
	width: 57%;
}
.mr-2 {
	margin-right: .5rem;
}
.wraper{
	display: flex;
}
.first_pages_wrap{
	width: 100%;
	border: 1px solid black;
}
.p-5{padding: 1.25rem; /* 20px */}
.text-right{text-align: right;}
.text-center{text-align: center;}
.font-bold{font-weight: 700;}
.font-semibold{font-weight: 600;}
.leading-3{line-height: .75rem; /* 12px */}
.leading-8{line-height: 2rem; /* 32px */}
.text-xs:{font-size: 0.75rem; /* 12px */line-height: 1rem; }
.text-sm{font-size: 0.875rem; /* 14px */line-height: 1.25rem; /* 20px */}
.text-lg{font-size: 1.125rem; /* 18px */line-height: 1.75rem; /* 28px */}
.w-full{width: 100%;}
.flex{display: flex;}
.gap-2{gap: 0.5rem; /* 8px */}
.gap-4{gap: 1rem; /* 16px */}
.w-3{width: 75%;}
.w-56{width: 14rem; /* 224px */}
.font-medium{font-weight: 500;}
.text-black{color: black;}
.py-0{padding-top: 0px;padding-bottom: 0;}
.border-b{border-bottom: 1px solid black;}
.focus\:outline-none:focus {
	outline: 2px solid transparent;
	outline-offset: 2px;
}
.focus\:border-indigo-500:focus {
	border-opacity: 1;
	border-color: rgba(99,102,241,var(border-opacity));
}
.h-6 {
	height: 1.5rem;
}

.my-3 {
	margin-top: .75rem;
	margin-bottom: .75rem;
}
.mt-3 {
	margin-top: .75rem;
}
.border-gray-600 {
	border-opacity: 1;
	border-color: rgba(75,85,99,var(border-opacity));
}
.mb-3 {
	margin-bottom: .75rem;
}
.text-gray-700 {
	text-opacity: 1;
	color: rgba(55,65,81,var(text-opacity));
}
.text-gray-700 {
	text-opacity: 1;
	color: rgba(55,65,81,var(text-opacity));
}
.text-xs {
	font-size: .75rem;
	line-height: 1rem;
}
.text-sm {
	font-size: 0.875rem;
	line-height: 1.25rem;
}
.w-1\/4 {
	width: 25%;
}
.h-28 {
	height: 7rem;
}
.mt-8 {
	margin-top: 2rem;
}
.h-5 {
	height: 1.25rem;
}
.border-t {
	border-top-width: 1px;
}
.border-black {
	border-opacity: 1;
	border-color: rgba(0,0,0,var(border-opacity));
}
.py-2 {
	padding-top: .5rem;
	padding-bottom: .5rem;
}
.justify-center {
	justify-content: center;
}
.items-center {
	align-items: center;
}
.h-full {
	height: 100%;
}

.w-8 {
	width: 2rem;
}
.pr-16 {
	padding-right: 4rem;
}
.p-2 {
	padding: .5rem;
}
.pl-2 {
	padding-left: .5rem;
}
.border-l {
	border-left-width: 1px;
}
.border-r {
	border-right-width: 1px;
}
.w-72 {
	width: 18rem;
}
.relative {
	position: relative;
}
.mb-8 {
	margin-bottom: 2rem;
}
.text-gray-900 {
	text-opacity: 1;
	color: rgba(17,24,39,var(text-opacity));
}
.mb-12 {
	margin-bottom: 3rem;
}
.text-gray-900 {
	text-opacity: 1;
	color: rgba(17,24,39,var(text-opacity));
}
.mt-12 {
	margin-top: 3rem;
}
.gap-3 {
	gap: .75rem;
}
.my-3 {
	margin-top: .75rem;
	margin-bottom: .75rem;
}
.pb-6 {
	padding-bottom: 1.5rem;
}
.w-3\/6 {
	width: 50%;
}
.mt-6 {
	margin-top: 1.5rem;
}
.pr-8 {
	padding-right: 2rem;
}
.border {
	border-width: 1px;
}
.mx-auto {
	margin-left: auto;
	margin-right: auto;
}
.py-5 {
	padding-top: 1.25rem;
	padding-bottom: 1.25rem;
}
.px-5 {
	padding-left: 1.25rem;
	padding-right: 1.25rem;
}
.w-20 {
	width: 5rem;
}
.right-0 {
	right: 0;
}
.top-0 {
	top: 0;
}
.absolute {
	position: absolute;
}
.leading-5 {
	line-height: 1.25rem;
}
.justify-between {
	justify-content: space-between;
}
.mt-5 {
	margin-top: 1.25rem;
}
.leading-5 {
	line-height: 1.25rem;
}
.pr-2 {
	padding-right: .5rem;
}
.border-dashed {
	border-style: dashed;
}
.border-2 {
	border-width: 2px;
}
.pl-6 {
	padding-left: 1.5rem;
}
.items-start {
	align-items: flex-start;
}
.border-collapse {
	border-collapse: collapse;
}
.w-1\/5 {
	width: 20%;
}
.px-2 {
	padding-left: .5rem;
	padding-right: .5rem;
}
.w-4\/5 {
	width: 80%;
}
.outline-none {
	outline: 2px solid transparent;
	outline-offset: 2px;
}
.p-1 {
	padding: .25rem;
}
.rounded {
	border-radius: .25rem;
}
.focus\:border-gray-600:focus {
	border-opacity: 1;
	border-color: rgba(75,85,99,var(border-opacity));
}
.pl-2 {
	padding-left: .5rem;
}
.w-3\/6 {
	width: 50%;
}
.mt-5 {
	margin-top: 1.25rem;
}
.invisible {
	visibility: hidden;
}
.border-b-0 {
	border-bottom-width: 0;
}
.text-gray-900 {
	text-opacity: 1;
	color: rgba(17,24,39,var(text-opacity));
}
.p-2\.5 {
	padding: .625rem;
}
.bg-gray-50 {
	bg-opacity: 1;
	background-color: rgba(249,250,251,var(bg-opacity));
}
.border-gray-900 {
	border-opacity: 1;
	border-color: rgba(17,24,39,var(border-opacity));
}
.border-dashed {
	border-style: dashed;
}
.rounded-lg {
	border-radius: .5rem;
}
.h-16 {
	height: 4rem;
}
.block {
	display: block;
}
textarea {
	resize: vertical;
}
.items-start {
	align-items: flex-start;
}
.my-5 {
	margin-top: 1.25rem;
	margin-bottom: 1.25rem;
}
.inline-block {
	display: inline-block;
}
.border-l-0 {
	border-left-width: 0;
}
.border-t-0 {
	border-top-width: 0;
}
.border-r {
	border-right-width: 1px;
}
.leading-5 {
	line-height: 1.25rem;
}
.w-36 {
	width: 9rem;
}
.p-2 {
	padding: .5rem;
}
.w-3\/4 {
	width: 75%;
}
.w-1\/4 {
	width: 25%;
}
.w-64 {
	width: 16rem;
}
.border-b-2 {
	border-bottom-width: 2px;
}
.border-dotted {
	border-style: dotted;
}
.border-2 {
	border-width: 2px;
}
.justify-center {
	justify-content: center;
}
.items-end {
	align-items: flex-end;
}
.w-28 {
	width: 7rem;
}
.leading-8 {
	line-height: 2rem;
}
</style>
<link rel="stylesheet" href="url('css/print.min.css')"  media="all">


</head>
<body id="printJS-form">
	<div class="flex">
		<div class="first_pages p-4">
			<div class=" w-full  border border-black">
				<div class="p-5">
					<div class="text-right">
						<h2 class="font-bold leading-3 text-xs">MPL 160A</h2>
						<H4 class="text-xs">Revised 2014</H4>
					</div>
					<div class="">
						<div class="text-center w-full">	
						  <h2 class="font-bold">THE MAURITIUS POST LTD</h2>
						  <h4>Advice and delivery of an Express Article</h4>
						</div>
						<div class="form flex p-4 gap-4 w-full">
							<div class="w-3/4">
								<div class=" flex gap-2">
				                    <label class="w-56 text-sm font-medium text-gray-700 leading-8">To the Postmaster of</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
			                	</div>
								<div class=" flex gap-2">
				                    <label class="w-56 text-sm font-medium text-gray-700 leading-8">Herewith Express*</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
			                	</div>
								<div class="text-xs my-3"><p>*State Whether letter, printed matter, newspaper or parcel</p></div>
								<h1 class="font-bold text-sm">Recipient</h1>
								<div class=" flex gap-2 mt-3">
				                    <label class="w-56 text-sm font-medium text-gray-700 leading-8">Name: Mr/Mrs/Miss:</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" value="{{$sales->customer_firstname}} {{$sales->customer_lastname}}" placeholder="">
			                	</div>
			                	<div class=" flex gap-2 mb-3">
				                    <label class="w-56 text-sm font-medium text-gray-700 leading-8">Address:</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" value="{{$sales->customer_address}}" placeholder="">
			                	</div>
			                	<h1 class="font-bold text-sm">Sender</h1>
								<div class=" flex gap-2">
				                    <label class="w-56 text-sm font-medium text-gray-700 leading-8">Name: Mr/Mrs/Miss:</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" value="{{@$company->company_name}}" placeholder="">
			                	</div>
			                	<div class=" flex gap-2">
				                    <label class="w-56 text-sm font-medium text-gray-700 leading-8">Address:</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" value="{{$company->company_address}}" placeholder="">
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
					<h2 class="font-semibold text-sm">Delivery Particulars</h2>
					<h3 class="font-semibold text-sm">Please do not omit to record date and time of delivery</h3>
				</div>
				<div class="w-full flex">

					<div class="delivl  box-sizing  ">
						<div class="w-full flex items-center justify-center h-full">
							<h2 class="w-8 writhing_mode rotate-180 transform-gpu  ">To be filled-in by recipient</h2>
							<div class="w-72 border-l border-r border-black p-2  relative h-full box-sizing pr-16">
								<h1 class="font-semibold mb-8 text-sm">Delivery Particulars</h1>
				            	<div class=" flex gap-4">
				                    <label class=" text-sm font-medium text-gray-900 leading-8">Date</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
				            	</div>
				            	<div class=" flex gap-4 mb-12">
				                    <label class=" text-sm font-medium text-gray-900 leading-8">Time</label>
				                    <input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
				            	</div>
				            	<input class=" text-sm py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
				            	<h3 class="text-sm">Signature of Pacipient</h3>
				            	<div class="mt-12">
				            		<input class=" text-sm py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
				            		<h3 class="text-sm">Name of Signatory</h3>
				            	</div>
							</div>
							<h2 class="writhing_mode rotate-180 transform-gpu w-8 ">To be filled-in by recipient</h2>
							
						</div>
					</div>	

					<div class="delivr gap-4 border-l border-black relative p-2 box-sizing">
						
						<div class="flex gap-3">
							<div class="delivr2 " >
								<h1 class="font-semibold text-sm">OFFICE USE</h1>
				            	<div class=" flex gap-2 my-3">
				                    <label class=" text-sm font-medium text-gray-900 leading-8 w-28">Serial No</label>
				                    <input class="w-full text-lg py-0 border-b border-dotted border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
				            	</div>
				            	<div class="w-full flex gap-2 pb-6">
				            		<div class="w-3/6">
				            			<h3 class="text-xs">Time sent out</h3>
				            			<h4 class="border_arrow relative text-center"> hr </h4>
				            			
				            		</div>
				            		<div class="w-3/6">
				            			<h3 class="text-xs">Time Returned</h3>
				            			<h4 class="border_arrow relative text-center"> hr </h4>
				            		</div>
				            	</div>
				            	<input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
				            	<h3 class="text-sm">Signature of Postmam / Asst. Postman</h3>
				            	<div class="mt-6">
				            		<input class="w-full text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6" type="text" placeholder="">
				            	<h3 class="text-sm">Name of Postmam / Asst. Postman</h3>
				            	</div>
				            	
				            	
							</div>
							<div class="delivl2 pr-8">
								.
								<div class="w-full border border-black h-28 "></div>
								<h2 class="text-center text-xs">Date Stamp Delivery office</h2>
							</div>
							
						</div>
						<input class="w-72 text-lg py-0 border-b border-gray-600 focus:outline-none focus:border-indigo-500 h-6  mx-auto block" type="text" placeholder="">
						<h3 class=" text-center w-72 mx-auto text-sm">Signature of Controlar Office</h3>
					</div>	

				</div>

			</div>
		</div>
		<div class="Second_pages">
			<div class="w-full px-5 py-5">
		<div class="text-center w-full relative ">	
		  <h2 class=" font-bold">THE MAURITIUS POST LTD</h2>
		  <img class="absolute right-0 top-0 w-20" src="{{url('img/logo.PNG')}}">
		 </div>
		 <div class="flex justify-between mt-5 text-center leading-5">
		 	<h2 class="font-semibold text-md">PARCEL DECLARATION (Inland / Inter Island)</h2>
		 	<h5 class="text-sm">MPL / 70 </br> (REV 2021) </h5>
		 </div>
		 <div class="border-dashed border-2 border-black pr-2">
		 	<h3 class="pl-6 text-sm">A false declaration is a criminal offence</h3>
		 	<div class="flex items-start">
			 	<h2 class="writhing_mode rotate-180 transform-gpu font-semibold text-md ">ADDRESSED TO</h2>
			 	

		 		<table class="border-collapse border border-slate-400 w-full text-center">

							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-xs semibold ">NAME</th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600" value="{{$sales->customer_firstname}} {{$sales->customer_lastname}}"></td>
							    </tr>
							  </thead>
							  <thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-xs semibold ">ADDRESS</th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600" value="{{$sales->customer_address}}"><input type="text" class="border-dotted border-t-2 border-black w-full h-full p-1 rounded outline-none focus:border-gray-600 "></td>
							    </tr>
							  </thead>

							  <thead>
								    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-xs semibold ">TEL. NO.</th>
							      <td class="px-2 text-center border-0 border-black w-full flex"><label for="">(H)</label><input type="text" class=" p-1 rounded outline-none focus:border-gray-600 w-full"><label for="">(M)</label><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600"><label for="">(O)</label><input type="text" class="w-full  p-1 rounded outline-none focus:border-gray-600"></td>
							    </tr>
							  </thead>
							 	<thead>

							    <tr>
							      <th class="border border-black text-left pl-2 w-1/5 text-xs text-xs semibold ">E-MAIL :</th>
							      <td class="px-2 text-center border border-black w-4/5"><input type="text" class="w-full h-4 p-1 rounded outline-none focus:border-gray-600"></td>
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

					      <td class="border border-black  w-full flex border-t-0 border-l-0"><input type="text" class="w-full h-full p-1 mr-2 outline-none focus:border-gray-600 border-r rounded-none border-black"><label class="w-36 leading-5" for="">email :</label><input type="text" class="w-full h-full p-1 rounded outline-none focus:border-gray-600"></td>
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
	
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{url('js/print.min.js')}}"></script>
        <script>
        $(document).ready(function(){
            printJS("printJS-form","html");
        });
        function print(){
            printJS("printJS-form","html");
        }
        </script>
</body>
</html>