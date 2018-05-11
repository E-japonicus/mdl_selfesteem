<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of infosysselfesteem
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_infosysselfesteem
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace infosysselfesteem with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... infosysselfesteem instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('infosysselfesteem', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $infosysselfesteem  = $DB->get_record('infosysselfesteem', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $infosysselfesteem  = $DB->get_record('infosysselfesteem', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $infosysselfesteem->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('infosysselfesteem', $infosysselfesteem->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_infosysselfesteem\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $infosysselfesteem);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/infosysselfesteem/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($infosysselfesteem->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('infosysselfesteem-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header('');

// Conditions to show the intro can change to look for own settings or whatever.
if ($infosysselfesteem->intro) {
    echo $OUTPUT->box(format_module_intro('infosysselfesteem', $infosysselfesteem, $cm->id), 'generalbox mod_introbox', 'infosysselfesteemintro');
}

include_once './locallib.php';  /* DB */

$composite_key = array('user_id' => $USER->id, 'infosysselfesteem_id' => $infosysselfesteem->id);

$context = context_course::instance($course->id);
$roles   = get_user_roles($context, $USER->id);
$teacher = array_filter($roles, function ($role) {
    return preg_match('/teacher/i', $role->shortname);
});

if (count($teacher) > 0) { /* treacher */
    include_once 'teachers_view.php';


} else {    /* student */
    // infosysselfesteem_formを読み込み
    require_once("{$CFG->dirroot}/mod/infosysselfesteem/infosysselfesteem_form.php");
    $mform = new infosysselfesteem_form("{$CFG->wwwroot}/mod/infosysselfesteem/view.php?id={$cm->id}");

    
    if ($mform->is_cancelled()) {
         //Handle form cancel operation, if cancel button is present on form

    } else if ($fromform = $mform->get_data()) {    /* 登録ボタンが押下され遷移して来た場合真になる */
        if (infosysselfesteem_rubric_upsert($fromform)) {
            // success upsert
        } else {
            // failed
        }
        // 登録したルーブリックの表示
        include_once './self_esteem_rubric_display.php';
        
        unset($fromform);

    } else {    /* DBからデータを取ってきて表示 */
        if ($record = $DB->get_record('infosysselfesteem_rubric', $composite_key)) {
            // 登録したルーブリックの表示
            include_once './self_esteem_rubric_display.php';
        } else {
            // フォームの表示
            $mform->display();
        }
        unset($record);
    }
}

unset($context, $roles, $teacher);




// Finish the page.
echo $OUTPUT->footer();
