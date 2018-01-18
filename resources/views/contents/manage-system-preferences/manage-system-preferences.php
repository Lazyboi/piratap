<?php

use App\Preferences;
use LPU\Form;
use LPU\Path;
use LPU\Route;

Route::validateTabs();

switch (Route::currentData()) {
    case 'general':
        $system_preference_fields = ['html_content_language', 'meta_charset', 'meta_application_name', 'meta_description', 'meta_keywords', 'meta_author', 'application_name', 'footer_copyright', 'password', 'edit_general_preference'];
        break;
    case 'ui':
        $system_preference_fields = ['skin_color', 'layout', 'password', 'edit_ui_preference'];
        break;
    case 'academic':
        $system_preference_fields = ['academic_year', 'semester', 'password', 'edit_academic_preference'];
        break;
    default:
}

if (Form::validate($system_preference_fields)) {
    Preferences::editSystemPreference();
} else {
    Preferences::loadSystemPreferenceFieldData();
}

?>
<div class="row">

  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <?php Route::displayTabs(); ?>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane">
          <?php if (Route::currentData() == 'general'): ?>
            <form method="POST">
              <?php Form::displayMessage(); ?>
              <!-- <div class="form-group <?php Form::displayFieldState('html_content_language', 'state'); ?>">
                <label>
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('html_content_language', 'name'); ?>
                  <div class="hint">(<?php Preferences::displaySystemPreferenceData('html_content_language', 'description'); ?>)</div>
                </label>
                <div>
                  <select class="form-control" name="html_content_language" required size="10">
                    <?php Preferences::displayLanguageSelect(Form::getFieldData('html_content_language')); ?>
                  </select>
                  <?php Form::displayFieldState('html_content_language', 'message'); ?>
                </div>
              </div> -->

              <div class="form-group <?php Form::displayFieldState('meta_application_name', 'state'); ?>">
                <label for="meta-application-name">
                  <span class="text-danger">*</span> Application Name
                   <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('meta_application_name', 'description'); ?>)</div> -->
                 </label>
                <div>
                  <input autocomplete="off" class="form-control" id="meta-application-name" name="meta_application_name" required type="text" value="<?php Form::loadFieldData('meta_application_name'); ?>">
                  <?php Form::displayFieldState('meta_application_name', 'message'); ?>
                </div>
              </div>

              <div class="form-group <?php Form::displayFieldState('meta_description', 'state'); ?>">
                <label for="meta-description">
                  <span class="text-danger">*</span> Description
                  <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('meta_description', 'description'); ?>)</div> -->
                </label>
                <div>
                  <textarea class="form-control" id="meta-description" name="meta_description" required><?php Form::loadFieldData('meta_description'); ?></textarea>
                  <!-- <?php Form::displayFieldState('meta_description', 'message'); ?> -->
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('meta_keywords', 'state'); ?>">
                <label for="meta-keywords">
                  <span class="text-danger">*</span> Keywords
                  <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('meta_keywords', 'description'); ?>)</div> -->
                </label>
                <div>
                  <input autocomplete="off" class="form-control" data-role="tagsinput" id="meta-keywords" name="meta_keywords" required type="text" value="<?php Form::loadFieldData('meta_keywords'); ?>">
                  <?php Form::displayFieldState('meta_keywords', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('meta_author', 'state'); ?>">
                <label for="meta-author">
                  <span class="text-danger">*</span> Author
                  <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('meta_author', 'description'); ?>)</div> -->
                </label>
                <div>
                  <input autocomplete="off" class="form-control" id="meta-author" name="meta_author" required type="text" value="<?php Form::loadFieldData('meta_author'); ?>">
                  <?php Form::displayFieldState('meta_author', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('application_name', 'state'); ?>">
                <label for="application-name">
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('application_name', 'name'); ?>
                  <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('application_name', 'description'); ?>)</div> -->
                </label>
                <div>
                  <input autocomplete="off" class="form-control" id="application-name" name="application_name" required type="text" value="<?php Form::loadFieldData('application_name'); ?>">
                  <?php Form::displayFieldState('application_name', 'message'); ?>
                </div>
              </div>

              <div class="form-group <?php Form::displayFieldState('meta_charset', 'state'); ?>">
                <label>
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('meta_charset', 'name'); ?>
                  <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('meta_charset', 'description'); ?>)</div> -->
                </label>
                <div>
                  <select class="form-control" name="meta_charset" required size="5">
                    <?php Preferences::displayCharsetSelect(Form::getFieldData('meta_charset')); ?>
                  </select>
                  <?php Form::displayFieldState('meta_charset', 'message'); ?>
                </div>
              </div>

              <div class="form-group <?php Form::displayFieldState('footer_copyright', 'state'); ?>">
                <label for="footer-copyright">
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('footer_copyright', 'name'); ?>
                  <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('footer_copyright', 'description'); ?>)</div> -->
                </label>
                <div>
                  <input autocomplete="off" class="form-control" id="footer-copyright" name="footer_copyright" required type="text" value="<?php Form::loadFieldData('footer_copyright'); ?>">
                  <?php Form::displayFieldState('footer_copyright', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('password', 'state'); ?>">
                <label for="password">
                  <span class="text-danger">*</span> Password
                  <!-- <div class="hint">(For security purposes)</div> -->
                </label>
                <div>
                  <input autocomplete="off" class="form-control" id="password" name="password" required type="password" value="<?php Form::loadFieldData('password'); ?>">
                  <?php Form::displayFieldState('password', 'message'); ?>
                </div>
              </div>
              <div class="form-group">
                <div>
                  <button class="btn bg-harvard-red" name='edit_general_preference' type="submit">Save Changes</button>
                </div>
              </div>
            </form>
            <?php Form::clearState(true);?>
          <?php endif; ?>
          <?php if (Route::currentData() == 'ui'): ?>
            <form method="POST">
              <!-- <div class="form-header">
                <?php Form::displayNotes(); ?>
              </div> -->
              <?php Form::displayMessage(); ?>
              <div class="form-group <?php Form::displayFieldState('skin_color', 'state'); ?>">
                <label>
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('skin_color', 'name'); ?>
                  <!-- <div class="hint">(<?php Preferences::displaySystemPreferenceData('skin_color', 'description'); ?>)</div> -->
                </label>
                <div>
                  <?php Preferences::displaySkinColorPaletteBox(Form::getFieldData('skin_color')); ?>
                  <?php Form::displayFieldState('skin_color', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('layout', 'state'); ?>">
                <label>
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('layout', 'name'); ?>
                  <div class="hint">(<?php Preferences::displaySystemPreferenceData('layout', 'description'); ?>)</div>
                </label>
                <div>
                  <?php Preferences::displayLayoutRadio('layout', Form::getFieldData('layout')); ?>
                  <?php Form::displayFieldState('layout', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('password', 'state'); ?>">
                <label for="password">
                  <span class="text-danger">*</span> Password
                  <div class="hint">(For security purposes)</div>
                </label>
                <div>
                  <input autocomplete="off" class="form-control" id="password" name="password" required type="password" value="<?php Form::loadFieldData('password'); ?>">
                  <?php Form::displayFieldState('password', 'message'); ?>
                </div>
              </div>
              <div class="form-group">
                <div>
                  <button class="btn bg-harvard-red" name='edit_ui_preference' type="submit">Save Changes</button>
                </div>
              </div>
            </form>
            <?php Form::clearState(true);?>
          <?php endif; ?>
          <?php if (Route::currentData() == 'academic'): ?>
            <form method="POST">
              <!-- <div class="form-header">
                <?php Form::displayNotes(); ?>
              </div> -->
              <?php Form::displayMessage(); ?>
              <div class="form-group <?php Form::displayFieldState('academic_year', 'state'); ?>">
                <label>
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('academic_year', 'name'); ?>
                  <div class="hint">(<?php Preferences::displaySystemPreferenceData('academic_year', 'description'); ?>)</div>
                </label>
                <div>
                  <select class="form-control" name="academic_year" required size="10">
                    <?php Preferences::displayAcademicYearSelect(Form::getFieldData('academic_year')); ?>
                  </select>
                  <?php Form::displayFieldState('academic_year', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('semester', 'state'); ?>">
                <label>
                  <span class="text-danger">*</span> <?php Preferences::displaySystemPreferenceData('semester', 'name'); ?>
                  <div class="hint">(<?php Preferences::displaySystemPreferenceData('semester', 'description'); ?>)</div>
                </label>
                <div>
                  <select class="form-control" name="semester" required size="10">
                    <?php Preferences::displaySemesterSelect(Form::getFieldData('semester')); ?>
                  </select>
                  <?php Form::displayFieldState('semester', 'message'); ?>
                </div>
              </div>
              <div class="form-group <?php Form::displayFieldState('password', 'state'); ?>">
                <label for="password">
                  <span class="text-danger">*</span> Password

                </label>
                <div>
                  <input autocomplete="off" class="form-control" id="password" name="password" required type="password" value="<?php Form::loadFieldData('password'); ?>">
                  <?php Form::displayFieldState('password', 'message'); ?>
                </div>
              </div>
              <div class="form-group">
                <div>
                  <button class="btn bg-harvard-red" name='edit_academic_preference' type="submit">Save Changes</button>
                </div>
              </div>
            </form>
            <?php Form::clearState(true);?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
