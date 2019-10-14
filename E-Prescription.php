<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: index.php");
}
//kinda global variable type for patient
$nid = $_SESSION['NID'];
$name = $_SESSION['Name'];
$age = $_SESSION['Age'];
$gender = $_SESSION['Gender'];

//for Doctor's name
$email = $_SESSION['email'];
$link = mysqli_connect("localhost", "root", "", "icare");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt select query execution
$sql = "SELECT * FROM doctor where Email = '$email'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$prescriptionId = $row['NID'] . '-' . $nid;
$_SESSION['prescriptionId'] = $prescriptionId;

//saving id into the prescription
$docNID = $row['NID'];
$query = "INSERT INTO prescription (Doc_id,Patient_Id,Prescription_id) 
VALUES ('$docNID','$nid','$prescriptionId')";
mysqli_query($link, $query);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>iCare</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="E-Prescription.css">

    


</head>
<body onload="myFunction()">
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <a href="doctorHomepage.php">Home</a>
    <a href="index.php"><b>Logout</b></a>
</div>

<div id="main">
    <button class="openbtn" onclick="openNav()">☰
        <?php
        echo "Dr. " . $row['Name'];
        ?>
    </button>
    <label for="examination"><b>
            <?php
            echo "&nbsp&nbsp&nbsp&nbsp". $row['PostGrad_deatails'] ."&nbsp&nbsp|&nbsp&nbspBMDC REG NO :" . $row['BMDC_RegNo'] ;
            ?>
        </b></label>
</div>


<p align="top-right" style="color: greenyellow;padding:0px;
       font-size: 16px;
       color: black;
       text-align:center;
       position: absolute;
       top: 10px;
       right: 10px;"><b><i>A New Era of Treatment</i></b></p>


