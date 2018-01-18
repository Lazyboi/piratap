<?php

use App\ComputerLaboratory;
use LPU\DateTime;
use LPU\Route;

ComputerLaboratory::validateClass();
ComputerLaboratory::loadClassData();

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
          <td style="width: 45%;">Subject: <?php ComputerLaboratory::displayClassData('subject'); ?></td>
          <td class="text-center" colspan="2" style="width: 50%;">Schedule</td>
        </tr>
        <tr>
          <td style="width: 12%;"><?php ComputerLaboratory::displayClassData('laboratory'); ?></td>
          <td style="width: 45%;">Instructor / Faculty: <?php ComputerLaboratory::displayClassData('assigned_professor'); ?></td>
          <td style="width: 19%;">Day/s: <?php ComputerLaboratory::displayClassData('days'); ?></td>
          <td style="width: 27%;">Time: <?php ComputerLaboratory::displayClassData('time'); ?></td>
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
        <?php ComputerLaboratory::displayClassData('class_list'); ?>
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
              <?php ComputerLaboratory::displayClassData('assigned_professor'); ?>
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
    <h4>SEATPLAN COMPUTER LAB <?php ComputerLaboratory::displayClassData('laboratory'); ?></h4>
    <h4>SEMESTER</h4>
    <h4>ACADEMIC YEAR</h4>
  </div>
  <div class="print-body">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td style="width: 70%;">Subject Code: <?php ComputerLaboratory::displayClassData('subject'); ?></td>
          <td style="width: 30%;">Section: <?php ComputerLaboratory::displayClassData('section'); ?></td>
        </tr>
        <tr>
          <td colspan="2">Description: <?php ComputerLaboratory::displayClassData('subject_description'); ?></td>
        </tr>
      </tbody>
    </table>
    <div>
      <?php ComputerLaboratory::displayClassData('class_list'); ?>
    </div>
    <table class="table">
      <tbody>
        <tr>
          <td class="pull-right">
            <div class="text-center signature-field">
              <?php ComputerLaboratory::displayClassData('assigned_professor'); ?>
              <div>Professor's Signature Over Printed Name</div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>