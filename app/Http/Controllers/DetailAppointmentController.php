<?php

namespace App\Http\Controllers;

use App\Models\AppointmentDiagnosis;
use App\Models\AppointmentFile;
use App\Models\Appointments;
use App\Models\Company;
use App\Models\MedicalAdvice;
use App\Models\MedVigilance;
use App\Models\PhysicalExamination;
use App\Models\PresentingComplaints;
use App\Models\Setting;
use App\Models\Vital;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DetailAppointmentController extends Controller
{
    public function presentingComplaints($id)
    {
        // Fetch appointment details
        $appointmentData = Appointments::findOrFail($id);  // Use findOrFail to automatically handle 404 errors
        // Fetch any saved presenting complaints if exists
        $presentingComplaints = PresentingComplaints::where('appointment_id',$id)->first();

        // Authorization checks for doctor and customer
        if (Auth::user()->role != 'admin'){
            if (Auth::user()->role === 'doctor') {
                if(empty($sales->doctor) || (int)($sales->doctor->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
            if (Auth::user()->role === 'customer') {
                if(empty($sales->customer) || (int)($sales->customer->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
        }
        return view('appointment.appointment-details.presenting-complaints', get_defined_vars());
    }
    public function storePresentingComplaints(Request $request, $appointmentId)
    {
        $request->validate([
            'compliant_text' => 'required|string',
        ]);
           PresentingComplaints::updateOrCreate(
            ['appointment_id' => $appointmentId],
            [
                'compliant_text' => $request->input('compliant_text'),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );

        return redirect()->route('detail-appointment.presenting-complaints', $appointmentId)
            ->with('success', 'Presenting complaints updated successfully.');
    }
    public function vitals($id)
    {
        // Fetch appointment details
        $appointmentData = Appointments::findOrFail($id);  // Use findOrFail to automatically handle 404 errors
        // Authorization checks for doctor and customer
        $vital = Vital::where('appointment_id', $id)->first();
        if (Auth::user()->role != 'admin'){
            if (Auth::user()->role === 'doctor') {
                if(empty($sales->doctor) || (int)($sales->doctor->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
            if (Auth::user()->role === 'customer') {
                if(empty($sales->customer) || (int)($sales->customer->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
        }
        return view('appointment.appointment-details.vitals', get_defined_vars());
    }
    public function storeVitals(Request $request, $id)
    {
        $appointmentData = Appointments::findOrFail($id);
        $request->validate([
            'pulse' => 'required',
            'sys_blood_pressure' => 'required',
            'dia_blood_pressure' => 'required',
            'blood_sugar' => 'required',
            'respiratory_rate' => 'required',
            'spo2' => 'required',
            'temperature' => 'required',
            'pain_score' => 'required',
        ]);
        Vital::updateOrCreate(
            ['appointment_id' => $appointmentData->id],
            [
                'height' => $request->height,
                'weight' => $request->weight,
                'circumference' => $request->circumference,
                'bmi' => $request->bmi,
                'pulse' => $request->pulse,
                'sys_blood_pressure' => $request->sys_blood_pressure,
                'dia_blood_pressure' => $request->dia_blood_pressure,
                'mean_blood_pressure' => $request->mean_blood_pressure,
                'blood_sugar' => $request->blood_sugar,
                'sugar_comments' => $request->sugar_comments,
                'respiratory_rate' => $request->respiratory_rate,
                'spo2' => $request->spo2,
                'spo2_comments' => $request->spo2_comments,
                'temperature' => $request->temperature,
                'pain_score' => $request->pain_score,
                'pain_comments' => $request->pain_comments,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );

        return redirect()->route('detail-appointment.vitals', $appointmentData->id)->with('success', 'Vitals saved successfully.');
    }
    public function physicalExamination($id)
    {
        // Fetch appointment details
        $appointmentData = Appointments::findOrFail($id);  // Use findOrFail to automatically handle 404 errors
        $physicalExamination=PhysicalExamination::where('appointment_id',$id)->first();
        // Authorization checks for doctor and customer
        if (Auth::user()->role != 'admin'){
            if (Auth::user()->role === 'doctor') {
                if(empty($sales->doctor) || (int)($sales->doctor->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
            if (Auth::user()->role === 'customer') {
                if(empty($sales->customer) || (int)($sales->customer->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
        }
        return view('appointment.appointment-details.physical-examination', get_defined_vars());
    }
    public function storePhysicalExamination(Request $request, $id)
    {
        // Fetch appointment details
        $appointmentData = Appointments::findOrFail($id);

        // Validation rules for required fields
        $request->validate([
            'e_comments' => 'required|string',
        ],[
            'e_comments.required' => 'Pickle comments field is required.',
        ]);

        // Save physical examination data
        $physicalExamination = PhysicalExamination::updateOrCreate(
            ['appointment_id' => $appointmentData->id],
            [
                'p_check' => $request->p_check,
                'i_check' => $request->i_check,
                'c_check' => $request->c_check,
                'k_check' => $request->k_check,
                'l_check' => $request->l_check,
                'e_check' => $request->e_check,
                'e_comments' => $request->e_comments,
                'cvs_comments' => $request->cvs_comments,
                'rs_comments' => $request->rs_comments,
                'cns_comments' => $request->cns_comments,
                'abdomen_comments' => $request->abdomen_comments,
                'skin_comments' => $request->skin_comments,
                'genitourinary' => $request->genitourinary,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );
        return redirect()->route('detail-appointment.physical-examination', $appointmentData->id)
            ->with('success', 'Physical Examination saved successfully.');
    }
    public function medicalAdvice($id)
    {
        // Fetch appointment details
        $appointmentData = Appointments::findOrFail($id);  // Use findOrFail to automatically handle 404 errors
        $medicalAdvice=MedicalAdvice::where('appointment_id',$id)->first();

        // Authorization checks for doctor and customer
        if (Auth::user()->role != 'admin'){
            if (Auth::user()->role === 'doctor') {
                if(empty($sales->doctor) || (int)($sales->doctor->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
            if (Auth::user()->role === 'customer') {
                if(empty($sales->customer) || (int)($sales->customer->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
        }
        return view('appointment.appointment-details.medical-advice', get_defined_vars());
    }
    public function storeMedicalAdvice(Request $request, $id)
    {
        // Fetch the appointment details
        $appointmentData = Appointments::findOrFail($id);
        // Validation rules for required fields
        $request->validate([
            'prescription' => 'required',
        ]);

        // Save or update medical advice
        $medicalAdvice = MedicalAdvice::updateOrCreate(
            ['appointment_id' => $appointmentData->id],
            [
                'prescription' => $request->prescription,
                'procedure' => $request->procedure,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect()->route('detail-appointment.medical-advice', $appointmentData->id)
            ->with('success', 'Medical advice saved successfully.');
    }
    public function medVigilance($id)
    {
        // Fetch appointment details
        $appointmentData = Appointments::findOrFail($id);  // Use findOrFail to automatically handle 404 errors
        $medvigilance=MedVigilance::where('appointment_id',$id)->first();

        // Authorization checks for doctor and customer
        if (Auth::user()->role != 'admin'){
            if (Auth::user()->role === 'doctor') {
                if(empty($sales->doctor) || (int)($sales->doctor->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
            if (Auth::user()->role === 'customer') {
                if(empty($sales->customer) || (int)($sales->customer->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
        }
        return view('appointment.appointment-details.med-vegiliance', get_defined_vars());
    }
    public function storeMedVigilance(Request $request, $id)
    {
        $appointmentData = Appointments::findOrFail($id);
//
//        $request->validate([
//            'date_investigations' => 'nullable|date',
//            'investigations' => 'nullable|string',
//            'date_radiology' => 'nullable|date',
//            'radiology' => 'nullable|string',
//            'date_equipment' => 'nullable|date',
//            'equipment' => 'nullable|string',
//            'date_medvigilance' => 'nullable|date',
//            'medvigilance' => 'nullable|string',
//        ]);

        // Create or update medvigilance record
        $medvigilance = MedVigilance::updateOrCreate(
            ['appointment_id' => $appointmentData->id],
            [
                'date_investigations' => $request->date_investigations,
                'investigations' => $request->investigations,
                'date_radiology' => $request->date_radiology,
                'radiology' => $request->radiology,
                'date_equipment' => $request->date_equipment,
                'equipment' => $request->equipment,
                'date_medvigilance' => $request->date_medvigilance,
                'medvigilance' => $request->medvigilance,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]
        );

        return redirect()->route('detail-appointment.medvigilance', $appointmentData->id)
            ->with('success', 'MedVigilance saved successfully.');
    }

    public function diagnosis($id)
    {
        // Fetch appointment details
        $appointmentData = Appointments::findOrFail($id);  // Use findOrFail to automatically handle 404 errors
        $diagnosisData = AppointmentDiagnosis::where('appointment_id', $id)->first();
        // Authorization checks for doctor and customer
        if (Auth::user()->role != 'admin'){
            if (Auth::user()->role === 'doctor') {
                if(empty($sales->doctor) || (int)($sales->doctor->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
            if (Auth::user()->role === 'customer') {
                if(empty($sales->customer) || (int)($sales->customer->user_id) !== Auth::user()->id){
                    abort(404);
                }
            }
        }
        return view('appointment.appointment-details.diagnosis', get_defined_vars());
    }
    public function storeDiagnosis(Request $request, $id)
    {
        $request->validate([
            'p_diagnosis.0' => 'required',
        ],[
            'p_diagnosis.0.required' => 'At least one Provisional diagnosis field is required.',
        ]);

        $data = [
            'appointment_id' => $id,
            'provisional_diagnosis' => json_encode($request->p_diagnosis),
            'diagnosis' => json_encode($request->diagnosis),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ];

        AppointmentDiagnosis::updateOrCreate(
            ['appointment_id' => $id], // Ensure updating the correct row
            $data
        );

        return redirect()->route('detail-appointment.diagnosis', $id)->with('success', 'Diagnosis updated successfully.');
    }
    public function endConsultation(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'start_consultation_date' => 'required',
            'consultation_comments' => 'nullable|string'
        ]);
        $appointment = Appointments::findOrFail($validated['appointment_id']);
        $appointment->consultation_start_time = $validated['start_consultation_date'];
        $appointment->consultation_end_time = now();
        $appointment->consultation_end_comments = $validated['consultation_comments'];
        $appointment->save();
        /*Generate PDF*/
        $this->generateAppointmentPDF($appointment->id);

        return response()->json([
            'success' => true,
            'message' => 'Consultation end time has been successfully saved.'
        ]);
    }
    public function generateAppointmentPDF($id)
    {
        $company = Company::latest()->first();
        $display_logo = Setting::where("key", "display_logo_in_pdf")->first();
        $appointmentData = Appointments::findOrFail($id);
        $presentingComplaints = PresentingComplaints::where('appointment_id', $id)->first();
        $vital = Vital::where('appointment_id', $id)->first();
        $physicalExamination = PhysicalExamination::where('appointment_id', $id)->first();
        $medicalAdvice = MedicalAdvice::where('appointment_id', $id)->first();
        $medvigilance = MedVigilance::where('appointment_id', $id)->first();
        $diagnosisData = AppointmentDiagnosis::where('appointment_id', $id)->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.appointment_report', compact(
            'appointmentData',
            'presentingComplaints',
            'vital',
            'physicalExamination',
            'medicalAdvice',
            'medvigilance',
            'diagnosisData',
            'company',
            'display_logo',
        ));
        $path = public_path('files/attachment/appointments');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $fileName= "appointment_report_{$id}.pdf";
        AppointmentFile::create([
            'appointment_id' =>$id,
            'name' => $fileName,
            'type' => "Consultation Record",
            'src' => asset("files/attachment/appointments/".$fileName),
            'date_generated' => date("Y-m-d H:i:s")
        ]);

        $pdf->save("{$path}/appointment_report_{$id}.pdf");
    }


}