<div class="column middle">
    <div class="topnav">
        <p style="float: left;
    position: relative; font-size: 16px">&nbsp&nbsp&nbsp&nbsp Patient Name: </p>
        <p style="float: left;
    position: relative; font-size: 16px">
            &nbsp&nbsp&nbsp&nbsp
            <?php
            echo $name;
            ?>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </p>

        <p style="float: left;
    position: relative; font-size: 16px"> Age: </p>
        <p style="float: left;
    position: relative; font-size: 16px">
            &nbsp&nbsp&nbsp&nbsp
            <?php
            echo $age;
            ?>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </p>

        <p style="float: left;
    position: relative; font-size: 16px">&nbsp&nbsp&nbsp&nbsp Gender: </p>
        <p style="float: left;
    position: relative; font-size: 16px">
            &nbsp&nbsp&nbsp&nbsp
            <?php
            echo $gender;
            ?>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </p>

        <p style="float: left;
    position: relative; font-size: 16px">&nbsp&nbsp&nbsp&nbsp NID: </p>
        <p style="float: left;
    position: relative; font-size: 16px">
            &nbsp&nbsp&nbsp&nbsp
            <?php
            echo $nid;
            ?>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </p>


    </div>
    <div id="invoice-POS">

        <center id="top">
            <div class="info">
                <h1 style="color:darkslategray;">Prescription</h1>
                Date: <input type="text" id="demo"/>
            </div><!--End Info-->
        </center><!--End InvoiceTop-->

        <div id="mid">
            <form action="" method="post">
                <label for="complaints"><b>Chief Complaints:&nbsp&nbsp</b></label>
                <input type="text" style="width: 30%; height: 10px" id="complaints" name="complaints">
                &nbsp&nbsp
                <input type="submit" name="complaintsSubmit" value="Submit">
                <?php
                if (isset($_POST['complaintsSubmit'])) {
                    $complaints = mysqli_real_escape_string($link, $_REQUEST['complaints']);
                    $sql = "INSERT INTO prescriptioncomplaint (Prescription_Id,Complaint) VALUES ('$prescriptionId','$complaints')";
                    echo "Successful !";
                    mysqli_query($link, $sql);
                }
                ?>
                <p></p>
                <p></p>
                <p></p>
                <p></p>

                <label for="examination"><b>On Examination:&nbsp&nbsp</b></label>
                <select id="examination" name="examination" style="width: 18%">
                    <option value="bp">BP</option>
                    <option value="Pulse">Pulse</option>
                    <option value="Weight">Weight</option>
                    <option value="Height">Height</option>
                    <option value="BMI">BMI</option>
                    <option value="Pressure">Pressure</option>
                </select>
                &nbsp&nbsp
                <label for="measurement"><b>Measurement:&nbsp&nbsp</b></label>
                <input type="text" style="width: 20%; height: 10px" id="measurement" name="measurement">
                &nbsp
                <input type="submit" name="ExaminationmeasurementSubmit" value="Submit">
                <?php
                if (isset($_POST['ExaminationmeasurementSubmit'])) {
                    $examination = mysqli_real_escape_string($link, $_REQUEST['examination']);
                    $measurement = mysqli_real_escape_string($link, $_REQUEST['measurement']);
                    $sql = "INSERT INTO prescriptionexamination (Prescription_Id,Examination_type,Measurement) VALUES ('$prescriptionId','$examination','$measurement')";
                    echo "Successful!";
                    mysqli_query($link, $sql);
                }
                ?>
                <p></p>
                <p></p>
                <p></p>
                <p></p>

                <label for="checkup"><b>Body-Checkup need to be done(tests):&nbsp&nbsp</b></label>
                <input type="text" style="width: 40%; height: 10px" id="checkup" name="checkup">
                &nbsp&nbsp
                <input type="submit" name="checkupSubmit" value="Submit">
                <?php
                if (isset($_POST['checkupSubmit'])) {
                    $tests = mysqli_real_escape_string($link, $_REQUEST['checkup']);
                    $sql = "INSERT INTO prescriptiontests (Prescription_Id,Tests) VALUES ('$prescriptionId','$tests')";
                    echo "Successful !";
                    mysqli_query($link, $sql);
                }
                ?>
                <p></p>
                <p></p>
                <p></p>
                <p></p>

                <label for="medicine"><b>Medicine:&nbsp&nbsp</b></label>
                <div>
                <input type="text" style="width: 30%; height: 10px" id="medicine" autocomplete="off" name="medicine">
                &nbsp
                <input type="checkbox" name="timing[]" id="timing" value="Morning"> Morning &nbsp&nbsp
                <input type="checkbox"  name="timing[]" id="timing" value="Noon"> Noon &nbsp&nbsp
                <input type="checkbox"  name="timing[]" id="timing" value="Night"> Night &nbsp&nbsp<br>
                </div>
                <label for="duration"><b>Duration:&nbsp&nbsp</b></label>
                <input type="text" style="width: 30%; height: 10px" id="duration" name="duration" placeholder="Duration">
                <input type="submit" name="medSubmit" value="Submit">
                <?php
                if (isset($_POST['medSubmit'])) {
                    $medicine = mysqli_real_escape_string($link, $_REQUEST['medicine']);
                    $duration = mysqli_real_escape_string($link, $_REQUEST['duration']);
                    if (isset($_POST['timing'])) {
                        $temp = $_POST['timing'];
                        $timing = '';
                        foreach ($temp as $timeTemp) {
                            $timing .=  $timeTemp . '  ';
                        }
                    }
                    $sql = "INSERT INTO prescriptionmedicine(Prescription_Id,Medicine,Timing,Duration) VALUES ('$prescriptionId','$medicine','$timing','$duration')";
                    echo "Successful!";
                    mysqli_query($link, $sql);
                }
                ?>
                <p></p>
                <p></p>
                <p></p>
                <p></p>

                <label for="Suggestion"><b>Suggestion :&nbsp&nbsp</b></label><br>
                <textarea name="Suggestion" id="Suggestion" name="Suggestion"
                          style="width:50%; height:100px;"></textarea>
                &nbsp&nbsp
                <input type="submit" name="suggestionSubmit" value="Submit">
                <?php
                if (isset($_POST['suggestionSubmit'])) {
                    $suggestion = mysqli_real_escape_string($link, $_REQUEST['Suggestion']);
                    $sql = "INSERT INTO prescriptionsuggestion (Prescription_Id,Suggestion) VALUES ('$prescriptionId','$suggestion')";
                    echo "Successful !";
                    mysqli_query($link, $sql);
                }
                ?>
                <br><br>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <input type="submit" style="width: 30%; padding: 14px 25px " name="generatePrescription" formaction="FinalPrescription.php" value="Generate Prescription">


            </form>
        </div><!--End Invoice-->

    </div>

    <!JS part>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>

    <script>
        function myFunction() {
            document.getElementById('demo').value = Date();
        }
    </script>
    <script>
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        var medName = ["Abacavir", "Acetazolamide","Acetylsalicylic", "Aciclovir", "Albendazole","Allopurinol","Amitriptyline","Amoxicillin","Ampicillin", "Artesunate", "Atenolol", "Atropine", "BCG vaccine", "Benzathine benzylpenicillin","Benzyl benzoate","Benzyl penicillin", "Betamethasone","Bleomycin","Bupivacaine", "Calcium gluconate", "Carbamazepine","Chlorambucil","Chloramphenicol", "Chlorhexidine","Chloroquine", "Chlorpheniramine" ,"Chlorpromazine", "Ciprofloxacin", "Cisplatin","Clofazimine","Clotrimazole","Cloxacillin","Cyclophosphamide", "Dapsone", "Dexamethasone","Dextran 70","Diazepam","Didanosine", "Diethylcarbamazine","Digoxin","Diloxanide", "Diphtheria antitoxin","Diptheria vaccine", "Dopamine","Doxorubicin", "Doxycycline", "Efavirenz","Enalapril","Epinephrine", "Ergocalciferol", "Ergometrine", "Erythromycin","Ethambutol", "Ferrous salt", "Fluconazole","Fluorescein", "Fluorouracil","Fluphenazine", "Furosemide","Gentamycin","Glibenclamide", "Gliclazide", "Glucose","Glyceryl trinitrate","Griseofulvin","Haloperidol", "Halothane", "Heparin sodium","Hepatitis B vaccine","Homatropine", "Hydrochlorothiazide", "Hydrocortisone","Hyoscine butylbromide", "Ibuprofen", "Indinavir",  "Isoniazide", "Isosorbide dinitrate", "Ketamine","Lamivudine-3TC", "Levamisole","Levothyroxine","Lidocaine","Mannitol", "Measles vaccine",
            "Mebendazole", "Mefloquine", "Metformin", "Methotrexate", "Methyldopa", "Metoclopramide", "Metronidazole","Miconazole", "Miltefosine","Misoprostol", "Morphine","Naloxone", "Nelfinavir","Neostigmine", "Nevirapine", "Nicotinamide","Nifedipine", "Nitrofurantoin","Nystatin", "Omeprazole", "Oseltamivir", "Oxytocin", "Paracetamol", "Paromomycin", "Permethrin","Pertussis vaccine","Phenobarbital","Phenoxymethylpenicillin", "Phenytoin","Pilocarpine", "Poliomyelitis vaccine", "Prednisolone","Primaquine", "Procainamide", "Procaine benzylpenicllin", "Procarbazine", "Proguanil", "Promethazine","Propranolol","Pyrazinamide", "Pyridoxine", "Pyrimethamine","Quinine", "Rabies vaccine", "Retinol", "Riboflavin", "Rifampicin", "Ritonavir", "Salbutamol","Saquinavir", "Senna","Spironolactone","Stavudine (d4t)", "Streptomycin", "Suxamethonium","Tamoxifen", "Tetanus vaccine","Tetracycline", "Thiamine","Thiopental", "Trimethoprim","Tropicamide","Tuberculin", "Vecuronium","Verapamil", "Vinblastine", "Vincristine", "Vitamin B-Complex",
            "Warfarin", "Xylometazoline Hydrochloride","Zidovudine","Telfast","Fimoxyl","Tushka","Napa","Ambrox","Geston","Esloric","Flexi","Virux","Antiva","Almex","Nixalo","Ambrisan","Tryptin","Apsol","Camlodin","Moxaclav","Entacyd","Alacot DS","Otelast","Ariprex","Lumertam","Zanthin","Anzitor","Flonasin","Zimax","Beclomin","Benzapen","Rex","Orogel","Prosalic","Laxyl","Bromolac",
            "Calcitrol","Calbo-D",
            "Xcid","Canaglif","Carbizol","Loracef","Fodexil","Cefotil","Alatrol","Ciprocin","Climycin","Olicod","Avaspray","Secrin","Trevox","Duolax",
            "Amodis","Inflagic","Vigosol"];

        /*initiate the autocomplete function on the "medicine" element, and pass along the medName array as possible autocomplete values:*/
        autocomplete(document.getElementById("medicine"), medName);
    </script>


</body>
</html>