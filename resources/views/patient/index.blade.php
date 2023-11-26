@extends('..app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .container {margin-bottom: 10px;padding: 10px;background-color: #e8e8e8;}
    .alert {
        top: 10px;
        left: 1px;
        display: none;
        position: absolute !important;
    }
    #errorMessage{
        margin-left: 5px;
        float: left;
    }

    #successMessage{
        margin-left: 5px;
        float: left;
    }
</style>
@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
            <h2>List of Patients</h2>
            <button class="btn btn-success" onclick="addPatientForm()">
                <i class="bi bi-plus"></i>
            </button>
        </div>
        <table class="table table-striped">
            <thead class="table-dark ">
            <tr>
                <th>IdCard</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Date of Birth</th>
                <th>Contact Number 1</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->IdCard }}</td>
                    <td>{{ $patient->Name }}</td>
                    <td>{{ $patient->Surname }}</td>
                    <td>{{ $patient->DateOfBirth }}</td>
                    <td>{{ $patient->ContactNumber1 }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" title="Show" type="button" onclick="editPatientForm({{ $patient->id }})" >
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" title="Show" type="button" onclick="deleteAction('patients',{{ $patient->id }})" >
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <ul class="pagination">

                @if($currentPage > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ route('patients.list', ['page' => $currentPage - 1, 'numberPerPage' => $numberPerPage]) }}">Previous</a>
                    </li>
                @endif

                @for ($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('patients.list', ['page' => $i, 'numberPerPage' => $numberPerPage]) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if($currentPage < $lastPage)
                    <li class="page-item">
                        <a class="page-link" href="{{ route('patients.list', ['page' => $currentPage + 1, 'numberPerPage' => $numberPerPage]) }}">Next</a>
                    </li>
                @endif

            </ul>

            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <label for="numberPerPageSelect" class="form-label me-2">Items per Page:</label>
                    <select style="width: 75px;" class="form-select" id="numberPerPageSelect">
                        <option value="5" {{ $numberPerPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $numberPerPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $numberPerPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $numberPerPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $numberPerPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="offcanvas offcanvas-end" style="width: 65%;border-left: 5px solid #212529;" id="rightSideBar" >
        <div class="offcanvas-header">
            <h2 class="offcanvas-title">Patient's information</h2>
            <button class="btn btn-secondary" id="closeSideBar">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="">
                <div class="row">
                    <div class="">
                        <!-- Form on the left -->
                        <div class="container clean" id="patientForm">

                        </div>
                    </div>
                    <br>
                    <div class="col-md-6 hide">
                        <!-- Next of Kin List on the right -->
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                                <h5>Next of Kin List</h5>
                                <button class="btn btn-success" onclick="addNextOfKin()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <div class="clean" id="nextOfKinData">

                            </div>

                            <div id="nextOfKinInfo" class="mt-4 clean">
                                <!-- This div will be dynamically populated with next_of_kin details -->
                            </div>

                        </div>

                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                                <h5>Medical Conditions List</h5>
                                <button class="btn btn-success" onclick="addMedicalConditions()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <div class="clean" id="medicalConditionsData">

                            </div>

                            <div id="medicalConditionsInfo" class="mt-4 clean">
                                <!-- This div will be dynamically populated with next_of_kin details -->
                            </div>

                        </div>
                        </div>
                        <div class="col-md-6 hide">
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                                <h5>Medications List</h5>
                                <button class="btn btn-success" onclick="addMedication()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <div class="clean" id="medicationsData">

                            </div>

                            <div id="medicationsInfo" class="mt-4 clean">
                                <!-- This div will be dynamically populated with next_of_kin details -->
                            </div>

                        </div>

                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                                <h5>Allergies List</h5>
                                <button class="btn btn-success" onclick="addAllergy()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <div class="clean " id="allergiesData">

                            </div>

                            <div id="allergiesInfo" class="mt-4 clean">
                                <!-- This div will be dynamically populated with next_of_kin details -->
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="successAlert" class="alert alert-success">
        <strong style="float: left">Success!</strong> <div id="successMessage">Success!</div>
    </div>

    <div id="errorAlert" class="alert alert-danger">
        <strong style="float: left">Error!</strong> <div id="errorMessage">Error!</div>
    </div>
@endsection

<script>

    // Click event for list items
    var global_patient = 0;
    function editPatientForm(patient_id){
        $(".clean").empty();
        $.ajax({
            url: `/patients/select/`+patient_id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if(data.data){
                    var patient = data.data;
                    showPatientForm(patient);
                    global_patient = patient;
                    $("#patientBtn").text("update")
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });

    };

    // Click event for add button
    function addPatientForm(){
        global_action = "add";
        // Replace this with your logic to fetch and display next_of_kin details
        showPatientForm([],"insert");
        $("#patientBtn").text("insert");
    };

    function showPatientForm(patient,action){
        $(".clean").empty();
        var patientFormHtml = `
            <div  class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="idCard" class="form-label">ID Card:</label>
                        <input type="text" class="patientsInputs form-control" id="idCard" name="IdCard" value="${patient.IdCard  ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="patientsInputs form-control" id="name" name="Name" value="${patient.Name  ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname:</label>
                        <input type="text" class="patientsInputs form-control" id="surname" name="Surname" value="${patient.Surname  ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <textarea class="patientsInputs form-control" id="address" name="Address" rows="4">${patient.Address ?? ""}</textarea>
                    </div>
                     <button type="submit" id="patientBtn" onclick="updateAction('patients',`+patient.id+`)" class="btn btn-primary">Update</button>

                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender:</label>
                        <select class="patientsInputs form-select" id="gender" name="Gender">
                            <option value="male" ${patient.Gender === 'Male' ? 'selected' : ''}>Male</option>
                            <option value="female" ${patient.Gender === 'Female' ? 'selected' : ''}>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dateOfBirth" class="form-label">Date of Birth:</label>
                        <input type="date" class="patientsInputs form-control" id="dateOfBirth" name="DateOfBirth" value="${patient.DateOfBirth ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="postcode" class="form-label">Postcode:</label>
                        <input type="text" class="patientsInputs form-control" id="postcode" name="Postcode" value="${patient.Postcode ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="contactNumber1" class="form-label">Contact Number 1:</label>
                        <input type="tel" class="patientsInputs form-control" id="contactNumber1" name="ContactNumber1" value="${patient.ContactNumber1  ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="contactNumber2" class="form-label">Contact Number 2:</label>
                        <input type="tel" class="patientsInputs form-control" id="contactNumber2" name="ContactNumber2" value="${patient.ContactNumber2  ?? ""}">
                    </div>
                </div>

            </div>`;

        if(action !== "insert"){

            // Iterate over each element in the JSON object
            var nextOfKinData = `<ul class="list-group" id="nextOfKinList">`;
            $.each(patient.next_of_kin, function(index, nextOfKin) {
                nextOfKinData = nextOfKinData + `
                <li class="list-group-item d-flex justify-content-between align-items-center" data-next-of-kin-id="1">
                   <h7 class="collapsed" data-bs-toggle="collapse" href="#nextOfKinCollapseDetails" aria-expanded="false" aria-controls="nextOfKinCollapseDetails">
                    `+nextOfKin.Name+' '+ nextOfKin.Surname+`
                </h7>
                     <div class="d-flex gap-2">
                         <!-- Eye button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-primary" onclick="editNextOfKinList(`+index+`,`+nextOfKin.id+`)">
                             <i class="bi bi-eye"></i>
                         </button>
                         <!-- Trash button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-danger" onclick="deleteAction('nextOfKin',`+nextOfKin.id+`)">
                             <i class="bi bi-trash"></i>
                         </button>
                     </div>
                 </li>
                `;
            });
            nextOfKinData = nextOfKinData + '</ul>';


            // Iterate over each element in the JSON object
            var medicalConditionsData = `<ul class="list-group" id="medicalConditionList">`;
            $.each(patient.medical_condition, function(index, medicalCondition) {
                medicalConditionsData = medicalConditionsData + `
                <li class="list-group-item d-flex justify-content-between align-items-center" data-next-of-kin-id="1">
                   <h7 class="collapsed" data-bs-toggle="collapse" href="#medicalConditionCollapseDetails" aria-expanded="false" aria-controls="medicalConditionCollapseDetails">
                    `+medicalCondition.Name+`
                </h7>
                     <div class="d-flex gap-2">
                         <!-- Eye button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-primary" onclick="editMedicalCondition(`+index+`,`+medicalCondition.id+`)">
                             <i class="bi bi-eye"></i>
                         </button>
                         <!-- Trash button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-danger" onclick="deleteAction('medicalCondition',`+medicalCondition.id+`)">
                             <i class="bi bi-trash"></i>
                         </button>
                     </div>
                 </li>
                `;
            });
            medicalConditionsData = medicalConditionsData + '</ul>';


            // Iterate over each element in the JSON object
            var medicationsData = `<ul class="list-group" id="medicationsList">`;
            $.each(patient.medication, function(index, medication) {
                medicationsData = medicationsData + `
                <li class="list-group-item d-flex justify-content-between align-items-center" data-next-of-kin-id="1">
                   <h7 class="collapsed" data-bs-toggle="collapse" href="#medicationsCollapseDetails" aria-expanded="false" aria-controls="medicationsCollapseDetails">
                    `+medication.Name+`
                </h7>
                     <div class="d-flex gap-2">
                         <!-- Eye button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-primary" onclick="editMedication(`+index+`,`+medication.id+`)">
                             <i class="bi bi-eye"></i>
                         </button>
                         <!-- Trash button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-danger" onclick="deleteAction('medication',`+medication.id+`)">
                             <i class="bi bi-trash"></i>
                         </button>
                     </div>
                 </li>
                `;
            });
            medicationsData = medicationsData + '</ul>';

            // Iterate over each element in the JSON object
            var allergiesData = `<ul class="list-group" id="AllergiesList">`;
            $.each(patient.allergy, function(index, allergy) {
                allergiesData = allergiesData + `
                <li class="list-group-item d-flex justify-content-between align-items-center" data-next-of-kin-id="1">
                   <h7 class="collapsed" data-bs-toggle="collapse" href="#allergiesCollapseDetails" aria-expanded="false" aria-controls="allergiesCollapseDetails">
                    `+allergy.Name+`
                </h7>
                     <div class="d-flex gap-2">
                         <!-- Eye button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-primary" onclick="editAllergy(`+index+`,`+allergy.id+`)">
                             <i class="bi bi-eye"></i>
                         </button>
                         <!-- Trash button (placeholder; replace with appropriate icon or content) -->
                         <button class="btn btn-danger" onclick="deleteAction('allergies',`+allergy.id+`)">
                             <i class="bi bi-trash"></i>
                         </button>
                     </div>
                 </li>
                `;
            });
            allergiesData = allergiesData + '</ul>';

            $('.hide').show();
        }else{
            $('.hide').hide();
        }

        $("#allergiesData").append(allergiesData);
        $("#medicationsData").append(medicationsData);
        $("#nextOfKinData").append(nextOfKinData);
        $("#medicalConditionsData").append(medicalConditionsData);
        $("#patientForm").append(patientFormHtml);
        setTimeout(function () {
            $('#rightSideBar').toggleClass('show');
        }, 1000)
    }

    var global_action = "edit";
    function editNextOfKinList(index,id){
        global_action = "edit";
        //$('.collapsed.collapse').slideUp('slow');
        var nextOfKinDetails = global_patient.next_of_kin[index];
        showNextOfKinInfo(nextOfKinDetails);
        $("#NextOfKinTitle").text("Next of Kin Details");
        $("#NextOfKinBtn").text("update");
    }

    function addNextOfKin(){
        global_action = "add";
        //$('.collapsed.collapse').slideUp('slow');
        showNextOfKinInfo([]);
        $("#NextOfKinTitle").text("Add New Next of Kin ");
        $("#NextOfKinBtn").text("add");
    }

    function editMedicalCondition(index,id){
        global_action = "edit";
        //$('.collapsed.collapse').slideUp('slow');
        var nextOfKinDetails = global_patient.medical_condition[index];
        showMedicalConditionInfo(nextOfKinDetails);
        $("#medicalConditionTitle").text("Medical Conditions Details");
        $("#medicalConditionBtn").text("update");
    }

    function addMedicalConditions(){
        global_action = "add";
        //$('.collapsed.collapse').slideUp('slow');
        showMedicalConditionInfo([]);
        $("#medicalConditionTitle").text("Add New Medical Condition ");
        $("#medicalConditionBtn").text("add");
    }

    function editMedication(index,id){
        global_action = "edit";
        //$('.collapsed.collapse').slideUp('slow');
        var medicationDetails = global_patient.medication[index];
        showMedicationInfo(medicationDetails);
        $("#medicationTitle").text("Medication Details");
        $("#medicationBtn").text("update");
    }

    function addMedication(){
        global_action = "add";
        //$('.collapsed.collapse').slideUp('slow');
        showMedicationInfo([]);
        $("#medicationTitle").text("Add New Medication ");
        $("#medicationBtn").text("add");
    }

    function addAllergy(){
        global_action = "add";
        //$('.collapsed.collapse').slideUp('slow');
        showAllergyDetailsInfo([]);
        $("#allergyTitle").text("Add New Allergy ");
        $("#allergyBtn").text("add");
    }

    function editAllergy(index,id){
        global_action = "edit";
        //$('.collapsed.collapse').slideUp('slow');
        var allergyDetails = global_patient.allergy[index];
        showAllergyDetailsInfo(allergyDetails);
        $("#allergyTitle").text("Allergy Details");
        $("#allergyBtn").text("update");
    }

    function showAllergyDetailsInfo(allergy) {
        // Dynamically populate the nextOfKinInfo div
        var allergyDetailsInfoHtml = `
            <div id="allergiesCollapseDetails" class="collapsed collapse show"  href="#allergiesCollapseDetails" aria-expanded="false" aria-controls="allergiesCollapseDetails" >
                <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                    <h5 id="allergyTitle">  Medication Details</h5>
                    <button class="btn btn-secondary close" data-bs-toggle="collapse" href="#allergiesCollapseDetails" aria-expanded="false" aria-controls="allergiesCollapseDetails">
                            <i class="bi bi-x"></i>
                    </button>
                </div>
                <div>
                    <div class="mb-3">
                        <label for="name">Name:</label>
                        <input type="text" class="allergiesInputs form-control"  name="Name" id="Name" value="${allergy.Name ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes:</label>
                        <textarea class="allergiesInputs form-control" id="Notes" name="Notes" rows="3">${allergy.Notes ?? ""}</textarea>
                    </div>
                    <div class="mb-3">
                        <button id="allergyBtn" class="allergiesInputs btn btn-primary" onclick="updateAction('allergies',${allergy.id})">Update</button>
                    </div>
                </div>
            </div>
        `;
        $('#allergiesInfo').html(allergyDetailsInfoHtml);
    }

    function showMedicationInfo(medication) {
        // Dynamically populate the nextOfKinInfo div
        var medicalConditionInfoHtml = `
            <div id="medicationsCollapseDetails" class="collapsed collapse show"  href="#medicationsCollapseDetails" aria-expanded="false" aria-controls="medicationsCollapseDetails" >
                <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                    <h5 id="medicationTitle">  Medication Details</h5>
                    <button class="btn btn-secondary close" data-bs-toggle="collapse" href="#medicationsCollapseDetails" aria-expanded="false" aria-controls="medicationsCollapseDetails">
                            <i class="bi bi-x"></i>
                    </button>
                </div>
                <div>
                    <div class="mb-3">
                        <label for="name">Name:</label>
                        <input type="text" class="medicationInputs form-control" id="Name" name="Name" value="${medication.Name ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes:</label>
                        <textarea class="medicationInputs form-control" id="Notes" name="Notes" rows="3">${medication.Notes ?? ""}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="StartDate" class="form-label">Start Date:</label>
                        <input type="date" class="medicationInputs form-control" id="StartDate" name="StartDate" value="${medication.StartDate ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="EndDate" class="form-label">End Date:</label>
                        <input type="date" class="medicationInputs form-control" id="EndDate" name="EndDate" value="${medication.EndDate ?? ""}">
                    </div>

                    <div class="mb-3">
                        <button id="medicationBtn" class=" btn btn-primary" onclick="updateAction('medication',${medication.id})">Update</button>
                    </div>
                </div>
            </div>
        `;
        $('#medicationsInfo').html(medicalConditionInfoHtml);
    }

    function showMedicalConditionInfo(medicalCondition) {
        // Dynamically populate the nextOfKinInfo div
        var medicalConditionInfoHtml = `
            <div id="medicalConditionCollapseDetails" class="collapsed collapse show"  href="#medicalConditionCollapseDetails" aria-expanded="false" aria-controls="medicalConditionCollapseDetails" >
                <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                    <h5 id="medicalConditionTitle">  Next of Kin Details</h5>
                    <button class="btn btn-secondary close" data-bs-toggle="collapse" href="#medicalConditionCollapseDetails" aria-expanded="false" aria-controls="medicalConditionCollapseDetails">
                            <i class="bi bi-x"></i>
                    </button>
                </div>
                <div>
                    <div class="mb-3">
                        <label for="name">Name:</label>
                        <input type="text" class="medicalConditionInputs form-control" id="Name" name="Name" value="${medicalCondition.Name ?? ""}">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes:</label>
                        <textarea class="medicalConditionInputs form-control" id="Notes" name="Notes" rows="3">${medicalCondition.Notes ?? ""}</textarea>
                    </div>

                    <div class="mb-3">
                        <button id="medicalConditionBtn" class="medicalConditionInputs btn btn-primary" onclick="updateAction('medicalCondition',${medicalCondition.id})">Update</button>
                    </div>
                </div>
            </div>
        `;
        $('#medicalConditionsInfo').html(medicalConditionInfoHtml);
    }

    function showNextOfKinInfo(nextOfKinDetails) {
        // Dynamically populate the nextOfKinInfo div
        var nextOfKinInfoHtml = `
            <div id="nextOfKinCollapseDetails" class="collapsed collapse show"  href="#nextOfKinCollapseDetails" aria-expanded="false" aria-controls="nextOfKinCollapseDetails" >
                <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 5px">
                    <h5 id="NextOfKinTitle">  Next of Kin Details</h5>
                    <button class="btn btn-secondary close" data-bs-toggle="collapse" href="#nextOfKinCollapseDetails" aria-expanded="false" aria-controls="nextOfKinCollapseDetails">
                            <i class="bi bi-x"></i>
                    </button>
                </div>
                <div>
                    <div class="mb-3">
                        <label for="idCard">ID Card:</label>
                        <input type="text" class="nextOfKinInputs form-control" id="idCard" name="IdCard" value="${nextOfKinDetails.IdCard ?? ""}">
                    </div>
                    <div class="mb-3">
                        <label for="name">Name:</label>
                        <input type="text" class="nextOfKinInputs form-control" id="name" name="Name" value="${nextOfKinDetails.Name ?? ""}">
                    </div>
                    <div class="mb-3">
                        <label for="surname">Surname:</label>
                        <input type="text" class="nextOfKinInputs form-control" id="surname" name="Surname" value="${nextOfKinDetails.Surname ?? ""}">
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber1">Contact Number 1:</label>
                        <input type="tel" class="nextOfKinInputs form-control" id="contactNumber1" name="ContactNumber1" value="${nextOfKinDetails.ContactNumber1 ?? ""}">
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber2">Contact Number 2:</label>
                        <input type="tel" class="nextOfKinInputs form-control" id="contactNumber2" name="ContactNumber2" value="${nextOfKinDetails.ContactNumber2 ?? ""}">
                    </div>
                    <div class="mb-3">
                        <button id="NextOfKinBtn" class="btn btn-primary" onclick="updateAction('nextOfKin',${nextOfKinDetails.id})">Update</button>
                    </div>
                </div>
            </div>
        `;
        $('#nextOfKinInfo').html(nextOfKinInfoHtml);
    }



    function updateAction(action,id) {
        if(global_action === "add"){
            addAction(action,global_patient.id);
            return;
        }
        var inputs = $('.'+action+'Inputs');
        var params = "";
        $.each(inputs, function(index, input) {
            var name = $(this).attr("name");
            params = params+"&";
            if(name !== undefined){
                params = params + name + "=" + $(this).val();
            }
        });
        $.ajax({
            url: '/'+action+'/update?id='+id+params,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                alert(data.success,data.message);
                if(action !== "patients"){
                    editPatientForm(global_patient.id);
                    $('#rightSideBar').removeClass('show');
                }else{
                    location.reload();
                }
            },
            error: function (error) {
                alert(false,error)
            }
        });
    }


    function addAction(action,id) {
        var inputs = $('.'+action+'Inputs');
        var params = "";
        $.each(inputs, function(index, input) {
            var name = $(this).attr("name");
            params = params+"&";
            if(name !== undefined){
                params = params + name + "=" + $(this).val();
            }
        });
        $.ajax({
            url: '/'+action+'/store?patient_id='+id+params,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                alert(data.success,data.message);
                if(action !== "patients"){
                    editPatientForm(global_patient.id);
                    $('#rightSideBar').removeClass('show');
                }else{
                    location.reload();
                }
            },
            error: function (error) {
                alert(false,error)
            }
        });
    }

    function deleteAction(action,id) {
        $.ajax({
            url: '/'+action+'/destroy?id='+id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                alert(data.success,data.message);
                if(action !== "patients"){
                    editPatientForm(global_patient.id);
                    $('#rightSideBar').removeClass('show');
                }else{
                    location.reload();
                }
            },
            error: function (error) {
                alert(false,error)
            }
        });
    }

    $(document).ready(function () {
        // jQuery change event for the select element
        $('#numberPerPageSelect').on('change', function () {
            var selectedValue = $(this).val();
            // Redirect to the same page with the selected 'numberPerPage' value
            window.location.href = "{{ route('patients.list', ['page' => 1]) }}&numberPerPage=" + selectedValue;
        });
        $('#closeSideBar').on('click', function () {
            $('#rightSideBar').removeClass('show');
        });
    });

    function alert(state,message){
        var messageId = "";
        var alertId = "";
        if(state){
             messageId="successMessage";
             alertId="successAlert";
        }else{
             messageId="errorMessage";
             alertId="errorAlert";
        }
        $("#"+messageId).text(message);

        $("#"+alertId).slideDown(500, function () {
            setTimeout(function () {
                $(".alert").slideUp(500);
            }, 2000);
        });
    }



</script>
