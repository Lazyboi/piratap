<?php

use App\ComputerLaboratory;
use LPU\DateTime;
use LPU\Route;

ComputerLaboratory::validateAssignedClass();
ComputerLaboratory::loadAssignedClassData();

?>
<style>
.print-body table {
  margin: 10px 0;
}

.print-body table > thead > tr > th > h5 {
  color: #333;
  margin: 0;
}

.print-body table > thead > tr > th,
.print-body table > tbody > tr > td {
  padding: 5px;
  font-size: 11px;
}

.acceptance-details p {
  font-size: 14px;
}

.seat-plan {
  border: 1px solid #ddd;
  border-radius: 3px;
  padding: 10px;
  text-align: center;
  width: 100%;
}

.seat-plan > div {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 3px;
  cursor: move;
  display: inline-block;
  font-weight: normal;
  height: 90px;
  margin: 5px;
  padding: 5px;
  position: relative;
  vertical-align: top;
  width: 110px;
}

.seat-plan > div > h5 {
  font-family: Times New Roman;
  font-size: 11px;
  margin: 0;
  text-align: left;
}

.signature-field {
  padding-top: 5px;
  width: 250px;
}

.signature-field > span {
  color: #333;
  font-style: normal;
  font-weight: bold;
}

.signature-field > div {
  color: #333;
  font-style: normal;
  border-top: 1px solid #333;
}

.page-break {
  page-break-after: always;
}
</style>
<div class="page-break">
  <div class="print-header">
    <h4>LYCEUM OF THE PHILIPPINES UNIVERSITY</h4>
    <h5>Information and Communication Technology</h5>
    <h5>Cavite Campus</h5>
    <h3>WAIVER FOR THE USE OF COMPUTER FACILITIES</h3>
  </div>
  <div class="print-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th colspan="4">
            <h5>LABORATORY DETAILS:</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 12%;">Laboratory No.</td>
          <td style="width: 45%;">Subject: <?php ComputerLaboratory::displayAssignedClassData('subject'); ?></td>
          <td class="text-center" colspan="2" style="width: 50%;">Schedule</td>
        </tr>
        <tr>
          <td style="width: 12%;"><?php ComputerLaboratory::displayAssignedClassData('laboratory'); ?></td>
          <td style="width: 45%;">Instructor / Faculty: <?php ComputerLaboratory::displayAssignedClassData('assigned_professor'); ?></td>
          <td style="width: 19%;">Day/s: <?php ComputerLaboratory::displayAssignedClassData('days'); ?></td>
          <td style="width: 27%;">Time: <?php ComputerLaboratory::displayAssignedClassData('time'); ?></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td>PC No.</td>
          <td>Name</th>
          <td>Student No.</td>
          <td>Section</td>
          <td>College</td>
          <td>Contact No</td>
          <td>Conforme/Signature</td>
        </tr>
        <?php ComputerLaboratory::displayAssignedClassData('class_list'); ?>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>
            <h5>ACCEPTANCE DETAILS:</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="acceptance-details">
            <p>Above listed students accepted the assigned computer equipment from Information and Communication Technology department for laboratory use this semester, school year.</p>
            <p>The above students agreed to the condition that any loss or damage of the equipment will hold them responsible to replace part within the prescribed period</p>
            <p>Noted by:</p>
            <div class="text-center signature-field">
              <?php ComputerLaboratory::displayAssignedClassData('assigned_professor'); ?>
              <div>Instructor/Faculty Signature/Date</div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="page-break">
  <div class="print-header">
    <h4>SEATPLAN COMPUTER LAB <?php ComputerLaboratory::displayAssignedClassData('laboratory'); ?></h4>
    <h4>SEMESTER</h4>
    <h4>ACADEMIC YEAR</h4>
  </div>
  <div class="print-body">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td style="width: 70%;">Subject Code: <?php ComputerLaboratory::displayAssignedClassData('subject'); ?></td>
          <td style="width: 30%;">Section: <?php ComputerLaboratory::displayAssignedClassData('section'); ?></td>
        </tr>
        <tr>
          <td colspan="2">Description: <?php ComputerLaboratory::displayAssignedClassData('subject_description'); ?></td>
        </tr>
      </tbody>
    </table>
    <div class="seat-plan">
      <?php ComputerLaboratory::displayAssignedClassData('class_seat_plan'); ?>
    </div>
    <table class="table">
      <tbody>
        <tr>
          <td class="pull-right">
            <div class="text-center signature-field">
              <?php ComputerLaboratory::displayAssignedClassData('assigned_professor'); ?>
              <div>Professor's Signature Over Printed Name</div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
